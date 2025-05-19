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
define( 'AUTH_KEY',          't{rkUTO5cv6zeL!_4i~TEZ#]~I&qamg7BHzYraED]+EiG$etbHr24{NAM[b_@^LE' );
define( 'SECURE_AUTH_KEY',   'Kp$2;Cr{Nflvw6Q$3W*`iE:Nomj%Ya>t/{>lj!6xxF@p8crKMhW]8*RsyBM`J}Sf' );
define( 'LOGGED_IN_KEY',     'grv_4nNWTRdM*gfL9P)nV9NU3@ExJ6^T$vlK:Uxl@?H_3@epyj7+S/^s;CSBYuEC' );
define( 'NONCE_KEY',         'JK1q4L4zsg{OUoC?`6`oBGtZyHCEoZ#6Aph0]M|6(,5X Og2%dHR>>;m^^]=A[^A' );
define( 'AUTH_SALT',         'VZrY<2vk,C{^3Uzbyt`*,rvqYy<Q&42#a{ZXP|(0>^3?H-wP-FH=k`wy0@M7n-;f' );
define( 'SECURE_AUTH_SALT',  'L*uMtF.,}j-ZX.zF;+Hf}t4mOv0{&Pw7!^|/T13_w57Z!H8g5@,Vs56ZtBa23!p!' );
define( 'LOGGED_IN_SALT',    'R_4IEP<ot`!q<5C9#)@MC^cKxL}_*SfKz&gfwN!3#3FR35}+5.C![TSMH14)uck%' );
define( 'NONCE_SALT',        'e)%PtWjJ8hZ[CP*|9qk53xB<Q7wcW8$jwgxIG89T-A3fVbbLW_m:l6a<l>:OFx6_' );
define( 'WP_CACHE_KEY_SALT', 'E)x?Sc,Kp|Cq?&bf[i,tKBf2dpIAX:pdW2tO@v[/~]%|Q.0aN|Pc~mz:n;V*@.M!' );


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
