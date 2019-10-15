<?php  


  use FamiliaRolheta\Arquivos\Model\vinho;
  use FamiliaRolheta\Arquivos\Model\regiao;
  use FamiliaRolheta\Arquivos\Model\colheita;
  use FamiliaRolheta\Arquivos\Model\parreiral;
  use FamiliaRolheta\Arquivos\Model\safra;
  use FamiliaRolheta\Arquivos\Model\propriedade;
  use FamiliaRolheta\Arquivos\Model\cepa;
  require_once 'Model/vinho.php';
  require_once 'Model/regiao.php';
  require_once 'Model/colheita.php';
  require_once 'Model/parreiral.php';
  require_once 'Model/propriedade.php';
  require_once 'Model/cepa.php';
  require_once 'Model/safra.php';

     if(isset($_POST['vinho'])){
       $vinho = new vinho();
            $vinho->setNome($_POST['nome']);
            $vinho->setRotulo($_FILES['rotulo']);
            $img=$_FILES['rotulo'];
      $imgNome=$img['name'];
      if(empty($imgNome)){
          $ft='icon.png';
      }else{
        $extensao = strtolower(substr($_FILES['rotulo']['name'], -4));
          $novo_nome = md5(time()).$extensao;
          $diretorio = 'upload/';
          move_uploaded_file($_FILES['rotulo']['tmp_name'], $diretorio.$novo_nome);
          $ft=$novo_nome;
      }
      $vinho->setRotulo($ft);
       if(!is_object($vinho->verificacao())){
                $vinho->insert();
                ?><div class="alert alert-danger" role="alert" id="alertaVerde">
  ! Cadastro efetuado.
</div><?php
            } else{
              ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
  ! Nome já existente.
</div><?php
            }
     } 
        else if(isset($_POST['safra'])){
            $safra = new safra();
            $safra->setCodigo_Vinho($_POST['Codigo_Vinho']);
            $safra->setAno($_POST['Ano']);
            $safra->setQuantidade_Garrafas($_POST['Quantidade_Garrafas']);
            $safra->setAvaliacao($_POST['Avaliacao']);
                       $safra->insert();
          
      }


      else if(isset($_POST['colheita'])){
            $colheita = new colheita();
            $colheita->setMaterial($_POST['Material']);
            $colheita->setVindima($_POST['Vindima']);
            $colheita->setNome_Parreiral($_POST['Nome_Parreiral']);
            $colheita->setCodigo_Safra($_POST['Codigo_Safra']);
            $colheita->setInfo($_POST['Info']);
            
            $quantidade=$colheita->verificacaoQuantidade();
            $quantidade=$quantidade[0];

            if($quantidade["count(*)"]<2){
              if($quantidade["count(*)"]!=0){
                              $possibilidade= $colheita->verificarPossibilidade();
                            $possibilidade=$possibilidade[0];
                            $x=$possibilidade["X"];
                            if($x==1){
                               $colheita->insert();
                              }else{
            ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
         ! Essa safra ja colheu esse tipo de uva.
        </div><?php
                   }
                            }else{ 
                              $count = $colheita->vindimaCount();
                              $count = $count[0];
                              $count = $count["X"];
                              if($count>0){
                                  $max = $colheita->vindimaMax();
                                      if($max!=null){
                                  $max = $max[0];
                                  $VindimaMax = $max["MAX"];  
                                  $VindimaDigitada = $colheita->getVindima();  
                                  $partes_da_data = explode('-',$VindimaMax);
                                  $partes_da_data[0]=$partes_da_data[0]+1;
                                  $VindimaMax = $partes_da_data[0].'-'.$partes_da_data[1].'-'.$partes_da_data[2];
                                  if($VindimaDigitada>$VindimaMax){ 

            $colheita->insert();
            }else{?><div class="alert alert-danger" role="alert" id="alertaVermelho">
  ! Parreiral selecionado ainda nao obteve colheita.
</div><?php
}
}
                              }else{
                                $colheita->insert();
                              }
          }
            }
             else{
              ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
  ! Essa safra já estourou o limite de colheitas de uvas.
</div><?php
            }
            $tipo=$colheita->verificacaoTipo();
            $tipo=$tipo[0];
            $x = $tipo["X"];
            if($x==2){
              $colheita->setTipo_Safra("assemblage");
            }else if($x==1){
              $colheita->setTipo_Safra("varietal");
            }else {
?><div class="alert alert-danger" role="alert" id="alertaVermelho">
  ! Safra vazia
</div><?php

            }
             $colheita->addTipo();
             $count=$colheita->verificacaoQuantidadeParaTipoVinhoCount();
             $count=$count[0];
             $count=$count["X"];
            if($count==1){
             $quant=$colheita->verificacaoQuantidadeParaTipoVinho();
            $quant=$quant[0]; 
            $tipo=$quant["Tipo_Safra"];
             $colheita->setTipo_SafraVinho($tipo);
            }else{
              $colheita->setTipo_SafraVinho("assemblage");
            }
           
             $colheita->addTipoVinho();
          }
       
          


          else if(isset($_POST['cepa'])){
            $cepa = new cepa();
            $cepa->setNome($_POST['Nome']);
            $cepa->setRegiao_Origem($_POST['Regiao_Origem']);
                 if(!is_object($cepa->verificacao())){
                $cepa->insert();
                ?><div class="alert alert-danger" role="alert" id="alertaVerde">
                ! Cadastro efetuado.
              </div><?php
            } else{
              ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
              ! Nome já existente.
            </div><?php
            }
          }


          else if(isset($_POST['parreiral'])){
            $parreiral = new parreiral();
            $parreiral->setQuantidade_Vinhas($_POST['Quantidade_Vinhas']);
            $parreiral->setArea($_POST['Area']);
            $parreiral->setNome_Propriedade($_POST['Nome_Propriedade']);
            $parreiral->setNome_Cepa($_POST['Nome_Cepa']);
            $parreiral->setData_Plantio($_POST['Data_Plantio']);
            $parreiral->insert();
          }


          else if(isset($_POST['regiao'])){
              $regiao = new regiao();
              $regiao->setTerroir($_POST['Terroir']);
              $regiao->setClima($_POST['Clima']);
              $regiao->setUmidade($_POST['Umidade']);
              $regiao->setAltitude($_POST['Altitude']);
              $regiao->setIndice_Pluviometrico($_POST['Indice_Pluviometrico']);
                 if(!is_object($regiao->verificacao())){
                $regiao->insert();
                ?><div class="alert alert-danger" role="alert" id="alertaVerde">
                ! Cadastro efetuado.
              </div><?php
            } else{
              ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
              ! Terroir já existente.
            </div><?php
            }
            }


            else if(isset($_POST['propriedade'])){
              $propriedade = new propriedade();
              $propriedade->setNome_Propriedade($_POST['Nome_Propriedade']);
              $propriedade->setAdministrador($_POST['Administrador']);
              $propriedade->setTerroir_Regiao($_POST['Terroir_Regiao']);
              $propriedade->setEmail($_POST['Email']);
              $propriedade->setTelefone($_POST['Telefone']);
              $propriedade->setEndereco($_POST['Endereco']);
                if(!is_object($propriedade->verificacao())){
                $propriedade->insert();
                ?><div class="alert alert-danger" role="alert" id="alertaVerde">
                ! Cadastro efetuado.
              </div><?php
            } else{
              ?><div class="alert alert-danger" role="alert" id="alertaVermelho">
              ! Nome já existente.
            </div><?php
            }
            }
