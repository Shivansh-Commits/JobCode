<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to Connect : " . $conn->connect_error);;

$new_address = file_get_contents('php://input');
 
$stmt = $conn->prepare("INSERT INTO address (address,balance) values (?,0)");
$stmt->bind_param("s", $new_address);

 // Execute the prepared statement

if ($stmt->execute()) 
{
   echo "true";
} 
else
{
    echo "false";
}

?>