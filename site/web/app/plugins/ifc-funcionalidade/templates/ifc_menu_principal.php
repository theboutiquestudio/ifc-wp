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
                  $info_curso = IFC_Consulta_Cursos::get_cursos_do_campi(4);
                  foreach ($info_curso as $curso) {
                    ?>
                    <li><?= $curso->nome ?></li>
                    <?php
                  }
                ?>
              </ul>
            </li>
          </ul>
        <?php
      }
    ?>

      <ul class="nossos-campi" <?php if (IFC_Func::get_tipo_site_atual() == 'geral'): ?>
        <?php echo 'menu-aberto'; ?>
      <?php endif ?>>
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
