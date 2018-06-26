<?php

class IFC_Admin_Menu_Sites {
	public static function registrar() {
		add_action('admin_enqueue_scripts', array(__CLASS__, '_carregar_script'));
		add_action('network_admin_menu', array(__CLASS__, '_registrar'));
		add_action('admin_post_ifc_admin_menu_sites', array(__CLASS__, 'salvar'));
	}

	public static function _registrar() {
		add_menu_page(
			'Sites IFC',
			'Sites IFC',
			'manage_sites',
			'ifc',
			array(__CLASS__, 'mostrar'),
			'dashicons-admin-generic',
			4
		);
	}

	public static function _carregar_script() {
		wp_enqueue_media();
		wp_enqueue_script('admin_menu_sites', plugin_dir_url(dirname(__FILE__)) . '/scripts/admin_menu_sites.js', array('jquery'));
		wp_enqueue_style('admin_menu_sites', plugin_dir_url(dirname(__FILE__)) . '/styles/admin_menu_sites.css');
	}

	private static function get_campi_nao_relacionados() {
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$ids_sites_campi_atuais = $wpdb->get_col(
			"SELECT blog_id FROM {$prefixo}campi"
		);

		$get_main_sites = function($network){
			return $network->blog_id;
		};
		$ids_main_sites = array_map($get_main_sites, get_networks());

		$remove_current_site_id = function($id) {
			return $id != get_network()->id;
		};
		$ids_main_sites = array_filter($ids_main_sites, $remove_current_site_id);

		if (empty($ids_main_sites)){
			$ids_nao_relacionados = array();
		} else if (empty($ids_sites_campi_atuais)){
			$ids_nao_relacionados = $ids_main_sites;
		} else {
			$ids_nao_relacionados = array_diff($ids_main_sites, $ids_sites_campi_atuais);
		}


		$wp_site_from_id = function($id) {
			return WP_Site::get_instance($id);
		};
		return array_map($wp_site_from_id, $ids_nao_relacionados);
	}

	private static function get_sites_nao_relacionados() {
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$ids_sites_nao_relacionados = $wpdb->get_col($wpdb->prepare(
			"SELECT blog_id FROM {$wpdb->base_prefix}blogs
			 WHERE site_id = %d
			 AND blog_id != %d
			 AND blog_id not IN (
			 	SELECT blog_id FROM {$prefixo}cursos
			 	UNION
			 	SELECT blog_id FROM {$prefixo}setores
			 )
			 ORDER BY registered DESC",
			 get_network()->id, get_current_blog_id()
		));
		$wp_site_from_id = function($id) {
			return WP_Site::get_instance($id);
		};
		return array_map($wp_site_from_id, $ids_sites_nao_relacionados);
	}

	private static function get_campi(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		return $wpdb->get_results(
			"SELECT id, blog_id, nome FROM {$prefixo}campi ORDER BY nome"
		);
	}

	private static function get_cursos_do_campus(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		return $wpdb->get_results($wpdb->prepare(
			"SELECT id, blog_id, nome FROM {$prefixo}cursos WHERE campi_id=%d ORDER BY nome",
			$wpdb->get_row($wpdb->prepare(
				"SELECT id FROM {$prefixo}campi WHERE blog_id=%d",
				get_main_site_id()
			))->id
		));
	}

	private static function get_setores_do_campus() {
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		return $wpdb->get_results($wpdb->prepare(
			"SELECT id, blog_id, nome FROM {$prefixo}setores WHERE campi_id=%d ORDER BY nome",
			$wpdb->get_row($wpdb->prepare(
				"SELECT id FROM {$prefixo}campi WHERE blog_id=%d",
				get_main_site_id()
			))->id
		));
	}

	public static function mostrar() {
		?>
		<div class="wrap sites-ifc">
			<h2 class="sites-ifc-title">
				<span>Sites IFC</span>
				<img src="<?= admin_url('/images/spinner.gif') ?>", id="sites_ifc_spinner"></img>
			</h2>
			<form action="<?= admin_url('admin-post.php'); ?>" onsubmit="return submeterForm()">
				<?php if (IFC_Func::is_current_site('geral')): ?>
				<h3><i>Campi</i></h3>
				<?php self::mostrarCampi() ?>
				<?php endif ?>
				<?php if (IFC_Func::is_current_site('campus')): ?>
				<h3>Cursos</h3>
				<?php self::mostrarCursos() ?>
				<?php endif ?>
				<h3>Setores</h3>
				<?php self::mostrarSetores() ?>
			</form>
		</div>
		<?php
	}

