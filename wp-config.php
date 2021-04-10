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
define( 'DB_NAME', 'bouletde_wp835' );

/** MySQL database username */
define( 'DB_USER', 'bouletde_wp835' );

/** MySQL database password */
define( 'DB_PASSWORD', '[u1q01pS!1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'tg0wrhzosj5jquayd1vz4lkemnmlo4ni45wtvigxp0scskq9z2rjg5dfxhylzulv' );
define( 'SECURE_AUTH_KEY',  'm7ba81otluemgguivrzgf1ic0octr6f5qonnrecxr2g45lobb6jd4igzmbao2lea' );
define( 'LOGGED_IN_KEY',    'jsuui4pvlc4r0n11oi488f0vc3d4rijafc5tl6qx89egns6i0wwnt5zt5simen5m' );
define( 'NONCE_KEY',        'wmlhvi3foldjgvqpbwasiqhezuds5lausbacywq2sd3wgd5lf349a5ww9irdbnso' );
define( 'AUTH_SALT',        'wwmdg8rkxwomrhtm6zmkax3i02jkvli3pfkigywwrrgzlgmpqfgcvspgmrg639vc' );
define( 'SECURE_AUTH_SALT', 'egdtrncreyagdblqrgzgz5dhouqm6wxoxkpbrr6nugcma0deqvgf22dtmmudbg8i' );
define( 'LOGGED_IN_SALT',   'wre5n3grv8nwgu59jp7bu43zaxbhitkgi6rrkaobbhvldhentebnoonaop09ayi0' );
define( 'NONCE_SALT',       'n80vdl7ityulfu5piu922sblcddff8sonwh4dpdvu3rzhpopr7nemmcesok5e0ub' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp6q_';

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



@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
