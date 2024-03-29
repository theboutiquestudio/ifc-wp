 <section class="menu-principal" role="navigation">



    <div>
      <?php
      if (IFC_Func::is_current_site('campus')){
        ?>
          <ul class="nossos-cursos menu-aberto">
            <li>
              <a>Nossos Cursos</a>
              <ul>
                <?php
                  $info_curso = IFC_Consulta_Cursos::get_cursos_do_campi(IFC_Func::get_id_campus_atual());
                  foreach ($info_curso as $curso) {
                    ?>
                    <li>
                      <a href="<?= $curso->url ?>">
                        <?= $curso->nome ?>
                      </a>
                    </li>
                    <?php
                  }
                ?>
              </ul>
            </li>
          </ul>
        <?php
      }
      $classes_menu_nossos_campi = "nossos-campi";
      if (IFC_Func::get_tipo_site_atual() === 'geral'){
        $classes_menu_nossos_campi .= " menu-aberto";
      }
    ?>

      <ul class="<?= $classes_menu_nossos_campi ?> ">
        <li>
          <a>Nossos Campi</a>
          <ul>
            <?php
              $info_campi = IFC_Consulta_Campi::get_campi();
              foreach ($info_campi as $campi) {
                ?>
                <li>
                  <a href="<?= $campi->url ?>">
                    <?php echo($campi->nome); ?>
                  </a>
                </li>
                <?php
              }
            ?>
          </ul>
        </li>
      </ul>
    </div>


    <!-- fim menu nossos campi  -->
    <!-- Menu de Acesso à informaçao -->

      <?php
        switch_to_blog(get_main_site_id(get_network(1)->id));
        wp_nav_menu(array(
          'theme_location' => 'Superior',
          'fallback_cb' => false,
          'menu_id' => 'menu_principal',
        ));
        restore_current_blog();
      ?>
  </section>
