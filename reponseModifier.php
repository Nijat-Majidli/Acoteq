<?php 
    session_start();  
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).  */  

    if (!isset($_SESSION['email']) && !isset($_SESSION['role'])=="fournisseur")
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");     // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> Réponse à modifier </title>

        <!-- Bootstrap CDN link -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
        <!-- Fichier CSS -->
        <link rel="stylesheet" href="css/style.css">

        <!-- JQuery Google CDN: -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>



    <body>
        <!-- PAGE HEAD -->        
        <?php
            if (file_exists("header_fournisseur.php"))
            {
                include("header_fournisseur.php");
            }
            else
            {
                echo "le fichier n'existe pas";
            }
        ?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid p-4 mb-3 mt-3 col-7 bg-light text-dark">
            <h3> Veuillez modifier votre réponse </h3>
            <br>
<?php
            // On récupérer le paramétre reponse_id transmit par la page "reponseDetail.php" et on le met dans la variable $reponse_id :
            $reponse_id = $_GET['reponse_id'];

            // Connéxion à la base de données 
            require "connection_bdd.php";
                
            // On construit la requête SELECT : 
            $requete = $db->prepare ("SELECT * FROM reponse WHERE reponse_id=:reponse_id");

            /* Association valeur au marqueur et execution de la requete.
            L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement". */
            $requete->execute(array(':reponse_id' => $reponse_id));

            // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête:
            $nbLigne = $requete->rowCount(); 

            if($nbLigne >= 1)
            {
                while ($row = $requete->fetch(PDO::FETCH_OBJ))  
                {                                           
?>
                    <form action="script_reponseModifier.php"  method="POST" autocomplete="off">   
                        <input type="hidden" name="reponse_id" value="<?php echo $reponse_id?>">  

                        <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="title"> Titre <sup>*</sup> </label> 
                            <input type="text" class="form-control" id="title" name="reponse_titre" value="<?php echo $row->reponse_titre?>"  required>
                        </div>

                        <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="desc"> Description <sup>*</sup> </label>
                            <textarea id="desc" class="form-control text-left" name="reponse_description" rows="10" style="resize:none" required> 
                                <?php echo $row->reponse_description?> 
                            </textarea>
                        </div>

                        <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                            <label for="budgetreponse"> Votre tarif proposé : <sup>*</sup> </label>
                            <input type="number" class="form-control" id="budgetreponse" name="reponse_budget" value=<?php echo $row->reponse_budget?> placeholder="en euro" required>
                        </div>

                        <div style="text-align:center; margin-top:40px;">
                            <input type="submit" class="btn btn-success mr-3" value="Valider"> </input>  
                            <a href="reponseDetail.php?reponse_id=<?php echo $row->reponse_id;?>"> 
                                <input type="button" class="btn btn-danger" value="Annuler"> 
                            </a>
                        </div>
                    </form>
<?php
                }
            }

            // Libèration la connection au serveur de BDD:
            $requete->closeCursor();
?>          

        </div>

      
  

        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

        
        <!-- fichier Javascript RegExp -->
        <script src="javascript/RegExp2.js"> </script>
        
    </body>
</html>