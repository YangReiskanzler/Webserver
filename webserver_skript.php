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

//insert data into database
$stmt = $conn->prepare ("INSERT INTO formular_daten (vorname, nachname, email, nachricht, zahl)
VALUES (?, ?, ?, ?,?)");

//get data from form
$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$email = $_POST["email"];
$nachricht = $_POST["nachricht"];
$zahl = $_POST["zahl"];

//bind parameters
$stmt->bind_param("ssssi", $vorname, $nachname, $email, $nachricht, $zahl);
$stmt->execute();

//write data to file
$data = "$vorname, $nachname, $email, $nachricht\n";
file_put_contents('daten.txt', $data, FILE_APPEND);

//check if data was inserted
if ($stmt->affected_rows > 0) {
    echo "Daten erfolgreich gesendet";
} else {
    echo "Error inserting data: " . $stmt->error;
}
$stmt->close();
$conn->close();


