<?php
require 'vendor/autoload.php';

/*=== Thumbnails ===*/
add_image_size('large-thumb', 240, 170, true);
add_image_size('small-thumb', 120, 90, true);

/*=== TEXTO INTRODUTÓRIO DO POST ===*/
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt);
	}else{
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

/*=== ATIVAR "IMAGEM DESTAQUE" ===*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size();

/*=== PAGINAÇÃO ===*/
function custom_pagination($pages = '', $range = 2) {  
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)	{
			$pages = 1;
		}
	}   

	if(1 != $pages)	{
		echo "<nav><ul class='pagination'>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."' id='paginacao-primeira'>Primeira</a></li>";
		if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."' id='paginacao-seta-erquerda'>&lsaquo;</a></li>";

		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<li class='active'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
			}
		}

		if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";  
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>Última</a></li>";
		echo "</ul></nav>\n";
	}
}
?>