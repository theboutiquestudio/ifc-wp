<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/functions-shared.php");


add_action('init', 'carregar_estilo');

function carregar_estilo(){
	wp_enqueue_style('estilo reitoria' , get_stylesheet_uri());
}
