<?php get_header(); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">
            
    <div class="row row-category">

      <!-- NAVEGUE NAS CATEGORIAS -->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 categories-selector">
        <div class="row">
          <div class="hidden-xs hidden-sm col-md-7 col-lg-7">&nbsp;</div>
          
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">Navegue nas categorias</div>
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Seletor de Categorias")): endif; ?>
              </div>
            </div><!-- /.row -->
          </div><!-- /.col -->
        </div><!-- /.row -->

      </div>
      <!-- /.NAVEGUE NAS CATEGORIAS -->

      <div class="col-md-12">

        <h1><span class="fa fa-list"></span> &nbsp;<?php single_cat_title(); ?></h1>
        <br/>
        
        <ul class="media-list">

          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article>
              <li class="media">
                <a href="<?php the_permalink() ?>">
                  <div class="media-left">
                    <div class="date">
                      <span class="day"><?php the_time('d') ?></span> 
                      <span class="month"><?php the_time('M') ?></span> 
                      <span class="year"><?php the_time('Y') ?></span>
                    </div>
                  </div>
                  <div class="media-body">
                    <h2 class="media-heading">
                      <?php the_title() ?>
                    </h2>
                    <p class="info">
                      <?php echo excerpt(55); ?>
                    </p>

                    <p class="categories">
                      <?php
                      $n=0;
                      $categoria = get_the_category();
                      
                      while(isset($categoria[$n])){
                        $nomeCategoria = $categoria[$n]->cat_name;
                        $idCategoria=$categoria[$n]->term_id;
                        ?>
                          <span class="label label-primary">
                            <?php echo $nomeCategoria; ?>
                          </span>&nbsp;
                      <?php $n++; } ?>
                    </p>
                  </div>
                </a>
              </li>
            </article>
          <?php endwhile?>
          <?php else: ?>
          <p>Sem artigos cadastrados.</p>
          <?php endif; ?>

          

        </ul>
      </div>

      <!-- PAGINAÇÃO -->
      <div class="text-center">
        <?php custom_pagination(); ?>
      </div>
      <!-- /.PAGINAÇÃO -->
    
    </div>
  
    <br/>

  </section>
<?php get_footer(); ?>
