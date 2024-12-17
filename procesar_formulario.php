<?php

$host = 'localhost';
$dbname = 'c1312181_voucher';
$user = 'c1312181_voucher';
$password = '55riDEzamo';

$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error en la conexión a la base de datos: " . $e->getMessage();
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Capturar los datos del formulario
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $mail = $_POST['mail'];
  $codArea = $_POST['codArea'];
  $telefono = $_POST['telefono'];
  $provincia = $_POST['provincia'];
  $localidad = $_POST['localidad'];
  $cuantos_van = $_POST['cuantos_van'];
  $fecha_asistencia = $_POST['fecha'];
  $fecha_envio = date('Y-m-d H:i:s'); // Fecha de envío actual

  // Guardar los datos en la base de datos
  $sql = "INSERT INTO voucher (nombre, apellido, mail, telefono, provincia, localidad, cuantos_van, que_dia_van, fecha_de_creacion)
          VALUES (:nombre, :apellido, :mail, :telefono, :provincia, :localidad, :cuantos_van, :que_dia_van, :fecha_de_creacion)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':mail' => $mail,
    ':telefono' => ($codArea + $telefono),
    ':provincia' => $provincia,
    ':localidad' => $localidad,
    ':cuantos_van' => $cuantos_van,
    ':que_dia_van' => $fecha_asistencia,
    ':fecha_de_creacion' => $fecha_envio
  ]);
}
