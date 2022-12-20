<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">



<?php
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  


    /* On va enregistrer la date et l'heure de modification de commentaire. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <datetime_zone> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');


    /* Nous récupérons les informations passées dans le fichier "commentModifier.php" dans la balise <form> et l'attribut action="script_commentModifier.php".   
    Les informations sont récupéré avec variable superglobale $_POST     */
    if(isset($_POST['comment_id']) && isset($_POST['reponse_id']) && isset($_POST['comment_description']))
    {
        if (!empty($_POST['comment_id'] && $_POST['reponse_id'] && $_POST['comment_description']))
        {
            // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $comment_id = trim(htmlspecialchars($_POST['comment_id']));
            $reponse_id = trim(htmlspecialchars($_POST['reponse_id']));
            $comment_description = htmlspecialchars($_POST['comment_description']);

            if(isset($_POST['visibilite'])=='visible')
            {
                $comment_visibilite = $_POST['visibilite'];
            }
            else
            {
                $comment_visibilite = 'non';
            }
            
            /*  Avant d'insérer en base de données on convertit tout les caractères en minuscules pour certaines variables. 
            Comme la fonction strtolower() ne convertit pas les lettres accentuées et les caractères spéciaux en minuscules, ici on utilise 
            la fonction mb_strtolower() qui passe tout les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) 
            en minuscules.       */  
            $comment_description = mb_strtolower($comment_description);
            
            
            // Connexion à la base de données:     
            require ("connection_bdd.php");

            // Construction de la requête UPDATE avec la méthode prepare() sans injection SQL
            $requete = $db->prepare("UPDATE commentaire SET comment_description=:comment_description, comment_modification=:comment_modification, 
            comment_visibilite=:comment_visibilite WHERE comment_id=:comment_id");

            // Association des valeurs aux marqueurs via méthode "bindValue()"
            $requete->bindValue(':comment_description', $comment_description, PDO::PARAM_STR);
            $requete->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
            $requete->bindValue(':comment_visibilite', $comment_visibilite, PDO::PARAM_STR);

            // On utilise l'objet DateTime() pour enregistrer la date et l'heure de creation et publication de demande dans la base de données
            $time = new DateTime();   
            $date = $time->format("Y/m/d H:i:s"); 

            $requete->bindValue(':comment_modification', $date, PDO::PARAM_STR);

            // Exécution de la requête
            $requete->execute();

            //Libèration la connection au serveur de BDD
            $requete->closeCursor();

            echo '<div class="container-fluid alert alert-success mt-5" role="alert">
                    <center> 
                        <h4> Votre commentaire a été modifié avec succès! </h4> 
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

                if($_SESSION['role']=='client')
                {
                    $page='client.php';
                }
                elseif($_SESSION['role']=='fournisseur')
                {
                    $page='fournisseur.php';
                }

                header("refresh:2; url=$page");  
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
        
        if($_SESSION['role']=='client')
        {
            $page='client.php';
        }
        elseif($_SESSION['role']=='fournisseur')
        {
            $page='fournisseur.php';
        }

        header("refresh:2; url=$page");  
        exit;
    }       


            

?>