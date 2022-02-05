<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices -->
  </head>

  <body>
    <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&currency=USD"></script>

    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <script>
      paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
          return actions.order.create({
            //desabilita el shipping
            application_context: {
                shipping_preference: "NO_SHIPPING"
            },

            payer:{
              email_address: 'sb-ofelx12920165@personal.example.com',
              name:{
                given_name:'John',
                surname: 'Doe'
              },
              address:{
                address_line_1: "los laureles",
                address_line_2: "test",
                admin_area_1: "",
                admin_area_2: "",
                postal_code: "10101",
                country_code: "US",
              }
            },
            purchase_units: [{
              amount: {
                value: '77.44' //PRECIO: Can reference variables or functions. Example: `value: document.getElementById('...').value` 
              }
            }]
          });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {

          console.log('data', data);
          console.log('actions', actions);


            return actions.order.capture().then(function(details){    
                alert('transaction completed by' + details.payer.name.given_name);
            });
        

            /*
                return fetch('/paypal/process/' + data.orderID, {
                    method: 'post'
                })
                
                .then(res => res.json())
                .then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart(); // Recoverable state, per:
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            */
        


        /*
          return fetch('/paypal/process/' + data.orderId, {
            method: 'post'
          })
          .then(res => res.json())
          .then(function(orderData){
            var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

            if(errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED'){
              return actions.restart();
            }
            if(errorDetail){
              var msg = 'sorry , your transaction could not be processed';
              if(errorDetail.description) msg += '\n\n' + errorDetail.description; 
              if(orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
              return alert(msg);
            }
          });
        */


          /*
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

            // When ready to go live, remove the alert and show a success message within this page. For example:
            // var element = document.getElementById('paypal-button-container');
            // element.innerHTML = '';
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
          */
        },
        onError: function (err) {
          // For example, redirect to a specific error page
          console.log(err)
          //window.location.href = "/your-error-page-here";
        }
      }).render('#paypal-button-container');

    </script>
  </body>
</html>