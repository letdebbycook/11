<?php
/**
 * Dukungan dan kustomisasi WooCommerce.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Jika WooCommerce tidak aktif, tidak ada yang dilakukan.
if ( ! ukm_is_woocommerce_active() ) {
	return;
}

/**
 * Deklarasikan dukungan tema terhadap WooCommerce.
 *
 * @since 1.0.0
 */
function ukm_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 520,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 10,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);

	// Aktifkan zoom pada gambar produk.
	add_theme_support( 'wc-product-gallery-zoom' );

	// Aktifkan lightbox pada galeri produk.
	add_theme_support( 'wc-product-gallery-lightbox' );

	// Aktifkan slider pada galeri produk.
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ukm_woocommerce_setup' );

/**
 * Hapus CSS WooCommerce default dan gantikan dengan style tema.
 *
 * @since  1.0.0
 * @param  array $enqueue_styles Daftar stylesheet WooCommerce.
 * @return array Daftar stylesheet setelah modifikasi.
 */
function ukm_woocommerce_disable_default_styles( $enqueue_styles ) {
	// Hapus style dasar WooCommerce yang akan kita override dengan CSS kita sendiri.
	// Tetap pertahankan yang penting seperti layout dan komponen spesifik.
	unset( $enqueue_styles['woocommerce-general'] );   // Style umum WooCommerce.
	unset( $enqueue_styles['woocommerce-layout'] );    // Layout WooCommerce.
	unset( $enqueue_styles['woocommerce-smallscreen'] ); // Responsif WooCommerce.

	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'ukm_woocommerce_disable_default_styles' );

/**
 * Wrap konten WooCommerce dengan kontainer tema.
 *
 * @since 1.0.0
 */
function ukm_woocommerce_wrapper_before() {
	echo '<div class="ukm-container ukm-woocommerce-wrap">';
}

function ukm_woocommerce_wrapper_after() {
	echo '</div>';
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'ukm_woocommerce_wrapper_before', 10 );
add_action( 'woocommerce_after_main_content', 'ukm_woocommerce_wrapper_after', 10 );

/**
 * Hapus sidebar WooCommerce default.
 *
 * Sidebar khusus toko ditangani via sidebar yang didaftarkan di setup.php.
 *
 * @since 1.0.0
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Tampilkan breadcrumb WooCommerce dengan markup aksesibel.
 *
 * @since  1.0.0
 * @param  array $args Argumen breadcrumb.
 * @return array Argumen yang sudah dimodifikasi.
 */
function ukm_woocommerce_breadcrumb_args( $args ) {
	$args['delimiter']   = '<span class="ukm-breadcrumb__separator" aria-hidden="true">/</span>';
	$args['wrap_before'] = '<nav class="ukm-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'ukm-toko-theme' ) . '">';
	$args['wrap_after']  = '</nav>';
	$args['before']      = '<span class="ukm-breadcrumb__item">';
	$args['after']       = '</span>';

	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'ukm_woocommerce_breadcrumb_args' );

/**
 * Ubah jumlah produk yang tampil di arsip per halaman.
 *
 * @since  1.0.0
 * @return int Jumlah produk per halaman.
 */
function ukm_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'ukm_woocommerce_products_per_page' );

/**
 * Ubah jumlah produk terkait yang tampil di single produk.
 *
 * @since  1.0.0
 * @param  array $args Argumen query produk terkait.
 * @return array Argumen yang sudah dimodifikasi.
 */
function ukm_woocommerce_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'ukm_woocommerce_related_products_args' );

/**
 * Tambahkan class body khusus untuk halaman WooCommerce.
 *
 * @since  1.0.0
 * @param  array $classes Daftar class body.
 * @return array Class body dengan tambahan.
 */
function ukm_woocommerce_body_class( $classes ) {
	if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
		$classes[] = 'ukm-is-woocommerce';
	}
	return $classes;
}
add_filter( 'body_class', 'ukm_woocommerce_body_class' );

/**
 * Tampilkan jumlah item di mini cart secara real-time via AJAX.
 *
 * @since  1.0.0
 * @param  array $fragments Fragment yang diupdate saat cart berubah.
 * @return array Fragment dengan penghitung cart yang diperbarui.
 */
