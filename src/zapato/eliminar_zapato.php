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

  $id_zapato = $_GET['id'];
  $zapato = Zapato::getZapatoById($id_zapato);

  if(!$zapato instanceof Zapato) {
    // TODO: Mostrar 404
    echo "No zapato";
    exit();
  }

  if(Zapato::delete($id_zapato)) {
    $_SESSION['del-zapato'] = true;
  }

  header('Location: /src/adminProducts.php');
?>