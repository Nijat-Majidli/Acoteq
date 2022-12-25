<?php   
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction tout au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).   */
    session_start();

    if (!isset($_SESSION['email']) && !isset($_SESSION['role']))
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }


    if (file_exists("header.php"))
    {
        include("header.php");
    }
    else
    {
        echo "Le fichier n'existe pas";
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid my-5 py-5">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row justify-content-center align-items-center">
                        <center> <h3> Demandes publiées </h3> </center> 
                        <br><br><br>
<?php
                    // Connéxion à la base de données 
                    require "connection_bdd.php";
                    
                    // On construit la requête SELECT : 
                    $requete = $db->prepare ("SELECT * FROM demande WHERE demande_etat=:demande_etat");

                    // Association valeur de $_SESSION['email'] au marqueur :email via méthode "bindValue()"
                    $requete->bindValue(':demande_etat', "publié", PDO::PARAM_STR);

                    //On exécute la requête
                    $requete->execute();

                    // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête
                    $nbLigne = $requete->rowCount(); 
                    
                    if($nbLigne >= 1)
                    {
?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"> Titre </th>
                                        <th scope="col"> Société </th>
                                        <th scope="col"> Publiée </th>
                                        <th scope="col"> Détail </th>
                                    </tr>
                                </thead>
<?php
                            while ($row = $requete->fetch(PDO::FETCH_OBJ))  // Grace à méthode fetch() on choisit le 1er ligne de chaque colonne et la mets dans l'objet $row
                            {                                               // Avec la boucle "while" on choisit 2eme, 3eme, etc... lignes de chaque colonne et les mets dans l'objet $row
?> 
                                <tbody>
                                    <tr>
                                        <td>  <?php echo $row->demande_titre; ?>  </td>
                                        <td>  <?php echo $row->demande_societe; ?>  </td>

                                        <!-- Ici on a besoin d'afficher une date qui provient de la base de données et 
                                        qui est dans un format MySql: 2018-11-16.
                                        Pour formater cette date, on va utiliser l'objet de la classe DateTime et la méthode format:    -->
                                        <?php $datePublication = new DateTime($row->demande_publication);?>
                                        <td> <?php echo $datePublication->format("d/m/Y H:\hi");?> </td>
                    
                                        <!-- On envoie en URL (méthode GET) le paramètre demande_id vers la page demandeDetail.php :   -->
                                        <td> <a href="demandeDetail.php?demande_id=<?php echo $row->demande_id ?>"> Afficher </a> </td> 
                                    </tr>
                                </tbody>
<?php
                            }
?>
                            </table>
                        </div>
<?php
                    }
                    else
                    {
                        echo "<center> <h5 style='color:red'> Pour l'instant il y'a aucune demande publiées ! </h5> </center>";
                    }

                    // Libèration la connection au serveur de BDD
                    $requete->closeCursor();
?>    
                               
                        <div class="text-center my-5">
                            <a href="script_deconnexion.php"> <button class="btn btn-warning"> Déconnexion </button> </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT END -->
           

<?php
  if (file_exists("footer.php"))
  {
    include("footer.php");
  }
  else
  {
    echo "file 'footer.php' n'existe pas";
  }
?>