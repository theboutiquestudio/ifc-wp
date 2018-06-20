<?php


class IFC_ACF_Agenda_Geral extends IFC_ACF {
	public static function getGrupos() {
		return array(
			array(
				'id' => 'acf_agenda_opcionais',
				'title' => 'Agenda_opcionais',
				'fields' => array(
					array(
						'key' => 'acf_agenda_data_de_inicio',
						'label' => 'Data de início',
						'name' => 'data_de_inicio',
						'type' => 'date_picker',
						'instructions' => 'Selecione a data de início',
						'required' => 1,
						'date_format' => 'ddmmyy',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
					array(
						'key' => 'acf_agenda_data_de_termino',
						'label' => 'Data de término',
						'name' => 'data_de_termino',
						'type' => 'date_picker',
						'instructions' => 'Selecione a data de término',
						'date_format' => 'ddmmyy',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'agenda_reitor',
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
