// surlignage.js

function surlignerElementActif(elementId) {
    // Récupérer l'élément <a> correspondant à l'ID spécifié
    let elementA = document.getElementById(elementId);
  
    // Vérifier si l'élément existe
    if (elementA) {
      // Ajouter la classe "actif" à l'élément <a>
      elementA.classList.add('actif');
      console.log("Ajout de l'élément " + elementA);
    }
}