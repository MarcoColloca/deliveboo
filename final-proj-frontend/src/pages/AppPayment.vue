<script>
import dropin from 'braintree-web-drop-in';
import axios from 'axios';
import { store } from '../store';

export default {
    data() {
        return {
            store,
            dropinInstance: null,
            successMessage: null,
            paymentLoad: false,
            errors: {}
        };
    },
    mounted() {
        this.initializeBraintree();
    },
    methods: {
        async initializeBraintree() {
            try {
                const response = await axios.get('/token');
                const clientToken = response.data;
                dropin.create({
                    authorization: clientToken,
                    container: this.$refs.dropinContainer
                }, (err, instance) => {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    this.dropinInstance = instance;
                });
            } catch (error) {
                console.error('Errore nel recuperare il token del cliente:', error);
            }
        },
        async submitPayment(event) {
            event.preventDefault();
            this.paymentLoad = true;
            this.errors = {};

            // Raccogli i dati dal form
            const customerData = {
                customer_name: this.$refs.customer_name.value,
                customer_address: this.$refs.customer_address.value,
                customer_phone: this.$refs.customer_phone.value,
                customer_email: this.$refs.customer_email.value,
                details: this.$refs.details.value,
                total: this.getTotal(),
                dishes: this.store.cartDishes.map(dish => ({
                    id: dish.id,
                    qty: dish.qty
                }))
            };

            try {
                // Validare i dati dell'ordine
                const validationResponse = await axios.post('http://127.0.0.1:8000/api/validate-order', customerData);
                if (!validationResponse.data.valid) {
                    console.error('Errore nella validazione dell\'ordine:', validationResponse.data.errors);
                    this.errors = validationResponse.data.errors;
                    this.paymentLoad = false;
                    return;
                }

                this.dropinInstance.requestPaymentMethod(async (err, payload) => {
                    if (err) {
                        console.error(err);
                        this.paymentLoad = false;
                        return;
                    }
                    try {
                        const paymentResponse = await axios.post('/checkout', {
                            paymentMethodNonce: payload.nonce
                        });

                        if (paymentResponse.data.success) {
                            console.log('Pagamento completato con successo:', paymentResponse.data);
                            
                            // Invia i dati dell'ordine al backend
                            const orderResponse = await axios.post('http://127.0.0.1:8000/api/orders', customerData);
                            console.log('Ordine inviato con successo', orderResponse.data);
                        } else {
                            console.error('Errore nel completare il pagamento:', paymentResponse.data.message);
                        }
                    } catch (paymentError) {
                        console.error('Errore durante il processo di pagamento:', paymentError);
                    } finally {
                        this.paymentLoad = false;
                        this.store.cartDishes = [];
                        this.store.cartCompany = null;
                        this.successMessage = 'Pagamento completato con successo!';
                    }
                });
            } catch (validationError) {
                if (validationError.response && validationError.response.data && validationError.response.data.errors) {
                    this.errors = validationError.response.data.errors;
                } else {
                    console.error('Errore nella validazione dell\'ordine:', validationError);
                }
                this.paymentLoad = false;
            }
        },
        getTotal() {
            let sum = 0;
            this.store.cartDishes.forEach(element => {
                const dishPrice = element.price * element.qty;
                sum += dishPrice;
            });
            return sum;
        },
        getPrice(qty, price) {
            const total = (qty * price).toFixed(2);
            return total;
        },
    }
};
</script>

