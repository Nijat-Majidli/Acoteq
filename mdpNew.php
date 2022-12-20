<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title> Nouveau mot de passe </title>

        <!-- Bootstrap CDN link -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
         <!-- Fichier CSS -->
         <link rel="stylesheet" href="css/style.css">

         <!-- JQuery Google CDN: -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>



    <body>
        <main>
            <!-- PAGE HEAD -->
            <?php
                if (file_exists("header_index.php"))
                {
                include("header_index.php");
                }
                else
                {
                echo "file 'header_index.php' n'existe pas";
                }
            ?>

            <!-- PAGE CONTENT -->
            <div class="container-fluid-fluid">
                <section class="maison">
                    <img src="../Acoteq/image/logo.png" alt="logo" title="logo">
                </section>

                <aside class="aside">
                    <div class="slogan_2">
                        <h3> Veuillez saisir votre votre adresse mail <br> et nouveau mot de passe : </h3> 
                    </div>

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
        </main>

        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
    
        <!-- fichier Javascript RegExp -->
        <script src="javascript/RegExp1.js"> </script>
    </body>
</html>