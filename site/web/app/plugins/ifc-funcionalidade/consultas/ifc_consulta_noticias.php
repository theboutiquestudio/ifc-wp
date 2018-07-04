<?php

class IFC_Consulta_Noticias {
	private const POST_TYPE_GERAL = 'noticia_geral';
	private const POST_TYPE_CAMPUS = 'noticia_campus';
	private const POST_TYPE_CURSO = 'noticia_curso';

	public static function get_noticias($limite=5, $apenas_destaque=false){
		global $wpdb;

		if (IFC_Func::is_current_site('geral')) {
			$n_gerais = self::get_noticias_gerais(array(
				'limite' => $limite,
				'apenas_destaque' => $apenas_destaque,
			));
			return $n_gerais;
		} else if (IFC_Func::is_current_site('campus')) {
			$n_gerais = self::get_noticias_gerais(array(
				'apenas_propagadas' => true,
				'apenas_destaque' => $apenas_destaque,
				'limite' => $limite,
			));
			$n_campus = self::get_noticias_campus(array(
				'site_id' => get_network()->id,
				'blog_id' => get_current_blog_id(),
				'apenas_destaque' => $apenas_destaque,
				'limite' => $limite,
			));
			return array_merge($n_gerais, $n_campus);
		} else if (IFC_Func::is_current_site('curso')) {
			$campus_id = $wpdb->get_row($wpdb->prepare(
				"SELECT campi_id FROM wp_ifc_cursos WHERE blog_id = %d",
				get_current_blog_id()
			))->campi_id;
			$campus = $wpdb->get_row($wpdb->prepare(
				"SELECT wp_blogs.site_id, wp_ifc_campi.blog_id FROM wp_ifc_campi JOIN wp_blogs ON (wp_blogs.blog_id = wp_ifc_campi.blog_id) where id = %d",
				$campus_id
			));

			$n_campus = self::get_noticias_campus(array(
				'site_id' => $campus->site_id,
				'blog_id' => $campus->blog_id,
				'apenas_propagadas' => true,
				'apenas_destaque' => $apenas_destaque,
				'limite' => $limite,
			));
			$n_curso = self::get_noticias_curso(array(
				'site_id' => get_network()->id,
				'blog_id' => get_current_blog_id(),
				'apenas_destaque' => $apenas_destaque,
				'limite' => $limite
			));
			return array_merge($n_campus, $n_curso);
		}
	}

	private static function get_noticias_gerais($args){
		$site_id = 1;
		$blog_id = get_main_site_id($site_id);
		switch_to_blog($blog_id);

		$apenas_propagadas = array_key_exists('apenas_propagadas', $args) && $args['apenas_propagadas'] === true;
		$apenas_destaque = array_key_exists('apenas_destaque', $args) && $args['apenas_destaque'] === true;

		$meta_query_propagar = array(
			'key' => 'propagar_para_todos_os_campi',
			'value' => '1',
			'compare' => '='
		);
		$meta_query_destaque = array(
			'key' => 'destaque',
			'value' => '1',
			'compare' => '='
		);

		$meta_queries = array();
		if ($apenas_propagadas) {
			array_push($meta_queries, $meta_query_propagar);
		}
		if ($apenas_destaque) {
			array_push($meta_queries, $meta_query_destaque);
		}

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_GERAL,
			'posts_per_page' => $args['limite'],
			'meta_query' => $meta_queries,
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
			$post->destaque = get_field('destaque', $post->ID) === '1';
			$post->propagar_para_todos_os_campi = get_field('propagar_para_todos_os_campi', $post->ID) === '1';
		}

		restore_current_blog();
		return $query->posts;
	}

	private static function get_noticias_campus($args){
		$site_id = $args['site_id'];
		$blog_id = $args['blog_id'];
		switch_to_blog($blog_id);

		$apenas_propagadas = array_key_exists('apenas_propagadas', $args) && $args['apenas_propagadas'] === true;
		$apenas_destaque = array_key_exists('apenas_destaque', $args) && $args['apenas_destaque'] === true;

		$meta_query_propagar = array(
			'key' => 'propagar_para_todos_os_cursos',
			'value' => '1',
			'compare' => '='
		);
		$meta_query_destaque = array(
			'key' => 'destaque',
			'value' => '1',
			'compare' => '='
		);

		$meta_queries = array();
		if ($apenas_propagadas) {
			array_push($meta_queries, $meta_query_propagar);
		}
		if ($apenas_destaque) {
			array_push($meta_queries, $meta_query_destaque);
		}

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_CAMPUS,
			'posts_per_page' => $args['limite'],
			'meta_query' => $meta_queries,
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
			$post->destaque = get_field('destaque', $post->ID) === '1';
			$post->propagar_para_todos_os_cursos = get_field('propagar_para_todos_os_cursos', $post->ID) === '1';
		}
		restore_current_blog();
		return $query->posts;
	}

	private static function get_noticias_curso($args){
		$site_id = $args['site_id'];
		$blog_id = $args['blog_id'];
		switch_to_blog($blog_id);

		$apenas_destaque = array_key_exists('apenas_destaque', $args) && $args['apenas_destaque'] === true;

		$meta_query_destaque = array(
			'key' => 'destaque',
			'value' => '1',
			'compare' => '='
		);

		$meta_queries = array();
		if ($apenas_destaque) {
			array_push($meta_queries, $meta_query_destaque);
		}

		$query = new WP_Query(array(
			'post_type' => self::POST_TYPE_CURSO,
			'posts_per_page' => $args['limite'],
			'meta_query' => $meta_queries,
		));

		foreach ($query->posts as $post) {
			$post->site_id = $site_id;
			$post->blog_id = $blog_id;
		}

		restore_current_blog();
		return $query->posts;
	}
}