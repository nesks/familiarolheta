<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class propriedade
{
  private  $Administrador, $Terroir_Regiao,$Nome_Propriedade,$Email, $Telefone, $Endereco;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO propriedade VALUES(:Nome, :Administrador, :Terroir_Regiao)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Nome", $this->Nome_Propriedade);
    $stmt->bindValue(":Administrador", $this->Administrador);
    $stmt->bindValue(":Terroir_Regiao", $this->Terroir_Regiao);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    $query = "INSERT INTO contato VALUES(:Nome_Propriedade, :Email, :Telefone, :Endereco)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Nome_Propriedade", $this->Nome_Propriedade);
    $stmt->bindValue(":Email", $this->Email);
    $stmt->bindValue(":Telefone", $this->Telefone);
    $stmt->bindValue(":Endereco", $this->Endereco);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

 public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `propriedade`,`contato` WHERE `Nome`= `Nome_Propriedade`  ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

public function exibirTipoUva(){
    $stmt = $this->conn->prepare("SELECT * FROM `propriedade`,`parreiral` WHERE :Nome_Propriedade LIKE propriedade.Nome  AND parreiral.Nome_Propriedade LIKE propriedade.Nome_Propriedade");
    $stmt->bindValue(":Nome_Propriedade", $this->Nome_Propriedade);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }


 public function exibirUvasP(){
    $stmt = $this->conn->prepare("SELECT * FROM `propriedade`,`parreiral` WHERE propriedade.Nome LIKE parreiral.Nome_Propriedade AND   ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }




public function verificacao(){
    $stmt = $this->conn->prepare("SELECT * FROM `propriedade` WHERE `Nome` LIKE :Nome");
    $stmt->bindValue(':Nome', $this->Nome_Propriedade);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }



  /**
  * @return mixed
  */
  public function getAdministrador()
  {
    return $this->Administrador;
  }

  /**
  * @param mixed $email
  */
  public function setAdministrador($Administrador)
  {
    $this->Administrador = $Administrador;
  }

  /**
  * @return mixed
  */
  public function getTerroir_Regiao()
  {
    return $this->Terroir_Regiao;
  }

  /**
  * @param mixed $password
  */
  public function setTerroir_Regiao($Terroir_Regiao)
  {
    $this->Terroir_Regiao = $Terroir_Regiao;
  }
  public function getTelefone()
  {
    return $this->Telefone;
  }

  /**
  * @param mixed $email
  */
  public function setTelefone($Telefone)
  {
    $this->Telefone = $Telefone;
  }
  public function getEmail()
  {
    return $this->Email;
  }

  /**
  * @param mixed $email
  */
  public function setEmail($Email)
  {
    $this->Email = $Email;
  }
  public function getNome_Propriedade()
  {
    return $this->Nome_Propriedade;
  }

  /**
  * @param mixed $email
  */
  public function setNome_Propriedade($Nome_Propriedade)
  {
    $this->Nome_Propriedade = $Nome_Propriedade;
  }
   public function getEndereco()
  {
    return $this->Endereco;
  }

  /**
  * @param mixed $id
  */
  public function setEndereco($Endereco)
  {
    $this->Endereco = $Endereco;
  }

}


?>
