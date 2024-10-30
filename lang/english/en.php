<?php
function WPLogs_lang($phrase) {
    static $lang = array (
        'ADMIN_MENU_TITLE' => "Connexion Logs",
        'SELECT_FILTER' => "Filter data",
        'SELECT_FILTER_MEMBER_ID' => "Member ID",
        'SELECT_FILTER_MEMBER' => "Member",
        'SELECT_FILTER_URL' => "URLs",
        'SELECT_FILTER_IN' => "In",
        'SELECT_FILTER_OUT' => "Out",
        'SELECT_FILTER_DURATION' => "Duration",
        'SELECT_FILTER_TIME' => "Time",
        'INPUT_FILTER' => "Filter",
        'FREE_VERSION_MESSAGE' => "In free version, the plugin only displays the 100 first lines",
        'EXPLICATION_MESSAGE' => "You have to wait for your users to browse your site pages to see their activity",
        'DELETE' => "Delete",
        'VIEW' => "View",
        'BACK' => "Back",
        'DELETE_ALL_ROW' => "Delete <span class='WPLogs_warning'>ALL</span> database entries ?",
        'CANCEL' => "Cancel",
        'SUBMIT' => "Submit",
        'VALID_DELETE_ALL_ROW' => "All entries have been successfully deleted from the database",
        'REFRESH_PAGE' => "Refresh the page",
        'DELETE_ENTRY' => "Delete entry",
        'IN_DATABASE' => "in database ?",
        'ENTRY' => "The entry",
        'VALID_DELETE_ONE_ROW' => "has been successfully deleted from the database",
        'LANGUAGE' => "Language",
        'SUBMIT_BUTTON' => "Save the changes",
        'PRO_VERSION' => "The new PRO Version 1.1.0 is out ! Buy the PRO version : ",
        "BUY_IT" => "Buy it",
        "NO_DATAS" => "You don't have datas, your database is empty, you will see table when you will get at least one entry",
        "PRO_LINK" => "https://comeup.com/fr/service/371002/give-you-the-pro-version-of-my-wordpress-connection-logs-plugin"
    );
    return $lang[$phrase];
}
?>