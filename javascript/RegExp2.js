/*  
A l'aide de la fonction checkForm() on va contrôler le format et le type des données saisi par l'utilisateur dans la page "inscription". 
Si le format et le type des données ne sont pas bons on va afficher un message d'erreur à l'utilisateur.
*/

document.getElementById("bouton_valider").addEventListener("click", checkForm);

function checkForm()
{
    var filtreString = new RegExp(/^[A-Za-z ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/);  // aprés a-z on a ajouté un espace pour autoriser la saisi de l'espace blanc entre les mots
    var filtreAlphanumeric = new RegExp(/^[A-Za-z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ_&!§$£@*',;.-]+$/);  // aprés 0-9 on a ajouté un espace pour autoriser la saisi de l'espace blanc entre les mots
    var filtreSiren = new RegExp(/^[0-9]{9}$/);
    var filtreZipCode = new RegExp(/^[0-9]{5}$/);
    var filtreEmail = new RegExp(/^[a-z0-9._ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/);
    
    var Nom = document.querySelector("#name").value;
    var Prenom = document.querySelector("#surname").value;
    var RaisonSociale = document.querySelector("#RaisonSociale").value;
    var Siren = document.querySelector("#siren").value;
    var Address = document.querySelector("#address").value;
    var City = document.querySelector("#city").value;
    var State = document.querySelector("#state").value;
    var ZipCode = document.querySelector("#ZipCode").value;
    var Email = document.querySelector("#email").value;

    var controlNom = filtreString.test(Nom);
    var controlPrenom = filtreString.test(Prenom);
    var controlRaisonSociale = filtreAlphanumeric.test(RaisonSociale);
    var controlSiren = filtreSiren.test(Siren);
    var controlAddress = filtreAlphanumeric.test(Address);
    var controlCity = filtreAlphanumeric.test(City);
    var controlState = filtreString.test(State);
    var controlZipCode = filtreZipCode.test(ZipCode);
    var controlEmail = filtreEmail.test(Email);


    if (controlNom==false)
    {
        window.alert("Entrez un nom valide !");
    }

    if (controlPrenom==false)
    {
        window.alert("Entrez un prénom valide !");
    }
    
    if (controlRaisonSociale==false)
    {
        window.alert("Entrez un nom correct de la Raison Sociale !");
    }
    
    if (controlSiren==false)
    {
        window.alert("Entrez un numéro Siren valide !");
    }

    if (controlAddress==false)
    {
        window.alert("Entrez une adresse valide !");
    }

    if (controlZipCode==false)
    {
        window.alert("Entrez un code postal correct !");
    }

    if (controlCity==false)
    {
        window.alert("Entrez une ville correcte !");
    }

    if (controlState==false)
    {
        window.alert("Entrez un pays correct !");
    }

    if (controlEmail==false)
    {
        window.alert("Entrez un email correct !");
    }


    // On vérifie si les mots de passe saisi par l'utilisateur sont idéntiques:
    var Code = document.querySelector("#code").value;
    var Code2 = document.querySelector("#confirmer").value;
    
    if (Code !== Code2)
    {
        window.alert("Le mot de passe n'est pas identique!");
    }
    

}



