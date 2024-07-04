<script>
import dropin from 'braintree-web-drop-in';
import axios from 'axios';

export default {
    data() {
        return {
            dropinInstance: null,
            successMessage: null
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
            this.dropinInstance.requestPaymentMethod((err, payload) => {
                if (err) {
                    console.error(err);
                    return;
                }
                axios.post('/checkout', {
                    paymentMethodNonce: payload.nonce
                }).then(response => {
                    console.log('Transazione simulata:', response.data);
                    this.successMessage = 'Pagamento completato con successo!';
                }).catch(error => {
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
        </div>

        <div ref="dropinContainer" class="dropin-container" v-if="!successMessage"></div>
        <button @click="submitPayment" class="payment-button" v-if="!successMessage">Paga</button>
    </div>
</template>







<style>
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
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.payment-button:hover {
    background-color: #0056b3;
}

.success-message {
    color: #1E4B5F;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    height: 100%;
    display: flex;
    align-items: center;
}
</style>