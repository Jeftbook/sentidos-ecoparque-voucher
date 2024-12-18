<?php

$host = 'localhost';
$dbname = 'c1312181_voucher';
$user = 'c1312181_voucher';
$password = '55riDEzamo';
$port = 3306;

$mysqli = new mysqli($host, $user, $password, $dbname, $port);
if ($mysqli->connect_errno) {
  echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error en la conexión a la base de datos: " . $e->getMessage();
  exit;
}

// Verificar si el parámetro "convenio" existe en la URL
if (isset($_GET['convenio'])) {
  $convenio_param = $_GET['convenio'];

  // Definir el valor que quieres comparar
  $valor_permitido = 'especial123';

  switch ($convenio_param) {
    case 'cos':
      $convenio_param = 'Cosquin';
      break;

    case 'sta':
      $convenio_param = 'Santa Maria';
      break;

    case 'bms':
      $convenio_param = 'Bialet Masse';
      break;

    case 'lfd':
      $convenio_param = 'La Falda';
      break;

    default:
      $convenio_param = '';
      break;
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
    $sql = "INSERT INTO voucher (nombre, apellido, mail, telefono, provincia, localidad, cuantos_van, que_dia_van, fecha_de_creacion, convenio)
                  VALUES (:nombre, :apellido, :mail, :telefono, :provincia, :localidad, :cuantos_van, :que_dia_van, :fecha_de_creacion, :convenio)";
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
      ':fecha_de_creacion' => $fecha_envio,
      ':convenio' => $convenio_param
    ]);

    echo "Datos guardados correctamente.";
  }
} else {
  // Si el parámetro "convenio" no está presente en la URL
  echo "Error: Falta el parámetro 'convenio' en la URL.";
  exit;
}
