<?php



// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'WPCACHEHOME', '/home5/organli6/public_html/news/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'organli6_ef4');

/** MySQL database username */
define('DB_USER', 'organli6_ef4');

/** MySQL database password */
define('DB_PASSWORD', 'CD6E302BAyu1o7qmx8w9i4g5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('AUTH_KEY',         '*f$Lc~Fra#-M(@?oeN8(d5HIF?k{IQZ.,+f++@/TcHw0}P_VqyjN,!CM@H?QQ9]L');
define('SECURE_AUTH_KEY',  'V>^aiD)QokoSN+~7Ib{PKS6Q-7G!9+qkOK-!},~1x%wUUZiHb:rS@pd`IcM7<L`C');
define('LOGGED_IN_KEY',    '89D-Q0t7)+iu~T .!E^X-sp-Q>z=J!Jpde:$f!<+i[6;s)37x<BiU2o|-SVb2>fX');
define('NONCE_KEY',        '?s7`9w x}__?*WR$9;1lzLeN0FS<+zKHX-:}Zre_87p59?a0lGaaSj<2mowI?%IR');
define('AUTH_SALT',        'CLOO$oW>O9mhYlqa1>.|.O/^vc@(L-5+42bAnvSrUH5#}{iN`3mf^$y*L)|%*BpX');
define('SECURE_AUTH_SALT', '~$&{gZ7F=x/KxGHV_^yJ:A|+/L0cteF`<K^mBt_Q7Ll05A{FBY^G]`K#(7pxpl+]');
define('LOGGED_IN_SALT',   'yc`LZ*EbbT]wG*NNnQ^fc8hr]Bn_|1Igeq4{:Oa6>]J4r&-;5ziPMMFM=kk-cf>b');
define('NONCE_SALT',       '-NP@hVR_!jU:RIXCNgKoA*^4)XM8XjPAH%}JDPq4Q=kew8i5rwn[yDAjLd<r)=c>');


$table_prefix = 'ef4_';


define('WP_MEMORY_LIMIT', '256M');


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
