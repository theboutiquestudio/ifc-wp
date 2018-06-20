<?php

class IFC_Consulta_Avisos {
	private const POST_TYPE_GERAL = 'aviso_geral';
	private const POST_TYPE_CAMPUS = 'aviso_campus';
	private const POST_TYPE_CURSO = 'aviso_curso';

	public static function get_avisos($limite=5){
		global $wpdb;

		if (IFC_Func::is_current_site('geral')) {
			$a_gerais = self::get_avisos_gerais(array(
				'limite' => $limite,
			));
			return $a_gerais;
		} else if (IFC_Func::is_current_site('campus')) {
			$a_gerais = self::get_avisos_gerais(array(
				'apenas_propagados' => true,
				'limite' => $limite,
			));
			$a_campus = self::get_avisos_campus(array(
				'site_id' => get_network()->id,
				'blog_id' => get_current_blog_id(),
				'limite' => $limite,
			));
			return array_merge($a_gerais, $a_campus);
		} else if (IFC_Func::is_current_site('curso')) {
			$campus_id = $wpdb->get_row($wpdb->prepare(
				"SELECT campi_id FROM wp_ifc_cursos WHERE blog_id = %d",
				get_current_blog_id()
			))->campi_id;
			$campus = $wpdb->get_row($wpdb->prepare(
				"SELECT wp_blogs.site_id, wp_ifc_campi.blog_id FROM wp_ifc_campi JOIN wp_blogs ON (wp_blogs.blog_id = wp_ifc_campi.blog_id) where id = %d",
				$campus_id
			));

			$a_campus = self::get_avisos_campus(array(
				'site_id' => $campus->site_id,
				'blog_id' => $campus->blog_id,
				'apenas_propagados' => true,
				'limite' => $limite,
			));
			$a_curso = self::get_avisos_curso(array(
				'site_id' => get_network()->id,
				'blog_id' => get_current_blog_id(),
				'limite' => $limite
			));
			return array_merge($a_campus, $a_curso);
		}
	}

	private static function get_avisos_gerais($args){
		$site_id = 1;
		$blog_id = get_main_site_id($site_id);
		switch_to_blog($blog_id);

		$apenas_propagados = array_key_exists('apenas_propagados', $args) && $args['apenas_propagados'] === true;

		$meta_query_propagar = array(
			'key' => 'propagar_para_todos_os_campi',
			'value' => '1',
			'compare' => '='
		);

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_GERAL,
			'posts_per_page' => $args['limite'],
			'meta_query' => $apenas_propagados ? array($meta_query_propagar) : null,
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
			$post->destaque = get_field('destaque', $post->id);
			$post->propagar_para_todos_os_campi = get_field('propagar_para_todos_os_campi', $post->id);
		}

		restore_current_blog();
		return $query->posts;
	}

	private static function get_avisos_campus($args){
		$site_id = $args['site_id'];
		$blog_id = $args['blog_id'];
		switch_to_blog($blog_id);

		$apenas_propagados = array_key_exists('apenas_propagados', $args) && $args['apenas_propagados'] === true;

		$meta_query_propagar = array(
			'key' => 'propagar_para_todos_os_cursos',
			'value' => '1',
			'compare' => '='
		);

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_CAMPUS,
			'posts_per_page' => $args['limite'],
			'meta_query' => $apenas_propagados ? array($meta_query_propagar) : null,
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
			$post->destaque = get_field('destaque', $post->id);
			$post->propagar_para_todos_os_cursos = get_field('propagar_para_todos_os_cursos', $post->id);
		}
		restore_current_blog();
		return $query->posts;
	}

	private static function get_avisos_curso($args){
		$site_id = $args['site_id'];
		$blog_id = $args['blog_id'];
		switch_to_blog($blog_id);

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_CURSO,
			'posts_per_page' => $args['limite'],
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
		}

		restore_current_blog();
		return $query->posts;
	}
}