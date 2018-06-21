<?php get_header(); ?>
<!-- CONTENT -->
<div class="container content-container main-grid">
  <!-- Primeiro bloco de conteudo -->
  <!-- inicio do menu de  destaque ingresso -->
  <?php require(get_template_directory()."/menu_destaque_ingresso.php"); ?>
  <!-- fim do menu de destaque ingresso -->
  <!-- inicio do menu de acesso perfil -->
  <div class="menu-acesso-perfil">
    <a
    href="#"
    class="ingressante"
    style="background-image: url('<?= IFC_Func_Site_Geral::get_imagem_perfil_url('ingressante') ; ?>');">
       QUERO ESTUDAR NO IFC
    </a>

    <a
    href="#"
    class="aluno"
    style="background-image: url('<?= IFC_Func_Site_Geral::get_imagem_perfil_url('aluno') ; ?>');">SOU ALUNO</a>

    <a
    href=""
    class="servidor"
    style="background-image: url('<?= IFC_Func_Site_Geral::get_imagem_perfil_url('servidor') ; ?>');">SOU SERVIDOR</a>

    <a
    href=""
    class="comunidade"
    style="background-image: url('<?= IFC_Func_Site_Geral::get_imagem_perfil_url('comunidade') ; ?>');">SOU MEMBRO DA COMUNIDADE</a>

  </div>

  <!-- fim do menu de acesso por perfil  -->
  <!-- fim do primeiro bloco de contudo -->

  <!-- inicio menus a esquerda (menu pricipal) -->

  <?php IFC_Func_Global::mostrar_menu_principal(); ?>

  <!-- fim menu a equerda (menu principal)-->

  <!-- Noticias -->
   <section class="noticia-index" role="main">

  <h1 class="sr-only"><?php wp_title(''); ?></h1>
  <a href="<?php echo get_post_type_archive_link('noticia_geral'); ?>">
    <h1 class="section-title">Notícias</h1>
  </a>

  <?php
    IFC_Func_Global::exibir_noticias(IFC_Consulta_Noticias::get_noticias());
  ?>
  <h1 class="ver-mais">
    <a href="<?php echo get_post_type_archive_link('noticia_geral'); ?>">MAIS NOTÍCIAS
      <span class="fa fa-chevron-right"></span>
    </a>
  </h1>
  </section>
  <!-- Fim noticias -->

  <!-- menu de acesso rapido -->
  <?php IFC_Acesso_Rapido::mostrar(); ?>
  <!-- Fim menu acesso rapido -->


<!-- COURSES & BANNER
<aside role="complementary">
<div class="col-md-4 col-courses-banner">
<?php # require("sidebar.php"); ?>
</div>
</aside>
/COURSES -->


<!-- local acesso rapido se der erro -->
<!-- Avisos  -->
<section class="avisos feed">
  <h1 class="section-title">
    <a href="<?php echo get_post_type_archive_link('aviso_geral'); ?>">
      <span class="fa fa-bullhorn"></span> Avisos
    </a>
  </h1>
  <?php
    $aviso_geral = IFC_Func_Global::consulta_post_type('aviso_geral' , 5);

  if ($aviso_geral->have_posts()) {
    while ( $aviso_geral->have_posts() ){
        $aviso_geral->the_post();
        ?>
        <span>
          [<?php the_time('d/m/Y'); ?>]
        </span>
        <a class="titulo" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <br>

    <?php
    }
    ?>
    <h1 class="ver-mais">
      <a href="<?php echo get_post_type_archive_link('aviso_geral'); ?>">TODOS OS AVISOS
        <span class="fa fa-chevron-right"></span>
      </a>
    </h1>
    <?php
  }else{
    ?>
    <span>Não há notícias cadastrados</span>
  <?php
  }
  wp_reset_postdata();

  ?>



</section>
  <!-- Fim Avisos -->
  <!-- Agenda Reitoria -->
  <section class="agenda feed" >
    <h1 class="section-title">
      <a href="<?php bloginfo('url'); ?>/events/">
        <span class="fa fa-calendar"></span> Agenda da Reitoria
      </a>
    </h1>
    <?php
      $agenda_reitoria = IFC_Func_Global::consulta_post_type('agenda_reitor', 5);

      if ($agenda_reitoria->have_posts()){
        while ($agenda_reitoria->have_posts()){
          $agenda_reitoria->the_post();
          ?>
          <a class="titulo" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          <?php
        }
        ?>
        <h1 class="ver-mais">
          <a href="<?php echo get_post_type_archive_link('agenda_reitor'); ?>">TODOS OS EVENTOS DA REITORIA
            <span class="fa fa-chevron-right"></span>
          </a>
        </h1>
        <?php
      }else{
        ?>
          <span>Não há eventos da reitoria cadastrados.</span>
        <?php
      }
    ?>
    <!--<ul class="list-unstyled">-->
      <!--<div class="calendar">-->
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Eventos")): endif; ?>
        <!--</div>-->
        <!--</ul>-->
  </section>

      <!-- Fim agenda reitoria -->
      <!-- Eventos -->
      <section class="eventos feed">
        <h1 class="section-title">
          <a href="<?php bloginfo('url'); ?>/events/">
            <span class="fa fa-calendar"></span> Eventos
          </a>
        </h1>

        <!--<ul class="list-unstyled">-->
          <!--<div class="calendar">-->
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Eventos")): endif; ?>
            <!--</div>-->
            <!--</ul>-->
      </section>

          <!-- Fim eventos -->

          <section class="redes-sociais feed">
            <h1 class="section-title ">
              <a href="">
                <span class="fa fa-calendar"></span> Redes Sociais
              </a>
            </h1>
            <ul class="nav nav-tabs" id="tabs">
              <li class="active"><a data-toggle="tab" href="#facebook">Facebook</a></li>
              <li><a data-toggle="tab" href="#instagram">Instagram</a></li>
            </ul>
            <div class="tab-content">
              <div id="facebook" class="tab-pane active">
                <?php
                the_widget('WEF_Widget',
                  array(
                    'shortcode' => '[fb_plugin page href=https://www.facebook.com/ifc.oficial/ small-header=true height=350 tabs=timeline ]',
                  )
                );
                ?>
              </div>

              <div id="instagram" class="tab-pane">
                <?php the_widget('null_instagram_widget',
                  array(
                    'username' => 'ifc.oficial',
                    'number'   => 1,
                    'size' =>'small',
                  )
                );
                ?>
              </div>
            </div>
          </section>
          <section class="setores feed">
            <h1 class="section-title">
              <a href="<?php bloginfo('url'); ?>/events/">
                <span class="fa fa-calendar"></span> Setores
              </a>
            </h1>
            <p>Swine picanha shankle pork, chicken prosciutto burgdoggen doner short ribs sirloin. Picanha drumstick burgdoggen kielbasa, pastrami cow ball tip short loin pork loin brisket andouille sausage capicola pork. Pork loin chicken tail corned beef alcatra, sausage pork chop venison burgdoggen buffalo chuck filet mignon. Landjaeger andouille biltong, chicken kielbasa meatloaf porchetta buffalo jerky fatback. T-bone hamburger landjaeger frankfurter short loin burgdoggen alcatra tenderloin pig beef picanha boudin tri-tip. Leberkas short loin kielbasa chuck short ribs beef. Ham biltong bacon sausage ground round.

            </p>
          </section>
        </div><!-- /.row-news-courses -->
        <?php get_footer() ?>
