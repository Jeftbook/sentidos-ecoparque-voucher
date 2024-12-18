<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">

      <h1>Formulario de Registro</h1>
      <form method="post">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>

        <div class="mb-3">
          <label for="mail" class="form-label">Correo electronico</label>
          <input type="text" class="form-control" id="mail" name="mail" required>
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Número de Telefono</label>
          <div class="input-group">
            <span class="input-group-text">Cod. de Area</span>
            <input type="number" class="form-control" id="codArea" name="codArea" required>
            <span class="input-group-text">Tel</span>
            <input type="number" class="form-control" id="telefono" name="telefono" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="provincia" class="form-label">Provincia</label>
          <input type="text" class="form-control" id="provincia" name="provincia" required>
        </div>

        <div class="mb-3">
          <label for="localidad" class="form-label">Localidad</label>
          <input type="text" class="form-control" id="localidad" name="localidad" required>
        </div>

        <div class="mb-3">
          <label for="cuantos_van" class="form-label">¿Cuantos van?</label>
          <input type="number" class="form-control" id="cuantos_van" name="cuantos_van" min="1" max="10" required>
        </div>

        <div class="mb-3">
          <label for="fecha" class="form-label">¿Que dia vas a asistir?</label>
          <input type="date" class="form-control" id="fecha" name="fecha" max="2025-03-31" required>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

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
?>