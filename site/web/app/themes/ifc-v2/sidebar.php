<div class="col-courses">
  <h1><a href="<?php bloginfo('url'); ?>/cursos/"><span class="fa fa-graduation-cap"></span> Cursos</a></h1>
  
  <ul class="list-unstyled">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Cursos")): endif; ?>
  </ul>
  
  <div class="modal-overlay"></div>
</div>

<div class="col-banner">
  <ul class="list-unstyled">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Banners")): endif; ?>
  </ul>
</div>