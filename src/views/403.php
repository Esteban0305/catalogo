<?php
  include_once 'validate.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Error 403 - Acceso denegado</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="text-center">
    <h1 class="text-7xl font-bold text-blue-600 mb-4">403</h1>
    <p class="text-xl text-gray-700 mb-6">Acceso denegado</p>
    <p class="text-gray-600 mb-8">No tienes permiso para acceder a esta página.</p>
    <a href="/src/login.php"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
      Volver al inicio
    </a>

    <?php if (isAuth()): ?>
      <p class="mt-4 text-gray-500">O <a href="/src/logout.php" class="text-blue-600 hover:underline">Cerrar sesión</a></p>
    <?php endif; ?>
  </div>
</body>
</html>
