<?php

// SSL-Zertifikatspfad und Schlüsselpfad
$certFile = 'server.crt';
$keyFile = 'server.key';

// Server-Konfiguration
$serverOptions = array(
    'ssl' => array(
        'local_cert' => $certFile,
        'local_pk' => $keyFile,
        'allow_self_signed' => true, // Nur für Testzwecke, sollte in Produktionsumgebung deaktiviert werden
        'verify_peer' => false
    )
);

// Erstellen des HTTPS-Servers
$server = stream_socket_server('https://localhost', $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, stream_context_create($serverOptions));

if (!$server) {
    die("Fehler beim Starten des Servers: $errstr ($errno)");
}

echo "HTTPS-Server gestartet.\n";

// Endlosschleife für Serverbetrieb
while ($client = stream_socket_accept($server)) {
    // HTTPS-Verbindung akzeptieren
    $request = fread($client, 8192); // Anfrage lesen


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

    // Antwort an den Client senden
    $response = "HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\nDaten erfolgreich gesendet";
    fwrite($client, $response); // Antwort senden
    fclose($client); // Verbindung schließen
}

// Server beenden
fclose($server);

