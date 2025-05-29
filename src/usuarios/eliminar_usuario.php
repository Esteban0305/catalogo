<?php
  require_once __DIR__ . '/../models/Usuario.php';
  require_once '../validate.php';

  if (!isAdminUsuarios()) {
    header('Location: /src/login.php');
    exit();
  }
  if (!isset($_GET['id'])) {
    // TODO: Error 404
    echo "ID de usuario no proporcionado.";
    exit();
  }

  $id_usuario = $_GET['id'];

  $usuario = Usuario::getUsuarioById($id_usuario);
  if (!$usuario instanceof Usuario) {
    // TODO: Error 404
    echo "Usuario no encontrado.";
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