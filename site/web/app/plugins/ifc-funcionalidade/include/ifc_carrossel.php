<?php

class IFC_Carrossel {

	public static function registrar() {
		add_action('wp_enqueue_scripts', array(__CLASS__, '_carregar_scripts_e_styles'));
	}

	public static function _carregar_scripts_e_styles() {
		wp_enqueue_style('dashicons');
		wp_enqueue_script('ifc_siema_carousel', plugin_dir_url(dirname(__FILE__)) . '/vendor/siema-1.5.1/dist/siema.min.js');
		wp_enqueue_script('ifc_carrossel', plugin_dir_url(dirname(__FILE__)) . '/scripts/carrossel.js', array('jquery'));
		wp_enqueue_style('ifc_carrossel', plugin_dir_url(dirname(__FILE__)) . '/styles/carrossel.css');
	}

	public static function mostrar($posts) {
		?>
		<div class="carrossel" tabindex="0">
			<div class="carrossel__prev">
				<span class="dashicons dashicons-arrow-left-alt2"></span>
			</div>
			<div class="carrossel__siema">
				<?php
				global $post;
				foreach($posts as $post){
					switch_to_network($post->site_id);
					switch_to_blog($post->blog_id);
					setup_postdata($post);
					self::mostrarPost();
				}
				wp_reset_postdata();
				restore_current_blog();
				restore_current_network();
				?>
			</div>
			<div class="carrossel__next">
				<span class="dashicons dashicons-arrow-right-alt2"></span>
			</div>
		</div>
		<?php
	}

	private static function mostrarPost(){
		?>
		<div>
			<a href="<?php the_permalink(); ?>">
				<?= wp_get_attachment_image(get_field('thumbnail'), 'full'); ?>
			</a>
			<a class="titulo-noticia" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
			<a class="texto-noticia" href="<?php the_permalink(); ?>">
				<?php IFC_Func_Global::echo_post_excerpt(55); ?>
			</a>
		</div>
		<?php
	}
}