<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php 
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  

    /* On va enregistrer la date et l'heure de publication de la nouvelle demande. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <<datetime_zone>> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');
    
    // On récupérer le paramétre demande_id transmit par la page "demandeSaved.php" et on le met dans la variable $demande_id :
    $demande_id = $_GET['demande_id'];

    // Connéxion à la base de données 
    require "connection_bdd.php";
        
    // On construit la requête SELECT : 
    $requete = $db->prepare ("UPDATE demande SET demande_etat=:demande_etat, demande_publication=:demande_publication WHERE demande_id=:demande_id");

    // Association valeur de $_SESSION['email'] au marqueur :email via méthode "bindValue()"
    $requete->bindValue(':demande_etat', "publié", PDO::PARAM_STR);
    $requete->bindValue(':demande_id', $demande_id, PDO::PARAM_INT);

    // On utilise l'objet DateTime() pour enregistrer la date et l'heure de publication de demande dans la base de données
    $time = new DateTime();   
    $date = $time->format("Y/m/d H:i:s"); 

    $requete->bindValue(':demande_publication', $date, PDO::PARAM_STR);

    //On exécute la requête
    $requete->execute();                 
    
    //Libèration la connection au serveur de BDD
    $requete->closeCursor();

    
    /*  Si un client publie sa demande on envoie un email de notification à tous les fournisseurs. 
    Pour cela on construit la requête SELECT pour aller chercher la colonne demande_etat et demande_notification dans la table "demande":     */
    $req="SELECT demande_etat, demande_notification FROM demande WHERE demande_etat='publié' AND demande_notification='non envoyé'";

    /* Avec la méthode query() on exécute notre requête et on ramene les colonnes demande_etat et demande_notification 
    on les mets dans l'objet $result.    */
    $result = $db->query($req)  or  die(print_r($db->errorInfo()));  // Pour repérer l'erreur SQL en PHP on utilise le code die(print_r($db->errorInfo())) 

    // Grace à la méthode "rowCount()" on peut connaitre le nombre de lignes retournées par la requête
    $nbLigne = $result->rowCount(); 
    
    if ($nbLigne >= 1)
    {
        while ($row = $result->fetch(PDO::FETCH_OBJ))   // Grace à la méthode fetch() on choisit 1er ligne de la colonne demande_etat et demande_notification et on les mets dans l'objet $row                                            
        {                                               // Ensuite avec la boucle "while" on choisit 2eme, 3eme, etc.. lignes de la colonne demande_etat et demande_notification et on les mets dans l'objet $row  
            
            $requete="SELECT user_email FROM users WHERE user_role='fournisseur'";
            $resultat = $db->query($requete)  or  die(print_r($db->errorInfo()));
            $nbLigne = $resultat->rowCount(); 
    
            if ($nbLigne >= 1)
            {
                while ($row2 = $resultat->fetch(PDO::FETCH_OBJ))
                {
                    // Avec la méthode mail() on envoie un email de notification aux fournisseurs:
                    mail($row2->user_email, "Nouvelle demande", "Bonjour, Une nouvelle demande a été publié!", array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=utf-8', "From"=>"contact@gmail.com", "X-Mailer" => "PHP/".phpversion()));
                } 
            }
        }
    }
            
    //Libèration la connection au serveur de BDD
    $result->closeCursor();

    // Puis on met à jour la colonne demande_notification:
    $req = "UPDATE demande SET demande_notification=:demande_notification WHERE user_email=:user_email AND demande_etat='publié'";
    $requete = $db->prepare($req);

    /* Execution de requête:
    L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement"     */
    $requete->execute(array(':demande_notification' => 'envoyé', ':user_email' => $_SESSION['email']));

    //Libèration la connection au serveur de BDD
    $result->closeCursor();

    echo'<div class="container-fluid alert alert-success mt-5" role="alert">
            <center> 
                <h4> Votre demande a été publié avec succès! </h4> 
            </center>
        </div>'; 

    header("refresh:2; url=demandeSaved.php");   
    exit;

?>

  
  