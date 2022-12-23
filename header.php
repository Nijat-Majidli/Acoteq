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
