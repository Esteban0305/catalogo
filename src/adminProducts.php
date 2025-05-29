<?php
  require_once 'models/Usuario.php';
  require_once 'models/Zapatos.php';
  require_once 'validate.php';

  if (!isAdminProductos()) {
    header("HTTP/1.1 403 Forbidden");
    include 'views/403.php';
    exit();
  }

  $zapatos = Zapato::getAllZapatos();

  function alertaNuevoZapato() {
    if (isset($_SESSION['last-zapato'])) {
      echo '<div class="toast fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
              Nuevo Zapato agregado correctamente.
            </div>';
      unset($_SESSION['last-zapato']);
    }
  }

  function alertaZapatoGuardado() {
    if (isset($_SESSION['save-zapato'])) {
      echo '<div class="toast fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
              Zapato actualizado correctamente.
            </div>';
      unset($_SESSION['save-zapato']);
    }
  }

  function alertaDelZapato() {
    if (isset($_SESSION['del-zapato'])) {
      echo '<div class="toast fixed bottom-5 right-5 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-95 animate-slide-in-out">
              Zapato eliminado correctamente.
            </div>';
      unset($_SESSION['del-zapato']);
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración de Zapatos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Administración de Zapatos</h1>
    </div>
    <nav class="space-x-4">
      <?php if (isAdminUsuarios()): ?>
        <a href="adminUsers.php" class="text-blue-600 hover:underline font-medium">Usuarios</a>
      <?php endif; ?>
      <a href="logout.php" class="text-red-600 hover:underline font-medium">Cerrar sesión</a>
    </nav>
  </header>

  <main class="max-w-4xl mx-auto mt-8 p-4">
    <?php
      alertaNuevoZapato();
      alertaZapatoGuardado();
      alertaDelZapato();
    ?>

    <div class="mb-6">
      <a href="zapato/nuevo_zapato.php"
         class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
        + Nuevo Zapato
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php foreach($zapatos as $zapato): ?>
        <div class="bg-white rounded-lg shadow p-4">
          <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($zapato->nombre) ?></h2>
          <p class="text-gray-600 mt-2">Precio: $<?= htmlspecialchars($zapato->precio) ?></p>
          <a href="zapato/zapato.php?id=<?= $zapato->id_zapato ?>"
             class="mt-4 inline-block text-blue-600 hover:underline">
            Editar
          </a>
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