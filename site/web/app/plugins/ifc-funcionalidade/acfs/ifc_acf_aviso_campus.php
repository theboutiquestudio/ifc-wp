<?php

class IFC_ACF_Aviso_Campus extends IFC_ACF{
	public static function getGrupos(){
		return array(
			array(
				'id' => 'acf_aviso_opcional',
				'title' => 'Aviso_opcional',
				'fields' => array(
					array(
						'key' => 'acf_aviso_propagar_para_todos_os_cursos',
						'label' => 'Propagar para todos os cursos?',
						'name' => 'propagar_para_todos_os_cursos',
						'type' => 'true_false',
						'message' => 'Selecione para propagar para todos os cursos',
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'aviso_campus',
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
