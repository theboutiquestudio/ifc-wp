<?php

/**
 * Funcionalidade exclusiva do site geral (ifc.edu.br)
 */
class IFC_Func_Site_Geral implements IFC_iFunc{

	public function executar(){
		add_action('widgets_init', array(__CLASS__, 'registrar_sidebars'));
		add_action('init', array(__CLASS__, 'registrar_taxonomias'));
		add_action('init', array(__CLASS__, 'registrar_custom_post_types'));
		add_action('init', array(__CLASS__, 'registrar_custom_fields'));
		add_action('wp_enqueue_scripts', array(__CLASS__, 'carregar_styles'));

		add_image_size('perfil', 420, 420);

		if (is_admin()){
			$this->restaurar_menu_links();
			add_action('admin_menu', array(__CLASS__, 'esconder_menu_posts'));
			$this->adicionar_campo_link_ao_attachment();
			add_action('add_meta_boxes', array(__CLASS__, 'adicionar_meta_boxes'));
			IFC_Admin_Menu_Geral::registrar();
		}
	}

	public static function ativarGlobal(){}

	public static function ativarEmSite(){
		self::criar_paginas_padrao();
		self::criar_categorias();
	}

	public static function desativarGlobal(){}

	public static function desativarEmSite(){}

	public static function registrar_sidebars(){
		register_sidebar(array(
			'id' => 'ifc-seletor-categorias',
			'name' => 'Seletor de Categorias',
			'before_title' => '<span class="hidden">',
			'after_title' => '</span>',
		));
		register_sidebar(array(
			'id' => 'ifc-eventos',
			'name' => 'Eventos',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
		));
		register_sidebar(array(
			'id' => 'ifc-cursos',
			'name' => 'Cursos',
		));
		register_sidebar(array(
			'id' => 'ifc-banners',
			'name' => 'Banners',
		));
	}

	public static function criar_paginas_padrao(){
		$titulo_pagina_cursos = 'Cursos';
		$titulo_pagina_campus = 'Conheça o Campus';

		$pagina_cursos = get_page_by_title($titulo_pagina_cursos);
		$pagina_campus = get_page_by_title($titulo_pagina_campus);

		if ($pagina_cursos === null || $pagina_cursos->post_status === 'trash'){
			wp_insert_post(array(
				'post_title' => $titulo_pagina_cursos,
				'post_type' => 'page',
				'post_status' => 'publish',
				'page_template' => 'page-cursos.php',
			));
		}

		if ($pagina_campus === null || $pagina_campus->post_status === 'trash'){
			wp_insert_post(array(
				'post_title' => $titulo_pagina_campus,
				'post_type' => 'page',
				'post_status' => 'publish',
				'page_template' => 'page_campus.php',
			));
		}
	}

