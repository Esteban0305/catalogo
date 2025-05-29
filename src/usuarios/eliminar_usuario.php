<?php
  require_once __DIR__ . '/../models/Usuario.php';
  require_once '../validate.php';

  if (!isAdminUsuarios()) {
    header("HTTP/1.1 403 Forbidden");
    include '../views/403.php';
    exit();
  }
  if (!isset($_GET['id'])) {
    header("HTTP/1.1 404 Not Found");
    include '../views/404.html';
    exit();
  }

  $id_usuario = $_GET['id'];

  $usuario = Usuario::getUsuarioById($id_usuario);
  if (!$usuario instanceof Usuario) {
    header("HTTP/1.1 404 Not Found");
    include '../views/404.html';
    exit();
  }

  if ($usuario->id_usuario == Usuario::getUserByToken($_SESSION['user'] ?? 'null')->id_usuario) {
    // No se puede eliminar el usuario actual
    $_SESSION['del-usuario'] = false;
    header('Location: /src/adminUsers.php');
    exit();
  }

  if (Usuario::deleteUsuario($id_usuario)) {
    $_SESSION['del-usuario'] = true;
  } else {
    $_SESSION['del-usuario'] = false;
  }
  header('Location: /src/adminUsers.php');
  exit();
?>