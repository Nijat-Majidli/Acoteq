<?php 
    session_start();  
    /* ATTENTION
    Le fonction session_start() démarre le système de sessions. Il est impératif d'utiliser cette fonction au début de chaque 
    fichier PHP dans lequel on utilisera la variable superglobale $_SESSION et avant tout envoi de requêtes HTTP, c'est-à-dire 
    avant tout code HTML (donc avant la balise <!DOCTYPE> ).  */  

    // On vérifie si l'utilisatuer est connecté ou non. Si il n'est pas connecté on lui refuse l'affichage de la page :
    if (!isset($_SESSION['email']) && !isset($_SESSION['user_siren']) && !isset($_SESSION['role'])=="client")
    {
        echo "<h4> Cette page nécessite une identification </h4>";
        header("refresh:2; url=connexion.php");  // refresh:2 signifie que après 2 secondes l'utilisateur sera redirigé sur la page connexion.php
        exit;
    }


    // Nous récupérons le paramétre equipe_id transmit en GET par la page "equipeCreated.php" et on le met dans la variable $equipe_id :
    if(isset($_GET['equipe_id']) && !empty($_GET['equipe_id']))
    {
        // La fonction "trim()" efface les espaces blancs au début et à la fin d'une chaîne.
        // La fonction "htmlspecialchars" rend inoffensives les balises HTML que le visiteur peux rentrer et nous aide d'éviter la faille XSS  
        $equipe_id = trim(htmlspecialchars((int)$_GET['equipe_id']));   // Pour vérifier que $_GET['demande_id'] contient bien un nombre entier, on utilise (int) pour convertir la variable GET en type entier. 
    }
    else
    {
        echo'<div class="container-fluid alert alert-danger mt-5" role="alert">
                    <center> 
                        <h4> Veuillez remplir tous les champs ! </h4> 
                    </center>
                </div>'; 
        header("refresh:2; url=equipeCreated.php");  
        exit;
    }   


    if (file_exists("header_client.php"))
    {
        include("header_client.php");
    }
    else
    {
        echo "le fichier n'existe pas";
    }
    
    
    // PAGE CONTENT 
    // Connéxion à la base de données 
    require "connection_bdd.php";
        
    // On construit la requête SELECT : 
    $requete = $db->prepare ("SELECT * FROM equipe WHERE equipe_id=:equipe_id");

    // Association valeur de $_SESSION['email'] au marqueur :email via méthode "bindValue()"
    $requete->bindValue(':equipe_id', $equipe_id, PDO::PARAM_INT);

    // On exécute la requête
    $requete->execute();

    // Grace à la méthode "rowCount()" on peut compter le nombre de lignes retournées par la requête:
    $nbLigne = $requete->rowCount(); 

    if($nbLigne >= 1)
    {
        while ($row = $requete->fetch(PDO::FETCH_OBJ))  
        {                                           
?>   
            <div class="container-fluid mt-5 col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
                <h3> Veuillez modifier votre équipe </h3>
                <br>
                <form action="script_equipeModifier.php" method="POST" autocomplete="off">
                    <input type="hidden" name="equipe_id" value="<?php echo $equipe_id?>">
                    <input type="hidden" name="equipe_proprietaire" value="<?php echo $row->equipe_proprietaire?>">
                    
                    <div class="form-group">
                        <label for="team"> Nom d'équipe : </label> 
                        <input id="team" type="text" class="form-control" name="equipe_nom" value="<?php echo $row->equipe_nom?>" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="teamOwner"> Propriétaire d'équipe : </label>
                        <input id="teamOwner" type="text" class="form-control" name="equipe_proprietaire" value="<?php echo $_SESSION["fullName"].', '.$_SESSION["email"] ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="member"> Membres d'équipe actuelle : </label> <br>
                        <input id="member" class="form-control" type="text" name="equipe_membres" value="<?php echo ucwords($row->equipe_membres)?>" readonly> 
                    </div>

                    <div class="form-group">
                        <label for="choisirMembres"> Modifier les membres : </label> 
                        <input id="choisirMembres" type="search" class="form-control">

                        <select id="liste" class="custom-select" style="display:none;" size="5">
<?php 
                            // On construit la requête SELECT via la méthode prepare() pour éviter injection SQL : 
                            $requete = $db->prepare ("SELECT * FROM users WHERE user_siren = :user_siren");

                            /* Association valeur au marqueur et execution de la requete.
                            L'écriture raccourcie: ici la méthode bindValue sera appellée "automatiquement". */
                            $requete->execute(array(':user_siren' => $_SESSION['user_siren']));   

                            // Grace à la méthode "rowCount()" nous pouvons connaitre le nombre de lignes retournées par la requête
                            $nbLigne = $requete->rowCount(); 

                            if ($nbLigne >= 1)
                            {
                                while ($row = $requete->fetch(PDO::FETCH_OBJ))   
                                {                       
?>
                                    <option> 
                                        <?php echo $row->user_prenom;?> <?php echo $row->user_nom;?>, <?php echo $row->user_email;?> 
                                    </option>
<?php
                                }
                            } 
?>
                        </select>
                    </div>

                    <label for="membresEquipe"> Nouvelle équipe : </label> <br>
                    <div class="inputholder">
                        <input id="membresEquipe" class="member" name="equipe_membres" style="color:transparent" required>
                    </div>

                    <!-- Les boutons <Valider> et <Annuler> -->
                    <div style="text-align: center; margin-top:40px;">
                        <button type="submit" class="btn btn-success mr-2" id="bouton_valider"> Valider </button>
                        <a href="equipeCreated.php"> <input type="button" class="btn btn-danger" value="Annuler"> </a>
                    </div>
                </form>
            </div>   
<?php
        }
    } 
    else
    {
        echo '<div class="container-fluid alert alert-danger mt-5" role="alert">
                <center> 
                    <h4> Il y a aucune équipe avec ce numéro ! </h4> 
                </center>
            </div>'; 
    
        header("refresh:2; url=equipeCreated.php");   // refresh:2 signifie qu'après 2 secondes l'utilisateur sera redirigé vers la page equipeCreated.php
        exit;
    }

    // Libèration la connection au serveur de BDD
    $requete->closeCursor();

    // PAGE CONTENT END
