<?php

class IFC_ACF_Evento_Curso extends IFC_ACF{
	public static function getGrupos(){
		return array(
			array(
				'id' => 'acf_evento_opcionais_curso',
				'title' => 'Evento_opcionais',
				'fields' => array(
					array(
						'key' => 'acf_evento_data_de_inicio',
						'label' => 'Data de início',
						'name' => 'data_de_inicio',
						'type' => 'date_picker',
						'instructions' => 'Selecione a data de início',
						'required' => 1,
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
					array(
						'key' => 'acf_evento_data_do_termino',
						'label' => 'Data do término',
						'name' => 'data_do_termino',
						'type' => 'date_picker',
						'instructions' => 'Selecione a data de término do evento',
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'evento_curso',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'no_box',
					'hide_on_screen' => array(
					),
				),
				'menu_order' => 0,
			)
		);
	}
}
