import express from 'express';
import braintree from 'braintree';
import dotenv from 'dotenv';

dotenv.config(); // Carica le variabili d'ambiente dal file .env

const app = express();
const PORT = process.env.PORT || 3000;

const gateway = new braintree.BraintreeGateway({
  environment: braintree.Environment.Sandbox, // Ambiente sandbox per i test
  merchantId: 'ywtk8fnk4kx6rhzg', // Usa variabili d'ambiente per sicurezza
  publicKey: 'r6d9mfhjqpw6rn24',
  privateKey: '2b022746e7ce000325da6c87fdfb100d'
});

app.get('/token', (req, res) => {
  gateway.clientToken.generate({}, (err, response) => {
    if (err) {
      res.status(500).send(err);
      return;
    }
    res.send(response.clientToken);
  });
});

app.post('/checkout', express.json(), (req, res) => {
  const nonceFromTheClient = req.body.paymentMethodNonce;

  gateway.transaction.sale({
    amount: '10.00', // Importo di prova
    paymentMethodNonce: nonceFromTheClient,
    options: {
      submitForSettlement: true
    }
  }, (err, result) => {
    if (err) {
      res.status(500).send(err);
      return;
    }
    res.send(result);
  });
});

app.listen(PORT, () => {
  console.log(`Server di test in esecuzione sulla porta ${PORT}`);
});
