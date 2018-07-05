<?php

class IFC_Consulta_Setores {
	public static function get_setores_da_network($networkId, $limite=0){
		global $wpdb;
		$prefixo = $wpdb->base_prefix . 'ifc_';

		if ($limite !== 0){
			$setores = $wpdb->get_results($wpdb->prepare(
				"SELECT id, blog_id, network_id, nome FROM {$prefixo}setores WHERE network_id = %d ORDER BY nome LIMIT %d",
				$networkId,
				$limite
			));
		} else {
			$setores = $wpdb->get_results($wpdb->prepare(
				"SELECT id, blog_id, network_id, nome FROM {$prefixo}setores WHERE network_id = %d ORDER BY nome",
				$networkId
			));
		}
		foreach ($setores as $setor) {
			$setor->url = get_site_url($setor->blog_id);
		}

		return $setores;
	}
}