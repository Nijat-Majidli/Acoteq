<?php 
    session_start();  
    /* ATTENTION
    Il est impératif d'utiliser la fonction session_start() au début de chaque fichier PHP dans lequel on manipulera cette 
    variable et avant tout envoi de requêtes HTTP, c'est-à-dire avant tout echo ou quoi que ce soit d'autre : rien ne doit 
    avoir encore été écrit/envoyé à la page web.  */

    if (!isset($_SESSION['email']) && !isset($_SESSION['role']))
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }

    
    if (file_exists("header.php"))
    {
        include("header.php");
    }
    else
    {
        echo "Le fichier n'existe pas";
    }
?>

            <!-- PAGE MAIN CONTENT -->
            <div class="container-fluid col-11 col-sm-9 col-lg-8">
                <br><br>
                <center> <h3> Mes reponses publiées </h3> </center> 
                <br> <br> <br>
<?php
                // Connection à la base de données 
                require "connection_bdd.php";

                $requete = $db->prepare("SELECT * FROM reponse WHERE user_email=:user_email");

                // Association des valeurs aux marqueurs via la méthode "bindValue()" :
                $requete->bindValue(':user_email', $_SESSION['email']);

                // On exécute la requête :
                $requete->execute();

                // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête
                $nbLigne = $requete->rowCount(); 
            
                if($nbLigne >= 1)
                {
?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"> Titre </th>
                                    <th scope="col"> Description </th>
                                    <th scope="col"> Budget </th>
                                    <th scope="col"> Date publication </th>
                                </tr>
                            </thead>
<?php
                        while ($row = $requete->fetch(PDO::FETCH_OBJ))  // Grace à méthode fetch() on choisit le 1er ligne de chaque colonne et la mets dans l'objet $row
                        {                                              // Avec la boucle "while" on choisit 2eme, 3eme, etc... lignes de chaque colonne et les mets dans l'objet $row
?>
                            <tbody>    
                                <tr>
                                    <td> <?php echo $row->reponse_titre;?> </td> 
                                    <td> <?php echo $row->reponse_description;?> </td>
                                    <td> <?php echo $row->reponse_budget;?> </td> 
                                    <td> <?php echo $row->reponse_publication;?> </td>
                                </tr>
                            </tbody>
<?php
                            }
?> 
                        </table>
                    </div>
<?php
                }
                else
                {
                    echo "<br> <center> <h5 style='color:red'> Pour l'instant vous avez aucune réponse publiée ! </h5> </center> <br>"; 
                }

                //Libèration la connection au serveur de BDD
                $requete->closeCursor();
?>    
                        
                    

                <div style="text-align:center; margin-top:200px"> 
                    <a href="fournisseur.php"> <input type="button" class="btn btn-primary mr-3" value="Retour" id="retour"> </a>
                    <a href="script_deconnexion.php"> <button class="btn btn-warning"> Déconnexion </button> </a> 
                </div> 
            </div>    
           

        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
</html>




