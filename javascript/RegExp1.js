/*  
A l'aide de la fonction verif() on va contrôler le format de l'adresse mail saisi par l'utilisateur dans la pge connexion.php. 
Si le format n'est pas correct on va afficher un message d'erreur à l'utilisateur.
*/

document.getElementById("bouton_valider").addEventListener("click", verif);

function verif()
{
    var filtreEmail = new RegExp(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/);

    var Email = document.querySelector("#email").value;

    var controlEmail = filtreEmail.test(Email);

    if (controlEmail===false)
    {
        window.alert("L'adresse email n'est pas valide !");
    }
}


    