<?php

/**
 * Funcionalidade global, para todos os sites
 */
class IFC_Func_Global implements IFC_iFunc{

	public function executar(){
		// Habilitar versão 5 do plugin advanced custom fields
		define('ACF_EARLY_ACCESS', '5');

		add_filter('wp_title', array(__CLASS__, '_alterar_titulo_da_pagina'));
		add_action('init', array(__CLASS__, 'registrar_menus'));
		$this->registrar_tamanhos_de_thumbnail();

		add_action('wp_enqueue_scripts', array(__CLASS__, 'carregar_scripts_styles'));

		if (is_admin()){
			add_action('admin_init', array(__CLASS__, 'refazer_permalinks'));
			add_filter('tiny_mce_before_init', array(__CLASS__, '_configurar_editor_tiny_mce'));
			add_action('admin_menu', array(__CLASS__, 'remover_menu_acf'), 11);
			IFC_Admin_Menu_Sites::registrar();
		}
	}

	public static function refazer_permalinks(){
		// Refazer permalinks se necessário
		// Requerido ao ativar o plugin (set_transient no método ativarEmSite)
		if(delete_transient('ifc_refazer_permalinks')){
			flush_rewrite_rules();
		}
	}

	public static function ativarGlobal(){}

	public static function ativarEmSite(){
		// Refazer os permalinks, para acomodar os novos post types.
		// Remover as regras existentes do banco.
		delete_option('rewrite_rules');
		// Refazer na próxima vez que o painel de administração for carregado.
		set_transient('ifc_refazer_permalinks', '');
	}

	public static function desativarGlobal(){}

	public static function desativarEmSite(){}

	public static function _alterar_titulo_da_pagina($titulo){
		$sufixo = 'Instituto Federal Catarinense';
		$separador = ' - ';
		if ((is_home() || is_front_page()) && empty($titulo)){
			// Página inicial
			return get_bloginfo('title') . $separador . $sufixo;
		} else if (empty($titulo)){
			// Página sem título
			return $sufixo;
		} else {
			// Página qualquer (com título)
			return $titulo . $separador . $sufixo;
		}
	}

	public function registrar_tamanhos_de_thumbnail(){
		add_image_size('large-thumb', 240, 170, true);
		add_image_size('small-thumb', 120, 90, true);
	}

	public static function echo_post_excerpt($limite){
		// Divide as palavras com espaço
		// (o 'explode' deixa o resto da string no úlimo elemento)
		$palavras_com_resto = explode(' ', get_the_excerpt(), $limite + 1);
		// Remover o resto
		$palavras = array_slice($palavras_com_resto, 0, $limite);

		$excerpt = implode(' ', $palavras);

		// Remover data no formato "[qualquer coisa]",
		// ou seja, dentro de colchetes.
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

		// Adicionar reticências caso o limite foi atingido
		if (count($palavras_com_resto) > $limite){
			$excerpt .= ' [...]';
		}

		echo $excerpt;
	}

	/**
	 * Gerar menu de navegação (links para a páginas)
	 *
	 * @param integer $n_paginas número total de páginas (null ou '' para obter automaticamente)
	 * @param integer $intervalo número de páginas para mostrar a frente e atrás da atual
	 */
	public static function echo_paginacao($n_paginas=null, $intervalo=2){
		// A global $paged contém o número de página atual
		// EXCETO quando estamos na primeira página: seu valor é 0.
		// Então, o setamos para 1.
		global $paged;
		$n_pagina_atual = $paged === 0 ? 1 : $paged;
		// A global $wp_query tem um atributo com o número total de páginas
		global $wp_query;

		if ($n_paginas === null || $n_paginas === ''){
			$n_paginas = $wp_query->max_num_pages;
		}

		if ($n_paginas <= 1){
			// Não há páginas a mostrar
			return;
		}

		// O intervalo total (esquerda, direita, e a página atual no centro)
		// Pode ser maior do que o número de páginas que realmente existem
		$n_paginas_mostradas = ($intervalo * 2) + 1;

		// Será true se os links para todas as páginas serão exibidos
		$mostramos_todas_paginas = $n_paginas_mostradas >= $n_paginas;

		echo "<nav><ul class='pagination'>";

		if ($n_pagina_atual >= 3 && $n_pagina_atual > $intervalo + 1 && !$mostramos_todas_paginas){
			// Link para a primeira página
			echo self::construir_botao_de_pagina('primeira', 1);
		}

		if ($n_pagina_atual >= 2 && !$mostramos_todas_paginas){
			// Link para a página anterior
			echo self::construir_botao_de_pagina('anterior', $n_pagina_atual-1);
		}

		for ($i=1; $i <= $n_paginas ; $i++) {
			$fora_do_intervalo = ($i >= $n_pagina_atual+$intervalo+1 || $i <= $n_pagina_atual-$intervalo-1);
			if ($mostramos_todas_paginas || !$fora_do_intervalo){
				if($n_pagina_atual == $i){
					echo self::construir_botao_de_pagina('atual', $i);
				} else {
					echo self::construir_botao_de_pagina('absoluta', $i);
				}
			}
		}

		$is_ultima_pagina = $n_pagina_atual == $n_paginas;
		if(!$is_ultima_pagina && !$mostramos_todas_paginas){
			// Link para a próxima página
			echo self::construir_botao_de_pagina('proxima', $n_pagina_atual+1);
		}

		$is_penultima_pagina = $n_pagina_atual == $n_paginas-1;
		$fora_do_intervalo = $n_pagina_atual+$intervalo-1 >= $n_paginas;
		if (!$is_penultima_pagina && !$mostramos_todas_paginas && !$fora_do_intervalo){
			echo self::construir_botao_de_pagina('ultima', $n_paginas);
		}

		echo "</ul></nav>\n";
	}

