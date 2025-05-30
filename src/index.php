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

  $zapatos = Zapato::getAllZapatos();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_zapato'])) {
    $id_zapato = $_POST['id_zapato'];
    $zapato = Zapato::getZapatoById($id_zapato);
    
    if ($zapato) {
      Zapato::addToWishlist($id_usuario, $id_zapato);
      $_SESSION['wishlist_message'] = true;
    }
  }

  function alertaZapatoWish() {
    if (isset($_SESSION['wishlist_message'])) {
      echo '<div class="toast fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
              Zapato agregado a la wishlist.
            </div>';
      unset($_SESSION['wishlist_message']);
    }
  }

  $wishlist = Usuario::getWishList($id_usuario);
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
      <a href="wishlist.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition"><?php echo count($wishlist); ?> Wishlist</a>
    </nav>
  </header>

  <main class="flex-grow p-6">
    <?php alertaZapatoWish(); ?>
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Catálogo de Zapatos</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($zapatos as $zapato): ?>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
          <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($zapato->nombre) ?></h2>
          <p class="text-gray-600">$<?= number_format($zapato->precio, 2) ?></p>
          <form action="" method="POST" class="mt-4">
            <input type="hidden" name="id_zapato" value="<?= $zapato->id_zapato ?>">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
              Agregar a la wishlist
            </button>
          </form>
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