<?php
namespace Drupal\commerce_kickstart_layout_builder\Plugin\Layout;

use Drupal\bootstrap_layout_builder\Plugin\Layout\BootstrapLayout;

/**
 * Slideshow custom layout.
 *
 * @Layout(
 *   id = "cklb_slideshow",
 *   label = @Translation("Slideshow"),
 *   template = "templates/cklb_slideshow",
 *   library = "commerce_kickstart_layout_builder/cklb-slideshow",
 *   description = @Translation("Each block added to this region will be an individual slide."),
 *   regions = {
 *     "main" = {
 *       "label" = @Translation("Main content"),
 *     }
 *   },
 *   icon_map = {
 *     0 = {"main"}
 *   }
 * )
 */
class SlideshowLayout extends BootstrapLayout {
  // Override any methods you'd like to customize here!
}
