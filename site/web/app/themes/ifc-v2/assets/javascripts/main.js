// High Contrast ===================================================================================
(function(){
  'use strict';
  
  var high_contrast_action = document.getElementById('high-contrast-action');
  var high_contrast_rules  = '\
    * { background-color: #000 !important; color: #fff !important; } \
    p a { color: #FFFF00 !important; } \
    a:hover { color: #fff !important; } \
    footer .links-wrapper { background: none !important; } \
    .bottom-wrapper { border-top: 1px solid #fff !important; } \
    .easingslider-arrows, .easingslider-icon, .easingslider-pagination{ background-color: transparent !important; } \
    #page-canvas.active #page-content .overlay { background: rgba(0,0,0,0.2) !important; } \
    .modal-dialog * { background-color: #222 !important; border-color: #222 !important;} \
    .modal-dialog .modal-dialog-header * { background-color: #222 !important; } \
    .modal-dialog .modal-dialog-header {  border-bottom: 1px solid white !important; } \
    .modal-overlay { background: rgba(0,0,0,0.8) !important; } \
    .label { border: 1px solid white !important; } \
    .pagination .active a { border-color: white !important; } \
    .main-menu .droplet .fill { background-color: #000 !important; background-image: none !important } \
    header .lista-links-acessibilidade li span { background-color: #eee !important; color: #0d6b1d !important; } \
    header .lista-links-acessibilidade li span { background-color: #eee !important; color: #0d6b1d !important; } \
    .tribe-events-calendar thead th { background-color: #000 !important; color: #fff !important; border: 1px solid #fff; } \
    .tribe-events-calendar div[id*="tribe-events-daynum-"], .tribe-events-calendar div[id*="tribe-events-daynum-"] a{ background-color: #000 !important; color: #fff !important; } \
    .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a{ background-color: #000 !important; color: #fff !important; } \
    .tribe-events-othermonth div[id*="tribe-events-daynum-"]{ background-color: #000 !important; color: #fff !important; } \
    .menu ul li {border-top: 0.4em #999 solid; } \
    .menu .title {border-top: 0.4em #666666 solid; }\
  ';
  
  function loadPreferredState() {
    var state = Cookies.get('contrast-state', {domain: '.ifc.edu.br'});
    if(typeof state === 'undefined' || state === ''){
      Cookies.set('contrast-state', 0, {domain: '.ifc.edu.br'});
      state = 0;
    }
    toggleContrast(state);
  }
  
  function toggleContrast(state) {    
    if (state == 1) {
      if (!document.getElementById('high-contrast-style')) {
        var body          = document.getElementsByTagName('body')[0];
        var style_div     = document.createElement('style');
        var style_content = document.createTextNode(high_contrast_rules);
        
        style_div.id = 'high-contrast-style';
        style_div.appendChild(style_content);
        document.head.appendChild(style_div);
        Cookies.set('contrast-state', 1, {domain: '.ifc.edu.br'});
      }
    } else {
      if (document.getElementById('high-contrast-style')) {
        var style_div = document.getElementById('high-contrast-style');
        document.head.removeChild(style_div);
        Cookies.set('contrast-state', 0, {domain: '.ifc.edu.br'});
      }
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    loadPreferredState();
    
    high_contrast_action.addEventListener('click', function() {
      if (parseInt(Cookies.get('contrast-state'), {domain: '.ifc.edu.br'}) == 0) {
        toggleContrast(1);
      } else {
        toggleContrast(0);
      }
    });
  });
})();

// Off Canvas Menu =================================================================================
(function(){
  'use strict';
  
  function toggleOffCanvas() {
    if ($('#page-canvas').hasClass('active')) {
      // Do things on Nav Close
      $('#page-canvas').removeClass('active');
      $('.overlay').remove();
    } else {
      // Do things on Nav Open
      $('#page-canvas').addClass('active');
      $('#page-content').append('<div class="overlay"></div>');
    }
  }
  
  $(function() {
    $('#toggle-off-canvas').click(function(e) {
      e.preventDefault();
      toggleOffCanvas();
    });
    
    $('#page-content').on('click', '.overlay', function(e) {
      e.preventDefault();
      toggleOffCanvas();
    });
    
    $('#page-canvas').on('swipe', '.overlay', function(e) {
      e.preventDefault();
      toggleOffCanvas();
    });
    
    $(window).on('scroll', function(e) {
      if ($(window).scrollTop() > 300) {
        $('.nav-mobile').addClass("fix-top");
      } else {
        $('.nav-mobile').removeClass("fix-top");
      }
    });
  });
})();

