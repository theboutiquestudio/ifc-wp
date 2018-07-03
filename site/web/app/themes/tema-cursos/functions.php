<?php
require(WP_CONTENT_DIR . "/themes/ifc-v2/functions-shared.php");

// Registra navegação secundária
// =================================================================================================
register_nav_menu('superior', 'Menu Superior');


add_action('init', 'carregar_estilo');

function carregar_estilo(){
	wp_enqueue_style('estilo campi' , get_stylesheet_uri());
}
