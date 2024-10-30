<?php
function WPLogs_lang($phrase) {
    static $lang = array (
        'ADMIN_MENU_TITLE' => "Logs de Connexion",
        'SELECT_FILTER' => "Filtrer une donnée",
        'SELECT_FILTER_MEMBER_ID' => "ID Membre",
        'SELECT_FILTER_MEMBER' => "Membre",
        'SELECT_FILTER_URL' => "URL",
        'SELECT_FILTER_IN' => "Entrée",
        'SELECT_FILTER_OUT' => "Sortie",
        'SELECT_FILTER_DURATION' => "Durée",
        'SELECT_FILTER_TIME' => "Temps",
        'INPUT_FILTER' => "Filtre",
        'FREE_VERSION_MESSAGE' => "En version gratuite le plugin n'affiche que les 100 premières lignes",
        'EXPLICATION_MESSAGE' => "Vous devez attendre que vos utilisateurs naviguent sur les pages de votre site pour voir leur activité",
        'DELETE' => "Supprimer",
        'VIEW' => "Voir",
        'BACK' => "Retour",
        'DELETE_ALL_ROW' => "Supprimer <span class='WPLogs_warning'>TOUTES</span> les entrées en base de données ?",
        'CANCEL' => "Annuler",
        'SUBMIT' => "Valider",
        'VALID_DELETE_ALL_ROW' => "Toutes les entrées ont bien été supprimées de la base de données",
        'REFRESH_PAGE' => "Rafraichir la page",
        'DELETE_ENTRY' => "Supprimer l'entrée",
        'IN_DATABASE' => "en base de données ?",
        'ENTRY' => "L'entrée",
        'VALID_DELETE_ONE_ROW' => "a bien été supprimée de la base de données",
        'LANGUAGE' => "Langue",
        'SUBMIT_BUTTON' => "Enregistrer les modifications",
        'PRO_VERSION' => "La nouvelle version PRO 1.1.0 est là ! Acheter la version PRO : ",
        "BUY_IT" => "Acheter",
        "NO_DATAS" => "Vous n'avez pas de données, votre base de données est vide, vous verrez un tableau lorsque vous obtiendrez au moins une entrée",
        "PRO_LINK" => "https://comeup.com/service/361147/vous-donner-la-version-pro-de-mon-plugin-wordpress-connexion-logs"
    );
    return $lang[$phrase];
}
?>