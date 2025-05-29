<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';

  if (!isAdminUsuarios()) {
    header('Location: /src/login.php');
  }

  $usuarios = Usuario::getAllUsuarios();

  function alertaDelUsuario() {
    if (isset($_SESSION['del-usuario'])) {
      if ($_SESSION['del-usuario'] == true) {
        echo "<p>Usuario eliminado correctamente.</p>";
      } else {
        echo "<p>Error al eliminar el usuario.</p>";
      }
      unset($_SESSION['del-usuario']);
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración de Usuarios</title>
</head>
<body>
  <?php
    foreach($usuarios as $usuario) {
      echo "<div>";
      echo "<h2>{$usuario->nombre} ({$usuario->email})</h2>";
      echo "<p>Roles: " . implode(", ", $usuario->role) . "</p>";
      echo "<p><a href='usuarios/usuario.php?id={$usuario->id_usuario}'>Editar</a></p>";
      if ($usuario->id_usuario != Usuario::getUserByToken($_SESSION['user'] ?? 'null')->id_usuario) {
        echo "<p><a href='usuarios/eliminar_usuario.php?id={$usuario->id_usuario}'>Eliminar</a></p>";
      }
      echo "</div>";
    }
  ?>
</body>
</html>