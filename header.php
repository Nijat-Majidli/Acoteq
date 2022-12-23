<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>  </title>

    <!-- Bootstrap CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Fichier CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- JQuery Google CDN: -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                <a class="nav-link" href="client.php"> <i class="fa fa-home" aria-hidden="true"></i> Accueil <span class="sr-only">(current)</span> </a>
                            </li>

                            <li class="nav-item dropdown active ml-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-users" aria-hidden="true"></i> Équipes 
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="equipeNew.php"> Nouvelle équipe </a>
                                    <a class="dropdown-item" href="equipeCreated.php"> Mes équipes crées </a>
                                    <a class="dropdown-item" href="equipeAutres.php"> Autres équipes </a>
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown active ml-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-text" aria-hidden="true"></i> Demandes
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="demandeNew.php"> Nouvelle demande </a>
                                    <a class="dropdown-item" href="demandeSaved.php"> Demandes sauvegardées </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown active ml-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['fullName'];?> 
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
<?php
      } 
      else if (isset($_SESSION['role']) && $_SESSION['role']=="fournisseur")
      {
?>
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
                                <a class="nav-link" href="fournisseur.php"> <i class="fa fa-home" aria-hidden="true"></i> Accueil <span class="sr-only">(current)</span> </a>
                            </li>
                            
                            <li class="nav-item active dropdown ml-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-th-list" aria-hidden="true"></i> Mes réponses
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="reponsePublished.php"> Réponsées publiées </a>
                                </div>
                            </li>

                            <li class="nav-item active dropdown ml-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['fullName'];?>
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
<?php
      }
      else
      {
?>
        <!-- PAGE HEAD -->
        <div class="container-fluid col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">      
          <header id="nav">   
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item" id="web_site">
                    <a class="nav-link" href=" index.php"> <button type="button" class="btn btn-warning"> acoteq.com </button> </a>
                  </li>

                  <li class="nav-item active dropdown ml-5 mr-2">
                    <a class="nav-link" href="connexion.php"> <b> Connexion </b> </a>
                  </li>
                  
                  <li class="nav-item active dropdown mr-2">
                    <a class="nav-link" href="inscription.php"> <b> S'inscrire </b> </a>
                  </li>
                  
                  <li class="nav-item active dropdown">
                    <a class="nav-link" href="about.php"> <b> Qui sommes-nous ? </b> </a>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
        </div>
        <!-- PAGE HEAD END -->
<?php
      }
?>
      
