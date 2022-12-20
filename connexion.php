<?php
  // La superglobale $_COOKIE représente le contenu de tous les cookies stockés (sous forme d'array) par votre site sur l'ordinateur du visiteur. 
  if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
  {
    $login = $_COOKIE['login'];
    $password = $_COOKIE['password'];
  }
  else {
    $login = '';
    $password = '';
  }


  if (file_exists("header.php"))
  {
    include("header.php");
  }
  else
  {
    echo "file 'header.php' n'existe pas";
  }
?>

  <!-- PAGE CONTENT -->
  <div class="container-fluid mt-5" style="padding-bottom:60px;">
    <div class="row justify-content-center no-gutters">
      <!-- LOGO -->
      <div class="col-12 col-sm-12 col-md-7 col-lg-6 col-xl-5">   
        <center>
          <section class="maison">
            <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" class="col-12" style="width:50vh;">
          </section>
        </center>  
      </div>

      <!-- Aside  -->
      <div class="col-12 col-sm-12 col-md-5 col-lg-6 col-xl-7" style="margin-top:60px;"> 
        <aside>
          <div class="slogan">
            <h4> Connecter vous pour accéder à tous nos services </h4> 
          </div>
          
          <form action="script_connexion.php" method="POST" autocomplete="off" class="form_connect">
              <div class="form-group">
                <label for="mail"> E-mail <sup>*</sup> </label>
                <input id="mail" type="text" class="form-control col-9 col-xl-8" name="email" value='<?php echo $login;?>' required>
              </div>
              
              <div class="form-group clearfix">
                <label for="code" style="display: block;"> Mot de passe <sup>*</sup> </label> 
                <input id="code" type="password" class="form-control col-9 col-xl-8 float-left" name="mdp" value='<?php echo $password;?>' required> 
                <img src="image/eye_closed.png" alt="eyePicture" id="eyeIcon">  
              </div>         

              <div class="form-group form-check">
                <input class="form-check-input" id="exampleCheck1" type="checkbox" name="cookie" value="rememberMe">
                <label class="form-check-label" for="exampleCheck1"> Se souvenir de moi </label>
              </div>

              <a href="mdpLost.php"> Mot de passe oublié ? </a>
              <br><br>

              <div class="text-center">
                <button type="submit" class="btn btn-primary"> Connexion </button>
              </div>
          </form>
        </aside>
      </div>
    </div>
  </div>
  <!-- PAGE CONTENT END -->   


<?php
  if (file_exists("footer.php"))
  {
    include("footer.php");
  }
  else
  {
    echo "file 'footer.php' n'existe pas";
  }
?>
