<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $mail = $_POST['mail'];
  $codArea = $_POST['codArea'];
  $telefono = $_POST['telefono'];
  $provincia = $_POST['provincia'];
  $localidad = $_POST['localidad'];
  $cuantos_van = $_POST['cuantos_van'];
  $fecha = $_POST['fecha'];


  // Procesa los datos aquí

  echo "Nombre: $nombre<br>";
  echo "Apellido: $apellido<br>";
  echo "Mail: $mail<br>";
  echo "Telefono: $codArea - $telefono<br>";
  echo "Provincia: $provincia<br>";
  echo "Localidad: $localidad<br>";
  echo "Cuantos van: $cuantos_van<br>";
  echo "Fecha: $fecha<br>";
}
