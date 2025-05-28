<?php
  require_once 'models/Usuario.php';
  require_once 'models/Zapatos.php';

  session_start();

  if (isset($_SESSION['user'])) {
    $token = $_SESSION['user'];
    $usr = Usuario::getUserByToken($token);

    if (!$usr->isCliente()) {
      require_once 'views/403.php';
      exit();
    }
  } else {
    header('Location: login.php');
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