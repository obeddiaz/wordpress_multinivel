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
define('DB_NAME', 'wordpress_multinivel');

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
define('AUTH_KEY',         ')<Zc:TlJ5.1?re=)}A7(QmM.M|L3t:GV4wYF;Y +JbyNB-pzk2Em{GC^h++rW A@');
define('SECURE_AUTH_KEY',  'A//yWJ]H%_/!^agf,Ab1$5wKJ9/v0d57-aB.uu{J}1wwZm-0J.JnkAMTqk|DbJ#3');
define('LOGGED_IN_KEY',    'z0-i=[6XTHi$+.@S`{Q?#hJySrb0PUD&?>.EZ-F<B|H:pHQ)|:MtEKkvMF)%8a4i');
define('NONCE_KEY',        '.*`fo9|OVi_<_%j*2u5$-#;5/&mO6[[p-$ [J}T{0WF$w>m jrP.H.sbS>MV%2l{');
define('AUTH_SALT',        'oYPQ{m9sI+qK@O&ioxxFw!.heT*^uI$^yvG|of]6i:Pee3(~X@ 00)PLNj<(QF8=');
define('SECURE_AUTH_SALT', '/vp|l,uTs(l?m49-~{+TMSnW1~6!7Sg]LIuFZc+x`3@|D6hXW(uw_^ZP!:4h:V/=');
define('LOGGED_IN_SALT',   't=Jh:*tr,i8|%Q@=t5KD)s/tq%QW%Tpycwt[$*ZWb`5lt:1y>ALxTTL?$_ dhdYL');
define('NONCE_SALT',       ' u$i`q6!Tt:m.X*W70w&j_XfRYsuY?(T<{%rblp?a[6;~+otF{nX_Ux%d<*(IrR>');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
