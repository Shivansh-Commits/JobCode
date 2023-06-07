<?php

function save_transaction($conn,$to_address,$from_address,$amount)
{
  $stmt = $conn->prepare("INSERT INTO transactions (to_address, from_address, amount) VALUES (?,?,?)");
  $stmt->bind_param("sss",$to_address,$from_address,$amount);
  $stmt->execute();  // EXECUTE THE STATEMeNt
  
  if ($stmt->affected_rows > 0) 
  {
     return 1;
  }
  else
  {
    return 0;
  }
  
}
function transact($conn,$remaining_balance,$from_address,$amount,$to_address)
{

   //UPDATING RECEIVERS BALANCE
   $stmt = $conn->prepare("UPDATE address SET balance = balance + ? WHERE address = ?");
   $stmt->bind_param("ss", $amount,$to_address);

    if($stmt->execute())
    {
        if($stmt->affected_rows > 0)
        {

          //UPDATING SENDERS BALANCE
          $stmt = $conn->prepare("UPDATE address SET balance = ? WHERE address = ?");
          $stmt->bind_param("ss", $remaining_balance,$from_address);
          if($stmt->execute())
          {
              if($stmt->affected_rows > 0)
              {
                save_transaction($conn,$to_address,$from_address,$amount);
                echo "1";
              }
              else
              {
                echo "0";  
              }
          }

        }
        else
        {
          echo "0";  
        }
    }  
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jobcoindb";

$to_address =  $_POST['to_address'];
$amount = $_POST['amount'];
$from_address = $_POST['from_address'];

$to_address = filter_input(INPUT_POST, 'to_address', FILTER_SANITIZE_STRING);
$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$from_address = filter_input(INPUT_POST, 'from_address', FILTER_SANITIZE_STRING);


$conn = new mysqli($servername, $username, $password, $dbname) or die("Failed to Connect : " . $conn->connect_error);

$stmt = $conn->prepare("SELECT balance FROM address WHERE address = ?");
$stmt->bind_param("s",$from_address);
$stmt->execute();  // EXECUTE THE STATEMeNt
$result = $stmt->get_result();


if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    if($row['balance'] - $amount >= 0)  // CHECK IF BALANCE IS SUFFICIENT
    {

      $remaining_balance = $row['balance'] - $amount;
      transact($conn,$remaining_balance,$from_address,$amount,$to_address); //FUNCTION TO UPDATE SENDER-RECEIVER BALANCE

    }
    else
    {
      echo "-1";
    }
}

$stmt->close();
$conn->close();



?>