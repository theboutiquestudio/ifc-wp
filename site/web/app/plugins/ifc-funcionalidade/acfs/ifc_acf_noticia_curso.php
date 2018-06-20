<?php

class IFC_ACF_Noticia_Curso extends IFC_ACF {
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
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'noticia_curso',
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
