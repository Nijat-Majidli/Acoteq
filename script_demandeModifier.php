<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    // Pour utiliser la variable superglobale "$_SESSION" il faut ajouter le fonction session_start() tout au début de la page:
    session_start();  

    /* On va enregistrer la date et l'heure de modification de la demande. Pour obtenir la bonne date et l'heure, 
    il faut configurer la valeur de l'option <<datetime_zone>> sur la valeur Europe/Paris. Donc, il faut ajouter 
    l'instruction <<date_default_timezone_set("Europe/Paris");>> dans nos scripts avant toute manipulation de dates.  */
    date_default_timezone_set('Europe/Paris');

    /* Nous récupérons les informations passées dans le fichier "demandeModifier.php" dans la balise <form>  et 
    l'attribut action="script_demandeModifier.php".   Les informations sont récupéré avec variable superglobale $_POST     */
    if(isset($_POST['demande_id']) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['budget']) && isset($_POST['etat']))
    {
        if (!empty($_POST['demande_id'] && $_POST['titre'] && $_POST['description'] && $_POST['budget'] && $_POST['etat']))
        {
            // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
            $demande_id = htmlspecialchars($_POST['demande_id']);
            $demande_titre = htmlspecialchars($_POST['titre']);
            $demande_description = htmlspecialchars($_POST['description']);
            $demande_budget = htmlspecialchars($_POST['budget']);
            $demande_etat = htmlspecialchars($_POST['etat']); 

            /* Ajouter une équipe dans une demande est facultative, n'est pas obligatoire. 
            Donc si le client décide d'ajouter une équipe on crée la variable $demande_equipe     */
            if(isset($_POST['equipe']) && !empty($_POST['equipe']))
            {
                $demande_equipe = trim(htmlspecialchars($_POST['equipe']));
            }


            /* Avant d'insérer en base de données on convertit tout les caractères en minuscules pour certaines variables. 
            Comme la fonction strtolower() ne convertit pas les lettres accentuées et les caractères spéciaux en minuscules, ici on utilise 
            la fonction mb_strtolower() qui passe tout les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) 
            en minuscules. Ensuite on utilise la fonction ucfirst() pour convertir que la 1ere lettre d'un mot en majuscule.      */ 
            $demande_titre = ucfirst(mb_strtolower($demande_titre));
            $demande_description = mb_strtolower($demande_description);
            
            if(isset($demande_equipe))
            {
                $demande_equipe = ucfirst(mb_strtolower($demande_equipe));
            }

           
            /* Lorsque le formulaire (page demandeNew.php) est soumis, on récupère les informations sur le fichier téléchargé par utilisateur
            via la variable superglobale $_FILES, qui se comporte comme un tableau associatif PHP.
            Le problème principal de l'upload d'un fichier est la sécurité. On doit tout d'abord vérifier 3 points basiques :
            1. Le fichier a-t-il bien été téléchargé (upload) ?
            2. La taille du fichier ne dépasse-t-elle pas la taille autorisée? ?
            3. Le type du fichier envoyé par l'utilisateur est-il celui attendu (image, document Word, PDF etc...) ?        */

            if(isset($_FILES['clientFile']))
            { 
                /* On doit sûrement limiter la taille du fichier. Il ne faudrait pas que quelqu'un s'amuse à uploader des fichiers de 
                plusieurs Mo. Donc on vérifie la taille (en octets) du fichier (1Mo = 1 000 000 octets,  1Ko = 1000 octets).
                Ici on definit la maximale taille autorisée comme 5 000 000 octets (soit 5Mo) :     */
                $taille_maxi = 5000000;
                
                $taille_fichier = $_FILES['clientFile']['size'];  // $_FILES['clientFile']['size'] retourne la taille du fichier en octets

                if($taille_fichier > $taille_maxi)
                {
            
                    echo '<div class="container-fluid alert alert-warning mt-5" role="alert">
                            <center> 
                                <h4> La taille du fichier ne doit pas dépasser 5Mo ! </h4> 
                            </center>
                        </div>'; 
                    header("refresh:2; url=demandeModifier.php?demande_id=$demande_id");  
                    exit;
                }
        
                // Maintenant on vérifie le type du fichier. Pour cela on met les types autorisés dans un tableau nommé $extensions_valide :  
                $extensions_valide = array(".pdf", ".doc", ".docx", ".txt");
                
                /* Ensuite on récupére l'extension du fichier téléchargé par l'utilisateur à l'aide de la fonction strrchr() qui nous renvoie 
                le string à partir de '.' qui correspond à l'extension du fichier    */
                $extension_fichier = mb_strtolower(strrchr($_FILES['clientFile']['name'], '.'));   // mb_strtolower() transforme tous les caractères majuscules (lettres normales, lettres accentuées, caractères spéciaux) en minuscules.

                if (!in_array($extension_fichier, $extensions_valide))
                {
                    // Le type n'est pas autorisé, donc message d'ERREUR
                    echo '<div class="container-fluid alert alert-warning mt-5" role="alert">
                            <center> 
                                <h4> Vous devez télécharger un fichier de type pdf, doc, docx ou txt ! </h4> 
                            </center>
                        </div>'; 
                    header("refresh:3; url=demandeModifier.php?demande_id=$demande_id");   // refresh:3 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page demandeNew.php
                    exit;
                }     
            } 
            else
            {
                echo'<div class="container-fluid alert alert-warning mt-5" role="alert">
                        <center> 
                            <h4> Veuillez télécharger un fichier ! </h4> 
                        </center>
                    </div>'; 
                
                header("refresh:2; url=demandeModifier.php?demande_id=$demande_id");   
                exit;
            }

            
            /* Maintenant on vérifie le nom du fichier. Le nom du fichier peut lui aussi poser problème. Nous devons donc nous occuper de lui 
            car s'il contient des accents, caractères spéciaux, espaces, ça peut poser problème. Nous allons donc "formater" le nom du fichier 
            avant de l'uploader. D'abord on récupére le nom de fichier :   */ 
            $nom_fichier = $_FILES['clientFile']['name'];   // $_FILES['clientFile']['name'] retourne nom du fichier d'origine
            
            // La fonction accent_to_noaccent($str) convertit les lettres accentutées aux lettres non accentuées  
            function accent_to_noaccent($str)
            {
                $url = $str;
                $url = preg_replace('#Ç#', 'C', $url);
                $url = preg_replace('#ç#', 'c', $url);
                $url = preg_replace('#è|é|ê|ë#', 'e', $url);
                $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
                $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
                $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
                $url = preg_replace('#ì|í|î|ï#', 'i', $url);
                $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
                $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
                $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
                $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
                $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
                $url = preg_replace('#ý|ÿ#', 'y', $url);
                $url = preg_replace('#Ý#', 'Y', $url);
                $url = preg_replace('#ñ#', 'n', $url);
                $url = preg_replace('#Ñ#', 'N', $url);
                
                return ($url);
            }

            // Avec la fonction accent_to_noaccent($str) on remplace les lettres accentutées par les non accentuées dans $nom_fichier:
            $nom_fichier = accent_to_noaccent($nom_fichier);

            
            /* Enfin, on va pouvoir déplacer et renommer le fichier. Par défaut, le fichier téléchargé par utilisateur est stocké 
            dans le répertoire tmp (temporary) de notre serveur Wamp dans C:/wamp/tmp. 
            Mais ce fichier devra se trouver dans un répertoire de notre projet, il faut donc le déplacer.
            Donc, via la méthode "move_uploded_file()" on va déplacer et renommer notre fichier depuis répertoire C:/wamp/tmp 
            vers le répertoire "fichiers" de notre projet. Le nouveau nom du fichier sera par exemple "demande_5 Isothermique".   */  
            move_uploaded_file($_FILES["clientFile"]["tmp_name"], "fichiers/demande_".$demande_id." ".$nom_fichier);   
    
            
            // Connexion à la base de données:     
            require ("connection_bdd.php");

            // Construction de la requête UPDATE avec la méthode prepare() sans injection SQL
            $requete = $db->prepare("UPDATE demande SET demande_titre=:demande_titre, demande_description=:demande_description, 
            demande_budget=:demande_budget, demande_file_name=:demande_file_name, demande_etat=:demande_etat, 
            demande_modification=:demande_modification, demande_publication=:demande_publication, demande_equipe=:demande_equipe 
            WHERE demande_id=:demande_id");

            // Association des valeurs aux marqueurs via méthode "bindValue()"
            $requete->bindValue(':demande_titre', $demande_titre, PDO::PARAM_STR);
            $requete->bindValue(':demande_description', $demande_description, PDO::PARAM_STR);
            $requete->bindValue(':demande_budget', doubleval($demande_budget), PDO::PARAM_INT); // fonction doubleval() convertit le type de variable en décimale
            $requete->bindValue(':demande_file_name', $nom_fichier, PDO::PARAM_STR);
            $requete->bindValue(':demande_etat', $demande_etat, PDO::PARAM_STR);
            $requete->bindValue(':demande_id', $demande_id, PDO::PARAM_INT);

            if(isset($demande_equipe))
            {
                $requete->bindValue(':demande_equipe', $demande_equipe, PDO::PARAM_STR);
            }
            else
            {
                $requete->bindValue(':demande_equipe', NULL, PDO::PARAM_STR);
            }

            // On utilise l'objet DateTime() pour enregistrer la date et l'heure de creation et publication de demande dans la base de données
            $time = new DateTime();   
            $date = $time->format("Y/m/d H:i:s"); 

            $requete->bindValue(':demande_modification', $date, PDO::PARAM_STR);

            if($demande_etat=="publié")
            {
                $requete->bindValue(':demande_publication', $date, PDO::PARAM_STR);
            }
            else if ($demande_etat=="sauvegardé")
            {
                $requete->bindValue(':demande_publication', NULL, PDO::PARAM_STR);   
            }

            // Exécution de la requête
            $requete->execute();

            //Libèration la connection au serveur de BDD
            $requete->closeCursor();
            
            echo'<div class="container-fluid alert alert-success mt-5" role="alert">
                    <center> 
                        <h4> Votre demande a été modifié avec succès! </h4> 
                    </center>
                </div>'; 

            header("refresh:2; url=client.php");   
            exit;


            /*  Si le client publie sa demande on envoie un email de notification à tous les fournisseurs. 
            Pour cela on construit la requête SELECT pour aller chercher la colonne demande_etat et demande_notification dans la table "demande":     */
            $req="SELECT demande_etat, demande_notification FROM demande WHERE demande_etat='publié' AND demande_notification='non envoyé'";

            /* Avec la méthode query() on exécute notre requête et on ramene les colonnes demande_etat et demande_notification 
            on les mets dans l'objet $result.     */
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
        }
        else
        {
            echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
            header("refresh:2; url=demandeNew.php");  // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page demandeNew.php
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
        header("refresh:2; url=demandeNew.php");  
        exit;
    }       
    

   


?>