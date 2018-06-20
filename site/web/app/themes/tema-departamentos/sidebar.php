<h2><span class="fa fa-reorder"></span>&nbsp; Categorias</h2>

<?php
	// Get Categories
	function ifc_get_categories() {
		$args = array(
			'parent'       => 0,
			'hide_empty'   => 0,
			'hierarchical' => 0,
			'exclude'      => '1'
		);
		
		return get_categories($args);
	}
	
	// Get Subcategory
	function ifc_get_subcategory($category) {
		$args = array(
			'parent'       => $category->cat_ID,
			'hide_empty'   => 0,
			'hierarchical' => 0
		);
		
		return get_categories($args);
	}
	
	function ifc_list_category($category) {
		if (get_term_children($category->cat_ID, 'category')) {
			echo '<li>';
			echo '<a href="#collapse-' . $category->cat_ID . '" data-toggle="collapse" data-parent="#accordion-categories"><span class="fa fa-angle-right"></span>&nbsp; ' . $category->cat_name . '</a>';
			echo '</li>';
			
			echo '<li><ul id="collapse-' . $category->cat_ID . '" class="list-unstyled collapse submenu">';
			foreach (ifc_get_subcategory($category) as $category) {
				ifc_list_category($category);
			}
			echo '</ul></li>';
		} else {
			echo '<li><a href="' . get_category_link( $category->cat_ID ) . '">' . $category->cat_name . '</a></li>';
		}
	}
	
	echo '<ul id="accordion-categories" class="menu list-unstyled">';
	foreach (ifc_get_categories() as $category) {
		ifc_list_category($category);
	}
	echo '</ul>';
?>
