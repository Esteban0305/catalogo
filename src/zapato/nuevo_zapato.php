<?php
  // Validación
  require_once '../models/Usuario.php';
  require_once '../models/Zapatos.php';
  require_once '../validate.php';

  if (!isAdminProductos()) {
    header('Location: /src/login.php');
  }

  // Nuevo Zapato
  $zapatoAgregado = null;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email and password from the form
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $zapato = Zapato::register($nombre, $precio);

    if ($zapato instanceof Zapato) {
      $_SESSION['last-zapato'] = $zapato->id_zapato;
      header('Location: ../adminProducts.php');
    } else {
      echo "No zapato";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuevo Zapato</title>
</head>
<body>
  <form action="" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>
    <label for="precio">Precio</label>
    <input type="number" name="precio" step="0.1" min="0" required>
    <button type="submit">Registrar</button>
  </form>
</body>
</html>