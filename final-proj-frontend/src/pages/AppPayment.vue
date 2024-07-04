<script>
import dropin from 'braintree-web-drop-in';
import axios from 'axios';

export default {
    data() {
        return {
            dropinInstance: null,
            successMessage: null,
            paymentLoad: false
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
        submitPayment() {
            this.paymentLoad = true;

            this.dropinInstance.requestPaymentMethod((err, payload) => {
                if (err) {
                    console.error(err);
                    this.paymentLoad = false;
                    return;
                }
                axios.post('/checkout', {
                    paymentMethodNonce: payload.nonce
                }).then(response => {
                    console.log('Transazione simulata:', response.data);
                    this.paymentLoad = false;
                    this.successMessage = 'Pagamento completato con successo!';
                }).catch(error => {
                    this.paymentLoad = false;
                    console.error('Errore nella transazione:', error);
                });
            });
        }
    }
};
</script>



<template>
    <div class="payment-container">
        <div v-if="successMessage" class="success-message">
            <h1>
                {{ successMessage }}
            </h1>
            <p class="back-home">
                <RouterLink :to="{ name: 'home' }">Torna alla Home</RouterLink>
            </p>

        </div>

        <div v-if="paymentLoad" class="processing-message">
            <h1>
                Pagamento in Corso... <font-awesome-icon class="spinner" :icon="['fas', 'spinner']" />
            </h1>
        </div>


        <div ref="dropinContainer" class="dropin-container" v-show="!paymentLoad && !successMessage"></div>
        <button @click="submitPayment" class="payment-button" v-show="!paymentLoad && !successMessage">Paga</button>
    </div>
</template>







<style  lang="scss" scoped>
@use '../assets/style/partials/variables' as*; 

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
    .back-home{
        text-decoration: underline;
        &:hover{
            cursor: pointer;
            color: $app-brand-yellow
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


</style>