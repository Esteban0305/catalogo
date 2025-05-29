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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Editar Usuario</h2>

    <p class="mb-4 text-gray-600 text-center font-mono"><?php echo htmlspecialchars($usuario->email); ?></p>

    <form action="" method="POST" class="space-y-6">
      <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario->id_usuario); ?>" />

      <div class="flex items-center space-x-3">
        <input type="checkbox" name="cliente" value="cliente" id="cliente"
          <?php echo in_array(Usuario::$CLIENTE, $usuario->role) ? 'checked' : ''; ?>
          class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" />
        <label for="cliente" class="text-gray-700 font-medium">Cliente</label>
      </div>

      <div class="flex items-center space-x-3">
        <input type="checkbox" name="adminUsuarios" value="adminUsuarios" id="adminUsuarios"
          <?php echo in_array(Usuario::$ADMIN_USUARIOS, $usuario->role) ? 'checked' : ''; ?>
          class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" />
        <label for="adminUsuarios" class="text-gray-700 font-medium">Administrador de Usuarios</label>
      </div>

      <div class="flex items-center space-x-3">
        <input type="checkbox" name="adminZapatos" value="adminZapatos" id="adminZapatos"
          <?php echo in_array(Usuario::$ADMIN_ZAPATOS, $usuario->role) ? 'checked' : ''; ?>
          class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" />
        <label for="adminZapatos" class="text-gray-700 font-medium">Administrador de Zapatos</label>
      </div>

      <div class="flex justify-between items-center">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
          Guardar
        </button>
        <a href="../adminUsers.php" class="text-blue-600 hover:underline font-semibold">Volver a la lista de usuarios</a>
      </div>
    </form>
  </div>
</body>
</html>