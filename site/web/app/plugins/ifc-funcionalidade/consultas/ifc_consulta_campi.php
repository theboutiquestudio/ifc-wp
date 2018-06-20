<?php

class IFC_Consulta_Campi {
	public static function get_campi(){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		$campi = $wpdb->get_results("SELECT id, blog_id, nome FROM {$prefixo}campi ORDER BY nome");

		foreach ($campi as $campus) {
			$campus->url = get_site_url($campus->blog_id);
		}

		return $campi;
	}
}