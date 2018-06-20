<?php

class IFC_Walker_Off_Canvas extends Walker_Nav_Menu {

	private $id_item_atual = 0;

	public function start_lvl(&$output, $depth=0, $args=array()){
		$output .= '
		<ul id="collapse-' . $this->id_item_atual . '" class="list-unstyled collapse off-canvas-sub-menu">
		';
	}

	public function end_lvl(&$output, $depth=0, $args=array()){
		$output .= '</ul>';
	}

	public function start_el(&$output, $item, $depth=0, $args=array(), $id=0){
		$this->id_item_atual = $item->ID;

		$output .= '<li>';

		if ($args->walker->has_children){
			$output .= '
			<a class="collapsible" href="#collapse-' . $item->ID . '" data-toggle="collapse" data-parent="#accordion-off-canvas">
			' . $item->title . '&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
			</a>
			';
		} else {
			$output .= '
			<a href="' . $item->url . '">' . $item->title . '</a>
			';
		}
	}

	public function end_el(&$output, $item, $depth=0, $args=array()){
		$output .= '</li>';
	}
}
