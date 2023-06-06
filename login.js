function login()
{
    debugger;

    var address = document.getElementById("address").value;
    if(address=="")
    {
        alert("Address Field cannot be Empty");
        return false;
    }


    var url = 'login.php';
    url += '?address=' + address;

  
    fetch(url)
    .then(response => response.text())
    .then(result => {
    console.log(result);
        alert("USER EXIST");
    })
    .catch(error => {
    console.error('Error:', error);
    // Handle any errors
    });
}