<?php
/** Development */

define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', false);


// Temporário: desabilitar debug por razões de desempenho :(
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);

@ini_set('display_errors', 0);
