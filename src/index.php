<?php
  require_once 'models/Usuario.php';
  require_once 'models/Zapatos.php';
  require_once 'validate.php';

  if(!isCliente()) {
    header("HTTP/1.1 403 Forbidden");
    include 'views/403.php';
    exit();
  }

  $zapatos = Zapato::getAllZapatos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapatería</title>
</head>
<body>
    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>