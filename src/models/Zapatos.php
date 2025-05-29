<?php
  require_once __DIR__ . '/../db/db.php';

  class Zapato {
    public $id_zapato;
    public $nombre;
    // public $id_marca;
    // public $id_categoria;
    public $precio;

    public function __construct($id_zapato, $nombre, /* $id_marca, $id_categoria, */ $precio) {
      $this->id_zapato    = $id_zapato;
      $this->nombre       = $nombre;
      // $this->id_marca     = $id_marca;
      // $this->id_categoria = $id_categoria;
      $this->precio       = $precio;
    }

    static function getAllZapatos() {
      $query = "SELECT * FROM zapatos";
      $stmt = Database::getInstance()->getConnection()->prepare($query);
      $stmt->execute();
      $zapatos = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $zapatos[] = new Zapato($row['id_zapato'], $row['nombre'], /* $row['id_marca'], $row['id_categoria'], */ $row['precio']);
      }
      return $zapatos;
    }

    static function getZapatoById($id_zapato){
      $query = 'SELECT * FROM zapatos WHERE id_zapato = :id_zapato;';
      $stmt = Database::getInstance()->getConnection()->prepare($query);
      $stmt->bindParam(':id_zapato', $id_zapato);
      $stmt->execute();
      $zapatos = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $zapatos[] = new Zapato($row['id_zapato'], $row['nombre'], /* $row['id_marca'], $row['id_categoria'], */ $row['precio']);
      }
      if (count($zapatos) == 0) {
        return false;
      }
      return $zapatos[0];
    }

    static function register($nombre, $precio) {
      try {
        $query = "INSERT INTO zapatos (nombre, precio) VALUES (:nombre, :precio)";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $result = $stmt->execute();

        if ($result) {
          return new Zapato(Database::getInstance()->getConnection()->lastInsertId(), $nombre, /* null, null, */ $precio);
        } else {
          return "Error al registrar el zapato: " . implode(", ", $stmt->errorInfo());
        }
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

    static function update($id_zapato, $nombre, $precio) {
      try {
        $query = "UPDATE zapatos SET nombre = :nombre, precio = :precio WHERE id_zapato = :id_zapato";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_zapato', $id_zapato);
        $result = $stmt->execute();

        if ($result) {
          return true;
        } else {
          return "Error al registrar el zapato: " . implode(", ", $stmt->errorInfo());
        }
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

    static function delete($id_zapato) {
      try {
        $query = "DELETE FROM wishlist WHERE id_zapato = :id_zapato";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_zapato', $id_zapato);
        $result = $stmt->execute();
        $query = "DELETE FROM zapatos WHERE id_zapato = :id_zapato";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_zapato', $id_zapato);
        $result = $stmt->execute();

        if ($result) {
          return true;
        } else {
          return "Error al eliminar el zapato: " . implode(", ", $stmt->errorInfo());
        }
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

    public static function getZapatosDeWishlist($id_usuario) {
      $query = "SELECT z.* FROM wishlist w JOIN zapatos z ON w.id_zapato = z.id_zapato WHERE w.id_usuario = :id_usuario";
      $stmt = Database::getInstance()->getConnection()->prepare($query);
      $stmt->bindParam(':id_usuario', $id_usuario);
      $stmt->execute();
      $zapatos = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $zapatos[] = new Zapato($row['id_zapato'], $row['nombre'], /* $row['id_marca'], $row['id_categoria'], */ $row['precio']);
      }
      return $zapatos;
    }

    public static function addToWishlist($id_usuario, $id_zapato) {
      try {
        $query = "INSERT INTO wishlist (id_usuario, id_zapato) VALUES (:id_usuario, :id_zapato)";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_zapato', $id_zapato);
        return $stmt->execute();
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

    public static function removeFromWishlist($id_usuario, $id_zapato) {
      try {
        $query = "DELETE FROM wishlist WHERE id_zapato = :id_zapato AND id_usuario = :id_usuario";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_zapato', $id_zapato);
        $stmt->bindParam(':id_usuario', $id_usuario);
        return $stmt->execute();
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

  }
?>