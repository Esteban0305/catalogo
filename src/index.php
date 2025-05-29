<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';
  require_once 'models/Zapatos.php';

  if(!isCliente()) {
    header("HTTP/1.1 403 Forbidden");
    include 'views/403.php';
    exit();
  }

  $zapatos = Zapato::getAllZapatos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zapatería</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
  <header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-gray-800">Bienvenido a la Zapatería</h1>
    <nav class="space-x-4">
      <?php if (isAdminProductos()): ?>
        <a href="adminProducts.php" class="text-blue-600 hover:underline font-medium">Productos</a>
      <?php endif; ?>
      <?php if (isAdminUsuarios()): ?>
        <a href="adminUsers.php" class="text-blue-600 hover:underline font-medium">Usuarios</a>
      <?php endif; ?>
      <a href="logout.php" class="text-red-600 hover:underline font-medium">Cerrar sesión</a>
    </nav>
  </header>

  <main class="flex-grow p-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Catálogo de Zapatos</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($zapatos as $zapato): ?>
        <div class="bg-white rounded-2xl shadow p-4 hover:shadow-lg transition">
          <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($zapato->nombre); ?></h3>
          <p class="text-gray-600 mt-2">Precio: <span class="font-semibold">$<?php echo htmlspecialchars($zapato->precio); ?></span></p>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>