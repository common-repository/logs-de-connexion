<?php

date_default_timezone_set(get_option('timezone_string'));
/*********************************************************************************************************************************
                                                    CUSTOM STYLES (ADD CSS)
*********************************************************************************************************************************/
$WPLogs_tableCustomStyles = plugin_dir_url(__FILE__).'/styles.css';
wp_register_style('WPLogs_tableCustomStyles', $WPLogs_tableCustomStyles);
wp_enqueue_style('WPLogs_tableCustomStyles');

/*********************************************************************************************************************************
                                                    TABLE FILTERS (JS)
*********************************************************************************************************************************/
$WPLogs_table = plugin_dir_url(__FILE__).'/js/table.js';
wp_register_script('WPLogs_table', $WPLogs_table);
wp_enqueue_script('WPLogs_table');

/*********************************************************************************************************************************
                                                    OPTIONS MENU
*********************************************************************************************************************************/
if(get_option('WPLogs_lang') === "fr"){
    include_once plugin_dir_path(__FILE__).'lang/french/fr.php';
}
if(get_option('WPLogs_lang') === "en"){
    include_once plugin_dir_path(__FILE__).'lang/english/en.php';
}
if(!get_option('WPLogs_lang')) {
    include_once plugin_dir_path(__FILE__).'lang/english/en.php';
}

include_once plugin_dir_path(__FILE__).'options.php';
/*********************************************************************************************************************************
                                                ADD ADMIN PAGE IN WP MENU
*********************************************************************************************************************************/
add_action('admin_menu', 'WPLogs_adminMenu');
add_action('admin_init', 'WPLogs_settings');

function WPLogs_adminMenu(){
    add_menu_page(WPLogs_lang('ADMIN_MENU_TITLE'), 'WP Logs', 'manage_options', 'WPLogs_admin', 'WPLogs_adminMenuMain', 'dashicons-chart-line', 2);
    add_submenu_page('WPLogs_admin', 'Options', 'Options', 0, 'WPLogs_adminOptionsMenu', 'WPLogs_adminOptions');
}

