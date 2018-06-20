<!-- Barra Brasil -->
<div id="barra-brasil"></div>
<script src="http://barra.brasil.gov.br/barra.js" type="text/javascript"></script>
<!-- Barra Brasil -->

<!-- HEADER -->
<header role="banner">
	<div class="main-wrapper">
		<div class="container">

			<!-- MAIN HEADER -->
			<section>
				<h1 class="sr-only">Barra de acessibilidade</h1>
				<div class="row row-single">
					<div class="col-xs-12 col-sm-12 col-md-12 col-left">
						<div class="lista-links-acessibilidade hidden-xs hidden-sm">
							<ul class="list-inline">
								<li><a href="#irconteudo" accesskey="1">Ir para o conteúdo <span>1</span></a></li>
								<li><a href="#irmenu" accesskey="2">Ir para o menu principal <span>2</span></a></li>
								<li><a href="#irbusca">Ir para a busca <span>3</span></a></li>
							</ul>
						</div>
						<div class="lista-acoes">
							<ul class="list-inline">
								<li><a href="#" id="high-contrast-action" class="high-contrast text-right">Alto contraste</a></li>
							</ul>
						</div>
					</div><!-- /.col-left -->
				</div><!-- /.row-single -->
			</section>

			<div class="row row-single">
				<div class="col-xs-12 col-sm-12 col-md-6 col-left">
					<a href="<?php bloginfo('url'); ?>">
						<img class="logo-normal" alt="Logotipo do IFC" src="<?php echo get_theme_file_uri( 'assets/images/logo-ifc-alto-contraste.png' ); ?>">

					</a>
				</div><!-- /.col-left -->

				<div class="col-xs-12 col-sm-12 col-md-6 col-right">
					<section class="pesquisa" role="search">
						<h1 class="sr-only">Formulário de pesquisa</h1>
						<div class="row">
							<div class="col-sm-12">
								<div class="pull-right search-form">
									<form method="get" id="searchform" action="<?php restore_current_blog(); bloginfo('url'); switch_to_blog(1); ?>">
										<label for="irbusca" class="sr-only">Pesquisa</label>
										<input type="text" name="s" id="irbusca" accesskey="3" class="form-control search-query" placeholder="<?php echo get_search_query() != '' ? get_search_query() : 'Pesquisar'; ?>">
									</form>
								</div>
							</div>
						</div>
					</section>
					<section>
						<h1 class="sr-only">Links sociais</h1>
						<div class="row">
							<div class="col-sm-12">
								<div class="lista-social">
									<ul class="list-inline social">
										<li><a href="https://www.facebook.com/ifc.oficial" class="facebook"><span class="fa fa-facebook facebook" aria-hidden="true"></span><span class="sr-only">Facebook</span></a></li>
										<li><a href="https://www.youtube.com/user/IFCatarinense" class="youtube"><span class="fa fa-youtube-play youtube" aria-hidden="true"></span><span class="sr-only">Youtube</span></a></li>
									</ul>
									<ul class="list-inline restrict">
										<li><a href="/wp-admin"><span class="fa fa-lock" aria-hidden="true"></span><span class="sr-only">Restrito</span></a></li>
									</ul>
								</div>
							</div>
						</div>
					</section>
				</div><!-- /.col-right -->
			</div><!-- /.row-single -->
		</div><!-- /.container -->
	</div><!-- /.main-wrapper -->
	<!-- /MAIN HEADER -->
	<div class="col-md-12 col-left sub-banner-exterior ">

		<div class="container">
			<div class="hidden-xs hidden-sm  ">
				<ul class="list-inline sub-banner">
					<li><a href="http://ifc.test/acesso-a-informacao/perguntas-frequentes/" accesskey="1">Perguntas Frequentes</a></li>
					<li>|</li>
					<li><a href="http://webmail.ifc.test/" accesskey="2">Webmail </a></li>
					<li>
						|
					</li>
					<li><a href="#">Acesso aos Sistemas Institucinais</a></li>
					<li>|</li>
					<li><a href="#">Contato </a></li>
				</ul>
			</div>
		</div><!-- /.col-left -->
	</div>

</header>
<!-- /HEADER -->

<div class="container">
	<p>Você está aqui: </p>
</div>

<a href="#" id="irconteudo" class="sr-only">Início do conteúdo</a>
