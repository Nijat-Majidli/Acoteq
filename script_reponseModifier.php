<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction tout au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).   */
    session_start();  

    /* On va enregistrer la date et l'heure de modification de la reponse. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <<datetime_zone>> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');

    /* Nous récupérons les informations passées dans le fichier "reponseModifier.php" dans la balise <form>  et 
    l'attribut action="script_reponseModifier.php".   Les informations sont récupéré avec variable superglobale $_POST     */
    if(isset($_POST['reponse_id']) && isset($_POST['reponse_titre']) && isset($_POST['reponse_description']) && isset($_POST['reponse_budget']))
    {
        if (!empty($_POST['reponse_id'] && $_POST['reponse_titre'] && $_POST['reponse_description'] && $_POST['reponse_budget']))
        {
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $reponse_id = htmlspecialchars($_POST['reponse_id']);
            $reponse_titre = htmlspecialchars($_POST['reponse_titre']);
            $reponse_description = htmlspecialchars($_POST['reponse_description']);
            $reponse_budget = htmlspecialchars($_POST['reponse_budget']);

            // Connection à la base de données 
            require "connection_bdd.php";

            // Construction de la requête UPDATE avec la méthode prepare() pour éviter les injections SQL
            $requete = $db->prepare("UPDATE reponse SET reponse_titre=:reponse_titre, reponse_description=:reponse_description, 
            reponse_budget=:reponse_budget, reponse_modification=:reponse_modification WHERE reponse_id=:reponse_id");

            // Association des valeurs aux marqueurs via méthode "bindValue()"
            $requete->bindValue(':reponse_titre', $reponse_titre, PDO::PARAM_STR);
            $requete->bindValue(':reponse_description', $reponse_description, PDO::PARAM_STR);
            $requete->bindValue(':reponse_budget', doubleval($reponse_budget), PDO::PARAM_INT); // fonction doubleval() convertit le type de variable en décimale
            $requete->bindValue(':reponse_id', $reponse_id, PDO::PARAM_INT);

            // On utilise l'objet DateTime() pour enregistrer la date et l'heure de creation et publication de reponse dans la base de données
            $time = new DateTime();   
            $date = $time->format("Y/m/d H:i:s"); 

            $requete->bindValue(':reponse_modification', $date, PDO::PARAM_STR);

            // Exécution de la requête
            $requete->execute();

            //Libèration la connection au serveur de BDD
            $requete->closeCursor();
            
            echo'<div class="container-fluid alert alert-success mt-5" role="alert">
                    <center> 
                        <h4> Votre réponse a été modifié avec success! </h4> 
                    </center>
                </div>'; 

            header("refresh:2; url=reponseDetail.php?reponse_id=$reponse_id"); 
            exit;
        }
        else
        {
            echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=reponseModifier.php?reponse_id=$reponse_id"); 
            exit;
        }
    }
    else
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
        header("refresh:2; url=reponseModifier.php?reponse_id=$reponse_id");  
        exit;
    }       
    

   
?>




