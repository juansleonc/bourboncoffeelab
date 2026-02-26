<?php

function bluex_clean_logs_function()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'bluex_logs';
    $wpdb->query(
        "DELETE FROM {$table_name} WHERE log_timestamp < DATE_SUB( NOW(), INTERVAL 7 DAY )"
    );
}
add_action('bluex_clean_logs', 'bluex_clean_logs_function');

register_deactivation_hook(__FILE__, 'bluex_plugin_deactivate');
function bluex_plugin_deactivate()
{
    wp_clear_scheduled_hook('bluex_clean_logs');
}
