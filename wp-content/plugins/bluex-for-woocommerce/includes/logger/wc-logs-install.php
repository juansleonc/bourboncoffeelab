<?php
// 1. Función para crear/actualizar la tabla de logs
function bluex_create_logs_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bluex_logs';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        log_timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        log_type varchar(20) NOT NULL,
        log_body text NOT NULL,
        PRIMARY KEY  (id),
        KEY log_timestamp (log_timestamp)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// 2. Activación del plugin
register_activation_hook( __FILE__, 'bluex_plugin_activate' );
function bluex_plugin_activate() {
    bluex_create_logs_table();
    if ( ! wp_next_scheduled( 'bluex_clean_logs' ) ) {
        wp_schedule_event( time(), 'daily', 'bluex_clean_logs' );
    }
}
