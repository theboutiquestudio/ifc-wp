<?php

class IFC_Consulta_Cursos {
	public static function get_cursos_do_campi($campiId){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$cursos = $wpdb->get_results($wpdb->prepare(
			"SELECT id, blog_id, campi_id, nome FROM {$prefixo}cursos WHERE campi_id = %d ORDER BY nome",
			$campiId
		));

		foreach ($cursos as $curso) {
			$curso->url = get_site_url($curso->blog_id);
		}

		return $cursos;
	}
}