?>



<!DOCTYPE html>
<html lang="en">

  <style>
  .botao{
font: Tahoma, Geneva, sans-serif;
font-style:normal;
color:#BEBEBE;
background:#353A40;
border:0px solid #ffffff;
padding:15px 15px;
cursor:pointer;
margin-left: 15px;
}
.botao:active{
  color:#D3D3D3;
  cursor:pointer;
  position:relative;
  top:3px;
  margin: 0 auto;
}
.botao:hover{
  color:#D3D3D3;
  cursor:pointer;
  position:relative;
  margin: 0 auto;
}



.arreda_Menu{
  margin-left: 235px;
}

.c{
  width: 200px;
}

.content-wrapper{
  background: #B22222;
}






  </style>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="Felipe Lanna, Fabio e Felipe Sousa">
   <title>Família Rolheta</title>
      <meta name="description" content="Conheça uma das melhores fabricas de vinho do pais.">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="shortcut icon" type="image/x-icon" href="img/icon.ico">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin.css" rel="stylesheet">



<style>
    #alertaVerde{
      font-size: 30px;
      background-color: #ccffc1;
              color: #333333;
              text-align: right;
    }
    #alertaVermelho{
       font-size: 30px;
              color: #333333;
              text-align: right;
              
    }


</style>

  </head>

  <body class="fixed-nav" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a href="img/icon.php">
      <a class="navbar-brand" href="#"><img src="img/icon.png">Familia Rolheta</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
          <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Menu">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">
                Menu</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Cadastrar">
             <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#CadastrarComponentes">
              <i class="fa fa-fw fa-area-chart"></i>
              <span class="nav-link-text">
                Cadastrar</span>
            </a>
             <form  action="home.php" method="post" action="cadastrar"   enctype="multipart/form-data">
            <ul class="sidenav-second-level collapse" id="CadastrarComponentes">
              <li>
             <input type="submit" name="cadastrarVinhos" value="Cadastrar Vinhos" class="botao"> </li>
              <li>
             <input type="submit" name="cadastrarSafras" value="Cadastrar Safras" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="cadastrarColheita" value="Cadastrar Colheita" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="cadastrarCepa" value="Cadastrar Cepas" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="cadastrarParreiral" value="Cadastrar Parreiral" class="botao"> </li>
             
              </li>
               <li>
                <input type="submit" name="cadastrarRegiao" value="Cadastrar Regiões" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="cadastrarPropriedade" value="Cadastrar Propriedades" class="botao"> </li>
              </li>
            </ul>
            </form>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Exibir">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#TabelasComponentes">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">
                Exibir tabelas</span>
            </a>
            <form  action="home.php" method="post" action="exibir"   enctype="multipart/form-data">
             <ul class="sidenav-second-level collapse" id="TabelasComponentes">
              <li>
             <input type="submit" name="exibirVinhos" value="Exibir Vinhos" class="botao"> </li>
              </li>
              <li>
             <input type="submit" name="exibirSafras" value="Exibir Safras" class="botao">
              </li>
               <li>
                 <input type="submit" name="exibirColheita" value="Exibir Colheita" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="exibirCepa" value="Exibir Cepas" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="exibirParreiral" value="Exibir Parreiral" class="botao"> </li>
             
              </li>
               <li>
                <input type="submit" name="exibirRegiao" value="Exibir Regiões" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="exibirPropriedade" value="Exibir Propriedades" class="botao"> </li>
              </li>
              </li>
            </ul>
            </form>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Exibir">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#TabelasPedidas">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">
                Tabelas pedidas</span>
            </a>
            <form  action="home.php" method="post" action="exibir"   enctype="multipart/form-data">
             <ul class="sidenav-second-level collapse" id="TabelasPedidas">
              <li>
             <input type="submit" name="exibirVinhosS" value="Exibir Vinhos por safra" class="botao"> </li>
              </li>
              <li>
             <input type="submit" name="exibirPropriedadeA" value="produção por ano na propriedade" class="botao">
              </li>
               <li>
                 <input type="submit" name="exibirUvasP" value="uvas plantadas na propriedade" class="botao"> </li>
              </li>
               <li>
                <input type="submit" name="exibirUvaA" value="anos mais produtivos por uva" class="botao"> </li>
              </li>
              </li>
            </ul>
            </form>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Configurações">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents">
              <i class="fa fa-fw fa-wrench"></i>
              <span class="nav-link-text">
                Configurações</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseComponents">
              <li>
                <a href="cadastrar.php">Cadastrar Funcionario</a>
              </li>
              <li>
                <a href="edit.php">Editar perfil</a>
              </li>
            </ul>
          </li>
         
        </ul>
        <ul class="navbar-nav sidenav-toggler">
          <li class="nav-item">
            <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
          </li>
        </ul>
         <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <h6 class="dropdown-header">Pesquisar por:</h6>
            </li>
            <li class="nav-item" style="margin-top: 1%;">
              <form method="post" action="pesquisar">
                    <select name="pesquisarPor">
                    <option value="vinho">Vinhos</option>
                    <option value="safra">Safras</option>
                    <option value="colheita">Colheitas</option>
                    <option value="cepa">Cepas</option>
                    <option value="parreiral">Parreirais</option>
                    <option value="regiao">Regiões</option>
                    <option value="propriedade">Propriedades</option>
                    </select>
