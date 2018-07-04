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
    IFC_Carrossel::mostrar(IFC_Consulta_Noticias::get_noticias(5, true));
    IFC_Func_Global::exibir_noticias(IFC_Consulta_Noticias::get_noticias(5, false, true));
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
          <!-- rede social -->
          <section class="rede-social">
          	<h1 class="section-title ">
              <a href="">
                <span class="fa fa-facebook-square"></span> Facebook
              </a>
            </h1>

             <div id="facebook" class="tab-pane active">
                <?php
                the_widget('WEF_Widget',
                  array(
                    'shortcode' => '[fb_plugin page href=https://www.facebook.com/ifc.oficial/ small-header=true height=350 tabs=timeline ]',
                  )
                );
                ?>
              </div>
          </section>

          <section class="rede-social2">
          	<h1 class="section-title ">
              <a href="">
                <span class="fa fa-instagram"></span> Instagram
              </a>
            </h1>
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
          </section>
          <section class="setores feed">
            <h1 class="section-title">
              <a href="<?php bloginfo('url'); ?>/events/">
                <span class="fa fa-clipboard"></span> Setores
              </a>
            </h1>
           <?php $consulta =  IFC_Consulta_Setores::get_setores_da_network(get_network()->id);

           foreach ($consulta as $setores) {
             ?>
             <ul>
             	<li>
             		<a href="<?= $setores->url?>"><?= $setores->nome ?></a>
             	</li>
             </ul>

             <?php
           } ?>
            </p>
          </section>
        </div>
        <?php get_footer() ?>
