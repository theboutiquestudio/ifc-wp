<?php get_header(); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row">
      <div class="page-header">
        <h1><span class="fa fa-calendar"></span>&nbsp; Agenda do diretor</h1>
        <a href="<?php bloginfo('url'); ?>" class="btn btn-default pull-right back-link"><span class="fa fa-arrow-left"></span>&nbsp; Início</a>
      </div>
            
      <div class="col-md-12">
        <?php while (have_posts()): the_post(); ?>
          <article>
            <div class="page-subheader">
              <h2><?php the_title(); ?></h2>
            </div>
            
            <span class="text-muted">
              <?php
                global $wp_locale;
                $month_id = get_post_meta(get_the_ID(), 'event_date_month', true);
                
                
                
                $day = get_post_meta(get_the_ID(), 'event_date_day', true);
                $month = $wp_locale->get_month( $month_id );
                $year = get_post_meta(get_the_ID(), 'event_date_year', true);
                
                $hour = get_post_meta(get_the_ID(), 'event_date_hour', true);
                $minute = get_post_meta(get_the_ID(), 'event_date_minute', true);
                
                echo "$day de $month de $year, às $hour:$minute";
              ?>
            </span>
            <br/><br/>
            
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </div>

  </section>
<?php get_footer(); ?>
