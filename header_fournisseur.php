<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> </title>

        <!-- Bootstrap CDN link -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
        <!-- Fichier CSS -->
        <link rel="stylesheet" href="css/style.css">

        <!-- JQuery Google CDN: -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body style="background-color: #e3f2fd;">
        <!-- PAGE HEAD -->  
        <div class="container-fluid">
            <header>
                <!-- Navigation Bar -->
                <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active ml-5">
                                <a class="nav-link" href="fournisseur.php"> Accueil <span class="sr-only">(current)</span> </a>
                            </li>
                            
                            <li class="nav-item active dropdown ml-3">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Mes réponses
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="reponsePublished.php"> Réponsées publiées </a>
                                </div>
                            </li>

                            <li class="nav-item active dropdown ml-3">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Profil
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="infoPerso.php"> Infos personelles </a>
                                    <a class="dropdown-item" href="script_deconnexion.php"> Déconnexion </a>
                                </div>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </nav>
            </header>
            <br><br>
        </div>
        <!-- PAGE HEAD END -->

        