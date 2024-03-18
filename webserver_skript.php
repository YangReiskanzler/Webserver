<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbName = 'webserver';

//create connection
$conn = new mysqli($servername, $username, $password, $dbName);
//check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare ("INSERT INTO formular_daten (vorname, nachname, email, nachricht)
VALUES (?, ?, ?, ?)");

$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$email = $_POST["email"];
$nachricht = $_POST["nachricht"];

$stmt->bind_param("ssss", $vorname, $nachname, $email, $nachricht);
$stmt->execute();

$data = "$vorname, $nachname, $email, $nachricht\n";
file_put_contents('daten.txt', $data, FILE_APPEND);

if ($stmt->affected_rows > 0) {
    echo "Daten erfolgreich gesendet";
} else {
    echo "Error inserting data: " . $stmt->error;
}
$stmt->close();
$conn->close();


