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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         '7YP6Kmbdyxdn5S9ETcXU5C6Wh7AF7eSu9fZmAmkzmBInSRMBkqfD0x+f0OiTEKm5oEY//wEVKACMkFwla/jkvw==');
define('SECURE_AUTH_KEY',  '3M2LKGuDyb0ML1wJpvjyXMq30lQ+Z0YjNyfKLqPosC39cjGZSyvRHmEN19w+24kzTwZ8DhiySJZVqyiUpuez2A==');
define('LOGGED_IN_KEY',    '9BBk4zSrWxICMCdevIeGcxaW6WjiiKYKjm7haMrAxoAs5rssmgQF9fcsDkSQMe1SmVmTyNcBb+VTGH4XuBejDw==');
define('NONCE_KEY',        'VbVagaVA9VjWLusMCrIEHtb5cp/0/5iRP3Jwy6HoCr4eBxTAhJIqFRFvhTqFnGJSUh4jHaRrioHF6S3ITcsaUw==');
define('AUTH_SALT',        'IfTF9ERUarCTYuPeEjNDn+04eLEeX+jTKDZdyAQykLuX6R7QhZluthSX19bQ0s6f0sRov8FU/CkDoo8lsM1Akw==');
define('SECURE_AUTH_SALT', 'iHNWgUueO3XJAWxSJ4e5G7aNZo9QH2RnJ8E2pQBLpkcj7nfdGZrpJD+a6sXIspO1YTpjTzxUVouY5QcxwC7FzA==');
define('LOGGED_IN_SALT',   '0vLk8gzQnXgMyqoRGiGyR/C9xy0f2d5RuT2xK01yW8bdg0cnhg6M2YAy/KkarWxewSTY/E8Kv1Nq6Zk+71wE+g==');
define('NONCE_SALT',       'BO7N/8YbrtB2fWpRDZzdEDvzHPYEGypuiYnYYcpgPNawO6f5Ko92OSuG4Y8D2EXE/Y0bWWVlNoZUSWtouy0Kow==');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
