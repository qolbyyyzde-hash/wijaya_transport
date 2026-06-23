<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Checkout</h1>
    <p id="msg">Preparing payment...</p>
    <button id="payBtn" class="btn btn-accent" style="display:none">Pay</button>
  </div>

  <script>
  (function(){
    const params = new URLSearchParams(window.location.search);
    const bookingId = params.get('booking_id');
    if(!bookingId){ document.getElementById('msg').innerText = 'Missing booking id'; return; }

    // Fetch snap token from server
    fetch('/wijaya_transport/controllers/payment_controller.php?action=snapToken&booking_id=' + bookingId)
      .then(r=>r.json())
      .then(data=>{
        if(data.token){
          // load midtrans snap JS dynamically using client key placeholder
          const s = document.createElement('script');
          s.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
          s.setAttribute('data-client-key','MIDTRANS_CLIENT_KEY');
          s.onload = ()=>{
            document.getElementById('msg').innerText = 'Ready to pay';
            const payBtn = document.getElementById('payBtn');
            payBtn.style.display = 'inline-block';
            payBtn.addEventListener('click', ()=>{
              snap.pay(data.token, {
                onSuccess: function(result){
                  // send result to server to update payment record
                  fetch('/wijaya_transport/controllers/payment_callback.php', {
                    method:'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify({ booking_id: bookingId, result: result })
                  }).then(()=>{ window.location = '/wijaya_transport/index.php?msg=paid'; }).catch(()=>{ window.location = '/wijaya_transport/index.php?msg=paid'; });
                },
                onPending: function(result){
                  fetch('/wijaya_transport/controllers/payment_callback.php', {
                    method:'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify({ booking_id: bookingId, result: result })
                  }).then(()=>{ window.location = '/wijaya_transport/index.php?msg=pending'; }).catch(()=>{ window.location = '/wijaya_transport/index.php?msg=pending'; });
                },
                onError: function(result){
                  fetch('/wijaya_transport/controllers/payment_callback.php', {
                    method:'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify({ booking_id: bookingId, result: result })
                  }).then(()=>{ window.location = '/wijaya_transport/index.php?msg=error'; }).catch(()=>{ window.location = '/wijaya_transport/index.php?msg=error'; });
                }
              });
            });
          };
          document.body.appendChild(s);
        } else {
          document.getElementById('msg').innerText = 'Failed to get token';
        }
      }).catch(err=>{ document.getElementById('msg').innerText = 'Error: '+err; });
  })();
  </script>
</body>
</html>
