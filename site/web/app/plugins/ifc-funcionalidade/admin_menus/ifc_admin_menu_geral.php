<?php

class IFC_Admin_Menu_Geral {

	public static function registrar() {
		add_action('admin_enqueue_scripts', array(__CLASS__, '_carregar_script'));
		add_action('admin_menu', array(__CLASS__, '_registrar'));
		register_setting('grupo-opcoes-gerais', 'opcoes-gerais');
		add_settings_section('imagens-perfis', 'Imagens dos perfis', array(__CLASS__, 'mostrar_descricao_section_imagens_perfis'), 'opcoes-gerais');

		$gerar_callback = function($nome){
			return function() use($nome) {
				self::callback_imagem_perfil($nome);
			};
		};
		add_settings_field('imagem-perfil-ingressante', 'Ingressante', $gerar_callback('ingressante'), 'opcoes-gerais', 'imagens-perfis');
		add_settings_field('imagem-perfil-aluno', 'Aluno', $gerar_callback('aluno'), 'opcoes-gerais', 'imagens-perfis');
		add_settings_field('imagem-perfil-servidor', 'Servidor', $gerar_callback('servidor'), 'opcoes-gerais', 'imagens-perfis');
		add_settings_field('imagem-perfil-comunidade', 'Comunidade', $gerar_callback('comunidade'), 'opcoes-gerais', 'imagens-perfis');
	}

	public static function _carregar_script(){
		wp_enqueue_media();
		wp_enqueue_script('admin_upload_imagem', plugin_dir_url(dirname(__FILE__)) . 'scripts/admin_upload_imagem.js', array('jquery'));
	}

	public static function _registrar(){
		add_options_page(
			'Opções gerais',
			'Opções gerais',
			'manage_options',
			'opcoes-gerais',
			array(__CLASS__, 'mostrar_menu_admin')
		);
	}

	public static function mostrar_menu_admin(){
		?>
		<div class="wrap">
			<h2>Opções gerais</h2>
			<form action="options.php" method="POST">
				<?php
					settings_fields('grupo-opcoes-gerais');
					do_settings_sections('opcoes-gerais');
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public static function mostrar_descricao_section_imagens_perfis(){
		global $_wp_additional_image_sizes;
		$tamanho_imagem = $_wp_additional_image_sizes['perfil'];
		echo "
			Imagens para o menu de perfis da página inicial.<br/>
			Use imagens quadradas com dimensões próximas a {$tamanho_imagem['width']} por {$tamanho_imagem['height']}.
		";
	}

	public static function callback_imagem_perfil($nome){
		$opcoes = (array) get_option('opcoes-gerais');
		$nome_opcao = "imagem-perfil-{$nome}";
		$imagem_id = esc_attr($opcoes[$nome_opcao]);

		$imagem_src = '';
		if(!empty($imagem_id)){
			$imagem = wp_get_attachment_image_src($imagem_id, 'perfil');
			$imagem_src = $imagem[0];
		}

		?>
		<div>
			<img src="<?= $imagem_src ?>">
			<div>
				<input type="hidden" name="opcoes-gerais[<?= $nome_opcao ?>]" id="opcoes-gerais[<?= $nome_opcao ?>]" value="<?= $imagem_id ?>">
				<button class="btn_upload_image" type="submit">Upload</button>
				<button class="btn_remove_image" type="submit">Remover</button>
			</div>
		</div>
		<?php
	}
}