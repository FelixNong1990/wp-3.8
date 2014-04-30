<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp-3.8');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZU=+0|P3Q T|D#zb?N-Y)[9|c{_n_n[#+<le/W&qKD-KtbQQdq^p5Psb,]AN=~.z');
define('SECURE_AUTH_KEY',  ')N7+h0e^=1. /Y|?lnAf2TDvW_7r_We3S85R0}3)D}jYs<]Ir-9I-lr=w|-!Tp{N');
define('LOGGED_IN_KEY',    'xb`M7,/Qb|fR|#zx2}0WSSI~}|=EtzdMw2*F(%-D|p{3`qquzC<PM$_TVE?SrLe!');
define('NONCE_KEY',        'L8+rfMlm2IJm$ZlRW+`&dp2YFG{c_aA8v3#={bu%CM-ZzeRpWO|P:<. VmGks0~-');
define('AUTH_SALT',        '[7D+nw6]bV[6Q;!?NK7+<W+5`&U$cQw<)JrWU jWO}H7 -/6a|7s/IU:_P21]7|*');
define('SECURE_AUTH_SALT', 't!8ApZ,tWM~qB*?AS*]+(K.[|`P.s~]g#$+yo|a%N03+qNjpk!-vv~%Xb<wd.b)P');
define('LOGGED_IN_SALT',   'M|7^nH`x93G?F W?on:il=510|BX`12%F4r+R~Mp:OKa7J>/a+2WM&c|?KO!q4|D');
define('NONCE_SALT',       'O(D~MfaJeS*`lBle-3 5C&IZ#e=(3=i*|9N$6war!92P#bw@Q]B7Q*n98 O9=pyS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
