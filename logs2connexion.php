<?php
/*
Plugin Name: Connexion Logs
Description: Are you a professional training organization ? Get the connexion logs of your users and connected members on your site in real time. The data thus obtained are compatible with CPF funding, the various OPCOs and other funders, for the training courses of your vocational training center, and which are accessible online.
Author: SIMUNEK Florian
Version: 3.0.2
Author URI: https://floriansimunek.com/
License: GPL v2 or later
*/

/*********************************************************************************************************************************
                                                    WORDPRESS HOOKS
*********************************************************************************************************************************/
// Add jQuery
wp_enqueue_script('jquery');
// Add Heartbeat
wp_enqueue_script('heartbeat');
// Create table if plugin is actived
register_activation_hook(__FILE__, 'WPLogs_createDatabaseTable');
// Delete table if plugin is uninstalled
register_uninstall_hook(__FILE__, 'WPLogs_deleteDatabaseTable');
// Get Admin page : display logs
include_once plugin_dir_path(__FILE__).'admin.php';
// Create unique cookie
add_action('wp','WPLogs_createUniqueKeyCookie');
// Heartbeat : send datas to db every X (15) seconds
add_action('wp_footer', 'WPLogs_heartbeatSendDatas');
add_filter('heartbeat_received', 'WPLogs_heartbeatReceiveDatas', 10, 2);
add_filter('heartbeat_settings', 'WPLogs_heartbeatSettings');

/********************************************************************************************************************************
                            CREATE THE DATABASE TABLE WHEN THE PLUGIN IS ACTIVATED IF NOT EXISTS
********************************************************************************************************************************/
function WPLogs_createDatabaseTable()
{
    // Wordpress database global
    global $wpdb;
    // Get table prefix to match it
    $charset_collate = $wpdb->get_charset_collate();
    $table_name	= $wpdb->prefix . 'users_logs';

    // SQL Request for create the correct table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name 
	(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        WPLogs_Key varchar(50),
        userID bigint(20),
        userURL text DEFAULT '' NOT NULL,
        userTimeIN bigint(20),
        userTimeOUT bigint(20),
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // "Execute" the query
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/********************************************************************************************************************************
                                DELETE DATABASE TABLE WHEN THE PLUGIN IS UNINSTALLED
********************************************************************************************************************************/
function WPLogs_deleteDatabaseTable()
{
    // Wordpress database global + table prefix
    global $wpdb;
    $table_name = $wpdb->prefix . 'users_logs';
    // Query to drop the table
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

/********************************************************************************************************************************
                                                CREATE UNIQUE KEY + COOKIE
********************************************************************************************************************************/
function WPLogs_createUniqueKeyCookie()
{
	// Wordpress database global + table prefix
    global $wpdb;
    $table_name	= $wpdb->prefix . 'users_logs';
	// Create cookie + set in browser: available for session only
    if (isset($_COOKIE['WPLogs_Key'])) {
        unset($_COOKIE['WPLogs_Key']);
        setcookie('WPLogs_Key', '', -1);
        setcookie('WPLogs_Key', '', -1, '/'); 
        setcookie('WPLogs_Key', '', -1, '/', $_SERVER['HTTP_HOST']); 
    }
	$WPLogs_Key = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 50);
    setcookie('WPLogs_Key', $WPLogs_Key, time()+600, '/', '', true);
	// Delete userTimeIN >= 10min + null userTimeOUT
	$wpdb->query("DELETE FROM `".$table_name."` WHERE `userTimeIN` <= ". (time() - (600)) . " AND `userTimeOUT` IS NULL");
	// Update WPLogs_Key column where userTimeOUT >= 10min
	$wpdb->query("UPDATE `".$table_name."` SET `WPLogs_Key` = 'OK' WHERE `userTimeOUT` <= ". (time()- 600) . "");
}

/********************************************************************************************************************************
                                                HEARTBEAT SETTINGS
********************************************************************************************************************************/
function WPLogs_heartbeatSettings($settings) {
    $settings['interval'] = 15;
    $settings['autostart'] = true;
    return $settings;
}
/********************************************************************************************************************************
                                            HEARTBEAT: SEND DATA TO SERVER
********************************************************************************************************************************/
function WPLogs_heartbeatSendDatas(){
    ?>
    <script type="text/javascript">
        jQuery(document).on('heartbeat-send', function (event, data) {
            data.WPLogs_URL = window.location.href;
        });
    </script>

    <script type="text/javascript">
        jQuery(document).on('heartbeat-tick', function (event, data) {
            if (!data) { return; }
            console.log("---\n" +
                        "Data sent ! " + data.WPLogs_Key + 
                        "\nURL: " + data.URL + 
                        "\nuserID: " + data.userID + 
                        "\nuserTimeIN: " + data.userTimeIN + 
                        "\n---");
        });
    </script>
    <?php
}

/********************************************************************************************************************************
                                        HEARTBEAT: RECEIVE DATA & SEND TO DB
********************************************************************************************************************************/
function WPLogs_heartbeatReceiveDatas(array $response, array $data){
    if(empty($data['WPLogs_URL'])) {
        return $response;
    }

    // Wordpress database global + table prefix
    global $wpdb;
    $table_name = $wpdb->prefix . 'users_logs';

    // Get all user informations from wordpress / Get userID if he's connected, don't do anything if not
    $userInformations = wp_get_current_user();
    if($userInformations->ID === 0) { return; }
    else {
        $userID = $userInformations->ID;
    }

    $WPLogs_Key = sanitize_key($_COOKIE["WPLogs_Key"]);
    $userTimeIN = time();
    $userURL = $data['WPLogs_URL'];

    $datas = $wpdb->get_results("SELECT WPLogs_Key FROM ".$table_name." WHERE WPLogs_Key='$WPLogs_Key'");
    if(empty($datas)){
        $sql = "INSERT INTO $table_name (WPLogs_Key, userID, userURL, userTimeIN) VALUES ('$WPLogs_Key', '$userID', '$userURL', '$userTimeIN')";
        $wpdb->query($sql);
    } else {
        $userTimeOUT = time();
        $sql = "UPDATE $table_name SET userTimeOUT = '$userTimeOUT' WHERE WPLogs_Key = '$WPLogs_Key'";
        $wpdb->query($sql);
    }

    $response['userID'] = $userID;
    $response['URL'] = $userURL;
    $response['WPLogs_Key'] = $WPLogs_Key;
    $response['userTimeIN'] = $userTimeIN;

    setcookie('WPLogs_Key', $WPLogs_Key, time()+600, '/', '', true);
    
    return $response;
}

?>