/*********************************************************************************************************************************
                                                ADMIN MENU - TABULAR
*********************************************************************************************************************************/
function WPLogs_adminMenuMain(){
    echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';

    // Wordpress database global + Table prefix in database
	global $wpdb;
    $table_name = $wpdb->prefix . 'users_logs';

/*********************************************************************************************************************************
                                                FREE VERSION MESSAGES
*********************************************************************************************************************************/
    if(isset($_GET['view'])) {
        $sql = "SELECT * FROM $table_name WHERE id = " . sanitize_text_field($_GET["view"]) . "";
        $results = $wpdb->get_results($sql, ARRAY_A);
    } else {
        $sql = "SELECT * FROM $table_name ORDER BY id ASC";
        $results = $wpdb->get_results($sql, ARRAY_A);
    }

/*********************************************************************************************************************************
                                                DELETE ONE ROW
*********************************************************************************************************************************/
	if ((isset($_GET["delete"])) AND (!isset($_GET["validation"]))) { ?>
		<div class='postbox WPLogs_deleteAll_box'>
            <p style="text-align: center;"><?php echo WPLogs_lang('DELETE_ENTRY') ?> <span class='WPLogs_warning'><?= esc_attr($_GET["delete"]) ?></span> <?php echo WPLogs_lang('IN_DATABASE') ?></p>
        <?php
        $sql = "SELECT * FROM $table_name WHERE id = " . sanitize_text_field($_GET["delete"]) . "";
		$results = $wpdb->get_results($sql, ARRAY_A);
       
		if(!empty($results)) {
			foreach($results as $row) { ?>
                <div id="WPLogs_deleteOneBlock">
                    <p><span class='WPLogs_warning'>ID: </span>
                        <?= esc_attr($row['userID']) ?>
                    </p>
                    <p><span class='WPLogs_warning'><?php echo WPLogs_lang('SELECT_FILTER_MEMBER') ?>: </span>
                        <?= esc_attr(get_userdata($row['userID'])->first_name) . " " . esc_attr(get_userdata($row['userID'])->last_name) ?>
                    </p>
                    <p><span class='WPLogs_warning'><?php echo WPLogs_lang('SELECT_FILTER_URL') ?>: </span>
                        <?= esc_url($row['userURL']) ?>
                    </p>
                    <p><span class='WPLogs_warning'><?php echo WPLogs_lang('SELECT_FILTER_IN') ?>: </span>
                        <?= esc_attr(date('d/m/Y H\:i\:s', $row['userTimeIN'])) ?>
                    </p>
                    <p><span class='WPLogs_warning'><?php echo WPLogs_lang('SELECT_FILTER_OUT') ?>: </span>
                        <?= esc_attr(date('d/m/Y H\:i\:s', $row['userTimeOUT'])) ?>
                    </p>
                    <p><span class='WPLogs_warning'><?php echo WPLogs_lang('SELECT_FILTER_DURATION') ?>: </span>
                        <?= esc_attr(date('H\:i\:s', ($row['userTimeOUT'] - $row['userTimeIN']) - 3600)) . " - " . esc_attr($row['userTimeOUT'] - $row['userTimeIN']) ?> secondes
                    </p>
                </div><?php
			}
		} ?>
            <div style="text-align: center; margin-bottom: 20px;">
                <a class='button button-secondary WPLogs_button' href='<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin'><?php echo WPLogs_lang('CANCEL') ?></a>
                <a class='button button-primary WPLogs_button' href='<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin&delete=<?= esc_attr($_GET["delete"]) ?>&validation=oui'><?php echo WPLogs_lang('SUBMIT') ?></a>
            </div>
        </div><?php
	}

    // Confirmation
	if ((isset($_GET["delete"])) AND (isset($_GET["validation"]))) { ?>
		<div class='postbox WPLogs_deleteAll_box'>
            <p style="text-align: center;"><?php echo WPLogs_lang('ENTRY') ?> <span class='WPLogs_warning'><?= esc_attr($_GET["delete"]) ?></span> <?php echo WPLogs_lang('VALID_DELETE_ONE_ROW') ?></p>
		    <p style='text-align: center; margin: 20px auto;'>
                <a class='button button-primary WPLogs_button' href='<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin'><?php echo WPLogs_lang('REFRESH_PAGE') ?></a>
            </p>
        </div>
		<?php
        $sql = "DELETE FROM `".$table_name."` WHERE `id` = ". sanitize_text_field($_GET["delete"]) . "";
		$results = $wpdb->query($sql);
	}

/*********************************************************************************************************************************
                                                DISPLAY DATAS - TABULAR
*********************************************************************************************************************************/
    if(!empty($results)) { ?>
        <script>
            function WPLogs_show_options($id) {
                jQuery(".WPLogs_column_options_" + $id).css('visibility', 'visible');
            }
            function WPLogs_hide_options($id) {
                jQuery(".WPLogs_column_options_" + $id).css('visibility', 'hidden');
            }
        </script>
        <?php if(!isset($_GET['delete'])) { ?>
        <div class="notice notice-info is-dismissible"><p style="font-size: 1.5rem; font-weight: bold;"><?= WPLogs_lang('PRO_VERSION') ?><a href="<?= WPLogs_lang('PRO_LINK') ?>" target="_blank" class="button button-primary"><?= WPLogs_lang('BUY_IT') ?></a></p></div>
        <div id='WPLogs_filter'>
            <div id='WPLogs_refresh' class="button button-primary"><img style="display: inline-block; width: 20px; height: 20px" src='<?= plugin_dir_url(__FILE__).'/images/refresh_white.png' ?>'/></div>
            <select id='WPLogs_filter_select'>
                <option value='' selected disabled><?php echo WPLogs_lang('SELECT_FILTER') ?></option>
                <option value='WPLogs_ID'>ID</option>
                <option value='WPLogs_MemberID'><?php echo WPLogs_lang('SELECT_FILTER_MEMBER_ID') ?></option>
                <option value='WPLogs_names'><?php echo WPLogs_lang('SELECT_FILTER_MEMBER') ?></option>
                <option value='WPLogs_URL'><?php echo WPLogs_lang('SELECT_FILTER_URL') ?></option>
                <option value='WPLogs_timeIN'><?php echo WPLogs_lang('SELECT_FILTER_IN') ?></option>
                <option value='WPLogs_timeOUT'><?php echo WPLogs_lang('SELECT_FILTER_OUT') ?></option>
                <option value='WPLogs_duration'><?php echo WPLogs_lang('SELECT_FILTER_DURATION') ?></option>
                <option value='WPLogs_timer'><?php echo WPLogs_lang('SELECT_FILTER_TIME') ?></option>
            </select>
            <input id='WPLogs_filter_searchBar' class="regular-text" type='text' placeholder='<?php echo WPLogs_lang('INPUT_FILTER') ?>'>
        </div>
        <table id='WPLogs_table' class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <th class="th-sort-desc">ID ▼</th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_MEMBER_ID') ?></th>
					<th><?php echo WPLogs_lang('SELECT_FILTER_MEMBER') ?></th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_URL') ?></th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_IN') ?></th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_OUT') ?></th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_DURATION') ?></th>
                    <th><?php echo WPLogs_lang('SELECT_FILTER_TIME') ?></th>
                </tr>
            </thead>
            <tbody><?php
                foreach($results as $row){
                    if(!(esc_attr($row['userTimeOUT'] - $row['userTimeIN']) <= 1)){ ?>
                        <tr>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_ID">
                                <?= $row['id'] ?>
                                <div class="WPLogs_column_options WPLogs_column_options_<?= $row['id'] ?>" style="visibility:hidden; z-index: 10;">
                                    <span class="trash"><a href="<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin&delete=<?= esc_attr($row['id']) ?>" class="submitdelete"><?php echo WPLogs_lang('DELETE') ?></a></span>
									<?php if(!isset($_GET['view'])){ ?>
                                        <span class="view"> | <a href="<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin&view=<?= esc_attr($row['id']) ?>"><?php echo WPLogs_lang('VIEW') ?></a></span>
                                    <?php } ?>
                                </div>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_MemberID" class='WPLogs_columns'>
                                <?= esc_attr($row['userID']) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_names" class='WPLogs_columns'>
                                <?= esc_attr(get_userdata($row['userID'])->first_name) . " " . esc_attr(get_userdata($row['userID'])->last_name) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_URL" class='WPLogs_columns' style='text-align: left;'>
                                <?= esc_url($row['userURL']) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_timeIN" class='WPLogs_columns'>
                                <?= esc_attr(date('d/m/Y H\:i\:s', $row['userTimeIN'])) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_timeOUT" class='WPLogs_columns'>
                                <?= esc_attr(date('d/m/Y H\:i\:s', $row['userTimeOUT'])) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_duration" class='WPLogs_columns'>
                                <?= esc_attr($row['userTimeOUT'] - $row['userTimeIN']) ?>
                            </td>
                            <td onmouseover="WPLogs_show_options(<?= $row['id'] ?>)" 
                                onmouseleave="WPLogs_hide_options(<?= $row['id'] ?>)" 
                                id="WPLogs_timer" class='WPLogs_columns'>
                                <?= esc_attr(date('H\:i\:s', ($row['userTimeOUT'] - $row['userTimeIN']) - 60*60)) ?>
                            </td>
                        </tr><?php
                    }
                } ?>
            </tbody>        
        </table>
        <?php if(isset($_GET['view'])) { ?>
            <a id="WPlogs_back_button" class="button button-primary" href="<?php $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>?page=WPLogs_admin"><?php echo WPLogs_lang('BACK') ?></a>
        <?php }
        }
    } else { ?>
        <div class="WPLogs_noDatas">
            <p class="WPLogs_info"><?= WPLogs_lang("NO_DATAS") ?></p>
        </div>
    <?php }
}
?>