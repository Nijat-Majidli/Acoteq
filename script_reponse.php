<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  

    /* On va enregistrer la date de création et publication de la nouvelle demande. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <<datetime_zone>> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');

    /* Nous récupérons les informations passées dans le fichier "demandeDetail.php" dans la balise <form> et l'attribut action="script_reponse.php".  
    Les informations sont récupéré avec variable superglobale $_POST  */
    if(isset($_POST['user_email']) && isset($_POST['demande_id']) && isset($_POST['reponse_titre']) && isset($_POST['reponse_description']) && isset($_POST['reponse_budget']))
    {
        if (!empty($_POST['user_email'] && $_POST['demande_id'] && $_POST['reponse_titre'] && $_POST['reponse_description'] && $_POST['reponse_budget']))
        {
            // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $user_email = trim(htmlspecialchars($_POST['user_email']));
            $demande_id = trim(htmlspecialchars($_POST['demande_id']));
            $reponse_titre = trim(htmlspecialchars($_POST['reponse_titre']));
            $reponse_description = trim(htmlspecialchars($_POST['reponse_description']));
            $reponse_budget = trim(htmlspecialchars($_POST['reponse_budget']));

            /*  Avant d'insérer en base de données on convertit tout les caractères en minuscules de variables. Comme la fonction strtolower() 
            ne convertit pas les lettres accentuées et les caractères spéciaux en minuscules, ici on utilise la fonction mb_strtolower() 
            qui passe tout les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) en minuscules.   */  
            $reponse_titre = mb_strtolower($reponse_titre);
            $reponse_description = mb_strtolower($reponse_description);
        
            // Connexion à la base de données 
            require "connection_bdd.php";

            // Construction de la requête INSERT avec la méthode prepare() sans injection SQL
            $requete = $db->prepare("INSERT INTO reponse (reponse_titre, reponse_proprietaire, reponse_societe, reponse_description, 
            reponse_budget, reponse_publication, reponse_notification, demande_id, user_id, user_email) 
            VALUES(:reponse_titre, (SELECT CONCAT(user_nom, ' ', user_prenom) AS reponse_proprietaire FROM users WHERE user_email=:user_email), 
            (SELECT user_societe AS reponse_societe FROM users WHERE user_email=:user_email), :reponse_description, :reponse_budget, 
            :reponse_publication, :reponse_notification, :demande_id, (SELECT user_id FROM users WHERE user_email=:user_email), 
            (SELECT user_email FROM users WHERE user_email=:user_email))");
            

            // Association des valeurs aux marqueurs via la méthode "bindValue()"
            $requete->bindValue(':reponse_titre', $reponse_titre, PDO::PARAM_STR);
            $requete->bindValue(':reponse_description', $reponse_description, PDO::PARAM_STR);
            $requete->bindValue(':reponse_budget', $reponse_budget, PDO::PARAM_INT);
            
            // On utilise l'objet DateTime() pour enregistrer la date et l'heure de publication de reponse dans la base de données
            $time = new DateTime();   
            $date = $time->format("Y/m/d H:i:s"); 
            $requete->bindValue(':reponse_publication', $date, PDO::PARAM_STR);

            $requete->bindValue(':reponse_notification', 'envoyé', PDO::PARAM_STR);
            $requete->bindValue(':demande_id', $demande_id, PDO::PARAM_STR);
            $requete->bindValue(':user_email', $_SESSION['email'], PDO::PARAM_STR);

            // Exécution de la requête
            $requete->execute();

            // Libèration la connection au serveur de BDD
            $requete->closeCursor();

            // Avec la méthode mail() on envoie un email de notification au client pour lui dire que le fournisseur a répondu à sa demande. 
            mail($user_email, "Nouvelle réponse", "Bonjour, Une nouvelle réponse a été publié!", array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=utf-8', "From"=>"contact@gmail.com", "X-Mailer" => "PHP/".phpversion()));
            
            echo'<div class="container-fluid alert alert-success mt-5" role="alert">
                    <center> 
                        <h4> Votre réponse a été publié avec succès! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=fournisseur.php");   // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page fournisseur.php
            exit;
        }
        else
        {
            echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=detail.php");  
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
        header("refresh:2; url=detail.php");  
        exit;
    }


    
?>