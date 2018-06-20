<?php
  switch_to_blog(1); // Carrega o site principal para buscar os links
  $terms = get_terms('link_category', 'orderby=id');
?> 
  <section>
    <div class="page-subheader">
      <h2><a href="<?php bloginfo('url'); ?>/cursos/"><span class="fa fa-graduation-cap"></span> Cursos</a></h2>
    </div><!-- /.page-subheader -->

    <ul class="list-unstyled courses">
      <?php
        foreach ($terms as $term):
          $term_name_segments = explode(' - ', $term->name);
          if ($term_name_segments[0] != 'Lateral') continue;
      ?>
      
        <li>
          <a href="#" class="modal-activate"> <?php echo $term_name_segments[1]; ?></a> <!-- Nome do tipo de curso -->
          
          <div role="dialog" class="modal-dialog">
            <div class="modal-dialog-header">
              <h3><span class="fa fa-graduation-cap"></span> <?php echo $term_name_segments[1]; ?></h3> <!-- Nome do tipo de curso -->
              <a href="#" class="modal-dialog-close"><span class="fa fa-close" aria-hidden="true"></span><span class="sr-only">Fechar</span></a>
            </div>
            
            <div class="modal-dialog-body">
              <ul class="list-unstyled">
                <?php wp_list_bookmarks(
                  array(
                    'category_name' => $term->name, // Nome da categoria de links que contém os links desejados
                    'categorize'    => 0,
                    'title_li'      => '',
                    'before'        => '<li><span class="fa fa-angle-right"></span> ',
                    'after'         => '</li>')
                  );
                ?>
              </ul>
            </div>
          </div>
        </li>    
      
      <?php endforeach; ?>
    </ul><!-- /.courses -->
    
    <div class="modal-overlay"></div>
  </section>

<?php restore_current_blog(); ?> <!-- Retorna para o site atual -->