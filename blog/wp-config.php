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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/dofody/public_html/blog/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'dofody_blog');

/** MySQL database username */
define('DB_USER', 'dofody_blog');

/** MySQL database password */
define('DB_PASSWORD', 'dofodyblog@2018');

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
define('AUTH_KEY',         'PsOP3b-#+k)I.-#A^D<o9Ry{2L:T 4f}%4!V-5M0iYQ}z25W@&MOg1@N,d@/(>dv');
define('SECURE_AUTH_KEY',  'n6Y0;YlR2#Q=#f)ge c;t5|d@KNFj?63$Ni<YY:NO26$:JSt!|+wg+8J!3<Q(EKQ');
define('LOGGED_IN_KEY',    ':_+)%F#NSLJ=|R|b8lcCWMs@ov;}JB#|0(x(h<AeuSoxT*,`$9p|57 x)!rM5Zm)');
define('NONCE_KEY',        'ga`a{{Vz?o.LNgI!4;&2]kR*D(fH.=mTBk2)= Jl4?b?v,:_`h2[#MJy]t/,:{[6');
define('AUTH_SALT',        'TF#nn.S,{(_/p94X1y)I]^0@Hdy/mG/n=l kM5w,Ov%S)R&vMrz.WS}&Wm(,MCT~');
define('SECURE_AUTH_SALT', 'D_Xj(19lS$w!R3EL8Y/G_IHwH:GuW#DNK@yXCSO-WsDb[b9Kf$,6k3~JP$>#R?U.');
define('LOGGED_IN_SALT',   'e&Y^}}8[99<}d`[*&,Wl^SFiGq>pjQi$L!sSl0mrRYITem7Cv$e:U&LX?[l4Rx0|');
define('NONCE_SALT',       'Pi1!I8uiI/DvWj3IJM8G+8eM(BH:3$=mA%ZYN;c=@WMAQuL2jqfLUmPGY8#:O}>I');

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
