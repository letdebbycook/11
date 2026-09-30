<?php
/**
 * Checkout Form override
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package ukm-toko-theme
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'Anda harus masuk (login) untuk menyelesaikan pesanan.', 'ukm-toko-theme' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout ukm-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set ukm-checkout-layout" id="customer_details">
			<div class="col-1 ukm-checkout-col">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2 ukm-checkout-col">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

	<h3 id="order_review_heading" class="ukm-checkout-review-heading" style="font-size:var(--ukm-text-xl,1.25rem);margin-top:var(--ukm-space-8,2rem);margin-bottom:var(--ukm-space-4,1rem);">
		<?php esc_html_e( 'Ringkasan Pesanan Anda', 'ukm-toko-theme' ); ?>
	</h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order ukm-checkout-review-box">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
