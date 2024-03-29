<?php

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define('WP_ENV', env('WP_ENV') ?: 'production');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);

/**
<<<<<<< HEAD
 * Multisites
 */

define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);

if (array_key_exists('HTTP_HOST', $_SERVER)){
    define('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']);
} else{
    define('DOMAIN_CURRENT_SITE', env('DOMAIN_CURRENT_SITE'));
}

define('PATH_CURRENT_SITE', env('PATH_CURRENT_SITE') ?: '/');
define('SITE_ID_CURRENT_SITE', env('SITE_ID_CURRENT_SITE') ?: 1);

/**
 * WP Multi Network
 */

define( 'COOKIEHASH',        md5(env('DOMAIN_CURRENT_SITE')) );
define( 'COOKIE_DOMAIN',     env('DOMAIN_CURRENT_SITE')      );
define( 'ADMIN_COOKIE_PATH', '/' );
define( 'COOKIEPATH',        '/' );
define( 'SITECOOKIEPATH',    '/' );
define( 'TEST_COOKIE',        'wordpress_test_cookie' );
define( 'AUTH_COOKIE',        'wordpress_'          . COOKIEHASH );
define( 'USER_COOKIE',        'wordpress_user_'     . COOKIEHASH );
define( 'PASS_COOKIE',        'wordpress_pass_'     . COOKIEHASH );
define( 'SECURE_AUTH_COOKIE', 'wordpress_sec_'      . COOKIEHASH );
define( 'LOGGED_IN_COOKIE',   'wordpress_logged_in' . COOKIEHASH );


/**
=======
>>>>>>> bedrock/master
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}
