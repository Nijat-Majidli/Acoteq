<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    session_start();  
    /* ATTENTION
    Il est impératif d'utiliser la fonction session_start() au début de chaque fichier PHP dans lequel on manipulera cette 
    variable et avant tout envoi de requêtes HTTP, c'est-à-dire avant tout echo ou quoi que ce soit d'autre : rien ne doit 
    avoir encore été écrit/envoyé à la page web.  */

     
    // On récupérer le paramétre equipe_id transmit en GET par la page "equipeAutres.php" et on le met dans la variable $equipe_id :
    if(isset($_GET['equipe_id']) && !empty($_GET['equipe_id']))
    {
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
        $equipe_id = trim(htmlspecialchars((int)$_GET['equipe_id']));   // Pour vérifier que $_GET['equipe_id'] contient bien un nombre entier, on utilise (int) pour convertir la variable GET en type entier. 

        // Connéxion à la base de données 
        require "connection_bdd.php";
                        
        // On construit la requête DELETE avec la méthode prepare() sans injection SQL : 
        $requete = $db->prepare("SELECT * FROM equipe WHERE equipe_id=:equipe_id");

        // Association valeur au marqueur :email via méthode "bindValue()"
        $requete->bindValue(':equipe_id', $equipe_id, PDO::PARAM_INT);

        // On exécute la requête
        $requete->execute();

        // Si la requête renvoit un seul et unique résultat, on ne fait pas de boucle, ici c'est le cas: 
        $row = $requete->fetch(PDO::FETCH_OBJ);

        $membrePrenom = mb_strtolower($_SESSION['prenom']);
        $membreNom = mb_strtolower($_SESSION['nom']);
        $membreName = $membrePrenom." ".$membreNom;
        $removeName = "";

        // La fonction strpos(param1, param2) cherche la string param2 dans la string param1 et retourne sa position
        if(strpos($row->equipe_membres, $membreName)) 
        {
            echo "Hello ".$row->equipe_membres."<br>";
            
            $removeName = str_replace($membreName, '', $row->equipe_membres); 
            
            echo $removeName."<br>";
        }

        $removeEmail = "";
        if(strpos($row->member_mails, $_SESSION['email'])) 
        { 
            echo "Hello ".$row->member_mails."<br>";

            $removeEmail = str_replace($_SESSION['email'], '', $row->member_mails); 

            echo $removeEmail."<br>";
        }

        // Construction de la requête UPDATE avec la méthode prepare() sans injection SQL
        $requete = $db->prepare("UPDATE equipe SET equipe_membres=:equipe_membres, member_mails=:member_mails WHERE equipe_id=:equipe_id");

        // Association des valeurs aux marqueurs via méthode "bindValue()" :
        $requete->bindValue(':equipe_membres', $removeName, PDO::PARAM_STR); 
        $requete->bindValue(':member_mails', $removeEmail, PDO::PARAM_STR); 
        $requete->bindValue(':equipe_id', $equipe_id, PDO::PARAM_INT);

        // Exécution de la requête
        $requete->execute();

        //Libèration la connection au serveur de BDD
        $requete->closeCursor();

        echo '<div class="container-fluid alert alert-success mt-5" role="alert">
                <center> 
                    <h4> Vous avez quitté équipe ! </h4> 
                </center>
             </div>'; 
        
        header("refresh:2; url=equipeAutres.php");   // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page equipeCreated.php
        exit;
    }
    else
    {
        echo "<h4> Veuillez renseigner l'équipe numéro! </h4>";
        header("refresh:2; url=equipeAutres.php");  
        exit;
    }


            

?>