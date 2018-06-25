<?php

/**
 * Funcionalidade exclusiva dos sites de cursos:
 * bsi.ifc.edu.br, ctiadministracao.saofrancisco.ifc.edu.br, etc.
 */
class IFC_Func_Site_Curso implements IFC_iFunc{

	public function executar(){
		add_action('init', array(__CLASS__, 'registrar_custom_post_types'));
		add_action('init', array(__CLASS__, 'registrar_menus'));
		add_action('init', array(__CLASS__, 'registrar_custom_fields'));
		add_image_size('banner', 1170, 210);


		if(is_admin()){
			add_action('admin_enqueue_scripts', array(__CLASS__, 'carregar_scripts_admin'));
			add_action('admin_init', array(__CLASS__, 'registrar_opcoes_curso'));

			add_action('admin_menu', array(__CLASS__, 'adicionar_menus_admin'));
			add_action('admin_menu', array(__CLASS__, 'remover_menu_posts'));
			add_action('save_post', array(__CLASS__, '_salvar_meta_boxes'));
			add_action('add_meta_boxes', array(__CLASS__, 'adicionar_meta_boxes'));
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
		$sql = "CREATE TABLE {$prefixo}cursos (
			id int(11) NOT NULL auto_increment,
			blog_id bigint(20) NOT NULL,
			campi_id int(11) NOT NULL,
			nome varchar(200) NOT NULL,
			PRIMARY KEY  (id)
		) {$wpdb->get_charset_collate()}
		";
		dbDelta($sql);
	}

	private static function remover_tabelas(){
		global $wpdb;
		$tabelas = array(
			'cursos',
		);
		$prefixo = $wpdb->base_prefix . 'ifc_';
		foreach ($tabelas as $tabela) {
			$wpdb->query("DROP TABLE IF EXISTS ${prefixo}${tabela}");
		}
	}

	public static function adicionar_menus_admin(){
		add_menu_page(
			'Sobre o Curso',
			'Sobre o Curso',
			'edit_pages',
			'about_menu_page',
			array(__CLASS__, '_mostrar_menu_sobre_o_curso'),
			'dashicons-info',
			8
		);
		add_options_page(
			'Opções do curso',
			'Opções do curso',
			'manage_options',
			'opcoes-curso',
			array(__CLASS__, 'mostrar_menu_admin')
		);
	}

	public static function _mostrar_menu_sobre_o_curso(){
		if(isset($_POST['update_settings'])){
			update_option('about_text', $_POST['about_field']);
			update_option('info_text', $_POST['info_field']);
		}

		echo '
		<div class="wrap">
			' . screen_icon('themes') . ' <h2>Sobre o curso</h2>
			<form method="post" action="">
				<input type="hidden" name="update_settings" value="Y">
				<br /><br />
				<h3>Apresentação</h3>
		';
		wp_editor(get_option('about_text'), 'about_field', array(
			'media_buttons' => false,
			'textarea_rows' => 8,
		));
		echo '
				<br /><br />
				<h3>Informações</h3>
		';
		wp_editor(get_option('info_text'), 'info_field', array(
			'media_buttons' => false,
			'textarea_rows' => 5,
		));
		echo '
				<p class="submit">
					<input type="submit" value="Salvar" class="button-primary">
				</p>
			</form>
		</div>
		';
	}

	public static function remover_menu_posts(){
		remove_menu_page('edit.php');
	}

