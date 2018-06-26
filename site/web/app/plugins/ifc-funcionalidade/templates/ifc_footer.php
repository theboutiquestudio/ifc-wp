</div><!-- /.container -->
<!-- /.CONTENT -->

<!-- FOOTER -->
<footer>
	<section role="navigation">
		<h1 class="sr-only">Links de acesso rápido</h1>
		<div class="links-wrapper">
			<div class="container">
				<div class="row row-links">
					<?php
						function get_menu_by_location($location) {
							$locations = get_nav_menu_locations();
							if (array_key_exists($location, $locations)){
								return get_term($locations[$location], 'nav_menu');
							} else {
								return false;
							}
						}
						$locais_menu = array(
							'rodape-coluna-1',
							'rodape-coluna-2',
							'rodape-coluna-3',
							'rodape-coluna-4',
						);
						switch_to_blog(get_main_site_id(get_network(1)->id));
						foreach ($locais_menu as $local_menu) {
							$menu = get_menu_by_location($local_menu);
							if ($menu === false) {
								continue;
							}
							?>
							<div class="col-md-3 white-space-2x">
								<h2><?= $menu->name ?></h2>
							<?php
								wp_nav_menu(array(
									'menu' => $menu,
									'menu_class' => 'list-unstyled',
									'container' => false,
									'fallback_cb' => false,
								));
							?>
							</div>
							<?php
						}
						restore_current_blog();
					?>
				</div><

			</div>
		</div>
	</section>

	<div class="bottom-wrapper">
		<div class="container">

			<section>
				<div class="row row-bottom">
					<div class="col-md-12">
						<a href="http://www.acessoainformacao.gov.br/">
							<img class="imgs-footer acesso" title="Acesso à informação" src="<?= plugins_url('images/logo-acesso-informacao.svg', dirname(__FILE__)) ?>">
						</a>
						<a href="http://brasil.gov.br/">
							<img class="imgs-footer brasil" title="Portal de Estado do Brasil" src="<?= plugins_url('images/logo-brasil.svg', dirname(__FILE__)) ?>">
						</a>
					</div>
				</div>
			</section>

		</div>
	</div>
</footer>
<!-- /FOOTER -->

</div>

<!-- wp-footer -->
<?php wp_footer(); ?>
<!-- /.wp-footer -->

</body>
</html>
