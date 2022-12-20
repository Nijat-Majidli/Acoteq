<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">



<?php
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  


    /* On va enregistrer la date et l'heure de modification de l'équipe. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <datetime_zone> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');


    /* Nous récupérons les informations passées dans le fichier "equipeModifier.php" dans la balise <form> et l'attribut action="script_equipeModifier.php".   
    Les informations sont récupéré avec variable superglobale $_POST     */
    if(isset($_POST['equipe_id']) && isset($_POST['equipe_proprietaire']) && isset($_POST['equipe_nom']) && isset($_POST['equipe_membres']))
    {
        if (!empty($_POST['equipe_id'] && $_POST['equipe_proprietaire'] && $_POST['equipe_nom'] && $_POST['equipe_membres']))
        {
            // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $equipe_id = trim(htmlspecialchars($_POST['equipe_id']));
            $equipe_proprietaire = trim(htmlspecialchars($_POST['equipe_proprietaire']));
            $equipe_nom = trim(htmlspecialchars($_POST['equipe_nom']));
            $equipe_membres = trim(htmlspecialchars($_POST['equipe_membres']));
            
            /*  Avant d'insérer en base de données on convertit tout les caractères en minuscules pour certaines variables. 
            Comme la fonction strtolower() ne convertit pas les lettres accentuées et les caractères spéciaux en minuscules, ici on utilise 
            la fonction mb_strtolower() qui passe tout les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) 
            en minuscules. Ensuite on utilise la fonction ucfirst() pour convertir que la 1ere lettre d'un mot en majuscule.      */  
            $equipe_nom = ucfirst(mb_strtolower($equipe_nom));
            $equipe_membres = mb_strtolower($equipe_membres);

            // Avec la fonction explode() on convertit le string $equipe_membres au tableau (array) $membres :
            $membres = explode(",", $equipe_membres);

            // Ensuite on crée 2 tableaux vide:
            $memberNames = array();
            $memberEmails = array();

            /* Avec la boucle for on parcourt le tableau $membres et on insére:
            1. Les éléments pair dans le tableau $memberNames;
            2. Les éléments impair dans le tableau $memberEmails.       */
            for($i=0; $i<sizeof($membres); $i++)
            {
                if($i%2==0)
                {
                    array_push($memberNames, $membres[$i]); 
                }
                else
                {
                    array_push($memberEmails, $membres[$i]);
                }
            }

            /* Enfin avec la fonction implode() on convertit:
            1. Le tableau $memberNames au string $names;
            2. Le tableau $memberEmails au string $emails.   */
            $names = implode(", ", $memberNames);
            $emails = implode(", ", $memberEmails);

            // Connexion à la base de données:     
            require ("connection_bdd.php");

            // Construction de la requête UPDATE avec la méthode prepare() sans injection SQL
            $requete = $db->prepare("UPDATE equipe SET equipe_proprietaire=:equipe_proprietaire, equipe_nom=:equipe_nom, 
            equipe_membres=:equipe_membres, member_mails=:member_mails, equipe_modification=:equipe_modification WHERE equipe_id=:equipe_id");

            // Association des valeurs aux marqueurs via méthode "bindValue()"
            $requete->bindValue(':equipe_proprietaire', $equipe_proprietaire, PDO::PARAM_STR);
            $requete->bindValue(':equipe_nom', $equipe_nom, PDO::PARAM_STR);
            $requete->bindValue(':equipe_membres', $names, PDO::PARAM_STR); 
            $requete->bindValue(':member_mails', $emails, PDO::PARAM_STR); 
            $requete->bindValue(':equipe_id', $equipe_id, PDO::PARAM_INT);

            // On utilise l'objet DateTime() pour enregistrer la date et l'heure de creation et publication de demande dans la base de données
            $time = new DateTime();   
            $date = $time->format("Y/m/d H:i:s"); 

            $requete->bindValue(':equipe_modification', $date, PDO::PARAM_STR);

            // Exécution de la requête
            $requete->execute();

            //Libèration la connection au serveur de BDD
            $requete->closeCursor();

            // Aprés création d'une nouvelle équipe on envoie un email de notification à tous les membres d'équipe via la méthode mail() :
            mail($emails, "Modification d'équipe", "Bonjour, une modification d'équipe a été effectuée!", array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=utf-8', "From"=>"contact@gmail.com", "X-Mailer" => "PHP/".phpversion()));

            echo '<div class="container-fluid alert alert-success mt-5" role="alert">
                    <center> 
                        <h4> Votre équipe a été modifié avec succès! </h4> 
                    </center>
                </div>'; 

            header("refresh:2; url=equipeCreated.php");   // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page equipeCreated.php
            exit;
        }
        else
        {
            echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=equipeModifier.php");  
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
        header("refresh:2; url=equipeModifier.php");  
        exit;
    }       


            

?>