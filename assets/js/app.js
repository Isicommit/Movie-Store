/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 * 
 * any CSS you require will output into a single css file (app.css in this case)
 * require('../css/app.css');
 *
 * Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
 * var $ = require('jquery');
 * global.jQuery = require('jquery');
 */

/*
*
*SR: suite au bug avec webpack encore et jquery, appel au CDN dans le fichier twig "film_create"(voir lien dans ce dernier)
*
*/
 

var $collectionHolder;

// configuration du lien "ajouter une personne"
var $addPersonButton = $('<button type="button"  class="add_person_link btn btn-success">Ajouter une personne</button>');
var $newLinkLi = $('<li></li>').append($addPersonButton);

jQuery(document).ready(function() {
    // obtention de l'élément ul qui contiendra la collection personnes du formulaire imbriqué
    $collectionHolder = $('ul.personnes');

    // ajoute les li du formulaire imbriqué
    $collectionHolder.append($newLinkLi);

    // compte le nombre d'input du formulaire, et utilise ce nombre comme nouvel index lors de l'insertion d'un nouvel élément
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    // ajout du formulaire imbriqué au clic sur le bouton
    $addPersonButton.on('click', function(e) {
        addPersonForm($collectionHolder, $newLinkLi);
    });

     //ajout du formulaire imbriqué dans la page
    function addPersonForm($collectionHolder, $newLinkLi) {
        // récupère les données du data-prototype inclu dans le fichier twig (film_create)
        var prototype = $collectionHolder.data('prototype');
    
        // obtient le nouvel index
        var index = $collectionHolder.data('index');

        //déclaration du nouveau formulaire
        var newForm = prototype;

        // incrémente l'index en vue du prochain formulaire imbriqué
        $collectionHolder.data('index', index + 1);
    
        // Affiche le formulaire dans le <li></li>, avant le bouton "ajouter une personne"
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }

});
