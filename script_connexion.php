<!-- Bootstrap CDN link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">

<?php
    /* On va enregistrer la date et l'heure de dernier connexion de nos utilisateurs. 
    Pour obtenir la bonne heure, il faut configurer la valeur de l'option datetime_zone sur la valeur Europe/Paris avant toute manipulation de dates:   */
    date_default_timezone_set('Europe/Paris');

    /* Nous récupérons les informations passées dans le fichier "connexion.php" dans la balise <form> et l'attribut action="script_connexion.php".  
    Les informations sont récupéré avec variable superglobale $_POST:   */
    if(isset($_POST['email']) && isset($_POST['mdp']) && !empty($_POST['email'] && $_POST['mdp']))
    {
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
        $user_email = trim(htmlspecialchars($_POST['email']));
        $user_mdp = trim(htmlspecialchars($_POST['mdp']));
    }
    else
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                <center> 
                    <h4> Veuillez remplir tous les champs ! </h4> 
                </center>
            </div>'; 
        header("refresh:2; url=connexion.php");  // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé sur la page "connexion.php"
        exit;
    }


    // Vérification avec RegExp la validité de format d'adresse mail saisi par utilisateur en utilisant la fonction <<preg_match()>> qui renvoie True or False:         
    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $user_email))
    {
        echo"<div class='container-fluid alert alert-danger mt-5' role='alert'>
                <center> 
                    <h4> L'adresse mail n'a pas bon format ! </h4> 
                </center>
            </div>"; 

        header("refresh:2; url=connexion.php");
        exit;
    }

    /* Vérification si l'adresse mail saisi par utilisateur déjà existe dans la base de données ou non ?
    Pour cela d'abord on va se connecter à la base de données:     */
    require ("connection_bdd.php");

    // Ensuite on construit la requête SELECT :
    $req = "SELECT * FROM users WHERE user_email=:user_email" ;
                            
    // On utilise la méthode prepare() pour eviter les injection SQL :
    $result = $db->prepare($req);

    /* Association de valeur au marqueur et execution de la reqûete.
    L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement". */
    $result->execute(array(':user_email' => $user_email));

    // Si la requête renvoit un seul et unique résultat, on ne fait pas de boucle, ici c'est le cas: 
    $row = $result->fetch(PDO::FETCH_OBJ);

    if ($row==false)
    {

        echo '<script> window.alert("Cette utilisateur n\'existe pas!"); </script>';

        header("refresh:0; url=connexion.php");
        exit;
    } 
     
    
    /* Vérification: Est-ce que le mot de passe saisi par utilisateur déjà existe dans la base de données ou non ?
    D'abord on doit récupérer le mot de passe hashé de l'utilisateur qui se trouve dans la base de données. 
    Pour cela, on fait préparation de la requête SELECT avec la méthode prepare :  */
    $requete = $db->prepare('SELECT user_mdp, user_blocked FROM users WHERE user_email=:user_email');

    /* Association la valeur au marqueur et execution de requête:
    L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement"     */
    $requete->execute(array(':user_email' => $user_email));
    
    $resultat = $requete->fetch(); 
    /* Variable $resultat est un array associatif qui contient 2 éléments :  
    1. user_mdp et sa valeur;    
    2. user_blocked et sa valeur     */
     
    // Pour vérifier si le mot de passe saisi par utilisateur est bien celui enregistré en base de données, on utilise la fonction password_verify() qui renvoie True ou False :       */
    $PasswordCorrect = password_verify($user_mdp, $resultat['user_mdp']);
    
    if ($PasswordCorrect && empty($resultat['user_blocked']))
    {
        // Construction de la requête UPDATE pour mettre à jour la date et l'heure du dernier connexion de l'utilisateur:
        $requete = $db->prepare("UPDATE users SET user_connexion=:user_connexion WHERE user_email=:user_email");

        // On utilise l'objet DateTime pour montrer la date et l'heure du dernier connexion du client: 
        $time = new DateTime();  
        $date = $time->format("Y/m/d H:i:s"); 
        
        // Association des valeurs aux marqueurs via méthode "bindValue()"
        $requete->bindValue(':user_connexion', $date, PDO::PARAM_STR);
        $requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);

        // Exécution de la requête
        $requete->execute(); 

        // Création d'une session :
        session_start();
        
        // On va créer plusieurs variables de SESSION que l'on aura besoin dans les autres pages:  
        $_SESSION['id'] = $row->user_id; 
        $_SESSION['email'] = $user_email;
        $_SESSION['mdp'] = $user_mdp;

        // On vérifie si l'utilisateur a coché l'option "Ses souvenir de moi" dans la page connexion:
        if(isset($_POST['cookie'])=="rememberMe")
        {
            $remember = $_POST['cookie'];
        }

        // On crée la variable SESSION cookie:
        if(isset($remember))
        {
            $_SESSION['cookie'] = $remember;
        }
        
        /* Ensuite on va créer les autres variables de SESSION:  $_SESSION['nom'],  $_SESSION['prenom'],  $_SESSION['fullName'],  $_SESSION['user_siren'] et  $_SESSION['role'].
        Pour cela d'abord on envoie la requête vers la bdd:   */
        $requete = $db->prepare('SELECT * FROM users WHERE user_email=:user_email');
        
        /* Association valeur au marqueur et execution de la requete.
        L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement".  */
        $requete->execute(array(':user_email' => $user_email));   
        
        $resultat = $requete->fetch();      // Variable $resultat est un tableau (array) associatif 

        $_SESSION['nom'] = $resultat['user_nom'];
        $_SESSION['prenom'] = $resultat['user_prenom'];
        $_SESSION['fullName'] = $resultat['user_prenom']." ".$resultat['user_nom'];
        $_SESSION['user_siren'] = $resultat['user_siren'];
        
        if ($resultat['user_role']=='client')
        {
            $_SESSION['role'] = 'client';
            
            $page = 'client.php';
        }
        else if ($resultat['user_role']=='fournisseur')
        {
            $_SESSION['role'] = 'fournisseur';
            
            $page = 'fournisseur.php';
        }

        
        echo'<div class="container-fluid alert alert-primary mt-5" role="alert">
                <center> 
                    <h4> Bonjour '.$_SESSION['prenom'].' '.$_SESSION['nom'].'<br> Vous êtes connecté! </h4> 
                </center>
            </div> 

            <div class="container-fluid-fluid ml-5">
                <section class="maison">
                    <img src="../Acoteq/image/logo.png" alt="logo" title="logo">
                </section>
        
                <aside>
                    <div class="slogan_1">
                        <center> <h2 style="margin: 100px 0 0 100px"> Bienvenu sur notre site ! </h2>  </center> 
                    </div>
                </aside>
            </div>';

        header("refresh:2; url=$page");
        exit;
    }
    else 
    {
        $requete = $db->prepare('SELECT login_fail, user_blocked, unblock_time FROM users WHERE user_email=:user_email');
        
        // Association des valeurs aux marqueurs via méthode "bindValue()"
        $requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);

        // Exécution de la requête
        $requete->execute(); 
        
        $resultat = $requete->fetch(); 
        /* Variable $resultat est un tableau (array) associatif qui contient 3 éléments : 
        1. login_fail et sa valeur, 
        2. user_blocked et sa valeur,
        3. unblock_time et sa valeur.    */
         
        // On augmente le nombre de login_fail à chaque fois que l'utilisateur saisit mauvais mot de passe :
        $login_fail = $resultat['login_fail'] + 1;  

        if($login_fail < 4)   
        {
            // Ensuite on enregistre nouvelle valeur de login_fail dans la base de donnée: 
			$requete = $db->prepare('UPDATE users SET login_fail=:login_fail WHERE user_email=:user_email');
			
			// Association des valeurs aux marqueurs via méthode "bindValue()"
            $requete->bindValue(':login_fail', $login_fail, PDO::PARAM_INT);
            $requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            
            // Exécution de la requête
            $requete->execute(); 
           
            echo"<div class='container-fluid alert alert-danger mt-5' role='alert'>
                    <center> 
                        <h4> Mauvais email ou mot de passe! </h4> 
                    </center>
                </div>";  

            header("refresh:2; url=connexion.php");  
            exit;
        }
		else   // Si l'utilisateur 3 fois ne saisit pas son mot de passe correctement on le bloque 
		{
			if(empty($resultat['user_blocked']))
			{
				$requete = $db->prepare('UPDATE users SET user_blocked=:user_blocked, unblock_time=:unblock_time WHERE user_email=:user_email');
				
				// La fonction time() renvoie l'heure actuelle en nombre de secondes (timestamp) depuis l'époque Unix (1er janvier 1970 00:00:00 GMT).
				$unblock_time = time() + (1*1*2*60);	

                // Association des valeurs aux marqueurs via méthode "bindValue()"
				$requete->bindValue(':user_blocked', $user_email, PDO::PARAM_STR);
				$requete->bindValue(':unblock_time', $unblock_time, PDO::PARAM_INT);
				$requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);

				// Exécution de la requête
				$requete->execute(); 

                echo"<div class='container-fluid alert alert-danger mt-5' role='alert'>
                    <center> 
                        <h4> Vous êtes bloqué pour 2 minutes! </h4> 
                    </center>
                </div>"; 

				header("refresh:2; url=connexion.php");  
				exit;
			}
			else
			{
				$current_time = time();	  

				if($resultat['unblock_time'] < $current_time)
				{
					$requete = $db->prepare('UPDATE users SET login_fail=:login_fail, user_blocked=:user_blocked, unblock_time=:unblock_time WHERE user_email=:user_email');
					
					$requete->bindValue(':login_fail', 0, PDO::PARAM_INT);
					$requete->bindValue(':user_blocked', null, PDO::PARAM_STR);
					$requete->bindValue(':unblock_time', null, PDO::PARAM_INT);
					$requete->bindValue(':user_email', $user_email, PDO::PARAM_STR);
					
					$requete->execute();

                    echo"<div class='container-fluid alert alert-success mt-5' role='alert'>
                            <center> 
                                <h4> Maintenant vous êtes débloqué ! <br> Veuillez réessayer de vous connecter! </h4> 
                            </center>
                        </div>"; 

					header("refresh:3; url=connexion.php");  
					exit;
				}
				else
				{
                    echo"<div class='container-fluid alert alert-danger mt-5' role='alert'>
                            <center> 
                                <h4> Vous êtes bloqué pour 2 minutes! </h4> 
                            </center>
                        </div>"; 
					
					header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php.
					exit;
				}
			}
		} 
    }  
    
    
    $requete->closeCursor();  // Libère la connexion au serveur
        
?>



