<?php

/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://url_de_l_extension
 * Description: Plugin sur la législation des produits à base de nicotine.
 * Version: 1.5
 * Author: Stéphanie Fontés
 * Author URI: http://www.afpa.fr
 * Licence: (Lien de la license)
 * 
 *  
 */


//Explications:
//Réalisation d'un plugin pour un disclaimer (clause de non-responsabilité)
// Attention le commentaire ci-dessus est primordial ; il permet l'affichage, dans Wordpress,
// du module dans le panel administration des extensions (WP gère le bouton "activer »"/ "« désactiver" ). 
//Toutes les infos y sont obligatoires.
//Pour diffuser le plugin dans le Marketplace, il faut impérativement mettre le lien de la licence
// En créant le fichier «eu-disclaimer.php»,on créé indirectement une extension du fichier
// «functions.php» de WordPress ainsi ce fichier communique directement avec WP
// comme si ce code était présent dans le fichier «functions.php» sans pour autant le modifier directement. 

//Utilisation du fichier cisclaimerGestionTable.php qui gère la table 
require_once('Model/Repository/DisclaimerGestionTable.php');

// création de la fonction ajouter au menu, explication des options en variable:
//page: Texte affiché dans les balises de titre de la page, menu: texte à utiliser pour le menu
//puis capacité requise pour l'affichage du menu à l'utilisateur, nom du slug de référence
//Fonction appeler pour afficher le contenu, l'url de l'icone à utiliser
//position dans l'ordre du menu où cet élément doit apparaître.

function ajouterAuMenu()
{
    $page = 'eu-disclaimer';
    $menu = 'eu-disclaimer'; 
    $capability = 'edit_pages';
    $slug = 'eu-disclaimer';
    $function = 'disclaimerFonction';
    $icon = '';
    $position = 80;
    //La fonction "« is_Admin() »" de WordPress permet de sécuriser le plugin, elle détermine 
    //si la demande actuelle concerne une page d'interface d'administration.    
    if (is_admin()) {
        add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }
}


//hook pour réaliser l'action 'admin_menu' <- emplacement / ajouter Au Menu
//  <-fonction à appeler / <-priorité.
add_action("admin_menu", "ajouterAuMenu", 10);

//fonction à appeler lorsque l'on clic sur le Menu. Cette fonction charge la page PHP citée
// Conditions de gestion de la création ou suppression de la BDD:
//On requiert le fichier «DisclaimerGestionTable.php» puis nous créons un objet $gerer_table.
function disclaimerFonction()
{
    require_once('views/disclaimer-menu.php');
}

if (class_exists("DisclaimerGestionTable")) {
    $gerer_table = new DisclaimerGestionTable();
}
if (isset($gerer_table)) {
    //création de la table dans la BDD lors de l'activation
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable'));
    //suppression de la table dans la BDD lors de la désactivation
    register_deactivation_hook(__FILE__, array($gerer_table, 'supprimerTable'));
}


//Ajout du JS à l'activation du plugin:
add_action('init', 'inserer_js_dans_footer');

function inserer_js_dans_footer()
{
    if (!is_admin()) :
        wp_register_script(
            'jQuery',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js',
            null, null, true
        );
        wp_enqueue_script('jQuery');
           wp_register_script('jQuery_modal', 
           'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js', 
           null, null, true);
        wp_enqueue_script('jQuery_modal');
        wp_register_script(
            'jQuery_eu',
            plugins_url('assets/js/eu-disclaimer.js', __FILE__),
            array('jquery'),
            '1.1',
            true
        );
        wp_enqueue_script('jQuery_eu');
    endif;
}

//Ajout du CSS à l'activation du plugin :
add_action('wp_head', 'ajouter_css', 1);

function ajouter_css()
{
    if (!is_admin()) :
        wp_register_style('eu-disclaimer-css',
            plugins_url('assets/css/eu-disclaimer-css.css', __FILE__),
            null,
            null,
            false
        );
        wp_enqueue_style('eu-disclaimer-css');
        wp_register_style(
            'modal',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css',
            null,
            null,
            false
        );
        wp_enqueue_style('modal');
    endif;
}

// Ajout du modal et du shortcode -La fonction"«  add_shortcode() »" permet de lier 
// le "« shortcode »" à la méthode à appeler. Ce code est mis en commentaire car automatisé plus bas.
// add_shortcode('eu-disclaimer', 'afficheModal');
// function afficheModal() {
//     return DisclaimerGestionTable::AfficherDonneModal();
// }



//grace au add_action('nom du hook', 'nom de la fonction'), on peut activer le modal
//sans utilisation du shortcode, dès l'ouverture de la balise body
add_action('wp_body_open', 'afficheModalDansBody');

function afficheModalDansBody() {
   echo DisclaimerGestionTable::AfficherDonneModal();
}