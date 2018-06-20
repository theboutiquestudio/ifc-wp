<?php

class IFC_Walker_Secundario extends Walker_Nav_Menu {

	private $is_primeiro_elemento = true;

	public function start_lvl(&$output, $depth=0, $args=array()){
		$output .= '<ul class="dropdown-menu" role="menu">';
	}

	public function end_lvl(&$output, $depth=0, $args=array()){
		$output .= '</ul>';
	}

	public function start_el(&$output, $item, $depth=0, $args=array(), $id=0){
		if ($this->is_primeiro_elemento){
			$output .= '
			<li>
			<a href="' . get_bloginfo('url') . '">Início</a>
			</li>
			';
			$this->is_primeiro_elemento = false;
		}

		$output .= '<li>';

		if ($args->walker->has_children && $depth <= 1){
			$output .= '
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
			' . $item->title . '&nbsp;<span class="caret"></span>
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
