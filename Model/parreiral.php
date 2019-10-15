<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class parreiral
{
  private  $Quantidade_Vinhas, $Area, $Nome_Propriedade, $Nome_Cepa, $Data_Plantio;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO parreiral VALUES(NULL, :Quantidade_Vinhas, :Area, :Nome_Propriedade,:Nome_Cepa, :Data_Plantio)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Quantidade_Vinhas", $this->Quantidade_Vinhas);
    $stmt->bindValue(":Area", $this->Area);
    $stmt->bindValue(":Nome_Propriedade", $this->Nome_Propriedade);
    $stmt->bindValue(":Nome_Cepa", $this->Nome_Cepa);
    $stmt->bindValue(":Data_Plantio", $this->Data_Plantio);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

 public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `parreiral` ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getQuantidade_Vinhas()
  {
    return $this->Quantidade_Vinhas;
  }

  /**
  * @param mixed $email
  */
  public function setQuantidade_Vinhas($Quantidade_Vinhas)
  {
    $this->Quantidade_Vinhas = $Quantidade_Vinhas;
  }

  /**
  * @return mixed
  */
  public function getArea()
  {
    return $this->Area;
  }

  /**
  * @param mixed $password
  */
  public function setArea($Area)
  {
    $this->Area = $Area;
  }

  public function getNome_Propriedade()
  {
    return $this->Nome_Propriedade;
  }

  /**
  * @param mixed $id
  */
  public function setNome_Cepa($Nome_Cepa)
  {
    $this->Nome_Cepa = $Nome_Cepa;
  }

    public function getNome_Cepa()
  {
    return $this->Nome_Cepa;
  }

  /**
  * @param mixed $id
  */
  public function setNome_Propriedade($Nome_Propriedade)
  {
    $this->Nome_Propriedade = $Nome_Propriedade;
  }
    public function setData_Plantio($Data_Plantio)
  {
    $this->Data_Plantio = $Data_Plantio;
  }

    public function getData_Plantio()
  {
    return $this->Data_Plantio;
  }
  
}

?>
