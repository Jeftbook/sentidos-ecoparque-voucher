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
    case 'lcl':
      $convenio = 'La Calera';
      break;
    case 'vscl':
      $convenio = 'Villa Sta. Cruz del Lago';
      break;
    case 'srq':
      $convenio = 'San Roque';
      break;
    case 'htg':
      $convenio = 'Huerta Grande';
      break;
    case 'vho':
      $convenio = 'Valle Hermoso';
      break;
    case 'sqi':
      $convenio = 'Villa P. Siquiman';
      break;
    case 'cbg':
      $convenio = 'Cabalango';
      break;
    case 'vcp':
      $convenio = 'Villa Carlos Paz';
      break;
    case 'ssc':
      $convenio = 'SOELSAC';
      break;
    case 'bcr':
      $convenio = 'BANCARIA';
      break;
    case 'sdp':
      $convenio = 'SADOP';
      break;
    case 'uepc':
      $convenio = 'UEPC';
      break;
    case 'fmc':
      $convenio = 'FARMACIA';
      break;
    case 'spt':
      $convenio = 'SuperTourUPD';
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

  class PDF extends FPDF
  {
    // Sobrescribe el método Header
    function Header()
    {
      // Inserta una imagen en la cabecera
      $ancho_imagen = $this->GetPageWidth() * 1;
      $x = ($this->GetPageWidth() - $ancho_imagen) / 2; // Calcula la posición centrada
      $this->Image('voucher_cab.png', $x, 0.1, $ancho_imagen); // x=$x, y=5, ancho=$ancho_imagen
    }
  }

  if ($convenio == 'SuperTourUPD') {
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Ln(60);
    $pdf->Cell(0, 10, 'Super Tour', 0, 1, 'C');
    $pdf->Cell(0, 10, 'UPD Egresados', 0, 1, 'C');
    $pdf->Cell(0, 10, '2025', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 24);
    $pdf->Cell(0, 10, 'Pase gratuito de estudiante para', 0, 1, 'C');
    $pdf->Cell(0, 10, $nombre, 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 20);
    $pdf->Cell(0, 10, "E incluye un", 0, 1, 'C');
    $pdf->Cell(0, 10, "descuento del 15% valido para", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 40);
    $pdf->Ln(5);
    $pdf->Cell(0, 15, $cuantos_van, 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 20);
    $pdf->Cell(0, 10, "personas", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "En la fecha $fecha_asistencia", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "El descuento del 15% es valido unicamente", 0, 1, 'C');
    $pdf->Cell(0, 10, "para la fecha consignada en este voucher,", 0, 1, 'C');
    $pdf->Cell(0, 10, "por pago de contado efectivo presentando", 0, 1, 'C');
    $pdf->Cell(0, 10, "el mismo en puerta.", 0, 1, 'C');
    $pdf->Ln(5);
  } else {
    // Generar PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Ln(60);
    $pdf->Cell(0, 10, 'Gracias por venir', 0, 1, 'C');
    $pdf->Cell(0, 10, $nombre, 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 20);
    $pdf->Cell(0, 10, "Te otorgamos un", 0, 1, 'C');
    $pdf->Cell(0, 10, "descuento valido para", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 40);
    $pdf->Ln(5);
    $pdf->Cell(0, 15, $cuantos_van, 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 20);
    $pdf->Cell(0, 10, "personas", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "En la fecha $fecha_asistencia", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "Descuento del 15% valido unicamente", 0, 1, 'C');
    $pdf->Cell(0, 10, "para la fecha consignada en este voucher,", 0, 1, 'C');
    $pdf->Cell(0, 10, "por pago de contado efectivo presentando", 0, 1, 'C');
    $pdf->Cell(0, 10, "el mismo en puerta.", 0, 1, 'C');
    $pdf->Ln(5);
  }


  switch ($convenio) {
    case 'Cosquin':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Santa Maria':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Bialet Masse':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'La Falda':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'La Calera':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Villa Santa Cruz del Lago':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'San Roque':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Huerta Grande':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Valle Hermoso':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Siquiman':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Cabalango':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'Villa Carlos Paz':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "Municipalidad de $convenio", 0, 1, 'C');
      break;
    case 'SOELSAC':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "$convenio", 0, 1, 'C');
      break;
    case 'BANCARIA':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "$convenio", 0, 1, 'C');
      break;
    case 'SADOP':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "$convenio", 0, 1, 'C');
      break;
    case 'UEPC':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "$convenio", 0, 1, 'C');
      break;
    case 'FARMACIA':
      $pdf->Cell(0, 10, "Descuento otorgado a", 0, 1, 'C');
      $pdf->Cell(0, 10, "$convenio", 0, 1, 'C');
      break;
    default:
      $pdf->Cell(0, 10, "Descuento promocional", 0, 1, 'C');
      break;
  }

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
    <title>Sentidos Ecoparque - Voucher</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
      body {
        background-image: url('follaje_infinito_02_lr.jpg');
        background-size: 512px 512px;
        background-repeat: repeat;
        background-color: rgba(255, 255, 255, 0);
        background-blend-mode: overlay;
      }

      .card {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
      }

      input.form-control {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid #ccc;
      }

      .input-group-text {
        background-color: rgba(255, 255, 255, 0.8);
      }

      button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
      }

      button[type="submit"]:hover {
        background-color: #0056b3;
      }

      h1,
      h2,
      h3 {
        text-align: center;
        color: #333;
        /* Color del texto del título */
      }
    </style>
    <link rel="icon" type="image/x-icon" href="sentidos_300x300.png">
  </head>

  <body>
    <div>
      <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px; margin:25px;">
          <div style="width: 100%; max-width: 450px; align-items-center; text-align: center;"><img src="sentidos_300x300.png" style="width: 100%; max-width:100px;"></div>
          <h1>Obten&eacute; tu descuento</h1>
          <h3>Te esperamos en Sentidos Ecoparque</h3>
          <form action="" method="post">
            <input type="hidden" name="convenio" value="<?php echo $convenio; ?>">

            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>

            <div class="mb-3">
              <label for="mail" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="mail" name="mail" required>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Número de Teléfono</label>
              <div class="input-group">
                <span class="input-group-text">Cod. de Área</span>
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
              <label for="cuantos_van" class="form-label">¿Cuántos van?</label>
              <input type="number" class="form-control" id="cuantos_van" name="cuantos_van" min="1" max="10" required>
            </div>

            <div class="mb-3">
              <label for="fecha" class="form-label">¿Qué día vas a asistir?</label>
              <input type="date" class="form-control" id="fecha" name="fecha" max="2025-03-31" required>
            </div>

            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Enviar</button>
          </form>
        </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        // Manejar el envío del formulario
        $('form').on('submit', function(e) {
          e.preventDefault(); // Evita la recarga de la página

          $.ajax({
            url: '', // Se enviará al mismo script PHP
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                // Configura el enlace para descargar el PDF
                const downloadLink = document.querySelector('#exampleModal a');
                downloadLink.href = response.pdf;
                downloadLink.download = 'voucher.pdf';

                // Muestra el modal
                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                modal.show();
              } else {
                alert('Error: Ocurrió un problema al procesar tu solicitud.');
              }
            },
            // error: function() {
            //   alert('Error: No se pudo conectar con el servidor.');
            // },
          });
        });
      });
    </script>
  </body>

  </html>

<?php
}
?>