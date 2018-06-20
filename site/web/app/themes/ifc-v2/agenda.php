<?php
/*
 * Template Name: Agenda do Campus
*/
?>

<?php get_header(); ?>

  <div class="container content-container agenda-campus">
    <section role="main">
      <div class="row">
        <div class="page-header">
          <h1><span class="fa fa-calendar"></span>&nbsp; <a href="<?php bloginfo('url'); ?>/events">
            Agenda do Campus
          </a></h1>
        </div>
              
        <div class="col-md-12">
          <?php while (have_posts()): the_post(); ?>

            <article>
              <div class="entry-content">
                <?php the_content(); ?>
              </div>
            </article>

          <?php endwhile; ?>
        </div>
      </div>
    </section>
  <!-- /.container -->

<?php get_footer(); ?>