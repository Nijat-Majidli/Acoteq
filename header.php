<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Returns The Current PHP File Name  -->
        <title> 
            <?php echo basename($_SERVER['PHP_SELF'], '.php'); ?>   
        </title>

        <!-- Bootstrap 4.5.3 CDN link -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Fichier CSS -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Pour autocompletion de Code Postaux/villes et pour utiliser JQuery dans 
        notre projet il faut d'abord ajouter JQuery Google CDN:  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Ensuite on ajoute les 2 liens jQuery suivants pour autocompletion de 
        Code Postaux/villes dans le formulaire de page "inscription.php" :  -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.7.3/themes/base/jquery-ui.css">
    </head>
 
    <body style="background-color: #e3f2fd;">
        <!-- Si utilisateur a désactivé Javascript sur son navigateur on utilise la balise <noscript>
        pour lui afficher le message d'erreur et pour cacher le contenu de notre page  -->
        <noscript>
            <h3>Veuillez activer Javascript sur votre navigateur pour afficher cette page correctement</h3> 
            <style>
                main {display:none;}
            </style>
        </noscript>

        <main>   
            <?php   
                if (isset($_SESSION['role']) && $_SESSION['role']=="client")
                {
            ?>
                    <!-- PAGE HEAD -->
                    <header>
                        <div class="container-fluid">   
                            <div class="row justify-content-center">   
                                <div class="col-xl-10 bg-success rounded py-3 mb-3">
                                    <!-- Navigation Bar -->
                                    <nav class="navbar navbar-expand-xl navbar-dark">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                    
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="client.php"> <i class="fa fa-home" aria-hidden="true"></i> Accueil <span class="sr-only">(current)</span> </a>
                                                </li>

                                                <li class="nav-item dropdown active">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-users" aria-hidden="true"></i> Équipe
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="equipeNew.php"> Nouvelle équipe </a>
                                                        <a class="dropdown-item" href="equipeCreated.php"> Mes équipes crées </a>
                                                        <a class="dropdown-item" href="equipeAutres.php"> Autres équipes </a>
                                                    </div>
                                                </li>
                                                
                                                <li class="nav-item dropdown active">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-file-text" aria-hidden="true"></i> Demande
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="demandeNew.php"> Nouvelle demande </a>
                                                        <a class="dropdown-item" href="demandeSaved.php"> Demandes sauvegardées </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item dropdown active">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?php echo $_SESSION['fullName'];?> 
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="infoPerso.php"> Infos personelles </a>
                                                        <a class="dropdown-item" href="script_deconnexion.php"> Déconnexion </a>
                                                    </div>
                                                </li>
                                            </ul>
                                            <form class="form-inline">
                                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                                <button class="btn btn-outline-light" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- PAGE HEAD END -->  
            <?php
                } 
                else if (isset($_SESSION['role']) && $_SESSION['role']=="fournisseur")
                {
            ?>
                    <!-- PAGE HEAD -->
                    <header>
                        <div class="container-fluid">   
                            <div class="row justify-content-center">   
                                <div class="col-xl-10 bg-success rounded py-3 mb-3">
                                    <!-- Navigation Bar -->
                                    <nav class="navbar navbar-expand-xl navbar-dark">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                        </button>
                                    
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item active">
                                                    <a class="nav-link" href="fournisseur.php"> <i class="fa fa-home" aria-hidden="true"></i> Accueil <span class="sr-only">(current)</span> </a>
                                                </li>
                                                
                                                <li class="nav-item active dropdown ml-2">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-th-list" aria-hidden="true"></i> Mes réponses
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="reponsePublished.php"> Réponsées publiées </a>
                                                    </div>
                                                </li>

                                                <li class="nav-item active dropdown ml-2">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?php echo $_SESSION['fullName'];?>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="infoPerso.php"> Infos personelles </a>
                                                        <a class="dropdown-item" href="script_deconnexion.php"> Déconnexion </a>
                                                    </div>
                                                </li>
                                            </ul>
                                            <form class="form-inline">
                                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </header>   
                    <!-- PAGE HEAD END -->
            <?php
                }
                else
                {
            ?>
                    <!-- PAGE HEAD -->
                    <header>
                        <div class="container-fluid">   
                            <div class="row justify-content-center">   
                                <div class="col-xl-10 bg-success rounded py-3 mb-3">
                                    <!-- Navigation Bar -->
                                    <nav class="navbar navbar-expand-md navbar-dark">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>

                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item mr-4" id="web_site">
                                                    <a class="nav-link" href=" index.php"> <button type="button" class="btn btn-warning"> acoteq.com </button> </a>
                                                </li>

                                                <li class="nav-item active dropdown mr-4">
                                                    <a class="nav-link" href="connexion.php"> <b> Connexion </b> </a>
                                                </li>
                                                
                                                <li class="nav-item active dropdown mr-4">
                                                    <a class="nav-link" href="inscription.php"> <b> S'inscrire </b> </a>
                                                </li>
                                                
                                                <li class="nav-item active dropdown">
                                                    <a class="nav-link" href="about.php"> <b> Qui sommes-nous ? </b> </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div> 
                            </div>
                        </div>
                    </header>
                    <!-- PAGE HEAD END -->
            <?php
                }
            ?>
        
