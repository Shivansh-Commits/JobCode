<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$address =  $_POST['address'];
$amount = $_POST['generate_jobcoin_input'];

$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to Connect : " . $conn->connect_error);

$stmt = $conn->prepare("UPDATE address SET balance = balance + ? WHERE address = ?");
$stmt->bind_param("ss", $amount,$address);

    if($stmt->execute())
    {
        if($stmt->affected_rows > 0)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }


?>