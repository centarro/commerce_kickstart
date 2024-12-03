(function ($, Drupal) {
  "use strict";

  Drupal.behaviors.slickSlider = {
    attach: function (context) {
      $(once("slick-slider", ".cklb-slideshow:not(.layout-builder__region)", context))
        .each(function () {
          var $slider = $(this);

          $slider.on('init', function (event, slick) {
            if ($slider.find('.slick-current .block-layout-builder').hasClass('text-white')) {
              $slider.addClass('text-white');
            }
          })

          $slider.slick({
              arrows: true,
              dots: true,
              infinite: true,
              speed: 500,
              fade: true
            })
            .on('beforeChange', function (event, slick, currentSlide, nextSlide) {
              var $nextSlideBlock = $(slick.$slides.get(nextSlide)).find('.block-layout-builder');
              if ($nextSlideBlock.hasClass('text-white')) {
                $slider.addClass('text-white');
              } else {
                $slider.removeClass('text-white');
              }
            });
        });
    },
  };

})(jQuery, Drupal);
