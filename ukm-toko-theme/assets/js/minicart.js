/**
 * JavaScript interaksi WooCommerce Mini-Cart
 *
 * Menangani toggle drawer/dropdown mini cart, updating fragment event,
 * dan aksesibilitas keyboard untuk keranjang belanja.
 *
 * @package ukm-toko-theme
 */
(function ($) {
  'use strict';

  function initMiniCart() {
    var $cartToggle = $('.ukm-cart-toggle');
    var $miniCart = $('.ukm-mini-cart-dropdown, .ukm-mini-cart-drawer');

    if (!$cartToggle.length || !$miniCart.length) return;

    $cartToggle.on('click', function (e) {
      e.preventDefault();
      var isExpanded = $(this).attr('aria-expanded') === 'true';
      $(this).attr('aria-expanded', !isExpanded);
      $miniCart.toggleClass('is-open', !isExpanded);
    });

    $(document).on('click', function (e) {
      if (!$(e.target).closest('.ukm-header-cart').length) {
        $cartToggle.attr('aria-expanded', 'false');
        $miniCart.removeClass('is-open');
      }
    });

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && $miniCart.hasClass('is-open')) {
        $cartToggle.attr('aria-expanded', 'false');
        $miniCart.removeClass('is-open');
        $cartToggle.focus();
      }
    });

    // Update cart badge bounce animation on WooCommerce added_to_cart event
    $(document.body).on('added_to_cart removed_from_cart', function () {
      var $badge = $('.ukm-cart-badge');
      if ($badge.length) {
        $badge.addClass('ukm-pulse');
        setTimeout(function () {
          $badge.removeClass('ukm-pulse');
        }, 600);
      }
    });
  }

  $(document).ready(initMiniCart);
})(jQuery);
