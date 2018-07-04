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
			<div class="carrossel__siema">
				<?php
				global $post;
				$mostrar_navegacao = count($posts) > 1;
				foreach($posts as $post){
					switch_to_network($post->site_id);
					switch_to_blog($post->blog_id);
					setup_postdata($post);
					self::mostrarPost($mostrar_navegacao);
				}
				wp_reset_postdata();
				restore_current_blog();
				restore_current_network();
				?>
			</div>
		</div>
		<?php
	}

	private static function mostrarPost($navegacao=false){
		?>
		<div>
			<div class="carrossel__slide">
				<?php if ($navegacao): ?>
				<a class="carrossel__prev">
					<span class="dashicons dashicons-arrow-left-alt2"></span>
				</a>
				<?php endif; ?>
				<a class="carrossel__imagem" href="<?php the_permalink(); ?>">
					<?= wp_get_attachment_image(get_field('thumbnail'), 'full'); ?>
				</a>
				<?php if ($navegacao): ?>
				<a class="carrossel__next">
					<span class="dashicons dashicons-arrow-right-alt2"></span>
				</a>
				<?php endif; ?>
			</div>
			<a class="carrossel__titulo" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
			<a class="carrossel__texto" href="<?php the_permalink(); ?>">
				<?php IFC_Func_Global::echo_post_excerpt(33); ?>
			</a>
		</div>
		<?php
	}
}
