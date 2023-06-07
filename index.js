
function login(event) 
{
    event.preventDefault();
    
    // Get form data
    var form = event.target;
    var formData = new FormData(form);
  
    // Send data to PHP file
    fetch("login.php", {
      method: "POST",
      body: formData
    })
      .then(function(response) {
        return response.text(); // Get the response as text
      })
      .then(function(result) {
        if (result === "1") {
          // Redirect to home page or perform further actions
          var address = event.target.elements.address.value;
          sessionStorage.setItem('address',address );
          window.location.href = "home.html";
        } else {
          // Handle incorrect data
          alert("This Address does not exist");
        }
      })
      .catch(function(error) {
        console.log("Error:", error);
      });
}


function generate_address()
{
  var randomStr= document.getElementById("random_string_input").value;
  var new_address = btoa(randomStr+new Date().toLocaleString());
  document.getElementById("address").value = new_address;
  saveAddressToDb(new_address);
}

function showInputField() {
  var inputContainer = document.getElementById("random_string_input");
  inputContainer.style.display = "inline";
  var generate_address_button = document.getElementById("generate_address_button");
  generate_address_button.style.display = "inline";

}

function saveAddressToDb(new_address)
{
  debugger;
  fetch("save_new_address.php", {
    method: "POST",
    body: new_address
  })
    .then(function(response) {
      return response.text(); // Get the response as text
    })
    .then(function(result) {
      if (result === "true") 
      {
        alert("New Address Generated Successfully");

      } 
      else 
      {
        alert("ERROR : in saving or generating New Address");
      }
    })
    .catch(function(error) {
      console.log("Error:", error);
    });
}

  