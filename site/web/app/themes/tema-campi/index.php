<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container grid-campi">
  <!-- imagem baner -->
  <section class="imagem-fachada">
    <div style="background-image: url('<?php echo IFC_Func_Site_Campus::get_banner_url(); ?>')"></div>
  </section>
  <!-- fim imagem banner -->
  <!-- Inicio menu principal -->
    <?php
      switch_to_blog(get_main_site_id(get_network(1)->id));
      IFC_Func_Global::mostrar_menu_principal();
      restore_current_blog();
    ?>
  <!-- Fim menu principal -->
  <!-- menu CAMPUS -->
  <section class="menu-campus">
    <?php     
      wp_nav_menu(array(
        'theme_location' => 'menu_campus',
        'fallback_cb' => false,
      )); 
    ?>
  </section>
  <!-- Fim menu campus -->
  
  <div class="conteudo">
    <!-- Noticia -->
      <div class="noticias">
          <h1 class="section-title">
            <a href="<?php echo get_post_type_archive_link('noticia_campus'); ?>">Notícias
            </a>
          </h1>
          <?php IFC_Func_Global::exibir_noticias(IFC_Consulta_Noticias::get_noticias()); ?>
          <h1 class="ver-mais">
            <a href="<?php echo get_post_type_archive_link('noticia_campus'); ?>">TODOS AS NOTICIAS
              <span class="fa fa-chevron-right"></span>  
            </a>
        </h1>
      </div>
    <!-- Fim Noticia -->
  
  <!-- Acesso Rápido -->
    <?php 
      IFC_Acesso_Rapido::mostrar(true);
    ?>
  <!-- Fim do Acesso Rápido -->
  <!-- Avisos -->
  <section class="avisos">
     
  
      <h1 class="section-title">
        <a href="<?php echo get_post_type_archive_link('aviso_campus'); ?>">Avisos
        </a>
      </h1>
      <?php IFC_Avisos::exibir_avisos(IFC_Func_Global::consulta_post_type("aviso_campus", 5)); ?>
  </section>
  <!-- fim avisos -->

  <!-- agenda do diretor -->
  <section class="agenda-diretor">
    <h1 class="section-title">
      <a href="<?php echo get_post_type_archive_link('agenda_diretor'); ?>">Agenda do Diretor
      </a>
    </h1>
    <?php IFC_Agenda::exibir_agenda(IFC_Func_Global::consulta_post_type("agenda_diretor",5)); ?>
 
    
  </section>
  <!-- fim agenda do diretor  -->
  <!-- eventos -->
  <section class="eventos">
    <h1 class="section-title">
      <a href="<?php echo get_post_type_archive_link('evento'); ?>">Eventos
      </a>  
    </h1>
    <?php IFC_Eventos::exibir_eventos(IFC_Func_Global::consulta_post_type("evento",5));
    ?>
  </section>
  <!-- fim eventos -->
  <!-- setores -->
  <section class="setores">
    <h1 class="section-title">
      <a href="<?php echo get_post_type_archive_link('setores'); ?>">Setores
      </a>
    </h1>
  </section>
  <!-- fim setores -->
</div>
</div>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
