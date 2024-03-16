<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $vorname = $_POST["vorname"];
  $nachname = $_POST["nachname"];
  $data = "$vorname, $nachname\n";
  file_put_contents("daten.txt", $data, FILE_APPEND);

  echo "Daten wurden erfolgreich gesendet!";

}