</li>
 <li class="nav-item">&nbsp&nbsp</li>
          <li class="nav-item">
              <div class="input-group">

                <input type="text" class="form-control" placeholder="Pesquisar">
                <span class="input-group-btn">

                  <button class="btn btn-primary" type="button" name="pesquisar">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </form>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-fw fa-sign-out"></i>
              Sair</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="content-wrapper py-3">

      <div class="container-fluid">

       
       <!-- CADASTRAR -->
<?php 
if (isset($_POST['cadastrarVinhos'])) {
?>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Vinhos:
          </div>
          <div class="card-body">
            <div class="table-responsive">

            <form  action="home.php" method="post" action="exibir"   enctype="multipart/form-data">
                
              Nome do Vinho:&nbsp 
              <input type="text" name="nome">
              <br>
              Escolha a imagem do Rotulo 
              <input type="file" name="rotulo">
              <br>
              <input type="submit" name="vinho">
              </form>
              

             </div>
             </div>
             </div>
<?php 
}else if (isset($_POST['cadastrarSafras'])) {
?>
  <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Safras:
          </div>
          <div class="card-body">
            <div class="table-responsive">
            <form  action="home.php" method="post" action="exibirSafra"   enctype="multipart/form-data">
             Codigo do Vinho: 
              <select name = "Codigo_Vinho">
                <option> </option>
                
              <?php 

                $x = new vinho();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Codigo"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>
              <br>
              Ano:&nbsp 
              <select name = "Ano">
                <option> </option>
                <option>1950</option>
                <option>1951</option>
                <option>1952</option>
                <option>1953</option>
                <option>1954</option>
                <option>1955</option>
                <option>1956</option>
                <option>1957</option>
                <option>1958</option>
                <option>1959</option>
                <option>1960</option>
                <option>1961</option>
                <option>1962</option>
                <option>1963</option>
                <option>1964</option>
                <option>1965</option>
                <option>1966</option>
                <option>1967</option>
                <option>1968</option>
                <option>1969</option>
                <option>1970</option>
                <option>1971</option>
                <option>1972</option>
                <option>1973</option>
                <option>1974</option>
                <option>1975</option>
                <option>1976</option>
                <option>1977</option>
                <option>1978</option>
                <option>1979</option>
                <option>1980</option>
                <option>1981</option>
                <option>1982</option>
                <option>1983</option>
                <option>1984</option>
                <option>1985</option>
                <option>1986</option>
                <option>1987</option>
                <option>1988</option>
                <option>1989</option>
                <option>1990</option>
                <option>1991</option>
                <option>1992</option>
                <option>1993</option>
                <option>1994</option>
                <option>1995</option>
                <option>1996</option>
                <option>1997</option>
                <option>1998</option>
                <option>1999</option>
                <option>2000</option>
                <option>2001</option>
                <option>2002</option>
                <option>2003</option>
                <option>2004</option>
                <option>2005</option>
                <option>2006</option>
                <option>2007</option>
                <option>2008</option>
                <option>2008</option>
                <option>2009</option>
                <option>2010</option>
                <option>2011</option>
                <option>2012</option>
                <option>2013</option>
                <option>2014</option>
                <option>2015</option>
                <option>2016</option>
                <option>2017</option>
              </select>
              <br>
              Entre com a Quantidade de Garrafas produzidas nessa safra: 
  <input type="number" name="Quantidade_Garrafas" min="1">
              <br>
             Avalie essa safra: 
             <select name = "Avaliacao">
                <option> </option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                </select>
  <input type="number" name="Avaliacao" min="1">
              <br>
             
              <input type="submit" name="safra">
              </form>
             </div>
             </div>
             </div>

<?php
}else if (isset($_POST['cadastrarColheita'])) {
?>
<div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Colheita:
          </div>
          <div class="cardrd-body">
            <div class="table-responsive">
            <form  action="home.php" method="post" action="exibirColheita"   enctype="multipart/form-data">
              <br>
              Material do Tonel :&nbsp 
              <input type="text" name="Material">
              <br>
              Data da vindima :  
              <input type="date" name="Vindima">
              <br>
              Codigo do Parreiral :
                <select name = "Nome_Parreiral">
                <option> </option>
                
              <?php 

                $x = new parreiral();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Codigo"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>
              <br>
              Codigo de Safra :
               <select name = "Codigo_Safra">
                <option> </option>
                
              <?php 

                $x = new safra();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Codigo"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>               
              <br>
              Informacoes adicionais da Safra:&nbsp <br>
              <textarea name="Info" rows="5" cols="40"></textarea>
              <br>
     <input type="submit" name="colheita">
              </form>
             </div>
             </div>
             </div>
<?php
}else if (isset($_POST['cadastrarCepa'])) {
?>
<div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Cepa:
          </div>
          <div class="card-body">
            <div class="table-responsive">

 <form  action="home.php" method="post" action="exibirCepa"   enctype="multipart/form-data">
           
              Nome: 
              <input type="text" name="Nome">
              <br>
              Regiao de Origem:&nbsp 
              <input type="text" name="Regiao_Origem">
              <br>
              <input type="submit" name="cepa">
              </form>
             </div>
             </div>
             </div>
  <?php
}else if (isset($_POST['cadastrarParreiral'])) {
?>
      <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Parreiral:
          </div>
          <div class="card-body">
            <div class="table-responsive">
          
 <form  action="home.php" method="post" action="exibirParreiral"   enctype="multipart/form-data">
            <br>
              <br>
              Quantidade de Vinhas: 
              <input type="int" name="Quantidade_Vinhas">
              <br>
              Area:
              <input type="double" name="Area">
              <br>
              Nome da Propriedade:
                   <select name = "Nome_Propriedade">
                <option> </option>
                
              <?php 

                $x = new propriedade();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Nome"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>
              <br>
              Nome da cepa:
                <select name = "Nome_Cepa">
                <option> </option>
                
              <?php 

                $x = new cepa();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Nome"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>
              <br>
               Data de Plantio :  
              <input type="date" name="Data_Plantio">
              <br>
              <input type="submit" name="parreiral">
              </form>
             </div>
             </div>
             </div>
<?php
}else if (isset($_POST['cadastrarRegiao'])) {
?>
      <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Região:
            <br>
          </div>
          <div class="card-body">
            <div class="table-responsive">
 <form  action="home.php" method="post" action="exibirRegiao"   enctype="multipart/form-data">
              Nome do Terroir: 
              <input type="text" name="Terroir" >
              <br>
              Tipo de Clima: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <input type="text" name="Clima">
              <br>
              Umidade: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <input type="double" name="Umidade">
              <br>
              Altitude:     &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <input type="double" name="Altitude" >
              <br>
              Indice Pluviometrico: 
              <input type="double" name="Indice_Pluviometrico" align="right">
              <br>              
              <input type="submit" name="regiao">


              </form>
             </div>
             </div>
             </div>
<?php
}else if (isset($_POST['cadastrarPropriedade'])) {
?>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Cadastrar Propriedade:
            
          </div>
          <div class="card-body">
            <div class="table-responsive">
 <form  action="home.php" method="post" action="exibirPropriedade"   enctype="multipart/form-data">
            Nome da Propriedade: 
              <input type="text" name="Nome_Propriedade" >
              <br>
            Administrador: 
              <input type="text" name="Administrador" >
              <br>
            Nome do Terroir:
            <select name = "Terroir_Regiao">
                <option> </option>
                
              <?php 

                $x = new regiao();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <option><?php echo ($exibe["Terroir"]);?></option>
                  <?php 
                  $x++;
                  }
                  ?>
                  </select>
              <br>
              Telefone: 
              <input type="int" name="Telefone" >
              <br>
              Email: 
              <input type="text" name="Email" >
              <br>
              Endereço:
              <input type="text" name="Endereco" >
              <br>
            <input type="submit" name="propriedade">
             
              </form>
             </div>
             </div>
             </div>

             <?php 
             }
             ?>

 <!-- EXIBIR -->
  <?php
 if (isset($_POST['exibirVinhos'])) {
?> 

        <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Vinhos:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Rotulo</th>
                    <th>Classificação</th>
                    <th>Avaliações</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Rotulo</th>
                    <th>Classificação</th>
                    <th>Avaliações</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new vinho();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Codigo"]);?></td>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><img src="upload/<?php echo ($exibe["Rotulo"]);?>" width='100' height='100' ></td>
                    <td><?php echo ($exibe["Classificacao"]);?></td>
                    <td>null</td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>

<?php
}else if (isset($_POST['exibirSafras'])) {
?> 
  <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Safras:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Codigo Vinho</th>
                    <th>Ano</th>
                    <th>Quantidade de Garrafas</th>
                    <th>Tipo de Safra</th>
                    <th>Avaliação</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Codigo</th>
                    <th>Codigo Vinho</th>
                    <th>Ano</th>
                    <th>Quantidade de Garrafas</th>
                    <th>Tipo de Safra</th>
                    <th>Avaliação</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new safra();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Codigo"]);?></td>
                    <td><?php echo ($exibe["Codigo_Vinho"]);?></td>
                    <td><?php echo ($exibe["Ano"]);?></td>
                    <td><?php echo ($exibe["Quantidade_Garrafas"]);?></td>
                    <td><?php echo ($exibe["Tipo_Safra"]);?></td>
                    <td><?php echo ($exibe["Avaliacao"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirColheita'])) {
?>    
  <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Colheita:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Numero</th>
                    <th>Material</th>
                    <th>Vindima</th>
                    <th>Informação</th>
                    <th>Codigo do Parreiral</th>
                    <th>Codigo da Safra</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                     <th>Numero</th>
                    <th>Material</th>
                    <th>Vindima</th>
                    <th>Informação</th>
                    <th>Codigo do Parreiral</th>
                    <th>Codigo da Safra</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new colheita();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Numero"]);?></td>
                    <td><?php echo ($exibe["Material"]);?></td>
                    <td><?php echo ($exibe["Vindima"]);?></td>
                    <td><?php echo ($exibe["Info"]);?></td>
                    <td><?php echo ($exibe["Codigo_Parreiral"]);?></td>
                    <td><?php echo ($exibe["Codigo_Safra"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirCepa'])) {
?>
 <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Cepas:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Região de Origem</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Região de Origem</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new cepa();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><?php echo ($exibe["Regiao_Origem"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirParreiral'])) {
?>
 <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Parreirais:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Quantidade de Vinhas</th>
                    <th>Area</th>
                    <th>Nome da propriedade</th>
                    <th>Nome da cepa</th>
                    <th>Data do plantio</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>Codigo</th>
                  <th>Quantidade de Vinhas</th>
                    <th>Area</th>
                    <th>Nome da propriedade</th>
                    <th>Nome da cepa</th>
                    <th>Data do plantio</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new parreiral();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Codigo"]);?></td>
                    <td><?php echo ($exibe["Quantidade_Vinhas"]);?></td>
                    <td><?php echo ($exibe["Area"]);?></td>
                    <td><?php echo ($exibe["Nome_Propriedade"]);?></td>
                    <td><?php echo ($exibe["Nome_Cepa"]);?></td>
                    <td><?php echo ($exibe["Data_Plantio"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirRegiao'])) {
?>
<!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Região:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Terroir</th>
                    <th>Clima</th>
                    <th>Umidade</th>
                    <th>Altitude</th>
                    <th>Indice Pluviometrico</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>Terroir</th>
                    <th>Clima</th>
                    <th>Umidade</th>
                    <th>Altitude</th>
                    <th>Indice Pluviometrico</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new regiao();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Terroir"]);?></td>
                    <td><?php echo ($exibe["Clima"]);?></td>
                    <td><?php echo ($exibe["Umidade"]);?></td>
                    <td><?php echo ($exibe["altitude"]);?></td>
                    <td><?php echo ($exibe["Indice_Pluviometrico"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>



<?php
}else if (isset($_POST['exibirPropriedade'])) {
?>
<!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Propriedade:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                     <th>Nome</th>
                    <th>Administrador</th>
                    <th>Regiao do Terroir</th>
                  <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>Nome</th>
                    <th>Administrador</th>
                    <th>Regiao do Terroir</th>
                  <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new propriedade();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><?php echo ($exibe["Administrador"]);?></td>
                    <td><?php echo ($exibe["Terroir_Regiao"]);?></td>
                    <td><?php echo ($exibe["Email"]);?></td>
                    <td><?php echo ($exibe["Telefone"]);?></td>
                    <td><?php echo ($exibe["Endereco"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>

<?php
}
?>
              


<!-- EXIBIR TABELAS DO PROFESSOR-->
  <?php
 if (isset($_POST['exibirVinhosS'])) {
?> 

        <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
           Todas as safras de um determinado vinho:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Rotulo</th>
                    <th>Classificação</th>
                     <th>Ano de safra</th>
                    <th>Quantidade de Garrafas</th>
                    <th>Tipo de Safra</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Rotulo</th>
                    <th>Classificação</th> 
                    <th>Ano de safra</th>
                    <th>Quantidade de Garrafas</th>
                    <th>Tipo de Safra</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new vinho();

                $vinho = $x->vinhoS();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Codigo"]);?></td>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><img src="upload/<?php echo ($exibe["Rotulo"]);?>" width='100' height='100' ></td>
                    <td><?php echo ($exibe["Classificacao"]);?></td>
                    <td><?php echo ($exibe["Ano"]);?></td>
                    <td><?php echo ($exibe["Quantidade_Garrafas"]);?></td>
                    <td><?php echo ($exibe["Tipo_Safra"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>

<?php
}else if (isset($_POST['exibirPropriedadeA'])) {
?> 
  <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
           Lista de todas as propriedades, mostrando a produção total em um dado ano:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                   <th>Nome</th>
                    <th>Administrador</th>
                    <th>Terroir_Regiao</th>
                    <th>Quantidade de cepas</th>
                    <th>Vindima</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Administrador</th>
                    <th>Terroir_Regiao</th>
                    <th>Quantidade de cepas</th>
                    <th>Vindima</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new propriedade();

                $vinho = $x->exibirPropriedadeA();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><?php echo ($exibe["Administrador"]);?></td>
                    <td><?php echo ($exibe["Terroir_Regiao"]);?></td>
                    <td><?php echo ($exibe["X"]);?></td>
                    <td><?php echo ($exibe["Vindima"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirUvasP'])) {
?>    
  <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            – Listar todos os tipos de uva plantados em uma propriedade:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Numero</th>
                    <th>Material</th>
                    <th>Vindima</th>
                    <th>Tipo uva</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                     <th>Numero</th>
                    <th>Material</th>
                    <th>Vindima</th>
                    <th>Tipo uva</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new propriedade();

                $vinho = $x->view();
                $Y=0;
                $tamanho=sizeof($vinho);
                while($Y!=$tamanho){
                $exibe=$vinho[$Y]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><?php echo ($exibe["Administrador"]);?></td>
                    <td><?php echo ($exibe["Terroir_Regiao"]);?></td>
                    <td>
                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <tbody>
                <?php 
                $x->setNome_Propriedade($exibe["Nome"]);
                $z=$x->exibirTipoUva();
                $x=0;
                $tamanho=sizeof($z);
                if($z!=null) {
                while($x!=$tamanho){
                $exibe2=$z[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe2["Nome_Cepa"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }}
                  ?>
                </tbody></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}else if (isset($_POST['exibirUvaA'])) {
?>
 <!-- Example Tables Card -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-table"></i>
            Exibir Cepas:
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Região de Origem</th>

                    <th>Tipo uva</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nome</th>
                    <th>Região de Origem</th>

                    <th>Tipo uva</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php 

                $x = new cepa();

                $vinho = $x->view();
                $x=0;
                $tamanho=sizeof($vinho);
                while($x!=$tamanho){
                $exibe=$vinho[$x]; 
                ?>
                  <tr>
                    <td><?php echo ($exibe["Nome"]);?></td>
                    <td><?php echo ($exibe["Regiao_Origem"]);?></td>
                  </tr>
                  <?php 
                  $x++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
            Familia Rolheta
          </div>
        </div>

      </div>

    </div>


<?php
}
?>
    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Selecione sair para deslogar da sessão.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="index.php">Sair</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/sb-admin.min.js"></script>

  </body>

</html>
