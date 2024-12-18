<?php
require('fpdf/fpdf.php'); // Asegúrate de descargar FPDF y colocarlo en la misma carpeta.

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'c1312181_voucher';
$user = 'c1312181_voucher';
$password = '55riDEzamo';
$port = 3306;

$mysqli = new mysqli($host, $user, $password, $dbname, $port);
if ($mysqli->connect_errno) {
  echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  exit;
}

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error en la conexión a la base de datos: " . $e->getMessage();
  exit;
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Capturar los datos del formulario
  $convenio = $_POST['convenio'];
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

  switch ($convenio) {
    case 'cos':
      $convenio = 'Cosquin';
      break;
    case 'sta':
      $convenio = 'Santa Maria';
      break;
    case 'bms':
      $convenio = 'Bialet Masse';
      break;
    case 'lfd':
      $convenio = 'La Falda';
      break;
    default:
      $convenio = '';
      break;
  }

  // Guardar los datos en la base de datos
  $sql = "INSERT INTO voucher (nombre, apellido, mail, telefono, provincia, localidad, cuantos_van, que_dia_van, fecha_de_creacion, convenio)
            VALUES (:nombre, :apellido, :mail, :telefono, :provincia, :localidad, :cuantos_van, :que_dia_van, :fecha_de_creacion, :convenio)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':mail' => $mail,
    ':telefono' => ($codArea . $telefono),
    ':provincia' => $provincia,
    ':localidad' => $localidad,
    ':cuantos_van' => $cuantos_van,
    ':que_dia_van' => $fecha_asistencia,
    ':fecha_de_creacion' => $fecha_envio,
    ':convenio' => $convenio
  ]);

  // Generar PDF
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 10, 'Sentidos', 0, 1, 'C');
  $pdf->Ln(10);
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, "Gracias por venir $nombre", 0, 1, 'C');
  $pdf->Ln(5);
  $pdf->Cell(0, 10, $fecha_asistencia, 0, 1, 'C');
  $pdf->Ln(5);
  $pdf->Cell(0, 10, "Voucher con descuento valido para $cuantos_van", 0, 1, 'C');

  $pdfFile = 'voucher.pdf';
  $pdf->Output('F', $pdfFile);
} else {
  $convenio = isset($_GET['convenio']) ? htmlspecialchars($_GET['convenio']) : '';
?>

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
        <form action="" method="post">
          <input type="hidden" name="convenio" value="<?php echo $convenio; ?>">

          <!-- Campos del formulario -->
          <!-- Igual que el código original -->

          <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Enviar</button>
        </form>
      </div>
    </div>

    <!-- Modal con botón para descargar PDF -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registro exitoso</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Tu registro ha sido procesado correctamente.
          </div>
          <div class="modal-footer">
            <a href="voucher.pdf" class="btn btn-success" download>Descargar Voucher</a>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>

<?php
}
?>