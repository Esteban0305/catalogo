<?php
  require_once 'models/Usuario.php';
  require_once 'models/Zapatos.php';
  require_once 'validate.php';

  if (!isAuth()) {
    header('Location: /src/login.php');
  }
  
  if(!isCliente()) {
    echo "403";
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