<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';

  if (!isAdminUsuarios()) {
    header("HTTP/1.1 403 Forbidden");
    include 'views/403.php';
    exit();
  }

  $usuarios = Usuario::getAllUsuarios();
  $currentUser = Usuario::getUserByToken($_SESSION['user'] ?? 'null');

  function alertaDelUsuario() {
    if (isset($_SESSION['del-usuario'])) {
      echo '<div class="toast fixed bottom-5 right-5 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
              Usuario eliminado correctamente.
            </div>';
      unset($_SESSION['del-usuario']);
    }
  }

  function alertaUpdUsuario(){
    if (isset($_SESSION['upd-usuario'])) {
      if (isset($_SESSION['upd-usuario'])) {
        echo '<div class="toast fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
                Usuario actualizado correctamente.
              </div>';
        unset($_SESSION['upd-usuario']);
      }
      unset($_SESSION['upd-usuario']);
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administración de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <?php alertaUpdUsuario(); alertaDelUsuario(); ?>
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Administración de Usuarios</h1>
    <nav class="space-x-4">
      <?php if (isAdminProductos()): ?>
        <a href="adminProducts.php" class="text-blue-600 hover:underline font-medium">Productos</a>
      <?php endif; ?>
      <a href="logout.php" class="text-red-600 hover:underline font-medium">Cerrar sesión</a>
    </nav>
  </header>

  <main class="max-w-5xl mx-auto mt-8 p-4">
    <?php alertaDelUsuario(); ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php foreach ($usuarios as $usuario): ?>
        <div class="bg-white shadow rounded-lg p-4">
          <h2 class="text-lg font-semibold text-gray-800">
            <span class="text-sm text-gray-500">(<?= htmlspecialchars($usuario->email) ?>)</span>
          </h2>
          <p class="text-gray-600 mt-1">Roles: <?= htmlspecialchars(implode(', ', $usuario->role)) ?></p>
          <div class="mt-4 space-x-4">
            <a href="usuarios/usuario.php?id=<?= $usuario->id_usuario ?>"
               class="text-blue-600 hover:underline font-medium">Editar</a>
            <?php if ($usuario->id_usuario != $currentUser->id_usuario): ?>
              <a href="usuarios/eliminar_usuario.php?id=<?= $usuario->id_usuario ?>"
                 class="text-red-600 hover:underline font-medium">Eliminar</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          keyframes: {
            'slide-in-out': {
              '0%': { transform: 'translateX(100%)', opacity: '0' },
              '10%': { transform: 'translateX(0)', opacity: '1' },
              '85%': { transform: 'translateX(0)', opacity: '1' },
              '100%': { transform: 'translateX(100%)', opacity: '0' },
            }
          },
          animation: {
            'slide-in-out': 'slide-in-out 8s ease forwards',
          }
        }
      }
    }
  </script>
</body>
</html>