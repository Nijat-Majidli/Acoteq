<?php 
    session_start();  
    /* ATTENTION
    Il est impératif d'utiliser la fonction session_start() au début de chaque fichier PHP dans lequel on manipulera cette 
    variable et avant tout envoi de requêtes HTTP, c'est-à-dire avant tout echo ou quoi que ce soit d'autre : rien ne doit 
    avoir encore été écrit/envoyé à la page web.  */

    if (!isset($_SESSION['email']) && !isset($_SESSION['user_siren']) && !isset($_SESSION['role']))
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }

    if($_SESSION['role']=='client')
    {
        if (file_exists("header_client.php"))
        {
            include("header_client.php");
        }
        else
        {
            echo "le fichier n'existe pas";
        }
    }
    elseif($_SESSION['role']=='fournisseur')
    {
        if (file_exists("header_fournisseur.php"))
        {
            include("header_fournisseur.php");
        }
        else
        {
            echo "le fichier n'existe pas";
        }
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid col-7">
            <br>
            <center> <h3> Infos personnelles </h3> </center> 
            <br>
<?php 
            // Connéxion à la base de données 
            require "connection_bdd.php";
                                
            // On construit la requête SELECT : 
            $requete = $db->prepare ("SELECT * FROM users WHERE user_email=:email");

            // Association valeur de $_SESSION['email'] au marqueur :email via méthode "bindValue()"
            $requete->bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);

            //On exécute la requête
            $requete->execute();

            // Si la requête renvoit un seul et unique résultat, on ne fait pas de boucle, ici c'est le cas: 
            $row = $requete->fetch(PDO::FETCH_OBJ);
?>
            <form action="#"  method="#" style="margin-bottom:50px;">   
                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Nom </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_nom;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Prénom </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_prenom;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Adresse mail </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_email;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Raison Sociale </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_societe;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> SIREN </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_siren;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Adresse </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_adresse;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Code postal </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_code_postal;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Ville </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_ville;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Pays </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_pays;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Date inscription </label>
                    <input type="text" class="form-control" value="<?php echo $row->user_inscription;?>" readonly>
                </div>
            </form>
<?php    
            // Libèration la connection au serveur de BDD
            $requete->closeCursor();               
?>    
                    
            <div class="mb-5">
                <center> 
<?php
                    if($_SESSION['role']=='client')
                    {
                        $page="client.php";
                    }
                    else if ($_SESSION['role']=='fournisseur')
                    {
                        $page="fournisseur.php";
                    }
?>
                    <a href="<?php echo $page?>"> <button class="btn btn-primary"> Retour </button> </a> 
                </center>
            </div>
        </div>
        <!-- PAGE CONTENT END -->


        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
</html>