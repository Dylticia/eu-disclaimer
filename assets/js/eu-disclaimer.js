//Configuration des options du modal en utilisant la bibliothèque jQuery 
// Empêche la fermeture du modal lorsque la touche "Escape"(1er cas) ou 
//lorsque l'arrière-plan(2eme cas) est pressée puis Masque le bouton de fermeture du modal
// $("#monModal").modal({
//     escapeClose: false,
//     clickClose: false,
//     showClose: false
//   });


  //La fonction suivante permet la CREATION du cookie :
  function creerUnCookie(nomCookie, valeurCookie,dureeJours) {
    console.log("Ecire Cookie : " + nomCookie);
    // Si le nombre de jour est spécifié
    if (dureeJours) {
        let date = new Date();
        // Converti le nombre de jours spécifiés en millisecondes
        date.setTime(date.getTime()+ (dureeJours * 24*60*60*1000));
        var expire = "; expires=" + date.toGMTString();
    }
    // Si aucune valeur de jour n'est spécifiée 
    else 
        var expire= "";
        document.cookie = nomCookie + "=" + valeurCookie + expire + ";path=/";
}

  //La fonction suivante permet de LIRE le cookie :
  // nomFormate: Ajoute le signe '='  au nom pour la recherche dans le tableau 
  //contenant tous les cookies
function lireUnCookie(nomCookie) {
  console.log("Lire Cookie : " + nomCookie);
  // crée une chaîne de caractères en ajoutant = au nom du cookie. Cela permettra de chercher ce format spécifique dans le tableau de cookies.
  let nomFormate = nomCookie + "=";
  //  divise la chaîne document.cookie en un tableau de cookies individuels en utilisant le ';' comme séparateur.
  let tableauCookies = document.cookie.split(";");
  console.log("Les cookies : ");
  console.log(tableauCookies);
  //la boucle for fait le tour de tous les cookies jusqu'à trouver le notre
  for (let i = 0; i < tableauCookies.length; i++) {
      let cookieTrouve = tableauCookies[i];
      // Tant qu'un espace est trouvé en 1er caractère, il est supprimé
      //Si le cookie voulu est trouvé, la fonction retourne sa valeur sinon null
      while (cookieTrouve.charAt(0) == ' ') {
          cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length);
      }
      if (cookieTrouve.indexOf(nomFormate) == 0) {
          return cookieTrouve.substring(nomFormate.length, cookieTrouve.length);
      }
  }
  // On retourne une valeur null dans le cas au aucun cookie n'est trouvé
  return null;
  }

  // document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);


  // Création d'une fonction associée au bouton OUI du MODAL
  //Au clic du bouton la fonction «accepterLeDisclaimer» va appeler la fonction «creerUnCookie». 
function accepterLeDisclaimer() {
  creerUnCookie("eu-diclaimer-vapobar", "ejD86j7ZXF3x", 1);
  let cookie= lireUnCookie("eu-diclaimer-vapobar");
  alert(cookie);
}

console.log("PRGM PRINCIPAL 1");
// vérification que si le cookie eu-diclaimer-vapobar n'a pas la valeur "ejD86j7ZXF3x". 
// lancement du modal avec un écouteur d'événement pour connaitre le choix de l'utilisateur 

jQuery(document).ready(function($) {
  console.log("PRGM PRINCIPAL 2");
  if (lireUnCookie("eu-diclaimer-vapobar") != "ejD86j7ZXF3x") {
    console.log("Modal");
    document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);
    $("#monModal").modal({
        escapeClose: false,
        clickClose: false,
        showClose: false
    });
}
});
