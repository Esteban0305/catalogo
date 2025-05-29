<?php
  require_once __DIR__ . '/../models/Zapatos.php';
  require_once __DIR__ . '/../models/Usuario.php';
  require_once '../validate.php';

  if (!isAdminProductos()) {
    header("HTTP/1.1 403 Forbidden");
    include '../views/403.php';
    exit();
  }
  
  if(!isset($_GET['id'])) {
    // TODO: Definir página de error
    header("HTTP/1.1 404 NOT FOUND");
    include '../views/404.html';
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_zapato  = $_POST['id'];
    $nombre     = $_POST['nombre'];
    $precio     = $_POST['precio'];
    
    $zapato = Zapato::update($id_zapato, $nombre, $precio);

    if ($zapato == true) {
      $_SESSION['save-zapato'] = 'guardado';
    } else {
      $_SESSION['save-zapato'] = $zapato;
    }

    header('Location: ../adminProducts.php');
    exit();
  }

  $id_zapato = $_GET['id'];
  $zapato = Zapato::getZapatoById($id_zapato);

  if(!$zapato instanceof Zapato) {
    header("HTTP/1.1 404 NOT FOUND");
    include '../views/404.html';
    exit();
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Zapato</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Editar Zapato</h2>
    <p class="mb-4 text-gray-600 text-center font-mono">ID: <?php echo htmlspecialchars($id_zapato); ?></p>

    <form action="?id=<?php echo htmlspecialchars($id_zapato); ?>" method="POST" class="space-y-5">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_zapato); ?>" />
      
      <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" name="nombre" id="nombre" required
               value="<?php echo htmlspecialchars($zapato->nombre); ?>"
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
        <input type="number" name="precio" id="precio" min="0" step="0.1" required
               value="<?php echo htmlspecialchars($zapato->precio); ?>"
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div class="flex justify-between items-center">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
          Actualizar
        </button>

        <a href="eliminar_zapato.php?id=<?php echo htmlspecialchars($id_zapato); ?>"
           class="text-red-600 hover:underline font-semibold">
          Eliminar
        </a>
      </div>
    </form>

    <p class="mt-6 text-center">
      <a href="../adminProducts.php" class="text-blue-600 hover:underline">Regresar</a>
    </p>
  </div>
</body>
</html>