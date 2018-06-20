 <section class="menu-principal" role="navigation">
    <!-- inicio menu nossos campi  -->
  <!--   <div class="nossos-campi">
      <h1 class="sr-only">Nossos Campi</h1>
      <div class="text-center menu">
        <div class="title collapsible" href="#collapse-0" data-toggle="collapse"  aria-expanded="false">Nossos <i>Campi</i>&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
          </div>
      </div>
      <ul id="collapse-0" class="list-inline acesso-rapido in">
        <li class=""><a href="">Abelardo Luz</a></li>
        <li class=""><a href="">Araquari</a></li>
        <li class=""><a href="">Blumenau</a></li>
        <li class=""><a href="">Brusque</a></li>
        <li class=""><a href="">Camburiú</a></li>
        <li class=""><a href="">Concórdia</a></li>
        <li class=""><a href="">Fraiburgo</a></li>
        <li class=""><a href="">Ibirama</a></li>
        <li class=""><a href="">Luzerna</a></li>
        <li class=""><a href="">Rio do Sul</a></li>
        <li class=""><a href="">Rio do Sul</a></li>
        <li class=""><a href="">Santa Rosa do Sul</a></li>
        <li class=""><a href="">São Francisco do Sul</a></li>
        <li class=""><a href="">Sombrio</a></li>

        <li><a href="">Videira</a></li>
      </ul>

    </div> -->
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
