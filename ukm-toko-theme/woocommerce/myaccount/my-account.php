<?php
/**
 * My Account page override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package ukm-toko-theme
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="ukm-myaccount-wrapper" style="display:grid;grid-template-columns:240px 1fr;gap:var(--ukm-space-8,2rem);margin:var(--ukm-space-8,2rem) 0;">
	<aside class="ukm-myaccount-sidebar">
		<?php
		/**
		 * My Account navigation.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_navigation' );
		?>
	</aside>

	<div class="woocommerce-MyAccount-content ukm-myaccount-content">
		<?php
		/**
		 * My Account content.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
		?>
	</div>
</div>