// Dropdown Menu ===================================================================================
(function(){
  'use strict';

  function initMegaMenu() {
    var megaMenu = document.getElementById('main-menu');
    // keyboard stuff
    $(megaMenu).delegate('li a', 'keydown', keyboardHandler);

    // mouse stuff
    $(' > li.has-drop', megaMenu).each(function () {
      var dropdown = $('.droplet', $(this)[0]);

      $(this).hover(
        function () {
          $(this).addClass('active');
          $('.droplet', megaMenu).each(function (index, drop) {
            if (drop !== dropdown) {
              $(drop).hide();
            }
          });

          $(dropdown).slideDown(100);

        }, function () {
          $(this).removeClass('active');
          $(dropdown).slideUp(100);
        }
      );
    });
  }


  function keyboardHandler(keyVent) {
    var target = keyVent.target;
    var which = keyVent.which;

    if (which === 39) { // RIGHT
      if (isTopLevel(target)) {
        // top level item
        var nextTopItem = adjacentTopLevelItem(target, 'next');

        if (nextTopItem) {
          keyVent.preventDefault();
          nextTopItem.focus();
        }
      } else {
        // dropdown item
        var nextDropletItem = adjacentDropdownItem(target, 'next');
        if (nextDropletItem) {
          keyVent.preventDefault();
          nextDropletItem.focus();
        }
      }
    } else if (which === 37) { // LEFT
      if (isTopLevel(target)) {
        // top level item
        var prevTopItem = adjacentTopLevelItem(target, 'prev');

        if (prevTopItem) {
          keyVent.preventDefault();
          prevTopItem.focus();
        }
      } else {
        // dropdown item
        var prevDropItem = adjacentDropdownItem(target, 'prev');
        if (prevDropItem) {
          keyVent.preventDefault();
          prevDropItem.focus();
        }
      }
    } else if (which === 40) { // DOWN
      if (isTopLevel(target) && hasDropdown(target)) {
        // top level item w/ dropdown -- open dropdown
        openDropdown(target);
      } else {
        // dropdown item
        var nextDropItem = adjacentDropdownItem(target, 'next');

        if (nextDropItem) {
          keyVent.preventDefault();
          nextDropItem.focus();
        }
      }
    } else if (which === 38) { // UP
      if (!isTopLevel(target)) {
        if (isFirstDropItem(target)) {
          keyVent.preventDefault();
          var top = closeDropdown(target);
          setTimeout(function () {
            top.focus();
          }, 0);
        } else {
          var prevDropAnchor = adjacentDropdownItem(target, 'prev');

          if (prevDropAnchor) {
            keyVent.preventDefault();
            prevDropAnchor.focus();
          }
        }
      }
    } else if (which === 27) { // ESCAPE
      if (!isTopLevel(target)) {
        var topper = closeDropdown(target);
        setTimeout(function () {
          topper.focus();
        }, 0);
      }
    } else if (which === 9 && keyVent.shiftKey) { // SHIFT + TAB
      if (!isTopLevel(target) && isFirstDropItem(target)) {
        keyVent.preventDefault();
        var topA = closeDropdown(target);
        setTimeout(function () {
          topA.focus();
        }, 0);
      }
    } else if (which === 9) { // TAB
      if (!isTopLevel(target) && isLastDropItem(target)) {
        keyVent.preventDefault();
        var topItem = closeDropdown(target);
        var nextLi = $(topItem.parentNode).next()[0];
        var nextAnchor = $('a', nextLi)[0];
        nextAnchor.focus();
      }
    } else if (which === 13 || which === 32) {
      if (isTopLevel(target) && $(target.parentNode).hasClass('has-drop')) {
        openDropdown(target);
      }
    }
  }

  // determines if the item is a top-level one
  function isTopLevel(item) {
    return $(item).is('#main-menu > li > a');
  }

  // determines if the item has a dropdown
  function hasDropdown(item) {
    return $(item.parentNode).hasClass('has-drop');
  }

  // determines if the item is the first in the dropdown
  function isFirstDropItem(item) {
    var drop = $(item).closest('.droplet')[0];
    var firstInDrop = $('li a', drop)[0];

    return firstInDrop === item;

  }

  // determines if the item is the last in the dropdown
  function isLastDropItem(item) {
    var drop = $(item).closest('.droplet')[0];
    var lastInDrop = $('li a', drop).last()[0];

    return lastInDrop === item;
  }

  // finds the adjacent top level item
  function adjacentTopLevelItem(item, dir) {
    var li = item.parentNode; // <li />
    var adjacentLi = (dir === 'next') ?
                      $(li).next()[0] :
                      $(li).prev()[0];
    var adjacentItem = adjacentLi && $('a', adjacentLi)[0];

    return adjacentItem;
  }

  // finds the next or prev dropdown item
  function adjacentDropdownItem(item, dir) {
    var adjacentDropItem;
    var li = item.parentNode;
    var adjacentSameCol = (dir === 'next') ?
                          $(li).next()[0] :
                          $(li).prev()[0];
    if (adjacentSameCol) {
      // there is one in the same col
      adjacentDropItem = $('a', adjacentSameCol)[0];
    } else {
      // lets look for one in the adjacent column
      var col = $(li).closest('.col')[0];
      var adjacentCol = (dir === 'next') ?
                        $(col).next()[0] :
                        $(col).prev()[0];
      if (adjacentCol) {
        // we've found the adjacent column
        var adjacentItem = (dir === 'next') ?
                            $('li a', adjacentCol)[0] :
                            $('li a', adjacentCol).last()[0];

        if (adjacentItem) {
          adjacentDropItem = adjacentItem;
        }
      }
    }

    return adjacentDropItem;
  }


  function openDropdown(item) {
    $(item.parentNode).addClass('active');
    var droplet = $(item).next()[0];
    // open the dropdown...
    $(droplet).slideDown(100);
    // ...and focus the first item
    setTimeout(function () {
      $('a', droplet)[0].focus();
    }, 100);
  }

  function closeDropdown(item) {
    var droplet = $(item).closest('.droplet')[0];
    var topLevelItem = $(droplet).prev()[0];
    $(topLevelItem.parentNode).removeClass('active');
    $(droplet).slideUp(100);

    return topLevelItem;
  }



  ////////////////////////////////////
  $(document).ready(initMegaMenu);
  ////////////////////////////////////
})();

