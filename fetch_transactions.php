<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to connect: " . $conn->connect_error);

$address = file_get_contents('php://input');

$stmt = $conn->prepare("SELECT to_address, SUM(amount) AS total_amount FROM transactions WHERE from_address = ? GROUP BY to_address");
$stmt->bind_param("s", $address);
$stmt->execute();
$result = $stmt->get_result();

$to_adds = [];
$amounts = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $to_adds[] = $row["to_address"];
    $amounts[] = $row["total_amount"];
  }
}

$data = array(
  'to_adds' => $to_adds,
  'amounts' => $amounts
);

header('Content-Type: application/json');
echo json_encode($data);
?>
