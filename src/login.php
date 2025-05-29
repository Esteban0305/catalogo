<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';
  
  if (isAuth()) {
    header('Location: /src/index.php');
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Validar que el email y el password estén
    $email = $_POST['email'];
    $password = $_POST['password'];

    $log = Usuario::login($email, $password);

    if ($log) {
      $_SESSION['user'] = $log->getToken();

      if($log->isAdminUsuarios()) {
        header('Location: adminUsers.php');
      }

      if($log->isAdminZapatos()) {
        header('Location: adminProducts.php');
      }

      if($log->isCliente()) {
        header('Location: index.php');
      }
      exit();
    } else {
      $_SESSION['error'] = 'Correo electrónico o contraseña incorrectos.';
    }
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar sesión</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <?= htmlspecialchars($_SESSION['error']) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-5">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <input type="email" name="email" id="email" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Entrar
      </button>
      <p class="text-center text-sm text-gray-600">
        ¿No tienes cuenta?
        <a href="register.php" class="text-blue-600 hover:underline">Regístrate aquí</a>
      </p>
    </form>
  </div>
</body>
</html>