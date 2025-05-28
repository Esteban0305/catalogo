<?php
  require_once 'models/Usuario.php';
  require_once 'validate.php';

  if (!isAdminUsuarios()) {
    header('Location: /src/login.php');
  }
?>