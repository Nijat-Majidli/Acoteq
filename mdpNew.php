<?php
    if (file_exists("header.php"))
    {
    include("header.php");
    }
    else
    {
    echo "le fichier n'existe pas";
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid mt-5" style="padding-bottom:20px;">
            <div class="row justify-content-center no-gutters">
            <!-- LOGO -->
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">   
                <section class="maison">
                    <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" style="width:40vh;"> 
                </section>
            </div>

            <!-- Aside  -->
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5"> 
                <aside class="aside">
                    <div class="slogan_2">
                        <h3> Veuillez saisir votre adresse mail <br> et le nouveau mot de passe : </h3> 
                    </div>
                    <br>
                    <form  action="script_mdpLost.php"  method="POST" autocomplete="off" class="form_connect">
                        <div class="form-group" class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="mail"> E-mail <sup>*</sup> </label>
                            <input id="mail" type="text" class="form-control" name="email" required>
                        </div>

                        <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="code"> Mot de passe <sup>*</sup> </label>
                            <input id="code" type="password" class="form-control" name="mdp" required>
                        </div>

                        <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="confirmer"> Confirmer le mot de passe <sup>*</sup> </label>
                            <input id="confirmer" type="password" class="form-control" name="mdp2" required>
                        </div>

                        <div class="boutons">
                            <button type="submit" class="btn btn-success"> Valider </button>
                            <a href="connexion.php"> <input type="button" class="btn btn-danger ml-3" value="Annuler"> </a>  
                        </div>
                    </form>
                </aside>
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