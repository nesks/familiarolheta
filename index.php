  <?php

  use VisaoJR\Arquivos\Model\Users;

  require_once 'Model/Users.php';

  $user = new Users();

  if (isset($_POST['submit'])) {
      $user->setEmail($_POST['email']);
      $user->setPassword($_POST['password']);
      $user->setdt_Nasc($_POST['data']);
      $user->setNome($_POST['nome']);
      $user->setdt_Nasc(date("Y-m-d",strtotime(str_replace('/','-',$_POST['data']))));
      $img=$_FILES['foto'];
      $imgNome=$img['name'];
      if(empty($imgNome)){
          $ft='icon.png';
      }else{
        $extensao = strtolower(substr($_FILES['foto']['name'], -4));
          $novo_nome = md5(time()).$extensao;
          $diretorio = 'upload/';
          move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);
          $ft=$novo_nome;
      }
      $user->setFoto($ft);
      $user->insert();
  }

  ?>
  <!DOCTYPE html>
  <html class="no-js" lang="pt-br">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Família Rolheta</title>
      <meta name="description" content="Conheça uma das melhores fabricas de vinho do pais.">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="shortcut icon" type="image/x-icon" href="img/icon.ico">
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <script src="js/vendor/modernizr-2.8.3.min.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5nZKbeK-WHQ70oqOWo-_4VmwOwKP9YQ"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
      <link rel="stylesheet" href="css/font-awesome.min.css">

      <link rel="stylesheet" href="css/main.css">

      <!-- Botão BACK TO TOP -->
      <style>
          a[href="#top"]{
              padding:10px;
              position:fixed;
              top: 90%;
              right:50px;
              display:none;
              font-size: 30px;
              color: #ca3438;
          }
          a[href="#top"]:hover{
              text-decoration:none;
          }
    

body
{
    background-image: url("img/parreiral.jpg");
    background-size: cover;
    padding: 0;
    margin: 0;
}

.wrap
{
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 99;
}

p.form-title
{
    font-family: 'Open Sans' , sans-serif;
    font-size: 20px;
    font-weight: 600;
    text-align: center;
    color: #FFFFFF;
    margin-top: 5%;
    text-transform: uppercase;
    letter-spacing: 4px;
}

form
{
    width: 250px;
    margin: 0 auto;
}

form.login input[type="text"], form.login input[type="password"]
{
    width: 100%;
    margin: 0;
    padding: 5px 10px;
    background: 0;
    border: 0;
    border-bottom: 1px solid #FFFFFF;
    outline: 0;
    font-style: italic;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #FFFFFF;
    outline: 0;
}

form.login input[type="submit"]
{
    width: 100%;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 16px;
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

form.login input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}

form.login .remember-forgot
{
    float: left;
    width: 100%;
    margin: 10px 0 0 0;
}
form.login .forgot-pass-content
{
    min-height: 20px;
    margin-top: 10px;
    margin-bottom: 10px;
}
form.login label, form.login a
{
    font-size: 12px;
    font-weight: 400;
    color: #FFFFFF;
}

form.login a
{
    transition: color 0.5s ease;
}

form.login a:hover
{
    color: #2ecc71;
}

.pr-wrap
{
    width: 100%;
    height: 100%;
    min-height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 999;
    display: none;
}

.show-pass-reset
{
    display: block !important;
}

.pass-reset
{
    margin: 0 auto;
    width: 250px;
    position: relative;
    margin-top: 22%;
    z-index: 999;
    background: #FFFFFF;
    padding: 20px 15px;
}

.pass-reset label
{
    font-size: 12px;
    font-weight: 400;
    margin-bottom: 15px;
}

.pass-reset input[type="email"]
{
    width: 100%;
    margin: 5px 0 0 0;
    padding: 5px 10px;
    background: 0;
    border: 0;
    border-bottom: 1px solid #000000;
    outline: 0;
    font-style: italic;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-bottom: 5px;
    color: #000000;
    outline: 0;
}

.pass-reset input[type="submit"]
{
    width: 100%;
    border: 0;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: 500;
    margin-top: 10px;
    outline: 0;
    cursor: pointer;
    letter-spacing: 1px;
}

.pass-reset input[type="submit"]:hover
{
    transition: background-color 0.5s ease;
}
.posted-by
{
    position: absolute;
    bottom: 26px;
    margin: 0 auto;
    color: #FFF;
    background-color: rgba(0, 0, 0, 0.66);
    padding: 10px;
    left: 38%;
}

  </style>


  </head>
  <body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pr-wrap">
                <div class="pass-reset">
                    <label>
                        Entre com o email</label>
                    <input type="email" placeholder="Email" />
                    <input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
                </div>
            </div>
            <div class="wrap">
                <p class="form-title">
                    Entrar</p>
                <form class="login">
                <input type="text" placeholder="nome de usuario" />
                <input type="password" placeholder="senha" />
                <input type="submit" value="entrar" class="btn btn-success btn-sm" />
                <div class="remember-forgot">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" />
                                   Me lembrar
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 forgot-pass-content">
                            <a href="javascription:void(0)" class="forgot-pass">Esqueceu sua senha</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="posted-by">Feito por: <a href="#">Felipe Sousa, Felipe Lanna e Fábio Duarte</a></div>
</div>

  


</body>
</html>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script><script src="js/plugins.js"></script>
<script src="js/main.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
      integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
      crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
    $(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
        $('a[href="#top"]').fadeIn();
    } else {
        $('a[href="#top"]').fadeOut();
    }
    });

    $('a[href="#top"]').click(function(){
    $('html, body').animate({scrollTop : 0},800);
        return false;
    });
    });
</script>
<script>
    $(document).ready(function(){
    $(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
        $('a[href="#top"]').fadeIn();
    } else {
        $('a[href="#top"]').fadeOut();
    }
    });
    });
</script>
<script>
$(document).ready(function(){
$('a').on('click', function(event){
  if(this.hash != ""){
  event.preventDefault();
  var hash=this.hash;

  $('html,body').animate({
  scrollTop: $(hash).offset().top
  },800,function(){

  window.location.hash = hash;
  });
  }
  });
  });
</script>

<script>
 $(document).ready(function () {
    $('.forgot-pass').click(function(event) {
      $(".pr-wrap").toggleClass("show-pass-reset");
    }); 
    
    $('.pass-reset-submit').click(function(event) {
      $(".pr-wrap").removeClass("show-pass-reset");
    }); 
});
</script>