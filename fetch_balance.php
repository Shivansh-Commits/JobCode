<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to Connect : " . $conn->connect_error);;

$input = file_get_contents('php://input');
$address = strtoupper($input);


$stmt = $conn->prepare("SELECT balance from address where address = ?");
$stmt->bind_param("s", $address);

$stmt->execute(); // Execute the prepared statement

$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc()) {
        // Access data fields
        echo $row["balance"];
    }
} 
else
{
    echo "false";
}

?>