<?php

function WPLogs_settings() {
	register_setting('WPLogs_settings-group', 'WPLogs_lang');
}

function WPLogs_adminOptions() {
    echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';

    if(!empty($_POST['WPLogs_langSelect'])) {
        update_option('WPLogs_lang', $_POST['WPLogs_langSelect']);
    }

    ?>
    <form method="post" action="<?php plugin_dir_path(__FILE__).'options.php'; ?>">
    <?php settings_fields('WPLogs_settings-group'); ?>
    <?php do_settings_sections('WPLogs_settings-group'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="WPLogs_langSelect"><?php echo WPLogs_lang('LANGUAGE') ?></label>
                    <td>
                        <select name="WPLogs_langSelect" id="WPLogs_langSelect">
                            <?php if(esc_attr(get_option('WPLogs_lang')) === "fr") { ?>
                                    <option value="fr" selected>Français</option>
                            <?php } else { ?>
                                    <option value="fr">Français</option>
                            <?php } ?>
                            <?php if(esc_attr(get_option('WPLogs_lang')) === "en") { ?>
                                    <option value="en" selected>English</option>
                            <?php } else { ?>
                                    <option value="en">English</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php submit_button(WPLogs_lang('SUBMIT_BUTTON'), "primary", "WPLogs_SubmitButton"); ?>
    </form>
    <?php
}
?>