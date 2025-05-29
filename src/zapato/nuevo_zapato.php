<?php
  // Validación
  require_once '../models/Usuario.php';
  require_once '../models/Zapatos.php';
  require_once '../validate.php';

  if (!isAdminProductos()) {
    header("HTTP/1.1 403 Forbidden");
    include '../views/403.php';
    exit();
  }

  // Nuevo Zapato
  $zapatoAgregado = null;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email and password from the form
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $zapato = Zapato::register($nombre, $precio);

    if ($zapato instanceof Zapato) {
      $_SESSION['last-zapato'] = $zapato->id_zapato;
      header('Location: ../adminProducts.php');
    } else {
      echo "No zapato";
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nuevo Zapato</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registrar nuevo zapato</h2>
    <form action="" method="POST" class="space-y-5">
      <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" name="nombre" id="nombre" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
        <input type="number" name="precio" id="precio" step="0.1" min="0" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Registrar
      </button>
      <div class="text-center mt-4">
        <a href="/src/adminProducts.php" class="text-sm text-gray-600 hover:underline">← Volver a productos</a>
      </div>
    </form>
  </div>
</body>
</html>
