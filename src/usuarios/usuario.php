<?php
  require_once __DIR__ . '/../models/Usuario.php';
  require_once '../validate.php';

  if (!isAdminUsuarios()) {
    header('Location: /src/login.php');
    exit();
  }

  if (!isset($_GET['id'])) {
    // TODO: Error 400
    echo "ID de usuario no proporcionado.";
    exit();
  }
  
  $id_usuario = $_GET['id'];
  $usuario = Usuario::getUsuarioById($id_usuario);

  // if(!$usuario instanceof Usuario) {
  //   echo "Usuario no encontrado.";
  //   exit();
  // }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roles = [];
    if (isset($_POST['cliente'])) {
      $roles[] = Usuario::$CLIENTE;
    }
    if (isset($_POST['adminUsuarios'])) {
      $roles[] = Usuario::$ADMIN_USUARIOS;
    }
    if (isset($_POST['adminZapatos'])) {
      $roles[] = Usuario::$ADMIN_ZAPATOS;
    }

    $token = $_SESSION['user'] ?? 'null';

    if(($usuario->id_usuario == Usuario::getUserByToken($token)->id_usuario) && !in_array(Usuario::$ADMIN_USUARIOS, $roles)) {
      $roles[] = Usuario::$ADMIN_USUARIOS;
    }

    $usuario->role = $roles;
    $result = Usuario::updateUsuario($usuario);

    if ($result === true) {
      // TODO: Alerta usuario actualizado
      echo "<p>Usuario actualizado correctamente.</p>";
    } else {
      echo "<p>Error al actualizar el usuario: $result</p>";
    }
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuario</title>
</head>
<body>
  <p><pre><?php echo $usuario->email ?><pre></p>
  <form action="" method="POST">
    <input type="hidden" name="id_usuario" value="<?php echo $usuario->id_usuario; ?>">
    <input type="checkbox" name="cliente" value="cliente" id="cliente" <?php echo in_array(Usuario::$CLIENTE, $usuario->role) ? 'checked' : ''; ?>>
    <label for="cliente">Cliente</label>
    <input type="checkbox" name="adminUsuarios" value="adminUsuarios" id="adminUsuarios" <?php echo in_array(Usuario::$ADMIN_USUARIOS, $usuario->role) ? 'checked' : ''; ?>>
    <label for="adminUsuarios">Administrador de Usuarios</label>
    <input type="checkbox" name="adminZapatos" value="adminZapatos" id="adminZapatos" <?php echo in_array(Usuario::$ADMIN_ZAPATOS, $usuario->role) ? 'checked' : ''; ?>>
    <label for="adminZapatos">Administrador de Zapatos</label>
    <button type="submit">Guardar</button>
    <a href="../adminUsers.php">Volver a la lista de usuarios</a>
    <?php

    ?>
  </form>
</body>
</html>