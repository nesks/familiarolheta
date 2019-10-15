<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class colheita
{
  private  $Material, $Vindima, $Info,$Nome_Parreiral,$Codigo_Safra,$Tipo_Safra,$Tipo_SafraVinho;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO colheita VALUES(NULL, :Material, :Vindima, :Info,:Nome_Parreiral, :Codigo_Safra)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Material", $this->Material);
    $stmt->bindValue(":Vindima", $this->Vindima);
    $stmt->bindValue(":Info", $this->Info);
    $stmt->bindValue(":Nome_Parreiral", $this->Nome_Parreiral);
    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

  public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `colheita` ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

public function verificacaoTipo(){
    $stmt = $this->conn->prepare("SELECT count( DISTINCT parreiral.Nome_Cepa) AS X FROM `safra`, `colheita`, `parreiral` WHERE safra.Codigo LIKE :Codigo_Safra AND safra.Codigo LIKE colheita.Codigo_Safra AND colheita.Codigo_Parreiral LIKE parreiral.Codigo ");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);

      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


public function vindimaCount(){
    $stmt = $this->conn->prepare("SELECT count(*) as X from `colheita`, `parreiral` where :Nome_Parreiral LIKE colheita.Codigo_Parreiral");

    $stmt->bindValue(":Nome_Parreiral", $this->Nome_Parreiral);

      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function vindimaMax(){
    $stmt = $this->conn->prepare("SELECT max(colheita.Vindima) as MAX WHERE  :Nome_Parreiral LIKE colheita.Codigo_Parreiral AND :vindima > parreiral.Data_Plantio");

    $stmt->bindValue(":Nome_Parreiral", $this->Nome_Parreiral);
    $stmt->bindValue(":vindima", $this->Vindima);
 try {
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      return null;
    }
  }





public function verificacaoQuantidadeParaTipoVinho(){
    $stmt = $this->conn->prepare("SELECT count(*) as X, safra.Tipo_Safra as Tipo_Safra  FROM `safra`, `vinho` WHERE :Codigo_Safra LIKE safra.Codigo AND  safra.Tipo_Safra != 'NULL' AND safra.Codigo_Vinho LIKE vinho.Codigo GROUP BY safra.Tipo_Safra");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function verificacaoQuantidadeParaTipoVinhoCount(){
    $stmt = $this->conn->prepare("SELECT count(*) as X  FROM `safra`, `vinho` WHERE :Codigo_Safra LIKE safra.Codigo AND  safra.Tipo_Safra != 'NULL' AND safra.Codigo_Vinho LIKE vinho.Codigo");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function verificacaoQuantidade(){
    $stmt = $this->conn->prepare("SELECT count(*) FROM `safra`, `colheita`
WHERE :Codigo_Safra LIKE colheita.Codigo_Safra AND safra.Codigo LIKE colheita.Codigo_Safra");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addTipo(){
    $query = ("UPDATE `safra` SET safra.Tipo_Safra = :Tipo_Safra WHERE safra.Codigo LIKE :Codigo_Safra");
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
    $stmt->bindValue(":Tipo_Safra", $this->Tipo_Safra);
          try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

   public function addTipoVinho(){
    $query = ("UPDATE `vinho`,`safra`, `colheita` SET vinho.Classificacao = :Tipo_SafraVinho WHERE :Codigo_Safra LIKE safra.Codigo AND safra.Codigo_Vinho LIKE vinho.Codigo");
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
    $stmt->bindValue(":Tipo_SafraVinho", $this->Tipo_SafraVinho);
          try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

    public function verificarPossibilidade(){

    $stmt = $this->conn->prepare("SELECT count(*) as X FROM `safra`, `colheita`, `parreiral` as p 
WHERE :Nome_Parreiral LIKE p.Codigo AND p.Nome_Cepa != (SELECT v.Nome_Cepa FROM `parreiral`as v WHERE :Codigo_Safra LIKE safra.Codigo AND safra.Codigo LIKE colheita.Codigo_Safra AND colheita.Codigo_Parreiral LIKE v.Codigo)");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);

    $stmt->bindValue(":Nome_Parreiral", $this->Nome_Parreiral);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /**
  * @return mixed
  */
  public function setNumero($Numero)
  {
    $this->Numero = $Numero;
  }

  /**
  * @param mixed $id
  */
  public function getNumero()
  {
    return $this->Numero;
    
  }

  /**
  * @return mixed
  */
  public function getMaterial()
  {
    return $this->Material;
  }

  /**
  * @param mixed $email
  */
  public function setMaterial($Material)
  {
    $this->Material = $Material;
  }

  /**
  * @return mixed
  */
  public function getVindima()
  {
    return $this->Vindima;
  }

  /**
  * @param mixed $password
  */
  public function setVindima($Vindima)
  {
    $this->Vindima = $Vindima;
  }

  public function getInfo()
  {
    return $this->Info;
  }

  /**
  * @param mixed $id
  */
  public function setInfo($Info)
  {
    $this->Info = $Info;
  }

    public function getCodigo_Safra()
  {
    return $this->Codigo_Safra;
  }

  /**
  * @param mixed $id
  */
  public function setCodigo_Safra($Codigo_Safra)
  {
    $this->Codigo_Safra = $Codigo_Safra;
  }

    public function getNome_Parreiral()
  {
    return $this->Nome_Parreiral;
  }

  /**
  * @param mixed $id
  */
  public function setNome_Parreiral($Nome_Parreiral)
  {
    $this->Nome_Parreiral = $Nome_Parreiral;
  }
  

  public function getTipo_Safra()
  {
    return $this->Tipo_Safra;
  }

  /**
  * @param mixed $id
  */
  public function setTipo_Safra($Tipo_Safra)
  {
    $this->Tipo_Safra = $Tipo_Safra;
  }
    public function getTipo_SafraVinho()
  {
    return $this->Tipo_SafraVinho;
  }

  /**
  * @param mixed $id
  */
  public function setTipo_SafraVinho($Tipo_SafraV)
  {
    $this->Tipo_SafraVinho = $Tipo_SafraV;
  }
}

?>