	public static function registrar_custom_post_types(){
		$post_types = array(
			'noticia_curso' => array(
				'labels' => array(
					'name' => 'Notícias',
					'singular_name' => 'Noticias',
					'all_items' =>  'Todas as notícias',
				),
			),
			'aviso_curso' => array(
				'labels' => array(
					'name' => 'Avisos',
					'singular_name' => 'Avisos',
					'all_items' =>  'Todos os avisos',
				),
			),
			'evento_curso' => array (
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
		);

		foreach ($post_types as $post_type_key => $custom_args) {
			register_post_type($post_type_key, array_merge($default_args, $custom_args));
		}
	}
		public static function registrar_custom_fields(){
		$grupos = array_merge(
			IFC_ACF_Noticia_Curso::getGrupos(),
			IFC_ACF_Evento_Curso::getGrupos()
		);

		foreach ($grupos as $grupo) {
			register_field_group($grupo);
		}
	}

	public static function adicionar_meta_boxes(){
		add_meta_box(
			'destaque_meta_box',
			'Destaque',
			array(__CLASS__, '_destaque_meta_box_callback'),
			'news',
			'side'
		);
		add_meta_box(
			'propagacao_meta_box',
			'Propagação',
			array(__CLASS__, '_propagacao_meta_box_callback'),
			'news',
			'side'
		);
	}


	public static function _destaque_meta_box_callback($post){
		wp_nonce_field('noticia_meta_box', 'noticia_meta_box_nonce');

		$value = get_post_meta($post->ID, 'destaque_portal', true);

		echo '<label for="destaque_field">';

		if ($value) {
			echo '<input type="checkbox" id="destaque_field" name="destaque_field" checked="checked" />';
		} else {
			echo '<input type="checkbox" id="destaque_field" name="destaque_field" />';
		}

		echo 'Marque se for destaque';
		echo '</label> ';
	}

	public static function _propagacao_meta_box_callback($post){
		wp_nonce_field('noticia_meta_box', 'noticia_meta_box_nonce');

		$value = get_post_meta($post->ID, 'noticia_portal', true);

		echo '<label for="propagacao_portal_field">';

		if ($value) {
			echo '<input type="checkbox" id="propagacao_portal_field" name="propagacao_portal_field" checked="checked" />';
		} else {
			echo '<input type="checkbox" id="propagacao_portal_field" name="propagacao_portal_field" />';
		}

		echo 'Marque se for notícia no portal de notícias';
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

		/* OK, it's safe for us to save the data now. */

		$destaque = $_POST['destaque_field'] == 'on';
		$propagacao_portal = $_POST['propagacao_portal_field'] == 'on';

		update_post_meta($post_id, 'destaque_portal', $destaque);
		update_post_meta($post_id, 'noticia_portal', $propagacao_portal);
	}


	public static function carregar_scripts_admin(){
		wp_enqueue_media();
		wp_enqueue_script('admin_upload_imagem', plugin_dir_url(dirname(__FILE__)) . '/scripts/admin_upload_imagem.js', array('jquery'));
	}

	public static function registrar_menus(){
		register_nav_menu('menu_curso', 'menu curso');
	}

	public static function registrar_opcoes_curso(){
		register_setting('grupo-opcoes-curso', 'opcoes-curso');
		add_settings_section('default', null, null, 'opcoes-curso');
		add_settings_field('banner', 'Banner', array(__CLASS__, 'callback_opcao_banner'), 'opcoes-curso', 'default');
	}

	public static function mostrar_menu_admin(){
		?>
		<div class="wrap">
			<h2>Opções do curso</h2>
			<form action="options.php" method="POST">
				<?php
					settings_fields('grupo-opcoes-curso');
					do_settings_sections('opcoes-curso');
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public static function callback_opcao_banner(){
		$opcoes = (array) get_option('opcoes-curso');
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
				<input type="hidden" name="opcoes-curso[banner]" id="opcoes-curso[banner]" value="<?= $imagem_id ?>">
				<button class="btn_upload_image" type="submit">Upload</button>
				<button class="btn_remove_image" type="submit">Remover</button>
				<br>
				Use imagens com as dimensões <?= $tamanho_imagem['width'] ?> por <?= $tamanho_imagem['height'] ?>.
			</div>
		</div>
		<?php
	}

	public static function get_banner_url(){
		$opcoes = get_option('opcoes-curso');
		$banner_id = $opcoes['banner'];

		$banner_padrao = plugin_dir_url(dirname(__FILE__)) . 'images/banner-sem-imagem.png';

		if (empty($banner_id)) {
			return $banner_padrao;
		} else {
			return wp_get_attachment_image_src($banner_id, 'banner')[0];
		}
	}

	public static function get_id_atual(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		static $cache_id;

		if (!isset($cache_id)) {
			$cache_id = $wpdb->get_row($wpdb->prepare(
				"SELECT id FROM {$prefixo}cursos WHERE blog_id = %d",
				get_current_blog_id()
			))->id;
		}

		return $cache_id;
	}
}