	private static function mostrarCampi() {
		$sites = self::get_campi_nao_relacionados();
		$campi = self::get_campi();
		?>
		<div class="campi box">
			<?php if (!empty($sites)): ?>
				<div class="input-group">
					<label for="novo_campus">Selecione um novo site</label>
					<select id="novo_campus" name="novo_campus">
						<?php foreach($sites as $site): ?>
						<option value="<?= $site->blog_id ?>"><?= $site->blogname ?></option>
						<?php endforeach ?>
					</select>
					<button type="button" onclick="adicionarCampus(this)">Adicionar <i>campus</i></button>
				</div>
			<?php else: ?>
				<div>(Nenhum novo campus disponível.)</div>
			<?php endif ?>
			<p class="titulo-lista"><i>Campi</i> atuais</p>
			<ul id="lista_campi" class="lista">
				<?php foreach($campi as $campus): ?>
					<li class="item campus" data-id="<?= $campus->blog_id ?>">
						<button type="button" class="deletar" onclick="deletarItem(event)"><span class="dashicons dashicons-no"></span></button>
						<div class="nome"><?= $campus->nome ?></div>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php
	}

	private static function mostrarCursos() {
		$sites = self::get_sites_nao_relacionados();
		$cursos = self::get_cursos_do_campus();
		?>
		<div class="cursos box">
			<?php if (!empty($sites)): ?>
				<div class="input-group">
					<label for="novo_curso">Selecione um novo site</label>
					<select id="novo_curso" name="novo_curso">
						<?php foreach($sites as $site): ?>
						<option value="<?= $site->blog_id ?>"><?= $site->blogname ?></option>
						<?php endforeach ?>
					</select>
					<button type="button" onclick="adicionarCurso(this)">Adicionar curso</button>
				</div>
			<?php else: ?>
				<div>(Nenhum novo curso disponível.)</div>
			<?php endif ?>
			<p class="titulo-lista">Cursos atuais</p>
			<ul id="lista_cursos" class="lista">
				<?php foreach($cursos as $curso): ?>
					<li class="item curso" data-id="<?= $curso->blog_id ?>">
						<button type="button" class="deletar" onclick="deletarItem(event)"><span class="dashicons dashicons-no"></span></button>
						<div class="nome"><?= $curso->nome ?></div>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php
	}

	private static function mostrarSetores() {
		$sites = self::get_sites_nao_relacionados();
		$setores = self::get_setores_do_campus();
		?>
		<div class="setores box">
			<?php if (!empty($sites)): ?>
				<div class="input-group">
					<label for="novo_setor">Selecione um novo site</label>
					<select id="novo_setor" name="novo_setor">
						<?php foreach($sites as $site): ?>
						<option value="<?= $site->blog_id ?>"><?= $site->blogname ?></option>
						<?php endforeach ?>
					</select>
					<button type="button" onclick="adicionarSetor(this)">Adicionar setor</button>
				</div>
			<?php else: ?>
				<div>(Nenhum novo setor disponível.)</div>
			<?php endif ?>
			<p class="titulo-lista">Setores atuais</p>
			<ul id="lista_setores" class="lista">
				<?php foreach($setores as $setor): ?>
					<li class="item setor" data-id="<?= $setor->blog_id ?>">
						<button type="button" class="deletar" onclick="deletarItem(event)"><span class="dashicons dashicons-no"></span></button>
						<div class="nome"><?= $setor->nome ?></div>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php
	}

	public static function salvar(){
		if (!empty($_POST['campi'])) {
			$campiNovos = array_map('intval', $_POST['campi']);
		} else {
			$campiNovos = array();
		}
		if (!empty($_POST['cursos'])) {
			$cursosNovos = array_map('intval', $_POST['cursos']);
		} else {
			$cursosNovos = array();
		}
		if (!empty($_POST['setores'])) {
			$setoresNovos = array_map('intval', $_POST['setores']);
		} else {
			$setoresNovos = array();
		}

		if (IFC_Func::is_current_site('geral')) {
			self::salvarCampi($campiNovos);
		}
		if (IFC_Func::is_current_site('campus')) {
			self::salvarCursos($cursosNovos);
		}
		self::salvarSetores($setoresNovos);
	}

