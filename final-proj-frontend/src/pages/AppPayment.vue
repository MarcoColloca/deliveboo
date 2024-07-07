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
                            this.successMessage = 'Pagamento completato con successo!';

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
    <div class="payment-container">
        <div class="user-data-container" v-show="!paymentLoad && !successMessage">
            <form @submit="submitPayment" >
                <h4 class="text-center">Inserisci i tuoi dati</h4>

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

                <div ref="dropinContainer" class="dropin-container" v-show="!paymentLoad && !successMessage"></div>
                
                <button type="submit" class="payment-button" v-show="!paymentLoad && !successMessage">Paga</button>
            </form>
        </div>

        <div v-if="successMessage" class="success-message">
            <h1>
                {{ successMessage }}
            </h1>
            <p class="back-home">
                <RouterLink :to="{ name: 'home' }">Ordina qualcos'altro!</RouterLink>
            </p>
        </div>

        <div v-if="paymentLoad" class="processing-message">
            <h1>
                Pagamento in Corso... <font-awesome-icon class="spinner" :icon="['fas', 'spinner']" />
            </h1>
        </div>
    </div>

    <div class="fake-cart" v-show="!paymentLoad && !successMessage">
        <h5 class="text-center mb-4">Riepilogo Ordine</h5>
        <div class="row mb-2" v-for="(dish, i) in store.cartDishes" :key="i">
            <div class="col-2 d-flex gap-2">
                <span class="">{{ dish.qty }}</span>
            </div>
            <div class="col-5 text-start">
                <p>{{ dish.name }}</p>
            </div>
            <div class="col-3">
                <p>{{ getPrice(dish.qty, dish.price) }} €</p>
            </div>
        </div>
        <div class="row mb-2 text-center">
            <h4>Totale Ordine: {{ getTotal() }} €</h4>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use '../assets/style/partials/variables' as*; 

.user-data-container {
    width: 400px;
    padding: 10px 15px;
    color: black;
    font-weight: 100;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.payment-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: 100%;
}

.dropin-container {
    width: 100%;
    max-width: 400px;
    margin-bottom: 20px;
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
    color: $app-brand-blue;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    .back-home {
        text-decoration: underline;
        &:hover {
            cursor: pointer;
            color: $app-brand-yellow;
        }
    }
}

.processing-message {
    color: #555;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    height: 100%;
    display: flex;
    align-items: center;
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
    position: fixed;
    left: 150px;
    top: 35%;
    min-width: 500px;
    padding: 30px 20px;
    color: black;
    font-weight: 100;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
</style>
