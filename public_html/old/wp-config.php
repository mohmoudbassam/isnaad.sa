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
define( 'DB_NAME', 'dbnb5pam8htyu6' );

/** MySQL database username */
define( 'DB_USER', 'udwx7edwj4adz' );

/** MySQL database password */
define( 'DB_PASSWORD', 'y8zn9mmwm78f' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'w#AqK4li4J8i`M,H5wnC@ FOXcgQ=X=)N-F5x&~s-vI8b($,&yv$ sz+U(<gf#<4' );
define( 'SECURE_AUTH_KEY',   'a=x_f-?4@W/wy`THtN|nf3Pg3.h+Oda~5bL$m;Sy7uOluOYH^yM{zpKjKH|4(#{n' );
define( 'LOGGED_IN_KEY',     '!ek9xm;[Oq.H;]0.$D~%brkT:e1~[nvF&TKx0v|J<:@*es=]jlay;|D*uL8tyma#' );
define( 'NONCE_KEY',         'RfFo{UdoUBk5eS-qx  ?DriT/:r ?*I@~T[^xsnAwdd9X!|9ABCxrWvQ:ECX=3s>' );
define( 'AUTH_SALT',         '?Z(o@pha0L3gQr=r1*MeH53#xrew7 o]m4[>rrb{``1Ha,LA7_#ap91Qt`~!ZAYM' );
define( 'SECURE_AUTH_SALT',  '?/(<L}mtUGaI#Z.{p v(*rXpdRk:M9Dum>Z6rOF%mNTCKwyGbU1LY17c@ )9{gH+' );
define( 'LOGGED_IN_SALT',    'X{&4r*8_`Q;(r|9(OR{{n O0^D~L[~X*BO#<pctDe{2W4rGFhM&(`Wg?N0Iv#.}<' );
define( 'NONCE_SALT',        '4J#+B4|-}{C!D 886>EhQ;vS{om8U7k3)xq_%ra>ov@5x30^ht4zBW04be2jyJ[.' );
define( 'WP_CACHE_KEY_SALT', '&_K;+nfcG2%;R|DLJl8*Z]vUQO5N5`q<.j?I>]+c}gqe$0G^_{$r{6 p]0sq=*8+' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
