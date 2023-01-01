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
<div class="container-fluid col-sm-10 col-lg-8 mt-5 mb-5">
    <!-- LOGO -->
    <div>   
        <center>
            <section>
                <img src="image/logo1.png" alt="logo" title="logo" style="width:30vh;">
            </section>
        </center>  
    </div>

    <h4 class="text-primary my-5"> Veuillez saisir vos coordonnées : </h4>
    
    <form action="script_inscription.php" method="POST" autocomplete="off" class="form_connect">
        <div class="form-group">
            <sup>*</sup> <label for="name"> Nom </label> 
            <input id="name" type="text" class="form-control" name="userNom" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="surname"> Prénom </label> 
            <input id="surname" type="text" class="form-control" name="userPrenom" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="RaisonSociale"> Raison Sociale </label> 
            <input id="RaisonSociale" type="text" class="form-control" name="societe" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="siren"> N° SIREN </label>
            <input id="siren" type="text" class="form-control" name="numSiren" maxlength="9" placeholder="SIREN doit contenir au maximum 9 chiffres" onblur="verify(this)" required>
        </div>
        
        <p> Vous êtes : </p>
        <div class="form-check form-check-inline ml-3">  
            <input class="form-check-input" id="customer" type="radio" name="userRole" value="client" checked>
            <label class="form-check-label" for="customer"> Client </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="supplier" type="radio" name="userRole" value="fournisseur">
            <label class="form-check-label" for="supplier"> Fournisseur </label>
        </div>

        <div class="form-group mt-3">
            <sup>*</sup> <label for="ZipCode"> Code Postal </label>
            <input id="ZipCode" type="text" class="form-control" name="codePostal" maxlength="5" placeholder="Code postal doit contenir au maximum 5 chiffres" onblur="verify(this)" required>   
        </div>
        
        <div class="form-group">
            <sup>*</sup> <label for="city"> Ville </label>
            <input id="city" type="text" class="form-control" name="ville" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="address"> Adresse </label>
            <input id="address" type="text" class="form-control" name="adresse" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="state"> Pays </label>
            <input id="state" type="text" class="form-control" name="pays" onkeyup="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="email"> Email </label>
            <input id="email" type="email" class="form-control" name="mail" onblur="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="code"> Mot de passe </label>
            <input id="code" type="password" class="form-control" name="mdp" placeholder="Mot de passe doit contenir au moins 8 characters" onblur="verify(this)" required>
        </div>

        <div class="form-group">
            <sup>*</sup> <label for="confirmer"> Confirmer le mot de passe </label>
            <input id="confirmer" type="password" class="form-control" name="mdp2" onblur="verify(this)" required>
        </div>
        <br>
        <!-- Boutons <Valider> et <Annuler> -->
        <div>
            <center>
                <button type="submit" class="btn btn-success mr-3"> Valider </button>
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




                
   


