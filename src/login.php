<?php
  require_once 'models/Usuario.php';

  session_start();

  if (isset($_SESSION['user'])) {
    $token = $_SESSION['user'];
    $usr = Usuario::getUserByToken($token);
    header('Location: index.php');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Get the email and password from the form
      $email = $_POST['email'];
      $password = $_POST['password'];

      $log = Usuario::login($email, $password);

      if ($log) {
          $_SESSION['user'] = $log->getToken();
          header('Location: index.php');
          exit();
      } else {
          echo "<script>alert('Correo o contraseña incorrectos.');</script>";
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
    <button type="submit">Entrar</button>
    <p><a href="register.php">Registro</a></p>
  </form>
</body>
</html>