	public static function construir_botao_de_pagina($tipo, $n_pagina){
		$template = '<li class="$classes"><a href="$link">$texto</a></li>';
		$texto = strval($n_pagina);
		$classes = "";

		if ($tipo === 'atual'){
			$classes = 'active';
		} elseif ($tipo === 'primeira'){
			$texto = 'Primeira';
		} elseif ($tipo === 'anterior'){
			$texto = '&lsaquo;';
		} elseif ($tipo === 'proxima'){
			$texto = '&rsaquo;';
		} elseif ($tipo === 'ultima'){
			$texto = 'Última';
		}

		return strtr($template, array(
			'$link' => get_pagenum_link($n_pagina),
			'$classes' => $classes,
			'$texto' => $texto,
		));
	}

	public static function _configurar_editor_tiny_mce($config){
		$config['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,alignjustify,alignleft,aligncenter,alignright,link,unlink,spellchecker,wp_fullscreen,wp_adv';
		$config['toolbar2'] = 'formatselect,underline,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help';
		$config['toolbar3'] = '';
		$config['toolbar4'] = '';
		return $config;
	}

	public static function registrar_menus(){
		register_nav_menu('Superior', 'Menu principal');
		register_nav_menu('Acesso Rapido', 'acesso_rapido');
		register_nav_menu('menu_header' , 'menu header');

		register_nav_menu('rodape-coluna-1', 'Rodapé - Coluna 1');
		register_nav_menu('rodape-coluna-2', 'Rodapé - Coluna 2');
		register_nav_menu('rodape-coluna-3', 'Rodapé - Coluna 3');
		register_nav_menu('rodape-coluna-4', 'Rodapé - Coluna 4');

	}
	public static function carregar_scripts_styles(){
		wp_enqueue_script('menu_principal' ,  plugin_dir_url(dirname(__FILE__)).'scripts/menu.js', array('jquery'));
		wp_enqueue_style('global_style' ,  plugin_dir_url(dirname(__FILE__)).'styles/global_style.css');
		wp_enqueue_style('menu_principal' ,  plugin_dir_url(dirname(__FILE__)).'styles/menu_principal.css');
		wp_enqueue_style('noticias' ,  plugin_dir_url(dirname(__FILE__)).'styles/noticias.css');

	}
	public static function mostrar_menu_principal(){
		require plugin_dir_path(dirname(__FILE__)).'templates/ifc_menu_principal.php';
	}

	public static function remover_menu_acf(){
		remove_menu_page('edit.php?post_type=acf-field-group');
	}

	public static function consulta_post_type ($posttype, $posts_per_page){

        $all_list = array(
          'post_type'      => "$posttype",
          'posts_per_page' => $posts_per_page
        );
        $consulta = new WP_Query($all_list);

        return $consulta;
	}

	public static function exibir_noticias($posts){
		global $post;

		if (count($posts) !== 0):
			foreach ($posts as $post):
				switch_to_network($post->site_id);
				switch_to_blog($post->blog_id);
				setup_postdata($post);
			?>
				<div class="noticia-main">

					<a href="<?php the_permalink(); ?>">
						<?php 
							echo wp_get_attachment_image(get_field('thumbnail'), array(120, 120)); ?>	
					</a>
					<div class="conteudo-noticia">
						<a class="titulo-noticia" href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
						<br>

						<a class="texto-noticia" href="<?php the_permalink(); ?>">
							<? echo IFC_Func_Global::echo_post_excerpt(55); ?>
						</a>

						<br>
					</div>
				</div>
			<?php
			endforeach;
		else:
			?> <span>Não há notícias cadastradas</span> <?php
		endif;
		wp_reset_postdata();
		restore_current_blog();
		restore_current_network();
	}
}
