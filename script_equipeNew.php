<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">

<?php
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  

    /* On va enregistrer la date de création d'une nouvelle équipe. 
    Pour obtenir la bonne date et l'heure, il faut configurer la valeur de l'option <datetime_zone> sur la valeur Europe/Paris. 
    Donc, il faut ajouter l'instruction <date_default_timezone_set("Europe/Paris");> dans nos scripts avant toute manipulation de dates et heures.  */
    date_default_timezone_set('Europe/Paris');

    /* Nous récupérons les informations passées dans le fichier "equipeNew.php" dans la balise <form> et l'attribut action="script_equipeNew.php".  
    Les informations sont récupéré avec variable superglobale $_POST  */
    if(isset($_POST['equipe_nom']) && isset($_POST['equipe_membres']) && !empty($_POST['equipe_nom'] && $_POST['equipe_membres']))
    { 
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS.  
        $equipe_nom = trim(htmlspecialchars($_POST['equipe_nom']));        
        $equipe_proprietaire = trim(htmlspecialchars($_POST['equipe_proprietaire'])); 
        $equipe_membres = trim(htmlspecialchars($_POST['equipe_membres']));

        
        /*  Avant d'insérer en base de données on convertit tout les caractères en minuscules pour certaines variables. 
        Comme la fonction strtolower() ne convertit pas les lettres accentuées et les caractères spéciaux en minuscules, ici on utilise 
        la fonction mb_strtolower() qui passe tout les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) 
        en minuscules. Ensuite on utilise la fonction ucfirst() pour convertir que la 1ere lettre d'un mot en majuscule.      */  
        $equipe_nom = ucfirst(mb_strtolower($equipe_nom));
        $equipe_membres = mb_strtolower($equipe_membres);


        /* Vérification si le nom d'équipe déjà existe dans base de donnée, car le client ne peut pas créer deux équipes qui portent le même nom.
        Pour cela, on va d'abord se connecter à la base de données:     */
        require ("connection_bdd.php");

        // Construction de la requête SELECT avec prepare() pour éviter injections SQL
        $requete = $db->prepare('SELECT equipe_nom FROM equipe WHERE user_email=:user_email');  

        // Association des valeurs aux marqueurs via méthode "bindValue()"    
        $requete->bindValue(':user_email', $_SESSION['email'], PDO::PARAM_STR);

        // Exécution de la requête
        $requete->execute();

        // Grace à la méthode "rowCount()" on peut connaitre le nombre de lignes retournées par la requête
        $nbLigne = $requete->rowCount(); 
        
        if ($nbLigne >= 1)
        {
            while ($row = $requete->fetch(PDO::FETCH_OBJ))   // Grace à la méthode fetch() on choisit 1er ligne de la colonne equipe_nom et on les mets dans l'objet $row                                            
            {                                               // Ensuite avec la boucle "while" on choisit 2eme, 3eme, etc.. lignes de la colonne equipe_nom et on les mets dans l'objet $row 
                if ($row->equipe_nom==$equipe_nom)
                {
                    echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                            <center> 
                                <h4> Cette équipe déjà existe. Veuillez choisir un autre nom pour votre nouvelle équipe ! </h4> 
                            </center>
                        </div>'; 
        
                    header("refresh:2; url=equipeNew.php");  // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page equipeNew.php
                    exit;
                }
            }
        }


        // Avec la fonction explode() on convertit le string $equipe_membres au tableau (array) $membres :
        $membres = explode(",", $equipe_membres);

        // Ensuite on crée 2 tableaux vides:
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


        /* Construction de la requête préparée INSERT pour la table equipe. Les requêtes préparées empêchent les injections SQL.
        On n'insére pas la valeur pour la colonne "equipe_modification" car dans base de données on a bien défini que cette colonne 
        accepte la valeur NULL.   */ 
        $requete = $db->prepare("INSERT INTO equipe (equipe_nom, equipe_proprietaire, equipe_membres, member_mails, equipe_creation, user_id, user_email) 
        VALUES (:equipe_nom, :equipe_proprietaire, :equipe_membres, :member_mails, :equipe_creation, 
        (SELECT user_id FROM users WHERE user_email=:user_email), (SELECT user_email FROM users WHERE user_email=:user_email))");

        // Association des valeurs aux marqueurs via méthode "bindValue()"
        $requete->bindValue(':equipe_nom', $equipe_nom, PDO::PARAM_STR);
        $requete->bindValue(':equipe_proprietaire', $equipe_proprietaire, PDO::PARAM_STR);
        $requete->bindValue(':equipe_membres', $names, PDO::PARAM_STR); 
        $requete->bindValue(':member_mails', $emails, PDO::PARAM_STR); 
        $requete->bindValue(':user_email', $_SESSION['email'], PDO::PARAM_STR);

        // On utilise l'objet DateTime() pour enregistrer la date et l'heure de création de la nouvelle équipe dans la base de données
        $time = new DateTime();   
        $date = $time->format("Y/m/d H:i:s"); 
        $requete->bindValue(':equipe_creation', $date, PDO::PARAM_STR);

        // Exécution de la requête
        $requete->execute();

        // Libèration la connection au serveur de BDD
        $requete->closeCursor();

        // Aprés création d'une nouvelle équipe on envoie un email de notification à tous les membres d'équipe via la méthode mail() :
        mail($emails, "Nouvelle équipe", "Bonjour, une nouvelle équipe a été crée dont vous faites partie!", array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=utf-8', "From"=>"contact@gmail.com", "X-Mailer" => "PHP/".phpversion()));
        
        
        echo '<div class="container-fluid alert alert-success mt-5" role="alert">
                <center> 
                    <h4> Votre équipe a été crée avec succès! </h4> 
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
            
        header("refresh:2; url=equipeNew.php");  
        exit;
    }    


?>
    
    
