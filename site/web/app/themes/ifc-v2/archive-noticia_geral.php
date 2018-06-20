<?php get_header(); ?>

  <div class="container content-container">

      <div class="">
        <h1 class="section-title">
          <?php echo get_post_type_object(get_post_type())->labels->name; ?>
        </h1>
        <ul class="media-list noticia-main">
          <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
              <a href="<?php the_permalink(); ?>">
                <?php echo wp_get_attachment_image(get_field('thumbnail'), array(120,120)) ?>  
              </a>
              <li>
                <a href="<?php the_permalink(); ?>">
                  <div class="media-body conteudo-noticia">
                    <h2 class="media-heading titulo_noticia">
                      <?php the_title(); ?>
                    </h2>
                    <span><?php the_date(); ?></span> 
                    <p class="info texto_noticia">
                       <?php IFC_Func_Global::echo_post_excerpt(50) ?>
                    </p>
                  </div>
                </a>
              </li>
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
      <br/>
    
  <!-- /.container -->

<?php get_footer(); ?>
