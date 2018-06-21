function inicializarMenu(elementoUl) {
  let abrirMenu = elementoUl.classList.contains('menu-aberto');
  // A estrutura abaixo é equivalente ao seletor CSS:
  // ul > li > a
  // Não podemos usar o querySelectorAll com o pseudo-elemento :scope
  // devido a falta de compatibilidade com muitos navegadores
  // https://developer.mozilla.org/en-US/docs/Web/CSS/:scope
  var elementosLi = elementoUl.children;
  for (var i = 0; i < elementosLi.length; i++) {
    var filhosLi = elementosLi[i].children;
    for (var j = 0; j < filhosLi.length; j++) {
      var filho = filhosLi[j];
      if (filho.tagName === "A") {
        // Cada elemento A de primeiro nível alternará a visibilidade
        // de seu submenu ao receber um click.
        filho.addEventListener("click", toggleSubMenuOnClick, false);
      } else if (filho.tagName === "UL") {
        if (!abrirMenu){
          toggleSubMenu(filho);
        }
      }
    }
  }
}

function toggleSubMenuOnClick(event) {
  // O método siblings (irmãos) não inclui o próprio elemento.
  // Assim, o primeiro e único irmão será o elemento ul.sub-menu
  let submenu = jQuery(event.target).siblings()[0];
  toggleSubMenu(submenu);
  event.preventDefault();
}

function toggleSubMenu(subMenu){
  jQuery(subMenu).toggle();
}

jQuery(function() {
  let menu_principal = document.querySelector("#menu_principal");
  if (menu_principal !== null) {
    inicializarMenu(menu_principal);
  }

  let menu_campus = document.querySelector(".menu-campus ul");
  if (menu_campus !== null) {
    inicializarMenu(menu_campus);
  }

  let menu_curso = document.querySelector(".menu-curso ul");
  if (menu_curso !== null) {
    inicializarMenu(menu_curso);
  }

  let menu_nossos_campi = document.querySelector(".nossos-campi");
  if (menu_nossos_campi !== null) {
    inicializarMenu(menu_nossos_campi);
  }

  let menu_nossos_cursos = document.querySelector(".nossos-cursos");
  if (menu_nossos_cursos !== null) {
    inicializarMenu(menu_nossos_cursos);
  }
});