	private static function salvarCampi($campiNovosIds){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$get_blog_id_from_campus = function($campus) {
			return $campus->blog_id;
		};
		$campiAtuais = array_map($get_blog_id_from_campus, self::get_campi());

		foreach ($campiNovosIds as $campusNovoId) {
			$campusNovoNome = get_sites(array('ID' => $campusNovoId))[0]->blogname;
			if (in_array($campusNovoId, $campiAtuais)){
				$wpdb->update(
					"{$prefixo}campi",
					array("nome" => $campusNovoNome),
					array("blog_id" => $campusNovoId),
					array('%s'),
					array('%d')
				);
			} else {
				$wpdb->insert(
					"{$prefixo}campi",
					array(
							"blog_id" => $campusNovoId,
							"nome" => $campusNovoNome,
					),
					array('%d', '%s')
				);
			}
		}

		foreach ($campiAtuais as $campusAtualId) {
			if (!in_array($campusAtualId, $campiNovosIds)){
				$campusAtualIdBanco = $wpdb->get_row($wpdb->prepare(
					"SELECT id FROM {$prefixo}campi WHERE blog_id = %d",
					$campusAtualId
				))->id;
				$wpdb->delete(
					"{$prefixo}campi",
					array("blog_id" => $campusAtualId),
					array("%d")
				);
				$wpdb->delete(
					"{$prefixo}cursos",
					array("campi_id" => $campusAtualIdBanco),
					array("%d")
				);
				$wpdb->delete(
					"{$prefixo}setores",
					array("campi_id" => $campusAtualIdBanco),
					array("%d")
				);
			}
		}
	}

	private static function salvarCursos($cursosNovosIds){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$campusId = get_main_site_id();
		$campusIdBanco = $wpdb->get_row($wpdb->prepare(
			"SELECT id FROM {$prefixo}campi WHERE blog_id = %d",
			$campusId
		))->id;

		$get_blog_id_from_curso = function($curso) {
			return $curso->blog_id;
		};
		$cursosAtuais = array_map($get_blog_id_from_curso, self::get_cursos_do_campus());

		foreach ($cursosNovosIds as $cursoNovoId) {
			$cursoNovoNome = get_sites(array('ID' => $cursoNovoId))[0]->blogname;
			if (in_array($cursoNovoId, $cursosAtuais)){
				$wpdb->update(
					"{$prefixo}cursos",
					array("nome" => $cursoNovoNome),
					array("blog_id" => $cursoNovoId),
					array('%s'),
					array('%d')
				);
			} else {
				$wpdb->insert(
					"{$prefixo}cursos",
					array(
						"blog_id" => $cursoNovoId,
						"campi_id" => $campusIdBanco,
						"nome" => $cursoNovoNome,
					),
					array('%d', '%d', '%s')
				);
			}
		}
		foreach ($cursosAtuais as $cursoAtualId) {
			if (!in_array($cursoAtualId, $cursosNovosIds)){
				$wpdb->delete(
					"{$prefixo}cursos",
					array("blog_id" => $cursoAtualId),
					array("%d")
				);
			}
		}
	}

	private static function salvarSetores($setoresNovosIds){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$campusId = get_main_site_id();
		$campusIdBanco = $wpdb->get_row($wpdb->prepare(
			"SELECT id FROM {$prefixo}campi WHERE blog_id = %d",
			$campusId
		))->id;

		$get_blog_id_from_setor = function($setor) {
			return $setor->blog_id;
		};
		$setoresAtuais = array_map($get_blog_id_from_setor, self::get_setores_do_campus());

		foreach ($setoresNovosIds as $setorNovoId) {
			$setorNovoNome = get_sites(array('ID' => $setorNovoId))[0]->blogname;
			if (in_array($setorNovoId, $setoresAtuais)){
				$wpdb->update(
					"{$prefixo}setores",
					array("nome" => $setorNovoNome),
					array("blog_id" => $setorNovoId),
					array('%s'),
					array('%d')
				);
			} else {
				$wpdb->insert(
					"{$prefixo}setores",
					array(
						"blog_id" => $setorNovoId,
						"campi_id" => $campusIdBanco,
						"nome" => $setorNovoNome,
					),
					array('%d', '%d', '%s')
				);
			}
		}
		foreach ($setoresAtuais as $setorAtualId) {
			if (!in_array($setorAtualId, $setoresNovosIds)){
				$wpdb->delete(
					"{$prefixo}setores",
					array("blog_id" => $setorAtualId),
					array("%d")
				);
			}
		}
	}
}