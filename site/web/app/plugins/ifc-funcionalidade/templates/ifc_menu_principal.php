 <section class="menu-principal" role="navigation">
    <div>
      <ul>
        <li>
          <a>Nossos Campi</a>
          <ul>
            <?php
              $info_campi = IFC_Consulta_campi::get_campi();
              foreach ($info_campi as $campi) {
                ?>
                <li><?php echo($campi->nome); ?></li>
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
        wp_nav_menu(array(
          'theme_location' => 'Superior',
          'fallback_cb' => false,
        ));
      ?>
      <!-- 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' -->

  </section>
