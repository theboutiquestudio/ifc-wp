<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

/**
 * Funcionalidade exclusiva dos sites de campi
 * araquari.ifc.edu.br, saofrancisco.ifc.edu.br, etc.
 */
class IFC_Func_Site_Campus implements IFC_iFunc{

	public function executar(){
		add_action('init', array(__CLASS__, 'registrar_menus'));
		add_action('wp_enqueue_scripts', array(__CLASS__, 'carregar_styles'));
		add_action('init', array(__CLASS__, 'registrar_custom_post_types'));
		add_action('init', array(__CLASS__, 'registrar_custom_fields'));
		add_image_size('banner', 1170, 210);


		if(is_admin()){
			add_action('admin_enqueue_scripts', array(__CLASS__, 'carregar_scripts_admin'));
			add_action('admin_init', array(__CLASS__, 'registrar_opcoes_campi'));
			add_action('admin_menu', array(__CLASS__, 'registrar_menu_admin'));
		}

	}

	public static function ativarGlobal(){
		self::criar_tabelas();
	}

	public static function ativarEmSite(){}

	public static function desativarGlobal(){
		self::remover_tabelas();
	}

	public static function desativarEmSite(){}


	private static function criar_tabelas(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$sql = "CREATE TABLE {$prefixo}campi (
			id int(11) NOT NULL auto_increment,
			blog_id bigint(20) NOT NULL,
			nome varchar(200) NOT NULL,
			PRIMARY KEY  (id)
		) {$wpdb->get_charset_collate()}
		";
		dbDelta($sql);
	}

	private static function remover_tabelas(){
		global $wpdb;
		$tabelas = array(
			'campi',
		);
		$prefixo = $wpdb->base_prefix . 'ifc_';
		foreach ($tabelas as $tabela) {
			$wpdb->query("DROP TABLE IF EXISTS ${prefixo}${tabela}");
		}
	}
	public static function registrar_custom_post_types(){
		$post_types = array(
			'noticia_campus' => array(
				'labels' => array(
					'name' => 'Notícias',
					'singular_name' => 'Notícia',
					'all_items' =>  'Todas as notícias',
				),
			),
			'aviso_campus' => array(
				'labels' => array(
					'name' => 'Avisos',
					'singular_name' => 'Avisos',
					'all_items' =>  'Todos os avisos',
				),
			),
			'agenda_diretor' => array(
				'labels' => array (
					'name' => 'Agenda do Diretor',
				),
			),
			'evento_campus' => array (
				'labels' => array(
					'name' => 'Eventos',
					'singular_name' => 'Evento',
					'all_items' => 'Todos os Eventos'
				),
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
			IFC_ACF_Noticia_Campus::getGrupos(),
			IFC_ACF_Agenda_Campus::getGrupos(),
			IFC_ACF_Evento_Campus::getGrupos(),
			IFC_ACF_Aviso_Campus::getGrupos()
		);

		foreach ($grupos as $grupo) {
			register_field_group($grupo);
		}
	}

	public static function carregar_scripts_admin(){
		wp_enqueue_media();
		wp_enqueue_script('admin_upload_imagem', plugin_dir_url(dirname(__FILE__)) . 'scripts/admin_upload_imagem.js', array('jquery'));
	}

	public static function registrar_opcoes_campi(){
		register_setting('grupo-opcoes-campi', 'opcoes-campi');
		add_settings_section('default', null, null, 'opcoes-campi');
		add_settings_field('banner', 'Banner', array(__CLASS__, 'callback_opcao_banner'), 'opcoes-campi', 'default');
	}

	public static function registrar_menu_admin(){
		add_options_page(
			'Opções do campi',
			'Opções do campi',
			'manage_options',
			'opcoes-campi',
			array(__CLASS__, 'mostrar_menu_admin')
		);
	}

	public static function mostrar_menu_admin(){
		?>
		<div class="wrap">
			<h2>Opções do campi</h2>
			<form action="options.php" method="POST">
				<?php
					settings_fields('grupo-opcoes-campi');
					do_settings_sections('opcoes-campi');
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public static function callback_opcao_banner(){
		$opcoes = (array) get_option('opcoes-campi');
		$imagem_id = esc_attr($opcoes['banner']);

		$imagem_src = '';
		if(!empty($imagem_id)){
			$imagem = wp_get_attachment_image_src($imagem_id, 'banner');
			$imagem_src = $imagem[0];
		}

		global $_wp_additional_image_sizes;
		$tamanho_imagem = $_wp_additional_image_sizes['banner'];
		?>
		<div>
			<img src="<?= $imagem_src ?>">
			<div>
				<input type="hidden" name="opcoes-campi[banner]" id="opcoes-campi[banner]" value="<?= $imagem_id ?>">
				<button class="btn_upload_image" type="submit">Upload</button>
				<button class="btn_remove_image" type="submit">Remover</button>
				<br>
				Use imagens com as dimensões <?= $tamanho_imagem['width'] ?> por <?= $tamanho_imagem['height'] ?>.
			</div>
		</div>
		<?php
	}
	public static function registrar_menus(){
		register_nav_menu('menu_campus', 'Menu Campus');
	}

	public static function carregar_styles(){
		wp_enqueue_style('acesso_rapido' ,  plugin_dir_url(dirname(__FILE__)).'/styles/acesso_rapido.css');
	}

	public static function get_banner_url(){
		$opcoes = get_option('opcoes-campi');
		$banner_id = $opcoes['banner'];

		$banner_padrao = plugin_dir_url(dirname(__FILE__)) . 'images/banner-sem-imagem.png';

		if (empty($banner_id)) {
			return $banner_padrao;
		} else {
			return wp_get_attachment_image_src($banner_id, 'banner')[0];
		}
	}
}

