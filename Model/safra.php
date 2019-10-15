<?php

namespace familiarolheta\Arquivos\Model;

use \PDO;
use \PDOException;

require_once 'Database.php';

class safra
{
  private $Codigo_Vinho, $Ano, $Quant_Garrafas, $Tipo_Safra, $Avaliacao;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->dbSet();
  }

  public function insert()
  {
    $query = "INSERT INTO safra VALUES(:Codigo_Vinho, :Ano, :Quantidade_Garrafas,NULL,NULL,:Avaliacao)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(":Codigo_Vinho", $this->Codigo_Vinho);
    $stmt->bindValue(":Ano", $this->Ano);
    $stmt->bindValue(":Quantidade_Garrafas", $this->Quant_Garrafas);
    $stmt->bindValue(":Avaliacao", $this->Avaliacao);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->conn->lastInsertId();

  }

public function view(){
    $stmt = $this->conn->prepare("SELECT * FROM `safra` ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

public function verificarPossibilidade(){

    $stmt = $this->conn->prepare("SELECT count(*) as X FROM `safra`, `vinho` WHERE :Codigo_Safra LIKE safra.Codigo_Vinho AND safra.Codigo_Vinho LIKE vinho.Codigo AND safra.Tipo_Safra == NULL");

    $stmt->bindValue(":Codigo_Safra", $this->Codigo_Safra);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }






 

  /**
  * @return mixed
  */
  public function getCodigo_Vinho()
  {
    return $this->Codigo_Vinho;
  }

  /**
  * @param mixed $id
  */
  public function setCodigo_Vinho($Codigo_Vinho)
  {
    $this->Codigo_Vinho = $Codigo_Vinho;
  }

  /**
  * @return mixed
  */
  public function getAno()
  {
    return $this->Ano;
  }

  /**
  * @param mixed $email
  */
  public function setAno($Ano)
  {
    $this->Ano = $Ano;
  }

  /**
  * @return mixed
  */
  public function getQuantidade_Garrafas()
  {
    return $this->Quantidade_Garrafas;
  }

  /**
  * @param mixed $password
  */
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
     public function getAvaliacao()
  {
    return $this->Tipo_Safra;
  }

  /**
  * @param mixed $id
  */
  public function setAvaliacao($Avaliacao)
  {

    $this->Avaliacao = $Avaliacao;
  }
  

 public function setQuantidade_Garrafas($Quantidade_Garrafas)
  {
    $this->Quant_Garrafas = $Quantidade_Garrafas;

  
}
}
?>