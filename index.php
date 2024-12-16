<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
  <h1>Formulario de Registro</h1>
  <form action="procesar_formulario.php" method="post">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>

    <div class="mb-3">
      <label for="apellido" class="form-label">Apellido</label>
      <input type="text" class="form-control" id="apellido" name="apellido" required>
    </div>

    <div class="mb-3">
      <label for="mail" class="form-label">Mail</label>
      <input type="text" class="form-control" id="mail" name="mail" required>
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Número de Telefono</label>
      <div class="input-group">
        <span class="input-group-text">Cod. de Area</span>
        <input type="number" class="form-control" id="codArea" name="codArea" required>
      </div>
      <div class="input-group">
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>