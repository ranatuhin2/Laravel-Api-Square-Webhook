<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
</head>
<body>
     <div id="card-container"></div>
     <button id="card-button">Pay</button>
</body>

<script>
     const appId = 'sandbox-sq0idb-krFQTt1kP0Mqn1eeXHSHkA';
     const invoiceId = '123'; // Dynamically from backend/invoice page

     async function main() {
     const payments = Square.payments(appId, 'sandbox');
     const card = await payments.card();
     await card.attach('#card-container');

     document.getElementById('card-button').addEventListener('click', async () => {
          const result = await card.tokenize();
          if (result.status === 'OK') {
          const nonce = result.token;

          // Send to backend
          fetch('/api/payment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                    nonce: nonce,
                    invoice_id: invoiceId
               })
          })
          .then(response => response.json())
          .then(data => {
               alert();
               if (data.success) {
                    console.log(data);
                    
               alert('Payment initiated. Waiting for confirmation.');
               } else {
               alert('Error: ' + JSON.stringify(data.error));
               }
          });
          } else {
          alert('Card error: ' + result.errors[0].message);
          }
     });
     }

     main();


// SQUARE_ENV=sandbox
// SQUARE_ACCESS_TOKEN=EAAAlxttt8reynQX1F0W6nxvvkB-BWmTtJo3kLY7k6bpedrT1UmiyrarnKgmnw_Y
// SQUARE_LOCATION_ID=sandbox-sq0idb-krFQTt1kP0Mqn1eeXHSHkA
// SQUARE_APP_ID=sandbox-sq0idb-krFQTt1kP0Mqn1eeXHSHkA
// SQUARE_WEBHOOK_SIGNATURE_KEY=rNOy5-M6IZ2gYrCyLljh5Q

</script>
</html>