<?php

class IFC_Breadcrumbs {
	public static function mostrar(){
		global $post;

		$separador = " > ";

		$tipo_site = IFC_Func::get_tipo_site_atual();

		echo self::get_link_home();

		if ($tipo_site === 'geral'){
			// TODO: Portais
		} elseif ($tipo_site === 'campus') {
			echo $separador;
			echo self::get_link_campus();
		} elseif ($tipo_site === 'setor') {
			if (IFC_Func::get_id_campus_atual() !== null) {
				echo $separador;
				echo self::get_link_campus();
			}
			echo $separador;
			echo self::get_link_setor();
		} elseif ($tipo_site === 'curso') {
			echo $separador;
			echo self::get_link_campus();
			echo $separador;
			echo self::get_link_curso();
		} else {
			echo $separador;
			echo get_option('blogname');
		}

		if (is_single()){
			echo $separador;
			echo self::get_link_post_type();
			echo $separador;
			the_title();
		} elseif (is_page()){
			echo $separador;
			the_title();
		} elseif (is_archive()){
			echo $separador;
			echo self::get_link_post_type();
		}
	}

	private static function fazer_link($url, $texto){
		return "<a href=\"{$url}\">{$texto}</a>";
	}

	private static function get_link_home(){
		switch_to_blog(get_main_site_id(get_main_network_id()));
		$link = self::fazer_link(get_option('home'), 'Página inicial');
		restore_current_blog();
		return $link;
	}

	private static function get_link_campus(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$campus = $wpdb->get_row($wpdb->prepare(
			"SELECT blog_id, nome FROM {$prefixo}campi WHERE id = %d",
			IFC_Func::get_id_campus_atual()
		));
		switch_to_blog($campus->blog_id);
		$link = self::fazer_link(get_option('home'), 'Portal do <i>campus</i> ' . $campus->nome);
		restore_current_blog();
		return $link;
	}

	private static function get_link_setor(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$setor = $wpdb->get_row($wpdb->prepare(
			"SELECT blog_id, nome FROM {$prefixo}setores WHERE id = %d",
			IFC_Func_Site_Setor::get_id_atual()
		));
		switch_to_blog($setor->blog_id);
		return self::fazer_link(get_option('home'), $setor->nome);
		restore_current_blog();
	}

	private static function get_link_curso(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';
		$curso = $wpdb->get_row($wpdb->prepare(
			"SELECT blog_id, nome FROM {$prefixo}cursos WHERE id = %d",
			IFC_Func_Site_Curso::get_id_atual()
		));
		switch_to_blog($curso->blog_id);
		return self::fazer_link(get_option('home'), $curso->nome);
		restore_current_blog();
	}

	private static function get_link_post_type(){
		global $post;
		$post_type = get_post_type();
		return self::fazer_link(get_post_type_archive_link($post_type), get_post_type_object($post_type)->labels->singular_name);
	}
}