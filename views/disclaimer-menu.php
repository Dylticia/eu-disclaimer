<?php
//Appel du fichier pour les cdn de bootstrap et bootswatch
require_once('base_view.php');
?>

<?php
//Si le formulaire est bien complété, on envoie les données dans la table.
//la fonction PHP "« htmlspecialchars() »" permet de protéger le formulaire contre la faille XSS.
if (!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])) {
    $text = new DisclaimerOptions();
    $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
    $text->setRedirectionko(htmlspecialchars($_POST['url_redirection']));
    $message = DisclaimerGestionTable::insererDansTable($text);
}
?>

<body>
    <h1>EU DISCLAMER</h1>
    <br>
    <h2>Configuration</h2>
    <br>
  <!-- Création du formulaire du plugin -->

    <div class="container">
        <form method="post" action="" novalidate="novalidate">
            <table class="form-table">
             <!-- Affiche la variable $message si elle est définie --> 
                <p> <?php if (isset($message)) echo $message; ?></p>
                <tr>
                    <th scope="row"> <label for="blogname">Message du disclaimer</label></th>
                    <td><input name="message_disclaimer" type="text" id="message_disclaimer" value="" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"> <label for="blogname">Url de redirection</label></th>
                    <td><input name="url_redirection" type="text" id="url_redirection" class="regular-text" /></td>
                </tr>
                <br><br>
            </table>

            <p class="submit"> <input type="submit" name="submit 
            id=" submit class="btn btn-success" value="Enregistrer les modifications" /></p>
        </form>
        <br><br>
        <p>Par exemple: La législation nous impose de vous informer de la nocivité
            des produits à base de nicotine, vous devez avoir plus de 18 ans pour
            consulter ce site ! </p>
        <p><b>Utilisation du plugin : </b>Pour plus de facilité, nous avons automatisé le plugin...<br>
            Mais si vous souhaitez le maitriser, vous pouvez indiquer <br>
            ce code php sous la balise body html de la page home principale de votre thème WP :
            echo do_shortcode('[eu-disclaimer]');<br>
            En décommentant également la fonction associée dans eu-disclaimer.php
        </p>
        <br>
        <h3>Centre AFPA / session DWWM</h3>
        <img src="<?php
        // Obtient l'URL du répertoire du plugin en cours
                    echo plugin_dir_url(dirname(__FILE__)) . 'assets/logocompact.png';
                    ?>" width="" alt="AFPA">


    </div>


</body>


</html>