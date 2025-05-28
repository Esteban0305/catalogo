<?php
  require_once 'models/Usuario.php';
  require_once 'models/Zapatos.php';
  require_once 'validate.php';

  if (!isAdminProductos()) {
    header('Location: /src/login.php');
  }

  $zapatos = Zapato::getAllZapatos();

  function alertaNuevoZapato() {
    if (isset($_SESSION['last-zapato'])) {
      echo 'Nuevo Zapato agregado';
      unset($_SESSION['last-zapato']);
    }
  }
  
  function alertaDelZapato() {
    if (isset($_SESSION['del-zapato'])) {
      echo 'Zapato eliminado';
      unset($_SESSION['del-zapato']);
    }
  }

  // TODO: Alertas bien
  alertaNuevoZapato();
  // TODO: Alertas eliminación bien
  alertaDelZapato();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administración de Zapatos</title>
</head>
<body>
  <header>
    <h1>Administración de Zapatos</h1>
    <p><a href="logout.php">Cerrar sesión</a></p>
    <nav>
      <ul>
        <li><a href="adminProducts.php">Productos</a></li>
        <li><a href="adminUsers.php">Usuarios</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <p><a href="zapato/nuevo_zapato.php">Nuevo Zapato</a></p>
    <?php
      foreach($zapatos as $zapato) {
        echo "<div>";
        echo "<h2>" . htmlspecialchars($zapato->nombre) . "</h2>";
        echo "<p>Precio: $" . htmlspecialchars($zapato->precio) . "</p>";
        echo "<a href='zapato/zapato.php?id=" . $zapato->id_zapato . "'>Editar</a>";
        echo "</div>";
      }
    ?>
  </main>
</body>
</html>