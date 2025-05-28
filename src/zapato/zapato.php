<?php
  require_once __DIR__ . '/../models/Zapatos.php';
  require_once __DIR__ . '/../models/Usuario.php';
  require_once '../validate.php';

  if (!isAdminProductos()) {
    // TODO: Error 403
    header('Location: /src/login.php');
  }

  if(!isset($_GET['id'])) {
    // TODO: Definir página de error
    echo "No zapato ID";
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_zapato  = $_POST['id'];
    $nombre     = $_POST['nombre'];
    $precio     = $_POST['precio'];
    
    $zapato = Zapato::update($id_zapato, $nombre, $precio);

    if ($zapato == true) {
      $_SESSION['last-zapato'] = true;
    } else {
      $_SESSION['last-zapato'] = $zapato;
    }
  }

  $id_zapato = $_GET['id'];
  $zapato = Zapato::getZapatoById($id_zapato);

  if(!$zapato instanceof Zapato) {
    // TODO: Mostrar 404
    echo "No zapato";
    exit();
  }

  function zapatoUpdate() {
    if (isset($_SESSION['last-zapato'])) {
      if ($_SESSION['last-zapato'] == true) {
        echo "Zapato guardado bien";
        unset($_SESSION['last-zapato']);
      }
    }
  }

  zapatoUpdate();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <p><pre><?php echo $id_zapato ?></pre></p>
  <form action="?id=<?php echo $id_zapato; ?>" method="POST">
    <input type="hidden" name="id" value="<?php echo $id_zapato; ?>">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?php echo $zapato->nombre; ?>">
    <label for="precio">Precio</label>
    <input type="number" name="precio" min="0" step="0.1" value="<?php echo $zapato->precio; ?>">
    <button type="submit">Actualizar</button>
    <a href="eliminar_zapato.php?id=<?php echo $id_zapato; ?>">Eliminar</a>
  </form>
  <p><a href="../adminProducts.php">Regresar</a></p>
</body>
</html>