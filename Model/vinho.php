<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class vinho
{
  private $codigo, $nome, $rotulo , $classificacao = NULL;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO vinho VALUES(NULL,:Nome, :Rotulo, :Classificacao)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Nome", $this->nome);
    $stmt->bindValue(":Rotulo", $this->rotulo);
    $stmt->bindValue(":Classificacao", $this->classificacao);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

  public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `vinho`");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
   public function vinhoS(){
    $stmt = $this->conn->prepare("SELECT * FROM `vinho`,`safra` WHERE vinho.Codigo LIKE safra.Codigo_Vinho");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
 public function verificacao(){
    $stmt = $this->conn->prepare("SELECT * FROM `vinho` WHERE `Nome` LIKE :Nome");
    $stmt->bindValue(':Nome', $this->nome);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
  * @return mixed
  */
  public function getCodigo()
  {
    return $this->codigo;
  }

  /**
  * @param mixed $id
  */
  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  /**
  * @return mixed
  */
  public function getNome()
  {
    return $this->nome;
  }

  /**
  * @param mixed $email
  */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  /**
  * @return mixed
  */
  public function getRotulo()
  {
    return $this->rotulo;
  }

  /**
  * @param mixed $password
  */
  public function setRotulo($rotulo)
  {
    $this->rotulo = $rotulo;
  }


}

?>
