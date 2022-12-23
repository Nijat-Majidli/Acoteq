<?php
    if (file_exists("header.php"))
    {
    include("header.php");
    }
    else
    {
    echo "file 'header.php' n'existe pas";
    }
?>

        <!-- PAGE CONTENT -->
        <div class="container-fluid col-12 col-sm-12 col-md-11 col-lg-7 col-xl-7 mt-5 mb-5">
            <!-- LOGO -->
            <div>   
                <center>
                    <section>
                        <img src="../Acoteq/image/logo1.png" alt="logo" title="logo" style="width:30vh;">
                    </section>
                </center>  
            </div>

            <div class="slogan">
                <h4> Veuillez saisir vos coordonnées : </h4>
            </div>

            <form action="script_inscription.php" method="POST" autocomplete="off" class="form_connect">
                <div class="form-group">
                    <sup>*</sup> <label for="name"> Nom </label> 
                    <input id="name" type="text" class="form-control" name="userNom" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="surname"> Prénom </label> 
                    <input id="surname" type="text" class="form-control" name="userPrenom" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="RaisonSociale"> Raison Sociale </label> 
                    <input id="RaisonSociale" type="text" class="form-control" name="societe" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="siren"> N° SIREN </label>
                    <input id="siren" type="text" class="form-control" name="numSiren" required onkeyup="verify(this)">
                </div>
                
                <p>  Vous êtes : </p>
                <div class="form-check form-check-inline ml-3">  
                    <input class="form-check-input" id="customer" type="radio" name="userRole" value="client" checked>
                    <label class="form-check-label" for="customer"> Client </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="supplier" type="radio" name="userRole" value="fournisseur">
                    <label class="form-check-label" for="supplier"> Fournisseur </label>
                </div>

                <br><br>

                <div class="form-group">
                    <sup>*</sup> <label for="ZipCode"> Code Postal </label>
                    <input id="ZipCode" type="number" class="form-control" name="codePostal" maxlength="5" required onkeyup="verify(this)">   <!-- maxlength="5" Code postal doit contenir au maximum 5 chiffres -->
                </div>
                
                <div class="form-group">
                    <sup>*</sup> <label for="city"> Ville </label>
                    <input id="city" type="text" class="form-control" name="ville" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="address"> Adresse </label>
                    <input id="address" type="text" class="form-control" name="adresse" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="state"> Pays </label>
                    <input id="state" type="text" class="form-control" name="pays" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="email"> Email </label>
                    <input id="email" type="email" class="form-control" name="mail" required onkeyup="verify(this)">
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="code"> Mot de passe </label>
                    <input id="code" type="password" class="form-control" name="mdp" required>
                </div>

                <div class="form-group">
                    <sup>*</sup> <label for="confirmer"> Confirmer le mot de passe </label>
                    <input id="confirmer" type="password" class="form-control" name="mdp2" required>
                </div>
                <br>
                <!-- Boutons <Valider> et <Annuler> -->
                <div>
                    <center>
                        <button type="submit" class="btn btn-success mr-2"> Valider </button>
                        <a href="connexion.php"> <input type="button" class="btn btn-danger" value="Annuler"> </a>
                    </center>
                </div>
            </form>
            <br>
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


        <!-- Codes Javascript/jQuery  -->
        <script>
            // La fonction verify() sert à vérifier les données saisies par utilisateurs dans le formulaire d'inscription
            function verify(par)
            {
                // On récupére la valeur de l'input:
                let data = $(par).val(); 

                // On récupére le contenu de la balise label:
                let elementLabel = $(par).prev().text().trim();

                // On crée un message d'erreur:
                let errorMessage = '<small style="color:red";>'+elementLabel+' n\'est pas valide !</small>';

                switch (elementLabel)
                {
                    case "Nom":
                        filtre = new RegExp("^[A-Za-z ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$");  // aprés A-Za-z on a ajouté un espace pour autoriser la saisi de l'espace blanc entre les mots
                        break;
                    case "Prénom":
                        filtre = new RegExp("^[A-Za-z ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$");  
                        break;
                    case "Raison Sociale":
                        filtre = new RegExp("^[A-Za-z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_&!§£@*',.$;-]+$");  
                        break;
                    case "N° SIREN":
                        filtre = new RegExp("^[0-9]{9}$");  
                        break;
                    case "Code Postal":
                        filtre = new RegExp("^[0-9]{5}$");  
                        break;
                    case "Ville":
                        filtre = new RegExp("^[A-Za-z ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$");  
                        break;
                    case "Adresse":
                        filtre = new RegExp("^[A-Za-z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_&!§£@*',.$;-]+$");  
                        break;
                    case "Pays":
                        filtre = new RegExp("^[A-Za-z ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$");  
                        break;
                    case "Email":
                        filtre = new RegExp("^[a-z0-9._ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$");  
                        break;  
                    default:
                        filtre = new RegExp("^[A-Za-z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_&!§£@*',.$;-]+$");  
                        break;   
                };
                
                // Vérification la validité de format de tout les données saisi par utilisateur en utilisant la fonction test() de l'objet RegExp (filtre) qui renvoie True or False:      
                let resultat = filtre.test(data);

                if (resultat==true || data.length==0)  // Si le champ input contient les valeurs lettres ou il est vide
                {
                    $(par).next().remove(); 
                }
                else if (resultat==false)  // Si le champ input contient les valueurs autres que lettres
                {
                    $(par).next().remove(); 
                    $(par).after(errorMessage); 
                }  
            };
           
            // Autocompletion des adresses avec la Base Adresse Nationale dans le formulaire d'inscription 
            $("#ZipCode").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='codePostal']").val(),
                        data: { q: request.term },
                        dataType: "json",
                        success: function (data) {
                            var postcodes = [];
                            response($.map(data.features, function (item) {
                                // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                                if ($.inArray(item.properties.postcode, postcodes) == -1) {
                                    postcodes.push(item.properties.postcode);
                                    return { label: item.properties.postcode + " - " + item.properties.city, 
                                            city: item.properties.city,
                                            value: item.properties.postcode
                                    };
                                }
                            }));
                        }
                    });
                },
                // On remplit aussi la ville
                select: function(event, ui) {
                    $('#city').val(ui.item.city);
                }
            });

            $("#city").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='ville']").val(),
                        data: { q: request.term },
                        dataType: "json",
                        success: function (data) {
                            var cities = [];
                            response($.map(data.features, function (item) {
                                // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                                if ($.inArray(item.properties.postcode, cities) == -1) {
                                    cities.push(item.properties.postcode);
                                    return { label: item.properties.postcode + " - " + item.properties.city, 
                                            postcode: item.properties.postcode,
                                            value: item.properties.city
                                    };
                                }
                            }));
                        }
                    });
                },
                // On remplit aussi le CP
                select: function(event, ui) {
                    $('#ZipCode').val(ui.item.postcode);
                }
            });

            $("#address").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='codePostal']").val(),
                        data: { q: request.term },
                        dataType: "json",
                        success: function (data) {
                            response($.map(data.features, function (item) {
                                return { label: item.properties.name, value: item.properties.name};
                            }));
                        }
                    });
                }
            });
        </script>
        

        <!-- JQuery pour autocompletion de Code Postaux/villes dans le formulaire de page inscription-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                
    </body>
</html>


