<?php
/**
 * Plugin Name: DMG Read More
 * Description: A Gutenberg block for inserting stylized post links and a WP-CLI command to search for posts containing the block.
 * Version: 1.0.0
 * Author: Oliver Wieland
 * License: GPL-2.0-or-later
 */

defined('ABSPATH') || exit;

// Register Gutenberg block using block.json
function dmg_register_read_more_block() {
    register_block_type(__DIR__ . '/block.json');
}

// Filter REST API to restrict search to post titles
function dmg_filter_rest_post_search_query($args, $request) {
    if (isset($request['search']) && !empty($request['search'])) {
        $args['s'] = $request['search'];
        $args['search_columns'] = ['post_title'];
    }
    return $args;
}
add_filter('rest_post_query', 'dmg_filter_rest_post_search_query', 10, 2);

// Create custom table for block tracking on plugin activation
function dmg_create_post_blocks_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'post_blocks';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        post_id BIGINT(20) UNSIGNED NOT NULL,
        block_name VARCHAR(255) NOT NULL,
        PRIMARY KEY (post_id, block_name),
        INDEX block_name_idx (block_name)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'dmg_create_post_blocks_table');

// Update block usage on post save
function dmg_update_post_blocks($post_id, $post) {
    if (wp_is_post_revision($post_id) || $post->post_status !== 'publish') {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'post_blocks';
    $block_name = 'dmg/read-more';

    // Check if post contains the block
    $has_block = has_block($block_name, $post->post_content);

    // Delete existing record to avoid duplicates
    $wpdb->delete($table_name, ['post_id' => $post_id, 'block_name' => $block_name], ['%d', '%s']);

    // Insert if block is present
    if ($has_block) {
        $wpdb->insert(
            $table_name,
            ['post_id' => $post_id, 'block_name' => $block_name],
            ['%d', '%s']
        );
    }
}
add_action('save_post', 'dmg_update_post_blocks', 10, 2);

// Load WP-CLI command
if (defined('WP_CLI') && WP_CLI) {
    $cli_file = plugin_dir_path(__FILE__) . 'includes/class-dmg-read-more-cli.php';
    if (file_exists($cli_file)) {
        require_once $cli_file;
    } else {
        error_log('DMG Read More: CLI file not found at ' . $cli_file);
    }
}
add_action('init', 'dmg_register_read_more_block');
?>