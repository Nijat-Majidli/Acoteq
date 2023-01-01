<?php
  /*  Si lors de la première connexion l'utilisateur a coché l'option "Se souvenir de moi" les 2 cookies (login et password) ont été déjà créés par le fichier 
  "script_connexion.php". La superglobale $_COOKIE représente le contenu de tous les cookies créés (sous forme d'array) par votre site sur l'ordinateur du visiteur:   */
  if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
  {
    $login = $_COOKIE['login'];
    $password = $_COOKIE['password'];
  }
  else 
  {
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
<div class="container-fluid my-5 py-5">
  <div class="row justify-content-center">
    <div class="col-xl-10">
      <div class="row justify-content-center align-items-center">
        <!-- Logo -->
        <div class="col-lg-5 text-center">   
            <img src="image/logo1.png" alt="logo" title="logo" class="logo"> 
        </div>

        <!-- Login form  -->
        <div class="col-lg-7"> 
          <h4 class="text-primary my-5"> Connecter vous pour accéder à tous nos services </h4>   

          <form action="script_connexion.php" method="POST" autocomplete="off" class="form_connect">
            <div class="form-group">
              <sup>*</sup> <label for="mail"> Email </label>
              <input id="mail" type="text" class="form-control col-9" name="email" value="<?php echo $login;?>" placeholder="Veuillez saisir votre email" onblur="verify(this)" required>
            </div>    
            
            <div class="form-group clearfix">
              <sup>*</sup> <label for="code" class="d-block"> Mot de passe </label> 
              <input id="code" type="password" class="form-control float-left col-9" name="mdp" value="<?php echo $password;?>" placeholder="Veuillez saisir votre mot de passe" required> 
              <img src="image/eye_closed.png" alt="eyePicture" id="eyeIcon"> 
            </div>         
            
            <div class="form-group form-check">
              <input class="form-check-input" id="exampleCheck1" type="checkbox" name="cookie" value="rememberMe">
              <label class="form-check-label" for="exampleCheck1"> Se souvenir de moi </label>
            </div>

            <a href="mdpLost.php"> Mot de passe oublié ? </a>
            <br><br>

            <div class="text-center">
              <button type="submit" class="btn btn-success"> Connexion </button>
            </div>
          </form>
        </div>
      </div>
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