function ukm_woocommerce_cart_count_fragments( $fragments ) {
	ob_start();
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<span class="ukm-cart-count" aria-label="<?php echo esc_attr( sprintf( _n( '%d item', '%d item', $count, 'ukm-toko-theme' ), $count ) ); ?>"><?php echo absint( $count ); ?></span>
	<?php
	$fragments['span.ukm-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ukm_woocommerce_cart_count_fragments' );

/**
 * Tambahkan field nomor WhatsApp di halaman My Account.
 *
 * @since 1.0.0
 */
function ukm_woocommerce_myaccount_extra_fields() {
	$user_id = get_current_user_id();
	$wa      = get_user_meta( $user_id, 'ukm_wa_number', true );
	?>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="ukm_wa_number">
			<?php esc_html_e( 'Nomor WhatsApp', 'ukm-toko-theme' ); ?>
		</label>
		<input
			type="text"
			class="woocommerce-Input woocommerce-Input--text input-text"
			name="ukm_wa_number"
			id="ukm_wa_number"
			value="<?php echo esc_attr( $wa ); ?>"
			placeholder="6281234567890"
			maxlength="20"
		/>
		<span class="description"><?php esc_html_e( 'Format internasional tanpa + (misal: 6281234567890).', 'ukm-toko-theme' ); ?></span>
	</p>
	<?php
}
add_action( 'woocommerce_edit_account_form', 'ukm_woocommerce_myaccount_extra_fields' );

/**
 * Simpan field WhatsApp dari My Account.
 *
 * @since  1.0.0
 * @param  int $user_id ID pengguna yang sedang menyimpan profil.
 * @return void
 */
function ukm_woocommerce_save_myaccount_extra_fields( $user_id ) {
	if ( isset( $_POST['ukm_wa_number'] ) ) {
		// Nonce diverifikasi oleh WooCommerce sebelum memanggil hook ini.
		$wa = sanitize_text_field( wp_unslash( $_POST['ukm_wa_number'] ) );

		// Hanya izinkan angka dan +.
		$wa = preg_replace( '/[^0-9+]/', '', $wa );

		update_user_meta( $user_id, 'ukm_wa_number', $wa );
	}
}
add_action( 'woocommerce_save_account_details', 'ukm_woocommerce_save_myaccount_extra_fields' );

/**
 * Tambahkan field catatan produk di checkout untuk pelanggan.
 *
 * @since 1.0.0
 */
function ukm_woocommerce_checkout_extra_fields( $checkout ) {
	echo '<h3>' . esc_html__( 'Informasi Tambahan', 'ukm-toko-theme' ) . '</h3>';

	woocommerce_form_field(
		'ukm_catatan_pengiriman',
		array(
			'type'        => 'textarea',
			'class'       => array( 'form-row-wide' ),
			'label'       => __( 'Catatan Pengiriman', 'ukm-toko-theme' ),
			'placeholder' => __( 'Misal: Titip di depan pintu, hubungi jika tidak ada orang.', 'ukm-toko-theme' ),
			'required'    => false,
		),
		$checkout->get_value( 'ukm_catatan_pengiriman' )
	);
}
add_action( 'woocommerce_after_order_notes', 'ukm_woocommerce_checkout_extra_fields' );

/**
 * Simpan field catatan pengiriman ke order meta.
 *
 * @since  1.0.0
 * @param  int $order_id ID order yang baru dibuat.
 * @return void
 */
function ukm_woocommerce_save_checkout_extra_fields( $order_id ) {
	if ( isset( $_POST['ukm_catatan_pengiriman'] ) ) {
		// Nonce WooCommerce sudah diverifikasi sebelum hook ini.
		$catatan = sanitize_textarea_field( wp_unslash( $_POST['ukm_catatan_pengiriman'] ) );
		if ( $catatan ) {
			update_post_meta( $order_id, '_ukm_catatan_pengiriman', $catatan );
		}
	}
}
add_action( 'woocommerce_checkout_update_order_meta', 'ukm_woocommerce_save_checkout_extra_fields' );

/**
 * Tampilkan catatan pengiriman di detail order admin.
 *
 * @since 1.0.0
 * @param WC_Order $order Objek order.
 */
function ukm_woocommerce_display_checkout_extra_fields( $order ) {
	$catatan = get_post_meta( $order->get_id(), '_ukm_catatan_pengiriman', true );
	if ( $catatan ) {
		echo '<p><strong>' . esc_html__( 'Catatan Pengiriman:', 'ukm-toko-theme' ) . '</strong> ' . esc_html( $catatan ) . '</p>';
	}
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'ukm_woocommerce_display_checkout_extra_fields' );
