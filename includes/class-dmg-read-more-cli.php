<?php
/**
 * DMG Read More WP-CLI Command
 */
class DMG_Read_More_CLI extends WP_CLI_Command {
    public function search($args, $assoc_args) {
        // Ensure WordPress is loaded
        if (!defined('ABSPATH')) {
            WP_CLI::error('WordPress environment not loaded.');
            return;
        }

        global $wpdb;

        $date_after = $assoc_args['date-after'] ?? '';
        $date_before = $assoc_args['date-before'] ?? '';

        // Build SQL query using wp_post_blocks
        $sql = "SELECT p.ID, p.post_title, p.post_date 
                FROM $wpdb->posts p 
                INNER JOIN {$wpdb->prefix}post_blocks pb ON p.ID = pb.post_id 
                WHERE p.post_type = 'post' 
                AND p.post_status = 'publish' 
                AND pb.block_name = %s";
        $params = ['dmg/read-more'];

        if ($date_after) {
            $sql .= " AND p.post_date > %s";
            $params[] = $date_after;
        }
        if ($date_before) {
            $sql .= " AND p.post_date < %s";
            $params[] = $date_before . ' 23:59:59';
        }

        $query = $wpdb->prepare($sql, $params);
        $posts = $wpdb->get_results($query);

        if (empty($posts)) {
            WP_CLI::warning('No posts found with the dmg/read-more block in the specified date range.');
            return;
        }

        foreach ($posts as $post) {
            WP_CLI::line(sprintf('Post ID: %d, Title: %s, Date: %s', $post->ID, $post->post_title, $post->post_date));
        }
        WP_CLI::success('Found ' . count($posts) . ' posts.');
    }
}
WP_CLI::add_command('dmg-read-more', 'DMG_Read_More_CLI');