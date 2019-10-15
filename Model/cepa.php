<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class cepa
{
  private $Nome, $Regiao_Origem;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO cepa VALUES(:Nome, :Regiao_Origem)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Nome", $this->Nome);
    $stmt->bindValue(":Regiao_Origem", $this->Regiao_Origem);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `cepa` ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

   public function verificacao(){
    $stmt = $this->conn->prepare("SELECT * FROM `cepa` WHERE `Nome` LIKE :Nome");
    $stmt->bindValue(':Nome', $this->Nome);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
  * @return mixed
  */
  public function getNome()
  {
    return $this->Nome;
  }

  /**
  * @param mixed $id
  */
  public function setNome($Nome)
  {
    $this->Nome = $Nome;
  }

  /**
  * @return mixed
  */
  public function getRegiao_Origem()
  {
    return $this->Regiao_Origem;
  }

  /**
  * @param mixed $email
  */
  public function setRegiao_Origem($Regiao_Origem)
  {
    $this->Regiao_Origem = $Regiao_Origem;
  }


  
}

?>