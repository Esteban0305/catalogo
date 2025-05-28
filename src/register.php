<?php
  require_once 'models/Usuario.php';

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email and password from the form
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $usr = Usuario::register($email, $password);

    if ($usr instanceof Usuario) {
      $_SESSION['user'] = $usr->getToken();
      header('Location: index.php');
      exit();
    } else {
      echo "<script>alert('Registro incorrecto.');</script>";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de sesión</title>
</head>
<body>
  <form action="" method="POST">
    <label for="email">Correo</label>
    <input type="email" name="email" id="" required>
    <label for="password">Contraseña</label>
    <input type="password" name="password" id="" required>
    <button type="submit">Registrarse</button>
    <p><a href="login.php">Inicio de sesión</a></p>
  </form>
</body>
</html>