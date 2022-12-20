<?php   
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).  */  
    session_start();

    if (!isset($_SESSION['email']) && !isset($_SESSION['role'])=="client")
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }


    /*  Pour écrire un cookie, on utilise la fonction setcookie(). Il est impératif d'utiliser cette fonction au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).  
    On lui donne en général trois paramètres, dans l'ordre suivant :
    1. Le nom du cookie (exemple: 'login');
    2. La valeur du cookie (exemple: 'dupont@gmail.com');
    3. La date d'expiration du cookie, sous forme de timestamp (exemple: 1090521508 ). 
    Le dernier paramètre "true" permet d'activer le mode  << httpOnly >>  sur le cookie et permet de réduire drastiquement les risques 
    de faille XSS sur votre site.   */
    if(isset($_SESSION['cookie']))
    {
        setcookie('login', $_SESSION['email'], time() + 365*24*3600, null, null, false, true);
        setcookie('password', $_SESSION['mdp'], time() + 365*24*3600, null, null, false, true);
    }
    
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> Client </title>

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
            if (file_exists("header_client.php"))
            {
                include("header_client.php");
            }
            else
            {
                echo "le fichier n'existe pas";
            }
        ?>


        <!-- PAGE CONTENT -->
        <div class="container-fluid col-11 col-sm-10">
            <br><br>
            <center> <h3> Demandes publiées </h3> </center> 
            <br><br><br>
<?php
            // Connéxion à la base de données 
            require "connection_bdd.php";
            
            // On construit la requête SELECT : 
            $requete = $db->prepare ("SELECT * FROM demande WHERE user_email=:user_email AND demande_etat=:demande_etat");

            // Association des valeurs aux marqueurs via la méthode "bindValue()" :
            $requete->bindValue(':user_email', $_SESSION['email'], PDO::PARAM_STR);
            $requete->bindValue(':demande_etat', "publié", PDO::PARAM_STR);

            // On exécute la requête :
            $requete->execute();

            // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête :
            $nbLigne = $requete->rowCount(); 
            
            if($nbLigne >= 1)
            {
?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Titre </th>
                                <th scope="col"> Budget </th>
                                <th scope="col"> Equipe </th>
                                <th scope="col"> Publiée </th>
                                <th scope="col"> Détail </th>
                            </tr>
                        </thead>
<?php
                    while ($row = $requete->fetch(PDO::FETCH_OBJ))  // Grace à méthode fetch() on choisit le 1er ligne de chaque colonne et la mets dans l'objet $row
                    {                                              // Avec la boucle "while" on choisit 2eme, 3eme, etc... lignes de chaque colonne et les mets dans l'objet $row
?>         
                        <tbody>
                            <tr>
                                <td>  <?php echo $row->demande_titre;?>  </td>
                                <td>  <?php echo $row->demande_budget;?>  </td>
                                <td>  <?php echo $row->demande_equipe;?>  </td>

                                <!-- Ici on a besoin d'afficher une date qui provient de la base de données et 
                                qui est dans un format MySql: 2018-11-16.
                                Pour formater cette date, on va utiliser l'objet de la classe DateTime et la méthode format:     -->
                                <?php $datePublication = new DateTime($row->demande_publication);?>
                                <td> <?php echo $datePublication->format("d/m/Y H:\hi");?> </td>

                                <!-- On envoie en URL (méthode GET) le paramètre demande_id et demande_etat vers la page demandeDetail.php :   -->
                                <td> <a href="demandeDetail.php?demande_id=<?php echo $row->demande_id ?> &amp; demande_etat=<?php echo $row->demande_etat ?>"> Afficher </a> </td>
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
                echo "<br> <center> <h5 style='color:red'> Pour l'instant vous avez aucune demande publiées ! </h5> </center> <br>";
                echo '<center> 
                        Pour créer une demande veuillez cliquer : <a href="demandeNew.php"> Nouvelle demande </a>
                    <center>';
            }

            // Libèration la connection au serveur de BDD
            $requete->closeCursor();
?>    
                   
            <!-- Bouton Déconnexion -->
            <div style="text-align:center; margin-top:200px">
                <a href="script_deconnexion.php"> <button class="btn btn-warning"> Déconnexion </button> </a> 
            </div>
        </div>


     
        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </body>
</html>