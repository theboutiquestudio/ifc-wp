<?php

class IFC_Consulta_Departamentos {
	public static function get_departamentos_do_campi($campiId){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$departamentos = $wpdb->get_results($wpdb->prepare(
			"SELECT id, blog_id, campi_id, nome FROM {$prefixo}departamentos WHERE campi_id = %d ORDER BY nome",
			$campiId
		));

		foreach ($departamentos as $curso) {
			$curso->url = get_site_url($curso->blog_id);
		}

		return $departamentos;
	}
}