  <?php switch_to_blog(1); ?>

</div><!-- /.container -->
<!-- /.CONTENT -->


<!-- FOOTER -->
<footer>
  <section role="navigation">
    <h1 class="sr-only">Links de acesso rápido</h1>
    <div class="links-wrapper">
      <div class="container">

        <div class="row row-links">

          <?php
            $link_cat = array(
              'Aluno' => 'Rodapé - Alunos',
              'Comunidade' => 'Rodapé - Comunidade',
              'Servidor' => 'Rodapé - Servidores',
              'Sites de Interesse' => 'Rodapé - Sites de Interesse',
            );
            foreach ($link_cat as $label => $name) {
              echo '
              <div class="col-md-3 white-space-2x">
                <h2>' . $label . '</h2>
                <ul class="list-unstyled">
                  ' . wp_list_bookmarks(
                    array(
                      'category_name' => $name,
                      'categorize' => 0,
                      'title_li' => '',
                      'before' => '<li>',
                      'after' => '</li>',
                      'echo' => false
                    )
                  ) . '
                </ul>
              </div>
              ';
            }
          ?>

        </div><!-- /.row-links -->

      </div><!-- /.container -->
    </div><!-- /.links-wrapper -->
  </section>

  <div class="bottom-wrapper">
    <div class="container">

      <section>
        <div class="row row-bottom">
          <div class="col-md-12">
            <a href="http://www.acessoainformacao.gov.br/"><img class="imgs-footer acesso" title="Acesso à informação" src="<?php echo get_theme_file_uri('assets/images/logo-acesso-informacao.svg')?>"></a>
            <a href="http://brasil.gov.br/"><img class="imgs-footer brasil" title="Portal de Estado do Brasil" src="<?php echo get_theme_file_uri('assets/images/log-brasil.svg')?>"></a>
          </div>
        </div><!-- /.bottom-links -->
      </section>

    </div><!-- /.container -->
  </div><!-- /.bottom-wrapper -->
</footer>
<!-- /FOOTER -->

</div>

<?php restore_current_blog(); ?>

<!-- wp-footer -->
<?php wp_footer(); ?>
<!-- /.wp-footer -->

</body>
</html>
