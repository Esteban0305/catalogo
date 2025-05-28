<?php
  require_once __DIR__ . '/../db/db.php';

  class Zapato {
    public $id_zapato;
    public $nombre;
    public $id_marca;
    public $id_categoria;
    public $precio;

    public function __construct($id_zapato, $nombre, $id_marca, $id_categoria, $precio) {
      $this->id_zapato    = $id_zapato;
      $this->nombre       = $nombre;
      $this->id_marca     = $id_marca;
      $this->id_categoria = $id_categoria;
      $this->precio       = $precio;
    }

    static function getAllZapatos() {
      $query = "SELECT * FROM zapatos";
      $stmt = Database::getInstance()->getConnection()->prepare($query);
      $stmt->execute();
      $zapatos = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $zapatos[] = new Zapato($row['id_zapato'], $row['nombre'], $row['id_marca'], $row['id_categoria'], $row['precio']);
      }
      return $zapatos;
    }
  }
?>