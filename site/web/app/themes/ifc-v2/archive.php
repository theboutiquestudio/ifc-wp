<?php get_header(); ?>

  <div class="container content-container">

      <div class="">
        <h1 class="section-title">
          <?php echo get_post_type_object(get_post_type())->labels->name; ?>
        </h1>
        <ul class="media-list">
          <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
              <li class="media">
                <a href="<?php the_permalink(); ?>">
                  <div class="media-body">
                    <h2 class="media-heading">
                      <?php the_title(); ?>
                    </h2>
                    <span><?php the_date(); ?></span>
                    <p class="info">
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
