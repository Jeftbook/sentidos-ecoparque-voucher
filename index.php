<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <style src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h1>Formulario de Registro</h1>
  <form action="procesar_formulario.php" method="post">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>

    <div class="mb-3">
      <label for="apellido" class="form-label">Apellido:</label>
      <input type="text" class="form-control" id="apellido" name="apellido" required>
    </div>

    <div class="mb-3">
      <label for="dni" class="form-label">DNI:</label>
      <input type="number" class="form-control" id="dni" name="dni" required>
    </div>

    <div class="mb-3">
      <label for="cantidad_personas" class="form-label">Cantidad de Personas:</label>
      <input type="number" class="form-control" id="cantidad_personas" name="cantidad_personas" min="1" required>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha:</label>
      <input type="date" class="form-control" id="fecha" name="fecha" required>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</body>

</html>