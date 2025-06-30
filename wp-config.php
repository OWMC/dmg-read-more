<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dmg' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1:8889' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '{f/)fi5.-iQI/6el(O[l!WH*{dBIu`n>ARf+x*!a)9oQDuq,99RJx|-byE=+<Wg.');
define('SECURE_AUTH_KEY',  '^UI4_4z7C]|?9^z=HKRX9?Nci^n(8G;ttXK3T0aOzzPt!]AIouc6`m$u+u:+`0FE');
define('LOGGED_IN_KEY',    'tD=H;ycczt(C1rp#Icb},S}m^~d4fe7FC7u%0^A?r]-+MNS}V/ppFY`8G8M^(i@m');
define('NONCE_KEY',        'E|}0{y.-tg|.vLzL:P3yMYn f~<qS{8VJ7AU-Ff!+(1L[Y{E`g<9{(^yThbE`5,F');
define('AUTH_SALT',        'l2qAL?w-sO4-7e8$HSMyo+yAThV4baLeyDTs?4VP|-nO]|D_{PyNkQsrzo[K|KD|');
define('SECURE_AUTH_SALT', 'l@pp,+aG#$SCV<GX}P0?Sh?8Ox@`MJ Pxd%7?:+5)$SU2{R9TF:uR)|)+0.~%1)%');
define('LOGGED_IN_SALT',   's||KW-|et,-LW4L&8+`HWx+JL7M4-{^cIprA_*JcmR_jqD!-!]j|k=%vQ|%EQ-~x');
define('NONCE_SALT',       '4u|wRRc>VJwJ/yvUl/{6Tqz|!s>v`J!xEK[CPg:e]]/}SN+S3?epY@ y1@Bxsj= ');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
define ("WP_DEFAULT_THEME", "owmc-boilerplate");
define ("WPLANG", "en_GB");
define ("WP_AUTO_UPDATE_CORE", true);
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
