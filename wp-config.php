<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "local" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "root" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define('AUTH_KEY',         'g(<mmC5KQw@8|WHi&Js%LBhR$:c.A_t,,HcA}C0>o2cu;APa5:tDy}txb7b<^SlD');
define('SECURE_AUTH_KEY',  'WtXU#I#1DhTkOjE|)^8ofc,o1Ju3d(j1o/*w}t ~kz6KsMGTKj5,dW@em*.>>%:6');
define('LOGGED_IN_KEY',    'rcnaSE=_a4vreSBNEKFC>?l-o87Q7X|%@c$7FAd-Q@$_.z]g&|E9b+bE1:^`hYhu');
define('NONCE_KEY',        'rBF0jxM7z{!a+NC~mGK?/f4F(Ey0bH1$bbDdWuh3{G+|+-y+?UE@]nm:Q$>TNFuH');
define('AUTH_SALT',        'BD!nnuqx~O$nUTFH9icT&mh;yTi{[%ng5UXE-+b8@5?P-8cr6Rk23TW-p gHwiV~');
define('SECURE_AUTH_SALT', '/FW<B|l$4!kH9l)as9/6gzK/W{fP5Jgsi{Hl0f1qWpY+`,HAMZ#.GBpSNdhGM7/_');
define('LOGGED_IN_SALT',   '-s7w&id%nC-gPJusTFayEj?Nb~7;EqWx)Z1u2HfkW5EaS3}lTd>B=exj,bSZNF$8');
define('NONCE_SALT',       '0YHAA/!%t%/#}g<Ck{1,ahb@%OQGsjpeVv5em>Opb$QRwCJsa<x/v --84}W[uo}');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', 0 );
define( 'WP_DEBUG_DISPLAY', 0 );
define( 'WP_DEBUG_LOG', 0 );

define( 'WP_MEMORY_LIMIT', '512M' );

/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_SITEURL', 'http://uni-north.local/' );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
