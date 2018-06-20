<?php

class IFC_ACF_Noticia_Campus extends IFC_ACF {
	public static function getGrupos() {
		return array(
			array(
				'title' => 'Notícia (opcionais)',
				'fields' => array(
					array(
						'key' => 'acf_noticia_thumbnail',
						'label' => 'Thumbnail',
						'name' => 'thumbnail',
						'type' => 'image',
						'required' => 1,
						'save_format' => 'id',
						'min-width' => 230,
						'min-height' => 136,
					),
					array(
						'key' => 'acf_noticia_destaque',
						'label' => 'É destaque?',
						'name' => 'destaque',
						'type' => 'true_false',
						'message' => 'Selecione para que seja destaque',
						'default_value' => '',
						'layout' => 'vertical',
					),
					array(
						'key' => 'acf_noticia_propagar_para_todos_os_cursos',
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
							'value' => 'noticia_campus',
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
			),
		);
	}
}
