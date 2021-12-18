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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'alianzacarvajal_web');

/** MySQL database username */
define('DB_USER', 'alianzacarvajal_web');

/** MySQL database password */
define('DB_PASSWORD', 'Alianzacarvajal.123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         '%8}||-(#SS4}ZehJqvmSZQzylem|PKr}`=BY{evXuT%=?bqsY7 y0&a}F3#~Up!,');
define('SECURE_AUTH_KEY',  '1:L?)vUl1Qg#P0AOmw$3<wJ-f5P#x4o#vl?4>e=}yeBBvRpSAlor]]a}prQWK4ju');
define('LOGGED_IN_KEY',    '^u%6C4o iwI,y+5Nz#+BTx.; uR{,W -~Jsnr@wY3@y4skv;q*Vx<#v&/ebB*/x)');
define('NONCE_KEY',        'p@<)2b.!axc3^xa=JMO6X^2za(vi1f3#iK(;%s$>=8?M-I^Ypb+]]t]#C[gqX;*j');
define('AUTH_SALT',        'iiT*J|R<Ix3qADL*v#)5+~v~Oce)`m0&Wa:x_:QG+{6oOjKA0,ec_CI`A{$Ql9of');
define('SECURE_AUTH_SALT', 'M^zJm&X|ZlTu6:Um)]f*`vw|/mnwSaZ$^m4x4Dl00[ZN1`t<<`a[%n>^Tn$R1!>Q');
define('LOGGED_IN_SALT',   '5)E~e#s&H;RqICpfej&eIIO`%sA0M=J$IoT>?*O3lwU65:Rq)N:-Gt|3Ed2n/M|i');
define('NONCE_SALT',       'E]LVfQ?Rq[[|;ZnwrMQF|?aFyW~#sm|8xf*S|iC:>m5-lb)_&$8{rL R{e2X}&{)');

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
