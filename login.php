<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to Connect : " . $conn->connect_error);;

$address =  $_POST['address'];

$stmt = $conn->prepare("SELECT * from address where address = ?");
$stmt->bind_param("s", $address);

if($stmt->execute())
{
  $result = $stmt->fetch();

  if($result)
  {
    echo "1";
  }
  else
  {
    echo "0";  
  }
  
}

?>