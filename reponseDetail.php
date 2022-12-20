<?php 
    session_start();  
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).  */  

    if (!isset($_SESSION['email']) && !isset($_SESSION['user_siren']) && !isset($_SESSION['role']))
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }

    
    /* Nous récupérons les informations passées dans le fichier "demandeDetail.php" dans la balise <a> et l'attribut "href"  
    Les informations sont récupéré avec variable superglobale $_GET   */
    if(isset($_GET['reponse_id']) && !empty($_GET['reponse_id']))
    {
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS
        $reponse_id = trim(htmlspecialchars((int)$_GET['reponse_id']));  // Pour vérifier que $_GET['reponse_id'] contient bien un nombre entier, on utilise (int) pour convertir la variable GET en type entier. 
    }
    else
    {
        if($_SESSION['role']=='client')
        {
            $page='client.php';
        }
        elseif($_SESSION['role']=='fournisseur')
        {
            $page='fournisseur.php';
        }

        echo "<h4> Veuillez indiquer le numéro de reponse ! </h4>";
        header("refresh:2; url=$page"); 
        exit;
    }  

    if($_SESSION['role']=='client')
    {
        if (file_exists("header_client.php"))
        {
            include("header_client.php");
        }
        else
        {
            echo "le fichier n'existe pas";
        }
    }
    elseif($_SESSION['role']=='fournisseur')
    {
        if (file_exists("header_fournisseur.php"))
        {
            include("header_fournisseur.php");
        }
        else
        {
            echo "le fichier n'existe pas";
        }
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid p-4 mt-3 col-7 bg-light text-dark">
            <form action="#"  method="#">   
<?php 
                // Connéxion à la base de données 
                require "connection_bdd.php";
                                    
                // On construit la requête SELECT : 
                $result = $db->prepare("SELECT * FROM reponse WHERE reponse_id=:reponse_id");

                /* Association la valeur au marqueur et execution de requête:
                L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement"     */
                $result->execute(array(':reponse_id' => $reponse_id));

                // Si la requête renvoit un seul et unique résultat, on ne fait pas de boucle, ici c'est le cas: 
                $row = $result->fetch(PDO::FETCH_OBJ);

                // Libèration la connection au serveur de BDD:
                $result->closeCursor();
?>
                <center> <h4> <?php echo $row->reponse_titre;?> </h4> </center>  
                <br>
                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Description </label>
                    <textarea class="form-control" rows="5" style="resize:none" readonly> <?php echo $row->reponse_description;?> </textarea>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Budget prévu </label>
                    <input type="number" class="form-control" value="<?php echo $row->reponse_budget;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Date publication </label>
                    <!-- Ici on a besoin d'afficher une date qui provient de la base de données et qui est dans un format MySql: 2018-11-16
                    Pour formater cette date, on va utiliser l'objet de la classe DateTime et la méthode format:      -->
                    <?php $datePublication = new DateTime($row->reponse_publication);?>
                    <input type="text" class="form-control" name="budget" value="<?php echo $datePublication->format("d/m/Y H:\hi");?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Société </label>
                    <input type="text" class="form-control" value="<?php echo $row->reponse_societe;?>" readonly>
                </div>

                <div class="form-group"  class="col-1 col-sm-8 col-md-9 col-lg-10 col-xl-11">
                    <label> Publiée par </label>
                    <input type="text" class="form-control" value="<?php echo $row->reponse_proprietaire;?>" readonly>
                </div>
            </form>
            <br>
<?php
            /* Les boutons Modifier, Supprimer et Déconnexion  
            Seul la proprietaire de la demande (fournisseur qui a crée la demande) peut la modifier, publier ou supprimer :  */
            if($_SESSION['role']=="fournisseur" && $row->user_email==$_SESSION['email'])
            {
?>
                <div style="text-align:center"  id="buttons">
                    <a href="reponseModifier.php?reponse_id=<?php echo $row->reponse_id;?>"> 
                        <button class="btn btn-primary mr-3" type="button" onclick="modifier()"> Modifier </button> 
                    </a> 
                    
                    <a href="script_reponseSupprimer.php?reponse_id=<?php echo $row->reponse_id ?>"> 
                        <input class="btn btn-danger mr-3" type="button" onclick="supprimer()" value="Supprimer"> 
                    </a> 

                    <a href="script_deconnexion.php"> <button class="btn btn-warning mr-3"> Déconnexion </button> </a>
                </div> 
<?php
            }
?>
<br><br>

            <h5> Commentaires : </h5>
            <hr>
<?php
            // On construit la requête SELECT : 
            if($_SESSION['role']=="client")
            {
                $result = $db->prepare("SELECT * FROM commentaire WHERE reponse_id=:reponse_id");
                
                // Association des valeurs aux marqueurs via la méthode "bindValue()" :
                $result->bindValue(':reponse_id', $reponse_id);
            }
            else if($_SESSION['role']=="fournisseur")
            {
                $result = $db->prepare("SELECT * FROM commentaire WHERE reponse_id=:reponse_id AND comment_visibilite=:comment_visibilite");
                
                // Association des valeurs aux marqueurs via la méthode "bindValue()" :
                $result->bindValue(':reponse_id', $reponse_id);
                $result->bindValue(':comment_visibilite', 'visible');
            }   

            // On exécute la requête :
            $result->execute();

            // Grace à la méthode "rowCount()" on peut connaitre le nombre de lignes retournées par la requête
            $nbLigne = $result->rowCount(); 
                    
            if ($nbLigne >= 1)
            {
                // On crée un tableau (array) dans lequel on va enregistrer liste des emails clients:
                $liste_emailClient = array();

                while ($ligne = $result->fetch(PDO::FETCH_OBJ))   // Grace à la méthode fetch() on choisit 1er ligne de chaque colonne et on les mets dans l'objet $ligne                                            
                {    
                    if(!in_array($ligne->user_email, $liste_emailClient))
                    {
                        array_push($liste_emailClient, $ligne->user_email);   // Avec la méthode array_push on enregistre les emails clients dans l'array $liste_emailClient
                    }

                    /* Ici on a besoin d'afficher une date qui provient de la base de données et qui est dans un format MySql: 2018-11-16
                    Pour formater cette date, on va utiliser l'objet de la classe DateTime() et la méthode format():        */
                    $date = new DateTime($ligne->comment_publication);
?>
                    <!-- Text de commentaire -->
                    <form action="script_commentModifier.php" method="POST">
                        <input type="hidden" name="comment_id" value="<?php echo $ligne->comment_id?>">
                        <input type="hidden" name="reponse_id" value="<?php echo $reponse_id?>">
                        <br>
                        Le <?php echo $date->format("d/m/Y H:\hi")?> 
                        <?php echo $ligne->comment_proprietaire?> de la société <?php echo $ligne->comment_societe?> a écrit:
                        <textarea id='<?php echo $ligne->comment_id?>' name='comment_description' class='form-control text-left' style='resize:none;' readonly> <?php echo $ligne->comment_description?> </textarea>
<?php                
                        if($_SESSION['role']=="client" && $ligne->user_email==$_SESSION['email'])
                        {
                            if($ligne->comment_visibilite=='visible')
                            {
?>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="visibilite" value="visible" checked>
                                    <label class="custom-control-label" for="customCheck1"> Visible par le fournisseur </label>
                                </div>
<?php                  
                            }
                            else
                            {
?>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="visibilite" value="visible">
                                    <label class="custom-control-label" for="customCheck1"> Visible par le fournisseur </label>
                                </div>
<?php
                            }   

                            // bouton Supprimer ou Modifier
                            if($_SESSION['fullName']==$ligne->comment_proprietaire && $_SESSION['id']==$ligne->user_id)
                            {
?>
                                <center class="buttons"> 
                                    <a onclick='supprimer()' href='script_commentSupprimer.php?comment_id=<?php echo $ligne->comment_id?> &amp; reponse_id=<?php echo $reponse_id?>'> Supprimer </a>  
                                    <a onClick='change(<?php echo $ligne->comment_id?>)' href='#<?php echo $ligne->comment_id?>' style="margin-left:10px"> Modifier </a> 
                                </center> <br>
                                <center id="confirmer<?php echo $ligne->comment_id?>" style="display:none"> 
                                    <input onClick='valider(<?php echo $ligne->comment_id?>)' type="submit" value="Valider" class="btn btn-success mr-2">
                                    <input onClick='annuler(<?php echo $ligne->comment_id?>)' type="button" value="Annuler" class="btn btn-danger">
                                </center> <br>
<?php
                            }
                        }
                        elseif($_SESSION['role']=='fournisseur')
                        {
                            if($_SESSION['fullName']==$ligne->comment_proprietaire && $_SESSION['id']==$ligne->user_id_1)
                            {
?>
                                <center class="buttons"> 
                                    <a onclick='supprimer()' href='script_commentSupprimer.php?comment_id=<?php echo $ligne->comment_id?> &amp; reponse_id=<?php echo $reponse_id?>'> Supprimer </a>  
                                    <a onClick='change(<?php echo $ligne->comment_id?>)' href='#<?php echo $ligne->comment_id?>' style="margin-left:10px"> Modifier </a> 
                                </center> <br>
                                <center id="confirmer<?php echo $ligne->comment_id?>" style="display:none"> 
                                    <input onClick='valider()' type="submit" value="Valider" class="btn btn-success mr-2"> 
                                    <input onClick='annuler(<?php echo $ligne->comment_id?>)' type="button" value="Annuler" class="btn btn-danger">
                                </center> <br>
<?php
                            }   
                        }
?>
                    </form> 
<?php
                }


                $mail="";

                // Avec la fonction implode() on mets les éléments du tableau $liste_emailClient dans le string $mail:
                $mail = implode(", ", $liste_emailClient);  // La fonction implode() transforme le tableau (array) à une chaîne de caractères (string).
            }
            else
            {
                echo "<h6 style='color:red'> Il n'y a aucuns commentaires pour cette réponse! </h6> <br>";  
            } 

            // Libèration la connection au serveur de BDD:
            $result->closeCursor();
?>
            <br>
            <b onclick='afficher()' style='color:darkblue; cursor:pointer' class='comment'> COMMENTER </b>
            <br>
  
            <form action="script_comment.php" method="POST">
                <input type="hidden" name="reponse_id"  value="<?php echo $row->reponse_id;?>">
                <input type="hidden" name="fournisseur_email"  value="<?php echo $row->user_email;?>">
<?php
                if(isset($mail) && !empty($mail))
                {
?>
                  <input type="hidden" name="client_email"  value=<?php echo $mail?>>
<?php
                }
?>      
                <div style="margin-bottom:5%;"  class="commentaire">  
                    <h5> Votre commentaire : </h5>
                    <textarea class="form-control text-left" name="comment" rows="10" cols="70" style="resize:none" required> </textarea>
<?php                
                    if($_SESSION['role']=="client")
                    {
?>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="visibilite" value="visible">
                            <label class="custom-control-label" for="customCheck1"> Visible par le fournisseur </label>
                        </div>
<?php
                    }
?>
                    <br>
                    <center>
                        <div>
                            <button class="btn btn-success mr-3" type="submit"> Valider </button>
                            <input class="btn btn-warning mr-3" type="reset" value="Effacer"> 
                            <input class="btn btn-danger" type="button" onclick="cacher()" value="Annuler"> 
                        </div>
                    </center>
                </div>
            </form>
        </div>



        <!-- Javascript Codes -->
        <script>  

            function modifier()
            { 
                //Rappel : confirm() -> Bouton OK et Annuler, renvoie true ou false
                var resultat = confirm("Etes-vous certain de vouloir modifier ?");

                // alert("retour :" + resultat);

                if (resultat==false)
                {
                    alert("Vous avez annulé les modifications \n Aucune modification ne sera apportée !");

                    //annule l'évènement par défaut ... SUBMIT vers "reponseModifier.php"
                    event.preventDefault();    
                }
            }


            function supprimer()
            {
                var resultat = window.confirm("Êtes-vous sûr de vouloir supprimer ?");

                if (resultat==false)
                {
                    alert("Vous avez annulé suppression !");

                    //annule l'évènement par défaut ... SUBMIT vers "script_reponseSupprimer.php"
                    event.preventDefault();    
                }
            }

            

            // JQuery code 
            $(document).ready(function()
            {
                $('.commentaire').hide()
            });

            function afficher()
            {
                $('.commentaire').show(),
                $('.comment').hide(),
                $('#buttons').hide()
            };
            
            function cacher()
            {
                $('.commentaire').hide(),
                $('.comment').show(),
                $('#buttons').show()
            };
            
            function change(par)
            {
                $('#'+par).attr("readonly", false),
                $('.buttons').hide(),
                $('#confirmer'+par).show()
            };

            function valider(par)
            {
                $('.buttons').show(),
                $('#confirmer'+par).hide()
            };


            function annuler(par)
            {
                $('#'+par).attr("readonly", true),
                $('.buttons').show(),
                $('#confirmer'+par).hide()
            }
        </script>




        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
       
    </body>
</html>
