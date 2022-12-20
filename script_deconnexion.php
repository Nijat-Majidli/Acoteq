<!-- Bootstrap CDN link --> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Fichier CSS -->
<link rel="stylesheet" href="css/style.css">


<?php
    session_start();

    $_SESSION['email'] = "";
    $_SESSION['role'] = "";
    $_SESSION['user_siren'] = "";


    unset($_SESSION['email']);
    unset($_SESSION['role']);
    unset($_SESSION['user_siren']);


    if (ini_get("session.use_cookies")) 
    {
        setcookie(session_name(), '', time()-1);
    }


    session_destroy();
    


    echo'<div class="container-fluid alert alert-primary mt-5" role="alert">
            <center> 
                <h4> <br> Vous êtes déconnecté! </h4> 
            </center>
        </div> 

        <div class="container-fluid-fluid ml-5">
            <section class="maison" style="margin-left: 200px">
                <img src="../Acoteq/image/logo.png" alt="logo" title="logo">
            </section>

            <aside>
                <div class="slogan_1" style="margin: 200px 0 0 100px">
                    <center> <h2> À Bientôt! </h2>  </center> 
                </div>
            </aside>
        </div>';


    header("refresh:2; url= index.php");  
    exit;
   


    /* 
    Lignes 5-7 : on affecte une valeur vide aux variables de session.
    
    Lignes 10-12 : suppression des variables de session.
    
    Lignes 15-18 : via la fonction setcookie(), on fait expirer en termes de date le cookie qui concerne le nom de la session. 
    Ceci n’est valide que dans le cas où les sessions sont gérées par cookies (comportement par défaut de PHP), d’où la condition.
    
    Ligne 21 : la fonction session_destroy() détruit le reste de la session.     
    */

?>


