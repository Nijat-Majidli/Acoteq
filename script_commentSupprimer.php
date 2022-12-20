<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
     
    // On récupérer le paramétre comment_id transmit en GET par la page "reponseDetail.php" et on le met dans la variable $comment_id :
    if(isset($_GET['comment_id']) && isset($_GET['reponse_id']))
    {
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
        $comment_id = trim(htmlspecialchars((int)$_GET['comment_id']));   // Pour vérifier que $_GET['comment_id'] contient bien un nombre entier, on utilise (int) pour convertir la variable GET en type entier. 
        $reponse_id = trim(htmlspecialchars((int)$_GET['reponse_id']));

        // Connéxion à la base de données 
        require "connection_bdd.php";
                        
        // On construit la requête DELETE avec la méthode prepare() sans injection SQL : 
        $requete = $db->prepare("DELETE FROM commentaire WHERE comment_id=:comment_id");

        // Association valeur au marqueur :email via méthode "bindValue()"
        $requete->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

        // On exécute la requête
        $requete->execute();

        // Libèration la connection au serveur de BDD
        $requete->closeCursor();

        echo'<div class="container-fluid alert alert-success mt-5" role="alert">
            <center> 
                <h4> Votre commentaire a été supprimé avec succès! </h4> 
            </center>
        </div>'; 

        header("refresh:2; url=reponseDetail.php?reponse_id=$reponse_id");   // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page client.php
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
          

?>