<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
</head>

<body>
  <h1>Formulario de Registro</h1>
  <form action="procesar_formulario.php" method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellido">Apellido:</label><br>
    <input type="text" id="apellido" name="apellido" required><br><br>

    <label for="dni">DNI:</label><br>
    <input type="number" id="dni" name="dni" required><br><br>

    <label for="cantidad_personas">Cantidad de Personas:</label><br>
    <input type="number" id="cantidad_personas" name="cantidad_personas" min="1" required><br><br>

    <label for="fecha">Fecha:</label><br>
    <input type="date" id="fecha" name="fecha" required><br><br>

    <button type="submit">Enviar</button>
  </form>
</body>

</html>