(function ($, Drupal) {
  "use strict";

  Drupal.behaviors.slickSlider = {
    attach: function (context) {
      $(".cklb-slideshow:not(.layout-builder__region)", context)
        .once("slick-slider")
        .each(function () {
          $(this).slick({
            arrows: true,
            dots: true,
            infinite: true,
            speed: 500,
            fade: true
          });
        });
    },
  };

})(jQuery, Drupal);
