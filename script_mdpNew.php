<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    /* Nous récupérons les informations passées dans le fichier "mdpNew.php" dans la balise <form> et l'attribut action="script_mdpNew.php".  
    Les informations sont récupéré avec variable superglobale $_POST  */

    if(isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['mdp2']))
    {
        if (!empty($_POST['email'] && $_POST['mdp'] && $_POST['mdp2']))
        {
            // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
            // La fonction "htmlspecialchars()" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $user_email = trim(htmlspecialchars($_POST['email']));
            $user_mdp = trim(htmlspecialchars($_POST['mdp']));
            $user_mdp2 = trim(htmlspecialchars($_POST['mdp2']));
        }
        else
        {
            echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                <center> 
                    <h4> Veuillez saisir votre email et nouveau mot de passe ! </h4> 
                </center>
            </div>'; 
            header("refresh:2; url=mdpNew.php");  // refresh:2 signifie qu'après 2 secondes utilisateur sera redirigé sur la page mdpNew.php 
            exit;
        }
    }
    else
    {
        echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                <center> 
                    <h4> Veuillez saisir votre email et nouveau mot de passe ! </h4> 
                </center>
            </div>'; 
        header("refresh:2; url=mdpNew.php");  
        exit;
    }       


    /* Vérification avec l'expréssion RegExp la validité de format de tout les données saisi par utilisateur en utilisant 
    la fonction preg_match() qui renvoie True or False:      */
    if (!preg_match("#^[a-z0-9._ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $user_email))
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                <center> 
                    <h4> L\'adresse mail n\'a pas le bon format! </h4> 
                </center>
            </div>'; 
        header("refresh:2; url=mdpNew.php");
        exit;
    }


    /* Un mot de passe ne doit jamais être stocké en clair : il doit être crypté à l'aide d'un algorithme de cryptage afin que sa valeur 
    ne puisse être lue. La technique du grain de sel (appelée aussi salage, ou encore salt en anglais) consiste à ajouter une chaîne alphanumérique 
    au mot de passe lui-même. Le but est d'empêcher de retrouver le mot de passe d'origine à partir de sa chaîne hashée (appelée hash).
    La fonction password_hash() permet d’utiliser des algorithmes de cryptage en PHP et donc de générer le hash d’une chaîne de caractères, 
    grain de sel inclus.   
    D'abord on vérifie la validité du mot de passe:   */
    if ($user_mdp === $user_mdp2)
    {
        // Si le mot de passe est valide, on fait cryptage avec fonction password_hash()
        $user_mdp = password_hash($user_mdp, PASSWORD_DEFAULT);  // Ici 2eme paramètre PASSWORD_DEFAULT est l’algorithme de cryptage à utiliser, obligatoire.
    }
    else
    {
        echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                <center> 
                    <h4> Le mot de passe n\'est pas identique. </h4> 
                </center>
            </div>'; 
        header("refresh:2; url=mdpNew.php");
        exit;
    }


    /* Vérification si l'adresse mail saisi par utilisateur déjà existe dans la base de données ou non ?
    Pour cela d'abord on va se connecter à la base de données:     */
    require ("connection_bdd.php");

    // Ensuite on construit la requête SELECT pour aller chercher la colonne user_email qui se trouvent dans la table "users" :
    $requete = "SELECT user_email FROM users" ;
    
    // Grace à méthode query() on exécute notre requête et on ramene la colonne user_email et on les mets dans l'objet $result.
    $result = $db->query($requete)  or  die(print_r($db->errorInfo()));  // Pour repérer l'erreur SQL en PHP on utilise le code die(print_r($db->errorInfo())) 

    // Grace à la méthode "rowCount()" on peut connaitre le nombre de lignes retournées par la requête
    $nbLigne = $result->rowCount(); 
    
    if ($nbLigne >= 1)
    {
        // On crée un tableau (array) $listeEmail dans laquelle on va garder tous les adresses mail qui se trouve dans la table users :
        $listeEmail = array();  

        while ($row = $result->fetch(PDO::FETCH_OBJ))   // Grace à la méthode fetch() on choisit 1er ligne de la colonne user_email et on la mets dans l'objet $row                                            
        {                                               // Ensuite avec la boucle "while" on choisit 2eme, 3eme, etc.. lignes de la colonne user_email et on les mets dans l'objet $row  
            
            // Avec la méthode array_push on ajoute un par un tous les adresses mail dans tableau $listeEmail :
            array_push($listeEmail, $row->user_email);  
        }

        if (!in_array($user_email, $listeEmail))
        {
            echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                    <center> 
                        <h4> Cette utilisateur n\'existe pas! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=mdpNew.php");
            exit;
        } 
    } 


    // Construction de la requête préparée INSERT pour la table users. Les requêtes préparées empêchent les injections SQL :
    $requete = $db->prepare("INSERT INTO users (user_mdp) VALUES (:user_mdp) WHERE user_email=:user_email");

    // Association des valeurs aux marqueurs via méthode "bindValue()" :
    $requete->bindValue(':user_mdp', $user_mdp, PDO::PARAM_STR);
    $requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);

    // Exécution de la requête
    $requete->execute();

    // Libèration la connection au serveur de BDD
    $requete->closeCursor();

    // Redirection vers la page connexion.php 
    echo'<div class="container-fluid alert alert-success mt-5" role="alert">
            <center> 
                <h4> Votre mot de passe a été modifié avec success! </h4> 
            </center>
        </div>'; 
    header("refresh:2; url=connexion.php");
    exit;   
    


?>

