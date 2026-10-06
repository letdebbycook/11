<?php
/**
 * Template Header — dimuat di semua halaman via get_header().
 * Layout mengikuti pola Barter: Top Bar + Header Split + Navbar terpisah.
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
	<!-- TOP BAR (seperti Barter: info + CTA)                        -->
	<!-- ============================================================ -->
	<?php
	$wa_nomor   = ukm_get_option( 'ukm_whatsapp_toko', '' );
	$email_toko = ukm_get_option( 'ukm_email_toko', '' );
	$jam_buka   = ukm_get_option( 'ukm_jam_buka', '' );
	$show_topbar = get_theme_mod( 'ukm_show_topbar', true );

	if ( $show_topbar ) :
	?>
	<div class="ukm-top-bar" role="banner">
		<div class="ukm-container">
			<div class="ukm-top-bar__inner">
				<div class="ukm-top-bar__left">
					<?php if ( $jam_buka ) : ?>
						<span class="ukm-top-bar__item">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							<?php echo esc_html( $jam_buka ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $email_toko ) : ?>
						<span class="ukm-top-bar__separator" aria-hidden="true">|</span>
						<span class="ukm-top-bar__item">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<a href="mailto:<?php echo esc_attr( $email_toko ); ?>" class="ukm-top-bar__link"><?php echo esc_html( $email_toko ); ?></a>
						</span>
					<?php endif; ?>
				</div>
				<div class="ukm-top-bar__right">
					<?php if ( $wa_nomor ) : ?>
						<a
							href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $wa_nomor ) ); ?>"
							class="ukm-top-bar__cta"
							target="_blank"
							rel="noopener noreferrer"
							aria-label="<?php esc_attr_e( 'Hubungi via WhatsApp', 'ukm-toko-theme' ); ?>"
						>
							<?php esc_html_e( 'Hubungi Kami', 'ukm-toko-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<!-- /TOP BAR -->

	<!-- ============================================================ -->
	<!-- HEADER: Logo kiri + Search tengah + Cart/Account kanan       -->
	<!-- ============================================================ -->
	<header id="masthead" class="ukm-site-header" role="banner">
		<div class="ukm-container">
			<div class="ukm-header-main">

				<!-- Logo / Nama Toko -->
				<div class="ukm-site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-site-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<?php the_custom_logo(); ?>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ukm-site-logo" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<!-- Ikon toko SVG -->
							<svg class="ukm-logo-icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
								<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
								<polyline points="9 22 9 12 15 12 15 22"/>
							</svg>
							<span class="ukm-site-logo-text">
								<?php
								$nama_toko = get_theme_mod( 'ukm_header_site_name', get_bloginfo( 'name' ) );
								$kata      = explode( ' ', esc_html( $nama_toko ), 2 );
								echo '<span class="ukm-logo-word1">' . esc_html( $kata[0] ) . '</span>';
								if ( isset( $kata[1] ) ) {
									echo ' <span class="ukm-logo-word2">' . esc_html( $kata[1] ) . '</span>';
								}
								?>
							</span>
						</a>
					<?php endif; ?>
				</div>
				<!-- /Logo -->

				<!-- Search Bar (tengah, seperti Barter) -->
				<div class="ukm-header-search-wrap">
					<form role="search" method="get" class="ukm-header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label for="ukm-header-search-input" class="ukm-sr-only">
							<?php esc_html_e( 'Cari produk', 'ukm-toko-theme' ); ?>
						</label>
						<input
							type="search"
							id="ukm-header-search-input"
							class="ukm-header-search-input"
							name="s"
							placeholder="<?php esc_attr_e( 'Cari produk atau kategori...', 'ukm-toko-theme' ); ?>"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							autocomplete="off"
						/>
						<button type="submit" class="ukm-header-search-btn" aria-label="<?php esc_attr_e( 'Cari', 'ukm-toko-theme' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<circle cx="11" cy="11" r="8"/>
								<path d="m21 21-4.35-4.35"/>
							</svg>
						</button>
					</form>
				</div>
				<!-- /Search Bar -->

				<!-- Aksi Header Kanan: Account + Cart -->
				<div class="ukm-header-actions">

					<!-- Akun / Login -->
					<?php if ( ukm_is_woocommerce_active() ) : ?>
						<a
							href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"
							class="ukm-header-action-btn"
							aria-label="<?php esc_attr_e( 'Akun saya', 'ukm-toko-theme' ); ?>"
						>
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
								<circle cx="12" cy="7" r="4"/>
							</svg>
							<span class="ukm-header-action-label"><?php esc_html_e( 'Akun', 'ukm-toko-theme' ); ?></span>
						</a>
					<?php endif; ?>

					<!-- Keranjang WooCommerce -->
					<?php if ( ukm_is_woocommerce_active() && get_theme_mod( 'ukm_header_show_cart', true ) ) : ?>
						<a
							href="<?php echo esc_url( wc_get_cart_url() ); ?>"
							class="ukm-header-action-btn ukm-header-cart"
							aria-label="<?php
								$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
								echo esc_attr( sprintf( _n( 'Keranjang: %d item', 'Keranjang: %d item', $count, 'ukm-toko-theme' ), $count ) );
							?>"
						>
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
								<circle cx="9" cy="21" r="1"/>
								<circle cx="20" cy="21" r="1"/>
								<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
							</svg>
							<span class="ukm-header-action-label"><?php esc_html_e( 'Keranjang', 'ukm-toko-theme' ); ?></span>
							<?php
							$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
							if ( $cart_count > 0 ) :
							?>
								<span class="ukm-cart-badge" aria-hidden="true"><?php echo absint( $cart_count ); ?></span>
							<?php endif; ?>
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
			<!-- /ukm-header-main -->
		</div>
		<!-- /ukm-container header-main -->
	</header>
	<!-- /HEADER -->

	<!-- ============================================================ -->
	<!-- NAVBAR — Menu navigasi terpisah (seperti Barter)             -->
	<!-- ============================================================ -->
	<nav id="ukm-primary-nav" class="ukm-site-navbar" aria-label="<?php esc_attr_e( 'Menu Utama', 'ukm-toko-theme' ); ?>">
		<div class="ukm-container">
			<div class="ukm-navbar-inner">

				<!-- Desktop Nav -->
				<div class="ukm-navbar-menu">
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
				</div>

				<!-- Mobile Nav Drawer -->
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

			</div>
		</div>
	</nav>
	<!-- /NAVBAR -->

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
