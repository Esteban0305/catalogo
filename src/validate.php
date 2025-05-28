<?php
  session_start();

  function isAuth() {
    if (isset($_SESSION['user'])) {
      $token = $_SESSION['user'];
      $usr = Usuario::getUserByToken($token);
  
      if ($usr instanceof Usuario) {
        $USER = $usr;
        return true;
      }
    }
    return false;
  }

  function isCliente() {
    if (!isAuth()) {
      return false;
    }
    $token = $_SESSION['user'];
    $usuario = Usuario::getUserByToken($token);

    return $usuario->isCliente();
  }

  function isAdminUsuarios() {
    if (!isAuth()) {
      return false;
    }
    $token = $_SESSION['user'];
    $usuario = Usuario::getUserByToken($token);

    return $usuario->isAdminUsuarios();
  }

  function isAdminProductos() {
    if (!isAuth()) {
      return false;
    }
    $token = $_SESSION['user'];
    $usuario = Usuario::getUserByToken($token);

    return $usuario->isAdminZapatos();
  }
?>