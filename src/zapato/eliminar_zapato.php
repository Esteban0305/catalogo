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
    header("HTTP/1.1 404 NOT FOUND");
    include '../views/404.html';
    exit();
  }

  $id_zapato = $_GET['id'];
  $zapato = Zapato::getZapatoById($id_zapato);

  if(!$zapato instanceof Zapato) {
    header("HTTP/1.1 404 Not Found");
    include '../views/404.html';
    exit();
  }

  if(Zapato::delete($id_zapato)) {
    $_SESSION['del-zapato'] = true;
  }

  header('Location: /src/adminProducts.php');
?>