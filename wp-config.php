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

$url = parse_url(getenv('DATABASE_URL') ? getenv('DATABASE_URL') : getenv('CLEARDB_DATABASE_URL'));

/** The name of the database for WordPress */
define('DB_NAME', trim($url['path'], '/'));

/** MySQL database username */
define('DB_USER', $url['user']);

/** MySQL database password */
define('DB_PASSWORD', $url['pass']);

/** MySQL hostname */
define('DB_HOST', $url['host']);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// define('DB_NAME', 'talk_ux_com_1');
// define('DB_NAME', 'd1h9bnnc3g13vt');

/** MySQL database username */
// define('DB_USER', 'talkuxcom1');
// define('DB_USER', 'wrfotdgsptnuxy');

/** MySQL database password */
// define('DB_PASSWORD', 'sfnAL?3D');
// define('DB_PASSWORD', '8f680de5bfa3e30e196ab4e8215152a783fcefa51cc6de7752e3718899e2b4bf');

/** MySQL hostname */
// define('DB_HOST', 'mysql.talk-ux.com');
// define('DB_HOST', 'ec2-23-23-244-83.compute-1.amazonaws.com:5432');

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
// define('AUTH_KEY',         '(xc4vLsPj1p_EzYqDO)k2&j&F8duXloi7tbd@+R(dNjj6vlX_c(PBy3%:q@c@+F~');
// define('SECURE_AUTH_KEY',  'DYGj%:1&h:7nwk;A_h0yg;CrEK06/OSg1i|w00tO%Kl1"7Q5x&pLzM1VJ~bB9d##');
// define('LOGGED_IN_KEY',    'a)|pW?D;XPlbLBfovWw1SECIjj@y8f$k8UyyUXHk1twxPDkhfe:dT)1:L"6GchN2');
// define('NONCE_KEY',        'uS23jlSWVZF%OmuMKUQ&@fSa0^lMESd(nrga^?4RTklfNi3waznIW37w;c5mLhBN');
// define('AUTH_SALT',        'nsITuEi;/HaXB;hjK("I:6Xs5VWI0+Etvm@ZT3;xuh/p4YGk^&`^_;VP2&8&yI!L');
// define('SECURE_AUTH_SALT', 'e2PX^U*owFn%Fzw7FZD6*A9_pbGYlu+)!wHIvZ)J@QefQKJ~3jgGw!j"fz"OE!5@');
// define('LOGGED_IN_SALT',   '!gbeTz+/*Dq~#$??LNv+lswPpstfd(LFZMjME:rj@0:B1_DM"o2@;O%HX39CK%iU');
// define('NONCE_SALT',       'GIJ@1`NxImKQ+xbrJps/_/D:GiUrJXsF0+pbaY&tCPAAcS&KWV!lRjp+"z?2;JGA');

define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_g4fj4d_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

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

