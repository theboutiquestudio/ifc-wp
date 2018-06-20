<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
<div class="container content-container grid-cursos">
  <!-- Imagem banner -->
  <section class="imagem-fachada">
    <div style="background-image: url('<?php echo IFC_Func_Site_Curso::get_banner_url();?>');"></div>
  </section>
  <!-- menu principal -->
  <?php
  switch_to_blog(get_main_site_id(get_network(1)->id));
  IFC_Func_Global::mostrar_menu_principal();
  restore_current_blog();
  ?>
  <!-- fim menu princiapl -->
  <!-- inicio conteudo -->
  <section class="conteudo">
  <!-- inicio apresentação -->
    <section class="apresentacao" >
      <h1 class="section-title">Apresentação</h1>
    </section>
    <!-- fim apresentação -->
    <!-- info-gerais -->
    <section class="info-gerais">
      <h1 class="section-title">Informações Gerais</h1>
    </section>
    <!-- fim info-gerais -->
    <!-- noticia -->
    <section class="noticia">
        <h1 class="section-title">
          <a href="<?php echo get_post_type_archive_link('noticia_curso'); ?>">Notícias
          </a>
        </h1>
        <?php 
          IFC_Func_Global::exibir_noticias(IFC_Consulta_Noticias::get_noticias());
        ?>
      
    </section>
    <!-- fim noticia -->
    <!-- post types -->
    <section class="post-types">
      <section class="avisos">
        <h1 class="section-title">Avisos</h1>
      </section>
      <section class="eventos">
        <h1 class="section-title">Eventos</h1>
      </section>
    </section>
    <!-- fim post types -->
  </section>
  <!-- fim conteudo -->
  

  <!-- menu curso -->
  <section class="menu-curso">
    <?php     
      wp_nav_menu(array(
        'theme_location' => 'menu_curso',
        'fallback_cb' => false,
      )); 
    ?>
  </section>
  <!-- fim menu curso -->

  <?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>