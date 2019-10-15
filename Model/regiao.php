<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class regiao
{
  private $Terroir, $Clima, $Umidade, $Altitude, $Indice_Pluviometrico;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO regiao VALUES(:Terroir, :Clima, :Umidade, :Altitude, :Indice_Pluviometrico)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindValue(":Terroir", $this->Terroir);
    $stmt->bindValue(":Clima", $this->Clima);
    $stmt->bindValue(":Umidade", $this->Umidade);
    $stmt->bindValue(":Altitude", $this->Altitude);
    $stmt->bindValue(":Indice_Pluviometrico", $this->Indice_Pluviometrico);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

  public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `regiao` ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function verificacao(){
    $stmt = $this->conn->prepare("SELECT * FROM `regiao` WHERE `Terroir` LIKE :Terroir");
    $stmt->bindValue(':Terroir', $this->Terroir);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }
  /**
  * @return mixed
  */
  public function getTerroir()
  {
    return $this->Terroir;
  }

  /**
  * @param mixed $id
  */
  public function setTerroir($Terroir)
  {
    $this->Terroir = $Terroir;
  }

  /**
  * @return mixed
  */
  public function getClima()
  {
    return $this->Clima;
  }

  /**
  * @param mixed $email
  */
  public function setClima($Clima)
  {
    $this->Clima = $Clima;
  }

  /**
  * @return mixed
  */
  public function getUmidade()
  {
    return $this->Umidade;
  }

  /**
  * @param mixed $password
  */
  public function setUmidade($Umidade)
  {
    $this->Umidade = $Umidade;
  }

  public function getAltitude()
  {
    return $this->Altitude;
  }

  /**
  * @param mixed $id
  */
  public function setAltitude($Altitude)
  {
    $this->Altitude = $Altitude;
  }

  public function getIndice_Pluviometrico()
  {
    return $this->Indice_Pluviometrico;
  }

  /**
  * @param mixed $id
  */
  public function setIndice_Pluviometrico($Indice_Pluviometrico)
  {
    $this->Indice_Pluviometrico = $Indice_Pluviometrico;
  }


}

?>
