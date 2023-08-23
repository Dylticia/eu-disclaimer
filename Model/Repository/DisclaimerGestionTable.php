<?php


// définition du chemin d'accés à la class DisclamerOptions
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
include(MY_PLUGIN_PATH . '../Entity/DisclaimerOptions.php');


// Création d'une classe permettant d'intéragir avec la BDD: création,
// suppression, insertion etc

class DisclaimerGestionTable
{
    public function creerTable()
    {
        // instanciation de la classe DisclaimerOptions
        $message = new DisclaimerOptions();

        // on alimente l'objet message avec les valeurs par défaut grâce au setter (mutateur)
        $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visyer ce site ?");
        $message->setRedirectionko("https://www.google.com");

        // Création d'une variable globale $wpdb, instance de la classe WordPress
        // utilisée pour interagir avec la BDD: 
        global $wpdb;

        // création de la table: tableDisclaimer est construit en utilisant le préfixe 
        //de la BDD de WordPress suivi de 'disclaimer_options'
        //ce qui forme le nom complet de la table.
        $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';

        if ($wpdb->get_var("SHOW TABLE LIKE $tableDisclaimer") != $tableDisclaimer) {
            $sql = "CREATE TABLE $tableDisclaimer(id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                message_disclaimer TEXT NOT NULL,
                redirection_ko TEXT NOT NULL)
                ENGINE=InnoDB DEFAULT CHARSET=UTF8mb4 COLLATE=utf8mb4_unicode_ci;";

            // message d'erreur
            if (!$wpdb->query($sql)) {
                die("Une erreur est survenue, contactez le développeur du plugin...");
            }
            // Insertion du message par défaut
            $wpdb->insert(
                $wpdb->prefix . 'disclaimer_options',
                array(
                    'message_disclaimer' => $message->getMessageDisclaimer(),
                    'redirection_ko' => $message->getRedirectionko(),
                ),
                array('%s', '%s')
            );
            $wpdb->query($sql);
        }
    }

    //Suppression de la table :
    public function supprimerTable()
    {        
        global $wpdb;
        $table_disclaimer = $wpdb->prefix . 'disclaimer_options';
        $sql = "DROP TABLE $table_disclaimer";
        $wpdb->query($sql);
    }



    //message de confirmation lors d'insertion de valeurs dans le formulaire 
    //après l'insertion en BDD grâce au  "« try/catch »" 
    //requête pour mettre à jour les données saisies dans notre formulaire

    static function insererDansTable(DisclaimerOptions $option)
    {
        
        $message_inserer_valeur = '';
        global $wpdb;
        try {
            $table_disclaimer = $wpdb->prefix . 'disclaimer_options';
            $sql = $wpdb->prepare(
                
                "UPDATE $table_disclaimer SET message_disclaimer ='%s', redirection_ko = '%s'
                        WHERE id_disclaimer = '%s'",
                $option->getMessageDisclaimer(),
                $option->getRedirectionko(),
                1
            );
            $wpdb->query($sql);
            return $message_inserer_valeur = '<span style="color:green; font-size:16px;">Les données ont correctement été mises à jour !</span>';
        } catch (Exception $e) {
            return $message_inserer_valeur = '<span style="color:red; font-size:16px;">Une erreur est survenue !</span>';
        }
    }

    //La fonction AfficherDonneModal() comporte une requête sql qui récupère les
    // données de la table, on les retourne alors en affichage dans le modal.
      
    static function AfficherDonneModal()
    {
        global $wpdb;

        $query = "SELECT * from wp_disclaimer_options";
        $row = $wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        $lien_redirection = $row->redirection_ko;
        return '<div id="monModal" class="modal">
        <p>Le vapobar, vous souhaite la bienvenue !</p>
        <p>' . $message_disclaimer . '</p>
        <a href="' . $lien_redirection . '"
        type="button" class="btn-red">Non</a>
        <a href="#" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer" 
        >Oui</a> 
        </div>';
    }
}
