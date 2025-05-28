<?php
  require_once __DIR__ . '/../db/db.php';

  class Usuario {
    public $id_usuario;
    public $email;
    public $nombre;
    private $token;
    public $role;

    static $ADMIN_USUARIOS = 'adminUsuarios';
    static $ADMIN_ZAPATOS = 'adminZapatos';
    static $CLIENTE = "cliente";

    public function getToken() {
      return $this->token;
    }

    function __construct($email, $role = ["cliente"]) {
      $this->id_usuario = null;
      $this->email = $email;
      $this->token = hash('sha256', $email . time());
      $this->role = $role;
    }

    static function register($email, $password) {
      try {
        $query = "INSERT INTO usuarios (correo, hash) VALUES (:email, :password)";
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);
        $result = $stmt->execute();
  
        if ($result) {
          $user = new Usuario($email);
          $user->setToken($user->token);
          return $user;
        } else {
          return "Error al registrar el usuario: " . implode(", ", $stmt->errorInfo());
        }
      } catch (Exception $e) {
        if ($e->getCode() == 23000) {
          return "El correo ya está en uso.";
        }
        return "Error: " . $e->getMessage();
      }
    }

    static function login($email, $password) {
      try {
        $query = "SELECT * FROM usuarios WHERE correo = :email";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }

      if ($user) {
        if (password_verify($password, $user['hash'])) {
          $logged = new Usuario($user['correo']);
          $logged->id_usuario = $user['id_usuario'];
          $logged->role = explode(',', $user['roles']);
          $logged->setToken($logged->token);
          return $logged;
        } else {
          return null;
        }
      } else {
        return null;
      }
    }

    static function getUserByToken($token) {
      try {
        $query = "SELECT * FROM usuarios WHERE token = :token";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
          $usr = new Usuario($user['correo']);
          $usr->id_usuario = $user['id_usuario'];
          $usr->role = explode(',', $user['roles']);
          return $usr;
        } else {
          return null;
        }
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }

    }

    private function setToken($token) {
      try {
        $query = "UPDATE usuarios SET token = :token WHERE correo = :email";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $this->token = $token;
      } catch (Exception $e) {
        return "Error: " . $e->getMessage();
      }
    }

    public function isAdminUsuarios() {
      return in_array(self::$ADMIN_USUARIOS, $this->role);
    }
    public function isAdminZapatos() {
      return in_array(self::$ADMIN_ZAPATOS, $this->role);
    }
    public function isCliente() {
      return in_array(self::$CLIENTE, $this->role);
    }
  }
?>