	public static function registrar_taxonomias(){
		register_taxonomy('notice_category', array('notice'), array(
			'hierarchical' => true,
			'public' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'categoria-avisos'),
		));
	}

	public static function criar_categorias(){
		$categorias = array(
			array('nome' => 'Avisos',            'slug' => 'avisos'),
			array('nome' => 'Agenda do Diretor', 'slug' => 'agenda-do-diretor'),
		);
		foreach ($categorias as $cat) {
			$existente = term_exists($cat['nome'], 'category') !== null;
			if (!$existente){
				wp_insert_term($cat['nome'], 'category', array('slug' => $cat['slug']));
			}
		}
	}

	public static function registrar_custom_post_types(){
		$post_types = array(
			'noticia_geral' => array(
				'labels' => array(
					'name' => 'Notícias',
					'singular_name' => 'Notícia',
					'all_items' => 'Todas as notícias',
				),
				'rewrite' => array('slug' => 'noticia-geral'),
			),
			'evento_geral' => array(
				'labels' => array(
					'name' => 'Eventos',
					'singular_name' => 'Eventos',
					'all_items' => 'Todos os eventos',
				),
				'rewrite' => array('slug' => 'evento-geral'),
			),
			'agenda_reitor' => array(
				'labels' => array(
					'name' => 'Agenda do reitor',
					'singular_name' => 'Agenda do reitor',
					'all_items' => 'Todos os compromissos',
				),
				'rewrite' => array('slug' => 'agenda-do-reitor'),
			),
			'aviso_geral' => array(
				'labels' => array(
					'name' => 'Avisos',
					'singular_name' => 'Avisos',
					'all_items' => 'Todos os avisos',
				),
				'rewrite' => array('slug' => 'aviso-geral'),
			),
		);

		// Essas propriedades serão aplicadas a todos os post types
		$default_args = array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
		);

		foreach ($post_types as $post_type_key => $custom_args) {
			register_post_type($post_type_key, array_merge($default_args, $custom_args));
		}
	}
	public static function registrar_custom_fields(){
		$grupos = array_merge(
			IFC_ACF_Noticia_Geral::getGrupos(),
			IFC_ACF_Agenda_Geral::getGrupos(),
			IFC_ACF_Evento_Geral::getGrupos(),
			IFC_ACF_Aviso_Geral::getGrupos()
		);

		foreach ($grupos as $grupo) {
			register_field_group($grupo);
		}
	}

	private function restaurar_menu_links(){
		add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	}

	public static function esconder_menu_posts(){
		remove_menu_page('edit.php');
	}

	private function adicionar_campo_link_ao_attachment(){
		add_filter('attachment_fields_to_edit', array(__CLASS__, '_adicionar_campo_link_ao_attachment'), 10, 2);
		add_filter('attachment_fields_to_save', array(__CLASS__, '_salvar_campo_link_ao_attachment'), 10, 2);
	}

	public static function _adicionar_campo_link_ao_attachment($campos, $attachment){
		$campos['link'] = array(
			'label' => 'Link',
			'input' => 'text',
			'value' => get_post_meta($attachment->ID, 'link', true),
		);
		return $campos;
	}

	public static function _salvar_campo_link_ao_attachment($post, $attachment){
		if (isset($attachment['link'])){
			update_post_meta($post['ID'], 'link', $attachment['link']);
		}
		return $post;
	}

	public static function adicionar_meta_boxes(){
		add_meta_box(
			'event_date_meta_box',
			'Data do evento',
			array(__CLASS__, '_adicionar_metabox_data_ao_evento'),
			'agenda_director',
			'side'
		);
		add_action('save_post', array(__CLASS__, '_salvar_metabox_data_ao_evento'));
	}

	public static function _adicionar_metabox_data_ao_evento($evento){
		$wp_locale = new WP_Locale();
		wp_nonce_field('event_date_meta_box', 'event_date_meta_box_nonce');

		$evento_dados = get_post_custom($evento->ID);
		$evento_tem_data = array_key_exists('event_date_year', $evento_dados);

		if ($evento_tem_data){
			$year = $evento_dados['event_date_year'][0];
			$month = $evento_dados['event_date_month'][0];
			$day = $evento_dados['event_date_day'][0];
			$hour = $evento_dados['event_date_hour'][0];
			$minute = $evento_dados['event_date_minute'][0];
		} else {
			$agora = current_time('timestamp');
			$year = date('Y', $agora);
			$month = date('m', $agora);
			$day = date('d', $agora);
			$hour = date('H', $agora);
			$minute = "00";
		}

		echo '<label for="event_date_day">Data:</label><br/>
		<input type="text" name="event_date_day" value="' . $day  . '" size="2" maxlength="2" /> ';

		$month_s = '<select name="event_date_month">';
		for ($i=1; $i<=12; $i++){
			$month_s .= '<option value="' . zeroise($i, 2) . '"';
			if ($i == $month){
				$month_s .= ' selected="selected"';
			}
			$month_s .= '>' . $wp_locale->get_month_abbrev($wp_locale->get_month($i)). '</option>';
		}
		$month_s .= '</select>';
		echo $month_s;

		echo '<input type="text" name="event_date_year" value="' . $year . '" size="4" maxlength="4" /><br/>
		<label for="event_date_hour">Hora:</label><br/>
		<input type="text" name="event_date_hour" value="' . $hour . '" size="2" maxlength="2"/> :
		<input type="text" name="event_date_minute" value="' . $minute . '" size="2" maxlength="2" />';
	}

	public static function _salvar_metabox_data_ao_evento($evento_id){
		// Check if our nonce is set.
		if (!isset($_POST['event_date_meta_box_nonce'])){
			return;
		}
		// Verify that the nonce is valid.
		if (!wp_verify_nonce($_POST['event_date_meta_box_nonce'], 'event_date_meta_box')){
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return;
		}

		$year = $_POST['event_date_year'];
		$month = $_POST['event_date_month'];
		$day = $_POST['event_date_day'];
		$hour = $_POST['event_date_hour'];
		$minute = $_POST['event_date_minute'];

		update_post_meta($evento_id, 'event_date_year', $year);
		update_post_meta($evento_id, 'event_date_month', $month);
		update_post_meta($evento_id, 'event_date_day', $day);
		update_post_meta($evento_id, 'event_date_hour', $hour);
		update_post_meta($evento_id, 'event_date_minute', $minute);
	}
	public static function carregar_styles(){
		wp_enqueue_style('acesso_rapido' ,  plugin_dir_url(dirname(__FILE__)).'/styles/acesso_rapido.css');
	}


	public static function get_imagem_perfil_url($nome){
		$opcoes = get_option('opcoes-gerais');
		$imagem_id = $opcoes["imagem-perfil-{$nome}"];

		$imagem_padrao = plugin_dir_url(dirname(__FILE__)) . 'images/perfil-sem-imagem.png';

		if (empty($imagem_id)) {
			return $imagem_padrao;
		} else {
			return wp_get_attachment_image_src($imagem_id, 'perfil')[0];
		}
	}
}
