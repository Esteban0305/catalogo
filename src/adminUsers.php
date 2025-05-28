<?php
  require_once 'models/Usuario.php';

  session_start();

  if (isset($_SESSION['user'])) {
    $token = $_SESSION['user'];
    $usr = Usuario::getUserByToken($token);

    if (!$usr->isAdminUsuarios()) {
      require_once 'views/403.php';
    }
    exit();
  } else {
    header('Location: login.php');
    exit();
  }
?>