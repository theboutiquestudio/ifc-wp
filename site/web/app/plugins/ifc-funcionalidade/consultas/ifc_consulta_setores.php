<?php

class IFC_Consulta_Setores {
	public static function get_setores_do_campi($campiId){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$setores = $wpdb->get_results($wpdb->prepare(
			"SELECT id, blog_id, campi_id, nome FROM {$prefixo}setores WHERE campi_id = %d ORDER BY nome",
			$campiId
		));

		foreach ($setores as $curso) {
			$curso->url = get_site_url($curso->blog_id);
		}

		return $setores;
	}
}