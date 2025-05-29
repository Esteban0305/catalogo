<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';
  require_once 'models/Zapatos.php';

  if(!isCliente()) {
    header("HTTP/1.1 403 Forbidden");
    include 'views/403.php';
    exit();
  }

  
  $usuario = Usuario::getUserByToken($_SESSION['user']);
  $id_usuario = $usuario->id_usuario;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_zapato'])) {
    $id_zapato = $_POST['id_zapato'];
    // Agregar el id_usuario
    if (Zapato::removeFromWishlist($id_usuario, $id_zapato)) {
      $_SESSION['wishlist_message'] = true;
    }
  }

  $wishlist = Usuario::getWishList($id_usuario);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist</title>
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
      <a href="" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition"><?php echo count($wishlist); ?> Wishlist</a>
    </nav>
  </header>

  <main class="flex-grow p-6">
    <?php foreach ($wishlist as $zapato): ?>
      <div class="bg-white shadow-md rounded-lg p-4 mb-4">
        <h2 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($zapato->nombre); ?></h2>
        <p class="text-gray-600">Precio: $<?php echo number_format($zapato->precio, 2); ?></p>
        <form action="wishlist.php" method="POST" class="mt-4">
          <input type="hidden" name="id_zapato" value="<?php echo $zapato->id_zapato; ?>">
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition">Eliminar de Wishlist</button>
        </form>
      </div>
    <?php endforeach; ?>
    <?php if (empty($wishlist)): ?>
      <p class="text-gray-500">Tu wishlist está vacía.</p>
    <?php endif; ?>
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