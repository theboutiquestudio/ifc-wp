<?php if (has_nav_menu('superior')): ?>
  <nav role="navigation">
    <div id="nav-secondary" class="navbar navbar-default">
    
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-secondary-collapse">
            &nbsp;<span class="fa fa-bars"></span>&nbsp;
            <span class="sr-only">Menu secundário</span>
          </button>
        </div><!-- /.navbar-header -->
    
        <div class="collapse navbar-collapse" id="nav-secondary-collapse">
          <?php
            $defaults = array(
              'theme_location'  => '',
              'menu'            => 'superior',
              'container'       => '',
              'container_class' => '',
              'container_id'    => '',
              'menu_class'      => 'nav navbar-nav',
              'menu_id'         => '',
              'echo'            => true,
              'fallback_cb'     => '',
              'before'          => '',
              'after'           => '',
              'link_before'     => '',
              'link_after'      => '',
              'depth'           => 0,
              'walker'          => new IFC_Walker_Secundario()
            );
            
            wp_nav_menu($defaults);
          ?>
        </div><!-- /#nav-secondary-collapse -->
    
    </div><!-- /#nav-secondary -->
  </nav>
<?php endif; ?>