// Magnific Popup ==================================================================================
(function(){
  'use strict';
  
  $(function() {
    $('.entry-content a[href*=".jpg"], .entry-content a[href*=".jpeg"], .entry-content a[href*=".png"], .entry-content a[href*=".gif"]').each(function(){
      if ($(this).parents('.gallery').length == 0) {
        $(this).magnificPopup({
            type:'image',
            closeOnContentClick: true,
        });
      }
    });
    
    $('.gallery').each(function() {
      $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {enabled: true}
      });
    });
  });
})();

// Modal ===========================================================================================
(function(){
  'use strict';
    
  $(function() {
    $('.modal-activate').click(function(e) {
      e.preventDefault();
      
      $(this).next('.modal-dialog').addClass('active');
      $('.modal-overlay').addClass('active');
    });
    
    $('.modal-overlay').click(function() {
      $('.modal-dialog').removeClass('active');
      $('.modal-overlay').removeClass('active');
    });
    
    $('.modal-dialog-close').click(function(e) {
      e.preventDefault();
      $('.modal-dialog').removeClass('active');
      $('.modal-overlay').removeClass('active');
    });

    $(document).on('keyup', function(e) {
      if(e.keyCode === 27) {
        $('.modal-dialog').removeClass('active');
        $('.modal-overlay').removeClass('active');
      }
    });
  });
})();

// Main Menu ========================================================================================
(function(){
  'use strict';
  
  $(function() {
    $('#accordion-off-canvas').on('click', '.collapsible', function(e) {
      $(this).find('i').toggleClass('fa-rotate-90');
    });
    
    $('#accordion-side-menu').on('click', '.collapsible', function(e) {
      $(this).find('i').toggleClass('fa-rotate-90');
    });
  });
})();

// EOF =============================================================================================