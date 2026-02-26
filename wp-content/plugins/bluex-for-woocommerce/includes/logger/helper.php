<?php

function bluex_log($type, $message)
{
    if (!is_string($message)) {
        $message = print_r($message, true);
    }

    // If settings can't be loaded, fallback to error_log for all message types.
    if (!class_exists('WC_Correios_Settings')) {
        error_log('BlueX (' . $type . '): ' . $message . ' [WC_Correios_Settings not found]');
        return;
    }

    $settings = WC_Correios_Settings::get_instance();

    // If DB logging is disabled, only log errors to error_log.
    if ('yes' !== $settings->get_setting('active_logs')) {
        if ('error' === $type) {
            error_log('BlueX (' . $type . '): ' . $message);
        }
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'bluex_logs';

    // Check if the table exists.
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") === $table_name;

    // If it doesn't exist, create the table.
    if (!$table_exists) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            log_timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            log_type varchar(20) NOT NULL,
            log_body text NOT NULL,
            PRIMARY KEY  (id),
            KEY log_timestamp (log_timestamp)
        ) $charset_collate;";

        // The dbDelta function is not available here, so we use a direct query.
        // Note: Using dbDelta from 'wp-admin/includes/upgrade.php' is preferred in activation hooks.
        $wpdb->query($sql);

        // Check again if the table was created successfully.
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") === $table_name;

        // If it was not created, try to log to the WordPress error log.
        if (!$table_exists) {
            error_log('BlueX: Could not create the logs table "' . $table_name . '"');
            error_log('BlueX: Message that was attempted to be logged: [' . $type . '] ' . $message);
            return false;
        }
    }

    // Try to insert the log.
    $result = $wpdb->insert(
        $table_name,
        array(
            'log_timestamp' => date('Y-m-d H:i:s'),
            'log_type'      => $type,
            'log_body'      => $message,
        ),
        array(
            '%s',
            '%s',
            '%s'
        )
    );

    // If the insertion failed, log to the WordPress error log.
    if ($result === false) {
        error_log('BlueX: Error inserting log into table "' . $table_name . '": ' . $wpdb->last_error);
        error_log('BlueX: Message that was attempted to be logged: [' . $type . '] ' . $message);
        return false;
    }

    return true;
}
