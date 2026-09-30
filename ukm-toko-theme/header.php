<?php
/**
 * Template Header — dimuat di semua halaman via get_header().
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<!-- Skip link untuk aksesibilitas keyboard -->
<a class="ukm-skip-link" href="#ukm-main-content">
	<?php esc_html_e( 'Langsung ke konten utama', 'ukm-toko-theme' ); ?>
</a>

<div id="page" class="ukm-site-wrapper">

	<!-- ============================================================ -->
	<!-- HEADER                                                        -->
	<!-- ============================================================ -->
	<header id="masthead" class="ukm-site-header" role="banner">
		<div class="ukm-container">
			<div class="ukm-header-inner">

				<!-- Logo / Nama Toko -->
				<div class="ukm-site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<?php the_custom_logo(); ?>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-site-logo" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<span class="ukm-site-logo-text">
								<?php
								$nama_toko = get_theme_mod( 'ukm_header_site_name', get_bloginfo( 'name' ) );
								// Cetak nama toko — pisahkan kata pertama dengan warna aksen.
								$kata = explode( ' ', esc_html( $nama_toko ), 2 );
								echo '<span>' . esc_html( $kata[0] ) . '</span>';
								if ( isset( $kata[1] ) ) {
									echo ' ' . esc_html( $kata[1] );
								}
								?>
							</span>
						</a>
					<?php endif; ?>
				</div>
				<!-- /Logo -->

				<!-- Navigasi Desktop -->
				<nav id="ukm-primary-nav" class="ukm-site-nav" aria-label="<?php esc_attr_e( 'Menu Utama', 'ukm-toko-theme' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'menu_id'         => 'primary-menu',
							'container'       => false,
							'fallback_cb'     => 'ukm_nav_fallback',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
						)
					);
					?>
				</nav>
				<!-- /Navigasi Desktop -->

				<!-- Aksi Header Kanan -->
				<div class="ukm-header-actions">

					<!-- Tombol Pencarian -->
					<button
						id="ukm-search-toggle"
						class="ukm-header-search-toggle"
						aria-label="<?php esc_attr_e( 'Buka pencarian', 'ukm-toko-theme' ); ?>"
						aria-expanded="false"
						aria-controls="ukm-search-panel"
					>
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
							<circle cx="11" cy="11" r="8"></circle>
							<path d="m21 21-4.35-4.35"></path>
						</svg>
					</button>

					<!-- Ikon Keranjang WooCommerce -->
					<?php if ( ukm_is_woocommerce_active() && get_theme_mod( 'ukm_header_show_cart', true ) ) : ?>
						<a
							href="<?php echo esc_url( wc_get_cart_url() ); ?>"
							class="ukm-header-cart"
							aria-label="<?php
								$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
								echo esc_attr( sprintf( _n( 'Keranjang: %d item', 'Keranjang: %d item', $count, 'ukm-toko-theme' ), $count ) );
							?>"
						>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<circle cx="9" cy="21" r="1"></circle>
								<circle cx="20" cy="21" r="1"></circle>
								<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
							</svg>
							<?php
							$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
							if ( $cart_count > 0 ) :
							?>
								<span class="ukm-cart-count" aria-hidden="true"><?php echo absint( $cart_count ); ?></span>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<!-- Tombol WhatsApp di Header (opsional) -->
					<?php
					$tampil_wa = get_theme_mod( 'ukm_header_show_whatsapp', true );
					$wa_nomor  = ukm_get_option( 'ukm_whatsapp_toko', '' );
					if ( $tampil_wa && $wa_nomor ) :
					?>
						<a
							href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>"
							class="ukm-btn ukm-btn--primary ukm-btn--sm ukm-header-wa"
							target="_blank"
							rel="noopener noreferrer"
							aria-label="<?php esc_attr_e( 'Hubungi kami via WhatsApp', 'ukm-toko-theme' ); ?>"
						>
							<?php esc_html_e( 'WhatsApp', 'ukm-toko-theme' ); ?>
						</a>
					<?php endif; ?>

					<!-- Tombol Hamburger (Mobile) -->
					<button
						id="ukm-menu-toggle"
						class="ukm-menu-toggle"
						aria-label="<?php esc_attr_e( 'Buka menu', 'ukm-toko-theme' ); ?>"
						aria-expanded="false"
						aria-controls="ukm-mobile-nav"
					>
						<span class="ukm-menu-toggle-bar"></span>
						<span class="ukm-menu-toggle-bar"></span>
						<span class="ukm-menu-toggle-bar"></span>
					</button>

				</div>
				<!-- /Aksi Header Kanan -->

			</div>
			<!-- /ukm-header-inner -->

			<!-- Panel Pencarian -->
			<div id="ukm-search-panel" class="ukm-search-panel" aria-hidden="true" hidden>
				<form role="search" method="get" class="ukm-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="ukm-search-input" class="sr-only">
						<?php esc_html_e( 'Cari produk atau artikel', 'ukm-toko-theme' ); ?>
					</label>
					<input
						type="search"
						id="ukm-search-input"
						class="ukm-form-input ukm-search-input"
						name="s"
						placeholder="<?php esc_attr_e( 'Cari produk, sembako, atau artikel...', 'ukm-toko-theme' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						autocomplete="off"
					/>
					<button type="submit" class="ukm-btn ukm-btn--primary" aria-label="<?php esc_attr_e( 'Cari', 'ukm-toko-theme' ); ?>">
						<?php esc_html_e( 'Cari', 'ukm-toko-theme' ); ?>
					</button>
				</form>
			</div>
			<!-- /Panel Pencarian -->

			<!-- Navigasi Mobile -->
			<nav
				id="ukm-mobile-nav"
				class="ukm-mobile-nav"
				aria-label="<?php esc_attr_e( 'Menu Mobile', 'ukm-toko-theme' ); ?>"
				aria-hidden="true"
				hidden
			>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_id'         => 'mobile-menu',
						'container'       => false,
						'fallback_cb'     => 'ukm_nav_fallback',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 2,
					)
				);
				?>
			</nav>
			<!-- /Navigasi Mobile -->

		</div>
		<!-- /ukm-container -->
	</header>
	<!-- /HEADER -->

	<div id="ukm-main-content" tabindex="-1">
<?php
/**
 * Fallback jika menu belum diatur di admin.
 *
 * @since 1.0.0
 */
function ukm_nav_fallback() {
	echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Beranda', 'ukm-toko-theme' ) . '</a></li></ul>';
}
