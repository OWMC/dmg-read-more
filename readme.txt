=== DMG Read More ===
Contributors: Oliver Wieland
Tags: gutenberg, block, read more, post link, wp-cli
Requires at least: 5.8
Tested up to: 6.6
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A Gutenberg block to insert stylized "Read More" links to selected posts, with a WP-CLI command to search for posts containing the block, optimized for large databases.

== Description ==

DMG Read More is a custom Gutenberg block that allows users to select a post via a search interface (by title or ID) and display a stylized "Read More" link. The block includes pagination, loading states, and error handling for a seamless user experience. It also provides a WP-CLI command to search for posts containing the block within a specified date range, optimized for performance with millions of posts using a custom metadata table.

**Features:**
- Search posts by title or ID in the block editor with pagination (2 posts per page).
- Displays a styled "Read More" link with the selected post’s title and permalink.
- WP-CLI command (`wp dmg-read-more search`) to find posts with the block, supporting date range filtering.
- Optimized for large datasets using a custom `wp_post_blocks` table for fast block usage queries.
- Supports RTL languages and accessibility standards.

== Installation ==

1. Upload the `dmg-read-more` folder to the `/wp-content/plugins/` directory.
2. Run npm install in the plugin directory to install dependencies and automatically build the block assets (this generates the build folder).
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. On activation, the plugin creates a `wp_post_blocks` table to track block usage.
5. Add the "DMG Read More" block to any post or page via the Gutenberg editor.
6. Use the WP-CLI command `wp dmg-read-more search` to find posts containing the block (requires WP-CLI).

== Usage ==

### In the Block Editor
1. Add the "DMG Read More" block to your post or page.
2. In the block’s sidebar, search for a post by title or ID.
3. Use pagination to navigate search results (2 posts per page).
4. Select a post to set the "Read More" link, which displays as an italicized link to the post.

### WP-CLI Command
Search for posts containing the `dmg/read-more` block within a date range:
```bash
wp dmg-read-more search --date-after=2025-01-01 --date-before=2025-06-30
```
- `--date-after`: Filter posts published after this date (YYYY-MM-DD).
- `--date-before`: Filter posts published before this date (YYYY-MM-DD).
- Example output:
  ```
  Post ID: 12, Title: last one, Date: 2025-06-28 16:59:43
  Post ID: 1, Title: Hello world!, Date: 2025-06-28 14:47:17
  Success: Found 2 posts.
  ```

== Frequently Asked Questions ==

= How does the plugin handle large databases? =
The plugin uses a custom `wp_post_blocks` table to track block usage, enabling fast queries even with millions of posts. This avoids slow text searches on the `wp_posts` table.

= Can I use the block without WP-CLI? =
Yes, the block works fully in the Gutenberg editor. The WP-CLI command is optional for developers needing to audit block usage.

= What happens if no posts are found? =
The WP-CLI command outputs: `No posts found with the dmg/read-more block in the specified date range.`

== Changelog ==

= 1.0.0 =
* Initial release with Gutenberg block and WP-CLI command.
* Added custom `wp_post_blocks` table for performance with large datasets.
* Implemented title-only search and pagination in the block editor.

== Upgrade Notice ==

= 1.0.0 =
= 1.0.0 = Initial release. Ensure your WordPress database user has permissions to create tables for the wp_post_blocks table setup. Run npm install to generate the build folder after installation.

== Additional Notes ==

- The plugin requires MAMP or a similar environment with MySQL configured correctly (e.g., `DB_HOST` as `127.0.0.1:8889` for MAMP).
- For WP-CLI, ensure `/Applications/MAMP/Library/bin` is in your `PATH` to avoid database connection issues.
- Update WP-CLI to the latest version to avoid PHP 8.2+ deprecation warnings.
- The build folder is not included in the repository; run npm install to generate it.