?>        

  
        <!-- JQuery Codes pour aller chercher et ajouter les membres d'équipe depuis base de données -->
        <script>
            $(document).ready(function() 
            {
                $('#choisirMembres').keyup(function() 
                {
                    var inputValue = $(this).val().toLowerCase(); // "this" fait référence à la balise input avec ID "#choisirMembres"

                    $('select').css('display', 'block');

                    $('option').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(inputValue) > -1); // "this" fait référence à la balise <option>
                    })
                });


                $('select').on(
                {
                    mouseleave: function() {
                        $(this).css('display', 'none')
                    },

                    click: function() {
                        $(this).css('display', 'none')
                    }
                });


                // On crée un tableau (array) vide allMembers :
                var allMembers = [];

                // On récupére le contenu (valeur) de l'input ayant id='teamOwner'
                var teamOwner = $('#teamOwner').val();

                // Puis avec la méthode push() on ajoute la variable "teamOwner" dans l'array allMembers:
                allMembers.push(teamOwner); 

                $('#membresEquipe').before('<span class="tag">' + teamOwner + '<span class="effacer"> X </span> </span>');
                
                $('select').change(function() 
                {
                    // Dans la variable "newMembers" avec la méthode text() on récupére le contenu de la balise <option> cliquée (selected):
                    var newMembers = $("option:selected").text();   // newMembers contient la liste des nouvels membres 

                    $("option:selected").click(function() 
                    {
                        $('#membresEquipe').before('<span class="tag">' + newMembers + '<span class="effacer"> X </span> </span>');

                        // Avec la méthode push() on ajoute la variable "newMembers" dans l'array allMembers:
                        allMembers.push($.trim(newMembers));    // La méthode trim() est utilisée pour supprimer l'espace blanc du début et de la fin d'une chaîne

                        /* Avec la méthode join() on convertit les éléments du tableau (array) sous forme d'une chaîne. 
                        Le paramètre ", " insére l'éspace aprés les virgules entre les éléments.    */
                        var allMembersString = allMembers.join(", ");

                        $('#membresEquipe').val(allMembersString);

                        // On se focuse sur l'input ayant id='choisirMembres'
                        $('#choisirMembres').focus();
                    });
                });


                $(document).on('click', '.tag', function() 
                {
                    $(this).remove();

                    var deleteMember = $(this).text();

                    deleteMember = $.trim(deleteMember.replace("X", ""));

                    allMembers = $.grep(allMembers, function(value) 
                    {
                        return value != deleteMember;
                    });

                    /* Avec la méthode join() on convertit les éléments du tableau (array) sous forme d'une chaîne. 
                    Le paramètre ", " insére l'éspace aprés les virgules entre les éléments.    */
                    var allMembersString = allMembers.join(", ");

                    $('#membresEquipe').val(allMembersString);
                });

            })
        </script>


        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

        
        <!-- fichier Javascript RegExp -->
        <script src="javascript/RegExp2.js"> </script>
    </body>
</html>