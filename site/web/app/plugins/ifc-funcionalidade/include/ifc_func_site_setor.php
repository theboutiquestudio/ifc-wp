<?php

/**
 * Funcionalidade exclusiva dos sites de setores:
 * dti.ifc.edu.br, cecom.araquari.ifc.edu.br, etc.
 */
class IFC_Func_Site_Setor implements IFC_iFunc{

	public function executar(){}

	public static function ativarGlobal(){
		self::criar_tabelas();
	}

	public static function ativarEmSite(){
		self::criar_paginas_padrao();
	}

	public static function desativarGlobal(){
		self::remover_tabelas();
	}

	public static function desativarEmSite(){}


	private static function criar_tabelas(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$sql = "CREATE TABLE {$prefixo}setores (
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
			'setores',
		);
		$prefixo = $wpdb->base_prefix . 'ifc_';
		foreach ($tabelas as $tabela) {
			$wpdb->query("DROP TABLE IF EXISTS ${prefixo}${tabela}");
		}
	}



	public static function criar_paginas_padrao(){
		$paginas = array(
			array(
				'post_title' => 'Página Inicial',
				'post_content' => '*** Página sem Conteúdo ***',
				'page_template' => 'page-front-page.php',
			),
		);

		$parametros_padrao = array(
			'post_type' => 'page',
			'post_status' => 'publish',
		);

		foreach ($paginas as $pagina) {
			$pagina_existente = get_page_by_title($pagina['post_title']);
			$precisa_ser_criada = $existente === null || $existente->post_status === 'trash';

			if ($precisa_ser_criada){
				wp_insert_post(array_merge($parametros_padrao, $pagina));
			}
		}
	}

	public static function listar_categorias(){
		foreach (get_the_category() as $category) {
			echo '
			<a href="' . get_category_link($category->cat_ID) . '">
				<span class="label label-primary">' . $category->cat_name . '</span>
			</a>&nbsp;&nbsp;
			';
		}
	}

	public static function get_id_atual(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		static $cache_id;

		if (!isset($cache_id)) {
			$cache_id = $wpdb->get_row($wpdb->prepare(
				"SELECT id FROM {$prefixo}setores WHERE blog_id = %d",
				get_current_blog_id()
			))->id;
		}

		return $cache_id;
	}
}

