<?php

namespace FamiliaRolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class Users
{
  private $id, $email, $password, $nome, $dt_nasc, $foto;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO cadastro2 VALUES(NULL, :email, :password, :foto, :dt_nasc, :nome)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":email", $this->email);
    $stmt->bindValue(':password', hash('sha1', $this->password));
    $stmt->bindValue(":foto", $this->foto);
    $stmt->bindValue(":dt_nasc", $this->dt_nasc);
    $stmt->bindValue(":nome", $this->nome);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

  public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `cadastro2` WHERE `email` LIKE :email");
    $stmt->bindValue(':email', '%' . $this->email . '%');
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }


  /**
  * @return mixed
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * @param mixed $id
  */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
  * @return mixed
  */
  public function getEmail()
  {
    return $this->email;
  }

  /**
  * @param mixed $email
  */
  public function setEmail($email)
  {
    $this->email = $email;
  }

  /**
  * @return mixed
  */
  public function getPassword()
  {
    return $this->password;
  }

  /**
  * @param mixed $password
  */
  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getFoto()
  {
    return $this->foto;
  }

  /**
  * @param mixed $id
  */
  public function setFoto($foto)
  {
    $this->foto = $foto;
  }

  public function getdt_nasc()
  {
    return $this->dt_nasc;
  }

  /**
  * @param mixed $id
  */
  public function setdt_nasc($dt_nasc)
  {
    $this->dt_nasc = $dt_nasc;
  }

public function getNome()
  {
    return $this->nome;
  }

  /**
  * @param mixed $id
  */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }


}

?>
