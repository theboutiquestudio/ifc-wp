<?php get_header(); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row">
      <div class="col-md-12">
        <?php while (have_posts()): the_post(); ?>
          <article>
            <div class="page-subheader">
              <h2><?php the_title(); ?></h2>
            </div>
            
            <span class="text-muted"><?php the_time('l, j \d\e F \d\e Y'); ?></span><br/><br/>
            
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </div>

  </section>
<?php get_footer(); ?>
