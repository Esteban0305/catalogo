<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';
  
  if (isAuth()) {
    header('Location: /src/index.php');
  }

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Verificar que exista el email y password
    $email    = $_POST['email'];
    $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($regex, $_POST['password'])) {
      echo "<script>alert('La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.');</script>";
      header('Location: register.php');
      exit();
    }
    $password = $_POST['password'];

    $usr = Usuario::register($email, $password);

    if ($usr instanceof Usuario) {
      $_SESSION['user'] = $usr->getToken();
      header('Location: index.php');
      exit();
    } else {
      echo "<script>alert('Registro incorrecto.');</script>";
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md relative">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registro</h2>
    <form onsubmit="return validarPassword()" action="register.php" method="POST" class="space-y-5">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <input type="email" name="email" id="email" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <p class="text-sm text-gray-500 mt-1">Debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.</p>
      </div>
      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Registrarse
      </button>
    </form>

    <!-- Alerta flotante -->
    <div id="alerta" class="hidden fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50 transition-all duration-500">
      <strong class="font-bold">Error:</strong>
      <span class="block sm:inline">La contraseña no cumple con los requisitos.</span>
    </div>
  </div>

  <script>
    function validarPassword() {
      const password = document.getElementById('password').value;
      const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

      if (!regex.test(password)) {
        const alerta = document.getElementById('alerta');
        alerta.classList.remove('hidden');
        setTimeout(() => {
          alerta.classList.add('hidden');
        }, 5000);
        return false;
      }
      return true;
    }
  </script>
</body>
</html>