<?php

/**
 *
 */
class IFC_Avisos
{
	static function exibir_avisos($posts){
		global $post;

		if (count($posts) !== 0 ):
			foreach ($posts as $post):
				switch_to_network($post->site_id);
				switch_to_blog($post->blog_id);
				setup_postdata($post);
			?>
				<span>[<?php the_time('d/m/Y') ; ?>]</span>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<br>
			<?php
			endforeach;
		else:
		?>
			<span>Não há avisos cadastrados</span>
		<?php
		endif;
		wp_reset_postdata();
		restore_current_blog();
		restore_current_network();
	}
}