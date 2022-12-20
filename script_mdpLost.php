<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    /* Nous récupérons les informations passées dans le fichier "mdpLost.php" dans la balise <form> et l'attribut action="script_mdpLost.php".  
    Les informations sont récupéré avec variable superglobale $_POST  */

    if(isset($_POST['email']))
    {
        if (!empty($_POST['email']))
        {
            // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $user_email = trim(htmlspecialchars($_POST['email']));
        }
        else
        {
            echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                    <center> 
                        <h4> Veuillez entrer votre adresse mail ! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=mdpLost.php");  // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé sur la page mdpLost.php
            exit;
        }
    }
    else
    {
        echo '<div class="container-fluid alert alert-warning mt-5" role="alert">
                    <center> 
                        <h4> Veuillez entrer votre adresse mail ! </h4> 
                    </center>
                </div>';
        header("refresh:2; url=mdpLost.php");  
        exit;
    }        


    /* Vérification avec l'expréssion RegExp la validité de format d'adresse mail saisi par utilisateur en utilisant 
    la fonction <<preg_match()>> qui renvoie True or False:         */
    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $user_email))
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                <center> 
                    <h4> L\'adresse mail n\'a pas le bon format! </h4> 
                </center>
            </div>'; 
        header("refresh:2; url=mdpLost.php");
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

        if (in_array($user_email, $listeEmail))
        {
            // Si l'adresse mail d'utilisateur est trouvé dans bdd avec la méthode mail() on lui envoie un email de modification :
            $destinataire = $user_email;
            $objet = "Modification du mot de passe";
            $message = "<p> Bonjour, Veuillez cliquer sur le lien pour modifier votre mot de passe: <a href='Acoteq/mdpNew.php'> Modifier votre mot de passe </a> </p>";
            $content = 'text/html; charset=utf-8';
            $expediteur = "contact@gmail.com";

            mail($destinataire, $objet, $message, array('MIME-Version'=>'1.0', 'Content-Type'=>$content, "From"=>$expediteur, "X-Mailer"=>"PHP/".phpversion()));

            echo'<div class="container-fluid alert alert-primary mt-5" role="alert">
                    <center> 
                        <h4> Un mail vient de vous être envoyé avec un lien. Veuillez consulter votre adresse mail. </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=mdpLost.php");
            exit;   
        } 
        else
        {
            echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Cet utilisateur n\'existe pas! <br> Veuillez saisir une bonne adresse mail. </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=mdpLost.php");
            exit;
        }
    }
    else
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                <center> 
                    <h4> Aucune adresse mail trouvée! </h4> 
                </center>
            </div>'; 
    } 
    
    $result->closeCursor();


    
?>



