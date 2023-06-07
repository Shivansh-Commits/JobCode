function signout()
{
    window.location.href="index.html"
}

function setAddress_label()
{
    const address = sessionStorage.getItem('address');
    document.getElementById('address').innerHTML = address;
}


function setBalance_label()
{
    const address = sessionStorage.getItem('address');
    document.getElementById('address').innerHTML = address;

    fetch("fetch_balance.php", {
        method: "POST",
        body: address
      })
        .then(function(response) {
          return response.text(); // Get the response as text
        })
        .then(function(result) {
          if (result != "false") {
            document.getElementById("balance").innerHTML = result;

          } else {
            // Handle incorrect data
            alert("NO BALANCE FOUND");
          }
        })
        .catch(function(error) {
          console.log("Error:", error);
        });
}


function send_jobcoin(event)
{

  event.preventDefault();

  //USER input Validating
  var amt = document.getElementById('amount').value;
  var to_add = document.getElementById('to_address').value;

  if(amt === '' || to_add === '') 
  {
    alert(" Input Fields cannot be Empty! ")
    return false;
  }

   // INITIATING TRANSACTION PROCESS
    const from_address = sessionStorage.getItem('address');

    var form = event.target.form;
    var formData = new FormData(form);
    formData.append('from_address',from_address);


         fetch("send_jobcoin.php", {
          method: "POST",
          body: formData
        })
          .then(function(response) {
              return response.text(); // Getting the response as text
          })
          .then(function(result) {
            if(result === "1")
            {
              alert("Cheers! Transfer Successful")
              location.reload();
            }
            if(result === "-1")
            {
              alert("Oops! Insufficient Balance");
              location.reload();
              console.log(result);
            }
            if(result === "0")
            {
              location.reload();
              alert("Wrong Receiver Address");
              console.log(result);
            }
            else
            {
              console.log(result+"GETTING UN-EXPECTED OUTPUT , PLS CHECK");
            }
            
          })
          .catch(function(error) 
          {
          console.log("Error:", error);
          return false;
          });
}

function display_chart(amount,to_adds)
{
  const ctx = document.getElementById('transactionGraph').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: to_adds,
      datasets: [{
        label: 'Amount',
        data: amount,
        backgroundColor: 'blue',
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: 'To Address',
          },
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Amount',
          },
        },
      },
    },
  });
}

function fetch_transaction()
{
  const from_address = sessionStorage.getItem('address');

  fetch('fetch_transactions.php', {
    method: 'POST',
    body: from_address,
  })
    .then(function(response) {
      return response.json(); // Parse the response as JSON
    })
    .then(function(data) {
      var amount = data.amounts;
      var to_adds = data.to_adds;
      display_chart(amount, to_adds);
    })
    .catch(function(error) {
      console.log('Error:', error);
      return false;
    });
}