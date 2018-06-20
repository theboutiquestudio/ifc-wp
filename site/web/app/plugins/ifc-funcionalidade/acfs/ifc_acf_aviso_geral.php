<?php

class IFC_ACF_Aviso_Geral extends IFC_ACF{
	public static function getGrupos(){
		return array(
			array(
				'id' => 'acf_aviso_opcional',
				'title' => 'Aviso_opcional',
				'fields' => array(
					array(
						'key' => 'acf_aviso_propagar_para_todos_os_campi',
						'label' => 'Propagar para todos os campi?',
						'name' => 'propagar_para_todos_os_campi',
						'type' => 'true_false',
						'message' => 'Selecione para propagar para todos os campi',
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'aviso_geral',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'no_box',
				),
				'menu_order' => 0,
			)
		);
	}
}
