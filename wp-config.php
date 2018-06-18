<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'rupak_report');

/** MySQL database username */
define('DB_USER', 'rupak_db');

/** MySQL database password */
define('DB_PASSWORD', 'future@123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '-N?51S<_E q_9PEm$0qG?>m*N,TbPl8v[j=L{Um8!WXb1&KsyU5e-e-?~$ 8Kd,)');
define('SECURE_AUTH_KEY',  '[6GPra6QVbwVr,<C}1DpL,XIQGkN|r_F6f4_[rE@!a_,@*s{@3hRh5G?>5m;Rz`/');
define('LOGGED_IN_KEY',    '#xwd#%4f(rRss:AIX.`m? L}gVJaSi>&L!thj*zo_x$Z:X@)EmAnOP`sVza5?HoS');
define('NONCE_KEY',        'K@3k2?q/sNtohu5qF6}aZ?Cr)gD.sydvfl-X-+KCY%7Q(>L34E53].J*ZdFKZu-E');
define('AUTH_SALT',        '%.sP_k|45o]o-@wi}mJyUfO =p3vns2dTABwqVb>(!W9sg-b7`TRC(3DO:D&g6j^');
define('SECURE_AUTH_SALT', 'D(*.nzz8@XX8YY-5V_UORvhx5jPakS26%aH#W#!dKBnG#*MPl`Pd+s?tjoB)qHNn');
define('LOGGED_IN_SALT',   'W~]q0l5R^y.ZhBpRU,np~f+1P+Q8DQ6@(iF@I;<il%xasB4~e`JQ2 :)/%<PaZer');
define('NONCE_SALT',       'KTK>IVY;+XPC^6OIy^lU6?q]w@IcFbefK!{?N]0nzy2t*BA;F}AsGa^OqyJr-^y%');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
