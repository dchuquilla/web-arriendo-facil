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
define( 'DB_NAME', 'arriendo_facil' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'yse;:0Zn?[gq~QK:sgYa}Zxa)=X2t7oV|8s/bw<qhCRs%b{bpdG4pH:.>m)rC>]K' );
define( 'SECURE_AUTH_KEY',  ')TqG~RmYZ>Ms/s*wCgz0Ns}*zN>jR3qNTK:KG9a`*#vol>I_mSe1.MbM/%,R^FyW' );
define( 'LOGGED_IN_KEY',    'Bj:3L*uM1RCJA%$@A$i4a[{P)SY+!]4]_96KrSy)Ghewhy2$+=j?<ng(i8SPMzwC' );
define( 'NONCE_KEY',        '_aTJ_HRr@gw)>q$ZAB!.o)`zd&_G/#rpI=/WKqT3q~O~rv2d?ipU(eaV6-F/So>3' );
define( 'AUTH_SALT',        'TRZdTp|o 62m[N%8! ~Jta+MvBa{*@l+|P,,;mC38}EAR!8+ahrvIeVaxYJrxPhN' );
define( 'SECURE_AUTH_SALT', 'tSgu{VtjhwcQAFES2t?0j!EbfiEi<{;z:2Y>|v6jsN^0+JQf#<J)Qx/%q)[5M=Y]' );
define( 'LOGGED_IN_SALT',   'FX,GZBHW0=dI*O|r%ZhCISK+!C7FTR+Yu:H1R`{HXXk#Wp+<EczeRB6uSUf5nZg}' );
define( 'NONCE_SALT',       'U9Y,^x ,b:~X1tFZ|t-@^G+*wvR;x~&v {1@w*zSsj@^7sTq6Q{(F&N< =?B/$>u' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'af_';

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
