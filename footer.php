            <!-- PAGE FOOT -->
            <footer>
                <div class="container-fluid">      
                    <div class="row justify-content-center">   
                        <div class="col-xl-10 text-center text-light bg-success rounded py-4 mt-4">  
                            <h4> Suivez-nous sur </h4> 
                            <a href="#"> <img src="image/facebook.png" alt="facebook" title="facebook" style="width:6vh;"> </a>
                            <a href="#"> <img src="image/instagram.png" alt="instagram" title="instagram" style="width:6vh;"> </a>
                            <a href="#"> <img src="image/youtube.png" alt="youtube" title="youtube" style="width:6vh;"> </a>
                            <p class="mt-3"> <a href="#" class="text-light mr-2">Politique de confidentialité</a> | <a href="#" class="text-light ml-2">Contact</a> </p>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- PAGE FOOT END -->
        </main>


        <!-- Codes Javascript/jQuery -->
        <script>
            // Page "inscription.php" et "connexion.php"
            // La fonction verify() sert à vérifier les données saisies par utilisateurs dans le formulaire d'inscription et connexion
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
                        filtre = new RegExp("^[a-z0-9._ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+@[a-z]{2,}\.[a-z]{2,4}$");  
                        break;  
                    default:
                        filtre = new RegExp("^[A-Za-z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_&!§£@*',.$;-]{8,}$");  // Pour vérifier le mot de passe
                        break;   
                };
                
                // Vérification la validité de format de tout les données saisi par utilisateur en utilisant la fonction test() de l'objet RegExp (filtre) qui renvoie True or False:      
                let resultat = filtre.test(data);

                if (resultat==true || data.length==0)  
                {
                    $(par).next().remove(); 
                }
                else if (resultat==false)  
                {
                    $(par).next().remove(); 
                    $(par).after(errorMessage); 
                }  

                // On vérifie si la valeur du champ "Mot de passe" est identique à la valeur du champ "Confirmer le mot de passe":
                let password = document.querySelector("#code").value;
                let confirmPassword = document.getElementById("confirmer").value;

                if(password.length>0 && confirmPassword.length>0 && password!=confirmPassword)
                {
                    let message = '<small style="color:red";> Les deux mots de passe ne sont pas identiques !</small>';
                    $(par).next().remove(); 
                    $(par).after(message); 
                }
            };
            

            // Autocompletion du champ (input) "Code Postal" avec la Base Adresse Nationale dans le formulaire d'inscription 
            $("#ZipCode").autocomplete(
            {
                source: function (request, response) 
                {
                    $.ajax(
                    {
                        url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='codePostal']").val(),
                        data: { q: request.term },
                        dataType: "json",

                        success: function (data) 
                        {
                            var postcodes = [];

                            response($.map(data.features, function (item) 
                            {
                                // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                                if ($.inArray(item.properties.postcode, postcodes) == -1) 
                                {
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

                // On remplit aussi le champ "Ville"
                select: function(event, ui) 
                {
                    $('#city').val(ui.item.city);
                }
            });


            // Autocompletion du champ (input) "Ville" avec la Base Adresse Nationale dans le formulaire d'inscription 
            $("#city").autocomplete(
            {
                source: function (request, response) 
                {
                    $.ajax(
                    {
                        url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='ville']").val(),
                        data: { q: request.term },
                        dataType: "json",

                        success: function (data) 
                        {
                            var cities = [];

                            response($.map(data.features, function (item) 
                            {
                                // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                                if ($.inArray(item.properties.postcode, cities) == -1) 
                                {
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

                // On remplit aussi le champ "Code Postal"
                select: function(event, ui) 
                {
                    $('#ZipCode').val(ui.item.postcode);
                }
            });


            // Autocompletion du champ "Adresse" avec la Base Adresse Nationale dans le formulaire d'inscription 
            $("#address").autocomplete(
            {
                source: function (request, response) 
                {
                    $.ajax(
                    {
                        url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='codePostal']").val(),
                        data: { q: request.term },
                        dataType: "json",

                        success: function (data) 
                        {
                            response($.map(data.features, function (item) {
                                return { label: item.properties.name, 
                                    value: item.properties.name};
                            }));
                        }
                    });
                },

                // On remplit aussi le champ "Pays"
                select: function(event, ui) 
                {
                    $('#state').val("France");
                }
            });


        </script>


        <!-- Bootstrap Jquery, Popper -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
        <!-- fichier Javascript RegExp -->
        <script src="javascript/RegExp1.js"> </script>
        <script src="javascript/RegExp2.js"> </script>
    
        <!-- fichier Javascript pour icon Eye (à côté du champ mot de passe) dans la page "connexion.php" -->
        <script src="javascript/ShowPassword.js"> </script>

        <!-- JQuery pour autocompletion de Code Postaux/villes dans le formulaire de page inscription-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </body>
</html>