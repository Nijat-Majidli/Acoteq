/* 
La fonction showPassword() sert à nous afficher ou cacher le mot de passe saisi par l'utilisateur 
en cliquant sur l'icon oeil dans la page de "Connexion"
*/

document.getElementById("eyeIcon").addEventListener("click", showPassword);

function showPassword(event)
{
    var inputType = document.querySelector("#code"); 

    console.log(event.target.src);

    if(event.target.src=="http://localhost/Acoteq/image/eye_closed.png" || event.target.src=="http://127.0.0.1:5500/image/eye_closed.png")
    {
        event.target.src="image/eye_open.png";
        inputType.type="text";
    }
    else
    {
        event.target.src="image/eye_closed.png";
        inputType.type="password";
    }
    
}