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
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-7"> 
                <aside>
                    <div class="slogan">
                        <h5> Veuillez saisir votre adresse mail pour recevoir votre mot de passe </h5> 
                    </div>

                    <form  action="script_mdpLost.php"  method="POST" autocomplete="off" class="form_connect">
                        <div class="form-group">
                            <label for="mail"> E-mail <sup>*</sup> </label>
                            <input id="mail" type="text" class="form-control col-10 col-xl-8" name="email" required>
                        </div>

                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-success mr-2"> Valider </button>
                            <a href="connexion.php"> <input type="button" class="btn btn-danger" value="Annuler"> </a>  
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