<div class="row search-results">

  <div class="col-md-12">
    <?php if (have_posts()): ?>
      <div class="page-subheader">
        <h2><span class="fa fa-search"></span> &nbsp;Resultados da pesquisa por: "<span><?php echo get_search_query(); ?></span>"</h2>
      </div>
    
      <ul class="media-list">
    
        <?php while (have_posts()): the_post(); ?>
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
                  <h3 class="media-heading">
                    <?php the_title() ?>
                  </h3>
                  
                  <p class="info">
                    <span class="text-muted">[<?php the_time('d/m/Y') ?>]</span>
                    <?php echo excerpt(55); ?>
                  </p>
                </div><!-- /.media-body -->
              </a>            
            </li>
          </article>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <div class="text-center">
        <h2><span class="fa fa-search"></span> &nbsp;Resultados da pesquisa por: "<span><?php echo get_search_query(); ?></span>"</h2>
      </div>
      
      </br>

      <div class="text-center">
        <h3>Não há resultados para essa pesquisa!</h3>

        <br/>
        
        <div class="search-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="row">
            <form method="get" id="searchform" action="<?php echo bloginfo('url');?>">
              <div class="col-md-4 col-md-offset-4">
                <input type="text" name="s" class="form-control search-query" placeholder="Faça uma nova pesquisa...">
              </div>
            </form>
          </div>
        </div>
      </div>

      <br/><br/><br/>
    <?php endif; ?>
  </div><!-- /.col -->

  <!-- PAGINAÇÃO -->
  <div class="text-center">
    <?php custom_pagination(); ?>
  </div>
  <!-- /PAGINAÇÃO -->

</div><!-- /.row-search-results -->