<?php

/**
 * Funcionalidade exclusiva dos sites de noticias:
 * noticias.ifc.edu.br, noticias.araquari.ifc.edu.br, etc.
 */
class IFC_Func_Site_Noticias implements IFC_iFunc{

	public function executar(){
		add_action('init', array(__CLASS__, 'renomear_categoria_padrao'));
		$this->registrar_campos_na_api();

		if (is_admin()){
			add_action('add_meta_boxes', array(__CLASS__, 'adicionar_meta_boxes'));
			$this->mostrar_coluna_destaque_na_lista_de_posts();
			add_action('admin_menu', array(__CLASS__, 'remover_meta_boxes_padrao'));
		}
	}

	public static function ativarGlobal(){}

	public static function ativarEmSite(){}

	public static function desativarGlobal(){}

	public static function desativarEmSite(){
		self::remover_destaque_noticias();
		self::limpar_categorias();
	}

	public static function adicionar_meta_boxes(){
		add_meta_box(
			'destaque_meta_box',
			'Destaque',
			array(__CLASS__, '_destaque_meta_box_callback'),
			'post',
			'side'
		);
		add_meta_box(
			'propagacao_campi_meta_box',
			'Propagação',
			array(__CLASS__, '_propagacao_campi_meta_box_callback'),
			'post',
			'side'
		);
		add_action('save_post', array(__CLASS__, '_salvar_meta_boxes'));
	}

	public static function _destaque_meta_box_callback($post){
		wp_nonce_field('noticia_meta_box', 'noticia_meta_box_nonce');

		$value = get_post_meta($post->ID, 'destaque');

		echo '<label for="destaque_field">';

		if ($value[0]) {
			echo '<input type="checkbox" id="destaque_field" name="destaque_field" checked="checked" />';
		} else {
			echo '<input type="checkbox" id="destaque_field" name="destaque_field" />';
		}

		echo 'Marque se for destaque';
		echo '</label> ';
	}

	public static function _propagacao_campi_meta_box_callback($post){
		wp_nonce_field('noticia_meta_box', 'noticia_meta_box_nonce');

		$value = get_post_meta($post->ID, 'propagacao_campi');

		echo '<label for="propagacao_campi_field">';

		if ($value[0]) {
			echo '<input type="checkbox" id="propagacao_campi_field" name="propagacao_campi_field" checked="checked" />';
		} else {
			echo '<input type="checkbox" id="propagacao_campi_field" name="propagacao_campi_field" />';
		}

		echo 'Marque para propagar a notícia para os campi';
		echo '</label> ';
	}

	public static function _salvar_meta_boxes($post_id){
		// Check if our nonce is set.
		if (!isset($_POST['noticia_meta_box_nonce'])) {
			return;
		}

		// Verify that the nonce is valid.
		if (!wp_verify_nonce($_POST['noticia_meta_box_nonce'], 'noticia_meta_box')) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (isset($_POST['post_type']) && 'post' == $_POST['post_type']) {
			if (!current_user_can('edit_posts', $post_id)) {
				return;
			}
		} else {
			return;
		}

		/* OK, it's safe for us to save the data now. */
		$destaque = (int)($_POST["destaque_field"] == "on");
		$propagacao_campi = (int)($_POST["propagacao_campi_field"] == "on");

		update_post_meta($post_id, 'destaque', $destaque);
		update_post_meta($post_id, 'propagacao_campi', $propagacao_campi);
	}

	public function mostrar_coluna_destaque_na_lista_de_posts(){
		add_filter('manage_post_posts_columns', array(__CLASS__, '_coluna_destaque_head'));
		add_action('manage_post_posts_custom_column', array(__CLASS__, '_coluna_destaque_content'), 10, 2);
		add_action('admin_head', array(__CLASS__, '_coluna_destaque_injetar_estilo'));
	}

	public static function _coluna_destaque_head($defaults){
		$defaults['destaque'] = 'Destaque?';
		return $defaults;
	}

	public static function _coluna_destaque_content($column_name, $post_id){
		if ($column_name == 'destaque'){
			if (get_post_meta($post_id, 'destaque', true)){
				echo '<input type="checkbox" disabled checked>';
			} else {
				echo '<input type="checkbox" disabled>';
			}
		}
	}

	public static function _coluna_destaque_injetar_estilo(){
		echo '<style>
			.column-destaque {
				width: 80px;
				text-align: center !important;
			}
		</style>';
	}

	public static function remover_meta_boxes_padrao(){
		remove_meta_box('categorydiv', 'post', 'normal');
		remove_meta_box('tagsdiv-post_tag', 'post', 'normal');
	}

	public static function renomear_categoria_padrao(){
		wp_update_term(1, 'category', array(
			'name' => 'Notícias',
			'slug' => 'noticias',
		));
	}

	public static function remover_destaque_noticias(){
		foreach (get_posts(array('numberposts' => -1)) as $post){
			if (get_post_meta($post->ID, 'destaque', true) == 1) {
				update_post_meta($post->ID, 'destaque', 0);
			}
		}
	}

	public static function limpar_categorias(){
		$categorias = get_terms('category', 'hide_empty=0');
		if (!empty($categorias) && !is_wp_error($categorias)){
			foreach ($categorias as $categoria) {
				wp_delete_term($categoria->term_id, 'category');
			}
		}
	}

	public function registrar_campos_na_api(){
		$campos = array(
			'destaque',
			'propagacao_campi'
		);
		foreach ($campos as $campo) {
			register_rest_field('post', $campo, array(
				'get_callback' => array(__CLASS__, '_api_get_single_post_meta'),
			));
		}
	}

	public static function _api_get_single_post_meta($post, $attr){
		return get_post_meta($post['id'], $attr, true);
	}

}
