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
                    <label for="name"> Nom <sup>*</sup> </label> 
                    <input id="name" type="text" class="form-control" name="userNom" required>
                </div>

                <div class="form-group">
                    <label for="surname"> Prénom <sup>*</sup> </label> 
                    <input id="surname" type="text" class="form-control" name="userPrenom" required>
                </div>

                <div class="form-group">
                    <label for="RaisonSociale"> Raison sociale <sup>*</sup> </label> 
                    <input id="RaisonSociale" type="text" class="form-control" name="societe" required>
                </div>

                <div class="form-group">
                    <label for="siren"> N° SIREN <sup>*</sup> </label>
                    <input id="siren" type="text" class="form-control" name="numSiren" required>
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
                    <label for="ZipCode"> Code postal <sup>*</sup> </label>
                    <input id="ZipCode" type="number" class="form-control" name="codePostal" maxlength="5" required>   <!-- maxlength="5" Code postal doit contenir au maximum 5 chiffres -->
                </div>
                
                <div class="form-group">
                    <label for="city"> Ville <sup>*</sup> </label>
                    <input id="city" type="text" class="form-control" name="ville" required>
                </div>

                <div class="form-group">
                    <label for="address"> Adresse <sup>*</sup> </label>
                    <input id="address" type="text" class="form-control" name="adresse" required>
                </div>

                <div class="form-group">
                    <label for="state"> Pays <sup>*</sup> </label>
                    <input id="state" type="text" class="form-control" name="pays" required>
                </div>

                <div class="form-group">
                    <label for="email"> Email <sup>*</sup> </label>
                    <input id="email" type="email" class="form-control" name="mail" required>
                </div>

                <div class="form-group">
                    <label for="code"> Mot de passe <sup>*</sup> </label>
                    <input id="code" type="password" class="form-control" name="mdp" required>
                </div>

                <div class="form-group">
                    <label for="confirmer"> Confirmer le mot de passe <sup>*</sup> </label>
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

        <!-- Codes Javascript pour autocompletion des adresses avec la Base Adresse Nationale dans le formulaire d'inscription -->
        <script>
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



        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
 

        <!-- fichier Javascript RegExp -->
        <script src="javascript/RegExp2.js"> </script>


        <!-- JQuery pour autocompletion de Code Postaux/villes dans le formulaire de page inscription-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                
    </body>
</html>


