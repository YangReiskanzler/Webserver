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

$sql = "INSERT INTO formular_daten (vorname, nachname, email, nachricht)
VALUES ('" . $_POST["vorname"] . "','" . $_POST["nachname"] . "','" . $_POST["email"] . "','" . $_POST["nachricht"] . "')";

$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$email = $_POST["email"];
$nachricht = $_POST["nachricht"];

$data = "$vorname, $nachname, $email, $nachricht\n";
file_put_contents('daten.txt', $data, FILE_APPEND);

if ($conn->query($sql) === TRUE) {
  echo "Daten erfolgreich gesendet";
}else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


