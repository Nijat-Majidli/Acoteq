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
        <div class="container-fluid col-12">
            <br><br>
            <center> <h3> Autres équipes </h3> </center>
            <br><br><br>          
<?php
            // Connéxion à la base de données 
            require "connection_bdd.php";
            
            // On construit la requête SELECT pour sélectionner l'équipe duquelle utilisateur fait partie et n'est pas equipe proprietaire: 
            $req = "SELECT * FROM equipe WHERE member_mails LIKE '%".$_SESSION['email']."%' AND user_email NOT LIKE '%".$_SESSION['email']."%'";

            // Grace à méthode query() on exécute notre requête :
            $requete = $db->query($req)  or  die(print_r($db->errorInfo()));  // Pour repérer l'erreur SQL en PHP on utilise le code die(print_r($db->errorInfo()))

            // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête
            $nbLigne = $requete->rowCount(); 
            
            if($nbLigne >= 1)
            {
?>
                <h6 style="color:blue"> Les équipes dont vous faites partie </h6>
                <br>  
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Nom </th>
                                <th scope="col"> Propriétaire </th>
                                <th scope="col"> Membres </th>
                                <th scope="col"> Email </th>
                                <th scope="col"> Crée </th>
                                <th scope="col"> Demande </th>
                                <th scope="col"> Action </th> 
                            </tr>
                        </thead>
<?php
                    while ($row = $requete->fetch(PDO::FETCH_OBJ))      // Grace à méthode fetch() on choisit le 1er ligne de chaque colonne et la mets dans l'objet $row
                    {                                                   // Avec la boucle "while" on choisit 2eme, 3eme, etc... lignes de chaque colonne et les mets dans l'objet $row
?>                                                
                        <tbody>
                            <tr>
                                <td>  <?php echo $row->equipe_nom;?>  </td>
                                <td>  <?php echo $row->equipe_proprietaire;?>  </td>
                                <td>  <?php echo $row->equipe_membres;?>  </td> 
                                <td>  <?php echo $row->member_mails;?>  </td> 
                                <td>  <?php echo $row->equipe_creation;?>  </td>
<?php
                                // On construit la requête SELECT : 
                                $result = $db->prepare("SELECT * FROM demande WHERE equipe_id=:equipe_id");
                                
                                // Association des valeurs aux marqueurs via la méthode "bindValue()" :
                                $result->bindValue(':equipe_id', $row->equipe_id);

                                // On exécute la requête :
                                $result->execute();

                                // Grace à la méthode "rowCount()" on peut connaitre le nombre de lignes retournées par la requête
                                $nbLigne = $result->rowCount(); 
                                        
                                if ($nbLigne >= 1)
                                {
?>
                                    <td> 
<?php
                                        while ($ligne = $result->fetch(PDO::FETCH_OBJ))   // Grace à la méthode fetch() on choisit 1er ligne de chaque colonne et on les mets dans l'objet $ligne                                            
                                        {                                             
?>
                                            <a href="demandeDetail.php?demande_id=<?php echo $ligne->demande_id ?>"> 
                                                <?php echo $ligne->demande_titre."<br>";?> 
                                            </a>                     
<?php                                     
                                        }
?>
                                    </td>
<?php
                                }
                                else
                                {
                                    echo '<td> <p style="color:red"> Aucune demande </p> </td>';
                                }
?>                                         
                                <td>   
                                    <a href="script_equipeQuitter.php?equipe_id=<?php echo $row->equipe_id;?>"> 
                                        <button class="btn btn-danger" type="button" onclick="Quitter()"> Quitter </button> 
                                    </a>  
                                </td>
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
                echo "<br> <center> <h5 style='color:red'> Pour l'instant vous faites partie d'aucune équipe! </h5> </center> <br>"; 
            }

            //Libèration la connection au serveur de BDD
            $requete->closeCursor();
?>    
            <div style="text-align:center; margin-top:70px">
                <a href="script_deconnexion.php"> <button class="btn btn-warning mr-3"> Déconnexion </button> </a> 
                <a href="client.php"> <button class="btn btn-primary"> Retour </button> </a> 
            </div>
        </div>
        <!-- PAGE CONTENT END -->

        
        <!-- Javascript -->
        <script>  
            function Quitter()
            { 
                // Rappel : window.confirm() -> Bouton "OK" renvoie true, mais bouton "Annuler" renvoie false
                var resultat = window.confirm("Etes-vous certain de vouloir quitter cette équipe ?");

                if (resultat==false)
                {
                    window.alert("Vous avez annulé l'opération !");

                    // "event.preventDefault()" annule l'évènement par défaut (envoie vers le fichier "script_equipeQuitter.php")
                    event.preventDefault();    
                }
            }
        </script>
     

        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
</html>



    