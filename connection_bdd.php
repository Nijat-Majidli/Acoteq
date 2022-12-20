<?php

    /*  On vérifie si on désire se diriger vers le serveur distant ou bien vers le serveur local. 
    Dans ce cas, host, login, password et BDD sont différents d'un serveur à l'autre.     */

    if ($_SERVER["SERVER_NAME"]=="")  // Ici on ajoute entre guillements l'adresse du serveur distant hébergeant la base de données
    {
        // Paramètres de connexion serveur distant
        $host = "";     // Ajouter adresse du serveur distant hébergeant la base de données
        $base = "";     // Ajouter le nom de BDD avec laquelle vous voulez travailler 
        $login= "";     // Ajouter votre login d'accès au serveur distant 
        $password="";   // Ajouter votre password pour vous identifier auprès du serveur distant
    }
    else if ($_SERVER["SERVER_NAME"]=="localhost" || $_SERVER["SERVER_NAME"]=="127.0.0.1")  // ici un 'OU' car il se peut que le 'localhost' ne soit pas reconnu !
    {
        // Paramètres de connexion serveur local
        $host = "localhost";    // Le nom de serveur local
        $base = "acoteq";       // La bdd avec laquelle vous voulez travailler
        $login= "root";         // Votre login d'accès au serveur de BDD 
        $password="";           // Le Password pour vous identifier auprès du serveur local
    }


    try
    {    
        //Instanciation de la connexion à la base de données   
        $db = new PDO('mysql:host='.$host.';  charset=utf8;  dbname='.$base.'',  $login, $password);

        /* Configurons des attributs PDO au gestionnaire de base de données.
        Ici nous configurons l'attribut ATTR_ERRORMODE en lui donnant la valeur ERRMODE_EXCEPTION
        Cela sert à afficher des détails sur l'erreur avec un message beaucoup plus clair: */
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
   catch (Exception $e)     // Si échec de la connexion, on attrape l'exception avec catch
   {
        echo "La connection à la base e données a échoué ! <br>";
        echo "Merci de bien vérifier vos paramètres de connection ...<br>";
        echo "Erreur : " . $e->getMessage() . "<br>";   // On affiche le message de l'erreur
        echo "N° : " . $e->getCode(). "<br>";           // On affiche le code de l'erreur
        die("Fin du script");   // Le script s'arrête ici.
   } 


?>


