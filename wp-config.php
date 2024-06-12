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
define( 'DB_NAME', 'u419124460_8FXKN' );

/** Database username */
define( 'DB_USER', 'u419124460_wiWsU' );

/** Database password */
define( 'DB_PASSWORD', 'cbFooiyk4y' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'rLkX}b>Isl%J{I*N)!Kr Q-GH_)}*h%uY[<F* #TXS&wV/v32.9bVs QCpI;=l*&' );
define( 'SECURE_AUTH_KEY',   ':Vr[v%BBERQ_II.R,x3;Q{Li(xm@lNJWl]&A!V/(!iVN2:qB!v(=F G$cS6ccw$D' );
define( 'LOGGED_IN_KEY',     '7vjiZ~@+;[f#dQELOq|7D@AR|frjkn)`gi%~,Cgo_zFsAVTth;LgQ:?PgqBS)W[0' );
define( 'NONCE_KEY',         '[E&EdQd/dR&spS9I+d0?3249lfshiz+OuinTqA>wY$R;<DP2B`lAEn1#f@ClrP:q' );
define( 'AUTH_SALT',         'z4 H6?7?VG:|r|Yu.+a!TI*w_R8R0Jx#:|@j^{4oU2kW[7}Phqm*Qg2+FxP/iC4E' );
define( 'SECURE_AUTH_SALT',  'NxnpJ9NEB:krZWFp6:Z=zMOYvsK>pMT[IhiPfp:XVXEBOPAGWoxrQGc9^VSEvG8Y' );
define( 'LOGGED_IN_SALT',    'GEVV4[lS&7PD Z+xuth4%Fa_XnGTs@sc5nkN<18@~u-h2bQR5_Eff]#&>EJ5Y6h`' );
define( 'NONCE_SALT',        '~WEp?w&T:6)@X9}^8JOC@%`_Z^L7fTiw?ln;UFFM(7M,a Me[s7F)VNwLRo^Lh`/' );
define( 'WP_CACHE_KEY_SALT', 'V[(s_QSqFFArRmW%fEH3#|a]$fgOE_#0D2ddZEKG1XL)Tc^fsiI+s~3 #2M(<QP0' );


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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false); // Change to true to display errors directly on the site
@ini_set('display_errors', 0);


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
