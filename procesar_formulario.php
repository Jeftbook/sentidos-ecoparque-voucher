<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  $cantidad_personas = $_POST['cantidad_personas'];
  $fecha = $_POST['fecha'];

  // Procesa los datos aquí
  echo "Nombre: $nombre<br>";
  echo "Apellido: $apellido<br>";
  echo "DNI: $dni<br>";
  echo "Cantidad de Personas: $cantidad_personas<br>";
  echo "Fecha: $fecha<br>";
}
