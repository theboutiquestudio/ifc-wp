<?php
/** Development */
define('SAVEQUERIES', false);
define('WP_DEBUG', false);
define('SCRIPT_DEBUG', true);

//Fix cookies (login wasn't working)
// define('COOKIE_DOMAIN', '');

// Too many errors! Don't show 'em, just log 'em.
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);

@ini_set('display_errors', 0);

