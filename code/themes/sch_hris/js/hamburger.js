(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.toggle = {
    attach: function(context, settings) {

        $(".hamburger-trigger").unbind().click(function(){
          console.log('clicked!');
          $(this).toggleClass("show");
          $(".region-hamburger-menu").toggleClass("show");
        });

    }
  };

}(jQuery, Drupal));
