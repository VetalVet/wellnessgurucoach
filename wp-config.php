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
define( 'DB_NAME', 'wellnessguru' );

/** Database username */
define( 'DB_USER', 'wellnessguru' );

/** Database password */
define( 'DB_PASSWORD', 'GWEw5DX7xbLUI8SX' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('WP_HOME', 'https://wellnessgurucoach.com/');

define('WP_SITEURL', 'https://wellnessgurucoach.com/');

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
define( 'AUTH_KEY',         'QYkg&@X+#CULS7XKGa$F' );
define( 'SECURE_AUTH_KEY',  'Xz@JE7R3zPHLaFaIjIL#' );
define( 'LOGGED_IN_KEY',    'j0zjaDfQH4yE vZcjQdN' );
define( 'NONCE_KEY',        'V!c&6yLnQG!+zMtDHDFD' );
define( 'AUTH_SALT',        '%=/ bghCs0N769sEWy7W' );
define( 'SECURE_AUTH_SALT', 'Z7IJn&#VC0_Kjpfw 7It' );
define( 'LOGGED_IN_SALT',   'Uv*q$X4q4bj@fCc_N3Lc' );
define( 'NONCE_SALT',       'Hpsxwb(/PS8c%Nk#+_*q' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_d7qqb1q2fs_';

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
define( 'WP_DEBUG', false );
//define( 'WP_CACHE', true );
//require_once( dirname( __FILE__ ) . '/gd-config.php' );
define( 'FS_METHOD', 'direct' );
define( 'FS_CHMOD_DIR', (0705 & ~ umask()) );
define( 'FS_CHMOD_FILE', (0604 & ~ umask()) );

define('RECAPTCHA_SITE_KEY', '6Lf26tUpAAAAADpzuyE1x-wigbzhwR9XZMSdrdGI');
define('RECAPTCHA_SECRET_KEY', '6Lf26tUpAAAAAI1SuKoCQdcI7XakHOqGOykU2JVi');

// Paypal
define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
define('PAYPAL_BUSINESS_EMAIL', 'marina.wellnessguru@gmail.com');

// PayPal TEST
//define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
//define('PAYPAL_BUSINESS_EMAIL', 'leveugene-facilitator@gmail.com');
//define('PAYPAL_BUSINESS_EMAIL', 'sb-h0sce30673121@business.example.com');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';