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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'law' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'NS@!;ZHwlXS_08F@^WK!|g~dR8{kmdA KH8{5EJ!;qxnhN&2kO!z>cU%k.(7{u_s' );
define( 'SECURE_AUTH_KEY',  'O^tou*MM;Ea`@|yC1!8Q5US)%2aVr2[^BfAO.QYy~UyMN_iv&l86fs3,uh.IEJ9d' );
define( 'LOGGED_IN_KEY',    'k8tV1heh.iJi6[#-vFHyGCN>,S$1bx35{R%9L<p;2s5n4 OvIg* riaIXO%H3w< ' );
define( 'NONCE_KEY',        '!.j&+#wjuY1~t89Lp,zcClk{>gMLr:tZ#Y(%C|h]8J&I]>q!Ai,.yyT)AN:nvCp3' );
define( 'AUTH_SALT',        '>80Ji9BdV8w]u@]$t4L8(Pw[TKJN@sp9c0{;w%HR2<E;h`s$P}f}RTofN4_r)(D?' );
define( 'SECURE_AUTH_SALT', '<UsrFg7#j2>#,a4qm&V*]M-H}+P_^wqV*Z2%ZB8lq*X5o%5q3Nfw@C[p(LIeOv}p' );
define( 'LOGGED_IN_SALT',   'D{2H LCHIfEig5g>u]6o.E7t_9v9Y]Y)vUyU>|t1-cWc`Fo$2|7+*XpDqi,ijPGu' );
define( 'NONCE_SALT',       'D*bmqQ4#a0lQx82f<Afd-FX|Ms~,xKoaL;F?AJ_c4+`wh#3~ply-7x{+d3v8PW{7' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
