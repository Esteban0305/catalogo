<?php

  # TODO: Checar que sí exista la base de datos y que no esté vacía
  # TODO: Checar que las carpetas de uploads existan y que tengan permisos de escritura

  class Database {
      private static $instance = null;
      private $pdo;

      private function __construct() {
          $this->pdo = new PDO('sqlite:' . __DIR__ . '/database');
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

      public static function getInstance() {
          if (self::$instance === null) {
              self::$instance = new Database();
          }
          return self::$instance;
      }

      public function getConnection() {
          return $this->pdo;
      }
  }
?>