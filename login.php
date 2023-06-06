<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Failed to Connect : " . $conn->connect_error);
}

$address =  $_POST['address'];

$stmt = $conn->prepare("SELECT * from address where address = ?");
$stmt->bind_param("s", $address);

if($stmt->execute())
{
  $result = $stmt->fetch();

  if($result)
  {
    echo '<script>window.location.href="home.html"</script>';
  }
  else
  {
    echo '<script>
    alert("USER DOES NOT EXIST");
    window.location.href="index.html"
    </script>';  
  }
  
}

?>