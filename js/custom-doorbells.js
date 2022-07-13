var shuffleme = (function( $ ) {
  'use strict';
  var $grid = $('#grid'), //locate what we want to sort 
      $filterOptions = $('.product-filter li'),  //locate the filter categories
      $sizer = $grid.find('.shuffle_sizer'),    //sizer stores the size of the items

  init = function() {
    // None of these need to be executed synchronously
    setTimeout(function() {
      listen();
      setupFilters();
    }, 100);

    // instantiate the plugin
    $grid.shuffle({
      itemSelector: '[class*="col-"]',
      sizer: $sizer    
    });

    // setTimeout(function() {
    //   const params = new URLSearchParams(window.location.search);
    //   const catName = params.get("category");
    //   switch (catName) {
    //     case 'beachy':
    //       $grid.shuffle( 'shuffle', 'beachy' );
    //       break;
    //     case 'contemporary':
    //       $grid.shuffle( 'shuffle', 'comtemporary' );
    //       break;
    //     case 'dog':
    //       $grid.shuffle( 'shuffle', 'dog' );
    //       break;
    //     case 'animals':
    //       $grid.shuffle( 'shuffle', 'animals' );
    //       break;  
    //     case 'petroglyphs':
    //       $grid.shuffle( 'shuffle', 'petroglyphs' );
    //       break;
    //     case 'plants':
    //       $grid.shuffle( 'shuffle', 'plants' );
    //       break;
    //     case 'southwest':
    //       $grid.shuffle( 'shuffle', 'southwest' );
    //       break;
    //     case 'misc':
    //       $grid.shuffle( 'shuffle', 'misc' );
    //       break;
    //     case 'custom':
    //       $grid.shuffle( 'shuffle', 'custom' );
    //       break;
    //     default:
    //       break;  
    //   }
    // }, 1000);
    
    
  },

      

  // Set up button clicks
  setupFilters = function() {
    var $btns = $filterOptions.children();
    $btns.on('click', function(e) {
      e.preventDefault();
      var $this = $(this),
          isActive = $this.hasClass( 'active' ),
          group = isActive ? 'all' : $this.data('group');
          console.log("group: " + group);

      // Hide current label, show current label in title
      if ( !isActive ) {
        $('.product-filter li a').removeClass('active');
      }

      $this.toggleClass('active');

      // Filter elements
      $grid.shuffle( 'shuffle', group );
    });

    $btns = null;
  },

  // Re layout shuffle when images load. This is only needed
  // below 768 pixels because the .picture-item height is auto and therefore
  // the height of the picture-item is dependent on the image
  // I recommend using imagesloaded to determine when an image is loaded
  // but that doesn't support IE7
  listen = function() {
    var debouncedLayout = $.throttle( 300, function() {
      $grid.shuffle('update');
    });

    // Get all images inside shuffle
    $grid.find('img').each(function() {
      var proxyImage;

      // Image already loaded
      if ( this.complete && this.naturalWidth !== undefined ) {
        return;
      }

      // If none of the checks above matched, simulate loading on detached element.
      proxyImage = new Image();
      $( proxyImage ).on('load', function() {
        $(this).off('load');
        debouncedLayout();
      });

      proxyImage.src = this.src;
    });

    // Because this method doesn't seem to be perfect.
    setTimeout(function() {
      debouncedLayout();
    }, 500);
  };      

  return {
    init: init
  };
}( jQuery ));

$(document).ready(function()
{
  shuffleme.init(); //filter product
});