<template>
    <section class="payment">

        <div class="payment-container  container">
            <div class="row w-100 g-0 row-gap-2 justify-content-around">
                
                <div class="user-data-container" v-show="!paymentLoad && !successMessage">
                    <form @submit="submitPayment" >
                        <h3 class="text-center">Inserisci i tuoi dati</h3>
        
                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="customer_name" class="form-label fb-bold">Nome *</label>
                            <input type="text" required name="customer_name" class="form-control" id="customer_name" placeholder="Inserisci il nome" ref="customer_name" maxlength="250">
                            <span v-if="errors.customer_name" class="text-danger">{{ errors.customer_name[0] }}</span>
                        </div>
        
                        <!-- Indirizzo -->
                        <div class="mb-3">
                            <label for="customer_address" class="form-label fb-bold">Indirizzo *</label>
                            <input type="text" required name="customer_address" class="form-control" id="customer_address" placeholder="Inserisci l'indirizzo" ref="customer_address" maxlength="250">
                            <span v-if="errors.customer_address" class="text-danger">{{ errors.customer_address[0] }}</span>
                        </div>
        
                        <!-- Telefono -->
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label fb-bold">Telefono *</label>
                            <input type="tel" required name="customer_phone" class="form-control" id="customer_phone" placeholder="Inserisci il numero di telefono" ref="customer_phone" maxlength="250">
                            <span v-if="errors.customer_phone" class="text-danger">{{ errors.customer_phone[0] }}</span>
                        </div>
        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="customer_email" class="form-label fb-bold">Email *</label>
                            <input type="email" required name="customer_email" class="form-control" id="customer_email" placeholder="Inserisci la tua mail" ref="customer_email" maxlength="250">
                            <span v-if="errors.customer_email" class="text-danger">{{ errors.customer_email[0] }}</span>
                        </div>
        
                        <!-- Descrizione -->
                        <div class="mb-3">
                            <label for="details" class="form-label">Dettagli</label>
                            <textarea class="form-control" name="details" id="details" placeholder="Inserisci eventuali dettagli" ref="details" maxlength="2000"></textarea>
                            <span v-if="errors.details" class="text-danger">{{ errors.details[0] }}</span>
                        </div>
                        <div class="credit-data-container">
                            <div id="img-card-box">
                                <img src="/imgs/credit-card.png" id="credit-card-img" alt="">
                            </div>
                            <div ref="dropinContainer" class="dropin-container" v-show="!paymentLoad && !successMessage"></div>
                        </div>

                        
                        <button type="submit" class="payment-button" v-show="!paymentLoad && !successMessage">Paga</button>
                    </form>
                </div>
        
                <div v-if="successMessage" class="success-message">
                    <img src="/imgs/payment-ok.png" class="payment-ok" alt="">
                    <h1>
                        {{ successMessage }}
                    </h1>
                    <h3 class="back-home">
                        <RouterLink :to="{ name: 'home' }">Ordina qualcos'altro!</RouterLink>
                    </h3>
                </div>
        
                <div v-if="paymentLoad" class="processing-message">
                    <img src="/imgs/payment-process.png" class="payment-img" alt="">
                    <h1>
                        Pagamento in Corso... <font-awesome-icon class="spinner" :icon="['fas', 'spinner']" />
                    </h1>
                </div>
        
                <div class="fake-cart" v-show="!paymentLoad && !successMessage">
                    <h4 class="text-center recap-order-title mb-4">Riepilogo Ordine</h4>
                    <div class="recap-box mb-2" v-for="(dish, i) in store.cartDishes" :key="i">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <p class="">{{ dish.qty }}</p>
                        </div>
                        <div class="col-5  d-flex align-items-center justify-content-start">
                            <p>{{ dish.name }}</p>
                        </div>
                        <div class="col-3  d-flex align-items-center justify-content-center">
                            <p>{{ getPrice(dish.qty, dish.price) }} €</p>
                        </div>
                    </div>
                    <div class="row p-0 mb-2 text-center">
                        <h4>Totale Ordine: {{ getTotal() }} €</h4>
                    </div>
                    <span v-if="errors.dishes" class="text-danger">Non puoi effettuare un ordine con il carrello vuoto. Per favore torna <RouterLink class="text-warning" :to="{ name: 'home' }">indietro.</RouterLink></span>
                </div>
            </div>
        </div>
    </section>

</template>

<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*; 

.payment{
    height: 100%;
    padding:50px 0;
}
.payment-img{
    width: 40%;
}
.payment-ok{
    width: 40%;
}
.user-data-container {
    width: 100%;
    padding: 30px 20px;
    color: $app-brand-blue;
    font-weight: 100;
    // background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: hsla(0, 0%, 100%, 0.322);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(5px);
    border:3px solid $app-brand-blue;
}

.payment-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 44px 15px;
    // background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
    background-color: hsla(0, 0%, 100%, 0.322);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(5px);
    // box-shadow: 0 0 1.75rem rgba(201, 121, 2, 0.945);

}
.credit-data-container{
    width:100%;
    display:flex;
    flex-direction:column;
    align-items: center;
    #img-card-box{
        display:flex;
        align-items:baseline;
        justify-content: center;
        #credit-card-img{
            width: 90%;  
            border-radius: 22px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);     
        }
    }

    .dropin-container {
        width: 100%;
        margin-bottom: 20px;
    }
}

.payment-button {
    background-color: $app-brand-blue;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.5s;
}

.payment-button:hover {
    background-color: $app-brand-yellow;
}

.success-message {
    padding-top:10px;
    color: $app-brand-blue;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content:space-around;
    .back-home {
        margin-top:50px;
        color: $app-brand-blue;
        background-color: $app-brand-yellow;
        padding: 5px 15px;
        border-radius: 10px;
        border: 3px solid $app-brand-blue;
        box-shadow:1px 1px 4px $app-brand-blue;
        &:hover {
            cursor: pointer;
            color: $app-brand-yellow;
            background-color: $app-brand-blue;
            padding: 5px 15px;
            border-radius: 10px;
            // border: 3px solid $app-brand-yellow;
        }
        &:active{
            background-color: #123647;
        }
    }
}

.processing-message {
    color: $app-brand-blue;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content:space-around;
    
}

.spinner {
    display: inline-block;
    animation: rotate 2s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.fake-cart {
    
    width: 100%;
    align-self:flex-start;
    color: $app-brand-blue;
    border:3px solid $app-brand-blue;
    font-weight: 100;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: hsla(0, 0%, 100%, 0.322);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(5px);
    .recap-order-title{
        color:white;
        background-color: $app-brand-blue;
        padding: 15px;
        
    }
    .recap-box{
        display:flex;
        justify-content:space-around;
    }
}

@media (min-width: 992px) {
    .user-data-container{
        width: 65%;
    }
    .fake-cart{
        width: 30%;
    }
    .credit-data-container{
        flex-direction: row-reverse;
        #img-card-box{
            justify-content: flex-end;
        }
    }
}

</style>
