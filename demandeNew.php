<?php 
    session_start();  
    /* ATTENTION
    Il est impératif d'utiliser la fonction session_start() au début de chaque fichier PHP dans lequel on manipulera cette 
    variable et avant tout envoi de requêtes HTTP, c'est-à-dire avant tout echo ou quoi que ce soit d'autre : rien ne doit 
    avoir encore été écrit/envoyé à la page web.  */

    // La demande (appel d'offre) peut être créer que par le client, c'est pour ça la role d'utilisateur doit être égale à "client":
    if (!isset($_SESSION['email']) && !isset($_SESSION['user_siren']) && !isset($_SESSION['role']))
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
        echo "le fichier n'existe pas";
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid col-11 col-sm-9 col-lg-8 bg-light text-dark p-4 mb-5">
            <h3> Veuillez créer votre demande </h3>
            <br>
            <!--  Pour que le téléchargement soit possible, il faut ajouter l'attribut "enctype" à la balise <form>. 
            La valeur de l'attribut "enctype" doit être "multipart/form"-data  -->
            <form action="script_demandeNew.php"  method="POST" enctype="multipart/form-data" autocomplete="off">   
                <div class="form-group">
                    <label for="title"> Titre <sup>*</sup> </label> 
                    <input id="title" type="text" class="form-control" name="titre" required>
                </div>

                <div class="form-group">
                    <label for="desc"> Description <sup>*</sup> </label>
                    <textarea id="desc" class="form-control text-left" name="description" rows="10" style="resize:none" required></textarea>
                </div>

                <div class="form-group">
                    <label for="budgetDemande"> Budget prévu <sup>*</sup> </label>
                    <input id="budgetDemande" type="number" class="form-control" name="budget" placeholder="en euro" required>
                </div>

                <div class="form-group mb-4">
                    <label for="telecharger"> Télécharger votre demande <sup>*</sup> </label>
                    <input id="telecharger" type="file" class="form-control-file" name="clientFile" required>  
                </div>

                <!-- Ajouter une équipe dans une demande est facultative, n'est pas obligatoire. -->
                <div class="form-group">
                    <label for="myInput"> Ajouter une équipe : </label> 
                    <input id="myInput" type="search" class="form-control">

                    <select id="liste" class="custom-select" style="display:none;" size="5">
                        <!-- Code Php -->
<?php 
                        // Connéxion à la base de données
                        require ("connection_bdd.php");

                        // On construit la requête SELECT via la méthode prepare() pour éviter injection SQL : 
                        $requete = $db->prepare("SELECT * FROM equipe WHERE user_email = :user_email");

                        $requete->bindValue(':user_email', $_SESSION['email'], PDO::PARAM_STR);

                        // On exécute la requête
                        $requete->execute();

                        // Grace à la méthode "rowCount()" nous pouvons connaitre le nombre de lignes retournées par la requête
                        $nbLigne = $requete->rowCount(); 

                        if ($nbLigne >= 1)
                        {
                            while ($row = $requete->fetch(PDO::FETCH_OBJ))   
                            {                       
?>
                                <option> 
                                    <?php echo $row->equipe_nom;?> 
                                </option>
<?php
                            }
                        } 
?>      
                    </select>
                </div>

                <div class="form-group">
                    <label for="team"> Votre équipe : </label> <br>
                    <input id="team" type="text" name="equipe" style="width:100%; border:none; border-bottom:solid 1px #D5DBDB; outline:none"> 
                </div>

                <p>  Vous voulez : </p>
                <div class="form-check form-check-inline ml-3">  
                    <input class="form-check-input" type="radio" name="etat" id="save" value="sauvegardé" checked>
                    <label class="form-check-label" for="save"> Sauvegarder demande </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="etat" id="publish" value="publié">
                    <label class="form-check-label" for="publish"> Publier demande </label>
                </div>

                <div style="text-align:center; margin-top:40px;">
                    <input type="submit" class="btn btn-success mr-3" value="Valider"> </input>  
                    <a href="client.php"> <input type="button" class="btn btn-danger" value="Annuler"> </a>
                </div>
            </form>
        </div>
        <!-- PAGE CONTENT END -->
  
        <!-- JQuery Codes pour aller chercher et ajouter les membres d'équipe depuis base de données -->
        <script>
            $(document).ready(function() 
            {
                $('#myInput').keyup(function() 
                {
                    var inputValue = $(this).val().toLowerCase();
                    
                    $('select').css('display','block');

                    $('option').filter(function() 
                    {
                        $(this).toggle($(this).text().toLowerCase().indexOf(inputValue) > -1);
                    })
                });
                
                // On crée un tableau (array) vide: allTeams
                var allTeams=[];  

                $('select').change(function()
                {    
                    // Dans la variable "team" on récupére le contenu de la balise <option> cliquée (selected):
                    var team = $("option:selected").text();  
                   
                    // Puis avec la méthode push() on insére la variable "team" dans l'array allTeams:
                    allTeams.push($.trim(team));   // La méthode $.trim() est utilisée pour supprimer l'espace blanc du début et de la fin d'une chaîne

                    $("option:selected").click(function() 
                    {
                        $('#team').val((allTeams.join(", ")));  // La méthode join() convertit les éléments d'un tableau (array) sous forme d'une chaîne.
                                                                    // Le paramètre ", " insére l'éspace aprés les virgules entre les éléments. 
                    })
                });


                $('select').on(
                {
                    mouseleave: function() {
                    $(this).css('display','none')},
                
                    click: function() {
                    $(this).css('display','none')}
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