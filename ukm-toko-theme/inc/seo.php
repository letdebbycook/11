<?php
/**
 * SEO teknis: Schema JSON-LD, Open Graph, Twitter Card, Canonical.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output schema JSON-LD di <head> halaman.
 *
 * Schema yang dihasilkan:
 * - Organization + LocalBusiness (semua halaman).
 * - WebSite dengan SearchAction (semua halaman).
 * - Product (single produk CPT & WooCommerce single product).
 * - BreadcrumbList (semua halaman dengan breadcrumb).
 * - Article (single post blog).
 *
 * @since 1.0.0
 */
function ukm_output_schema_json_ld() {
	$schemas = array();

	// ---- Schema: Organization + LocalBusiness ----
	$schemas[] = ukm_schema_local_business();

	// ---- Schema: WebSite ----
	$schemas[] = ukm_schema_website();

	// ---- Schema: BreadcrumbList ----
	$breadcrumb = ukm_build_breadcrumb_schema();
	if ( ! empty( $breadcrumb ) ) {
		$schemas[] = $breadcrumb;
	}

	// ---- Schema: Single Produk CPT ----
	if ( is_singular( 'produk' ) ) {
		$schemas[] = ukm_schema_produk_cpt();
	}

	// ---- Schema: WooCommerce Single Product ----
	if ( ukm_is_woocommerce_active() && is_product() ) {
		$schemas[] = ukm_schema_woocommerce_product();
	}

	// ---- Schema: Blog Post / Article ----
	if ( is_singular( 'post' ) ) {
		$schemas[] = ukm_schema_article();
	}

	// Output semua schema.
	foreach ( $schemas as $schema ) {
		if ( empty( $schema ) ) {
			continue;
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'ukm_output_schema_json_ld', 5 );

/**
 * Bangun schema Organization + LocalBusiness.
 *
 * @since  1.0.0
 * @return array Schema JSON-LD.
 */
function ukm_schema_local_business() {
	$nama       = ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) );
	$alamat     = ukm_get_option( 'ukm_alamat_toko', '' );
	$kota       = ukm_get_option( 'ukm_kota_toko', '' );
	$provinsi   = ukm_get_option( 'ukm_provinsi_toko', '' );
	$kodepos    = ukm_get_option( 'ukm_kodepos_toko', '' );
	$telepon    = ukm_get_option( 'ukm_telepon_toko', '' );
	$email      = ukm_get_option( 'ukm_email_toko', get_bloginfo( 'admin_email' ) );
	$jam_buka   = ukm_get_option( 'ukm_jam_buka', '' );
	$logo_url   = '';

	// Ambil URL logo.
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( $logo_image ) {
			$logo_url = $logo_image[0];
		}
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => array( 'LocalBusiness', 'GroceryStore' ),
		'@id'             => esc_url( home_url( '/' ) ) . '#localbusiness',
		'name'            => esc_html( $nama ),
		'description'     => esc_html( get_bloginfo( 'description' ) ),
		'url'             => esc_url( home_url( '/' ) ),
	);

	if ( $logo_url ) {
		$schema['logo'] = array(
			'@type' => 'ImageObject',
			'url'   => esc_url( $logo_url ),
		);
		$schema['image'] = esc_url( $logo_url );
	}

	if ( $telepon ) {
		$schema['telephone'] = esc_html( $telepon );
	}

	if ( $email ) {
		$schema['email'] = sanitize_email( $email );
	}

	if ( $alamat || $kota ) {
		$schema['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => esc_html( $alamat ),
			'addressLocality' => esc_html( $kota ),
			'addressRegion'   => esc_html( $provinsi ),
			'postalCode'      => esc_html( $kodepos ),
			'addressCountry'  => 'ID',
		);
	}

	if ( $jam_buka ) {
		$schema['openingHours'] = esc_html( $jam_buka );
	}

	// Tambahkan profil media sosial.
	$same_as = array();
	$facebook  = ukm_get_option( 'ukm_facebook_url', '' );
	$instagram = ukm_get_option( 'ukm_instagram_url', '' );
	$tiktok    = ukm_get_option( 'ukm_tiktok_url', '' );

	if ( $facebook )  $same_as[] = esc_url( $facebook );
	if ( $instagram ) $same_as[] = esc_url( $instagram );
	if ( $tiktok )    $same_as[] = esc_url( $tiktok );

	if ( ! empty( $same_as ) ) {
		$schema['sameAs'] = $same_as;
	}

	return $schema;
}

/**
 * Bangun schema WebSite dengan SearchAction.
 *
 * @since  1.0.0
 * @return array Schema JSON-LD.
 */
function ukm_schema_website() {
	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'@id'             => esc_url( home_url( '/' ) ) . '#website',
		'url'             => esc_url( home_url( '/' ) ),
		'name'            => esc_html( get_bloginfo( 'name' ) ),
		'description'     => esc_html( get_bloginfo( 'description' ) ),
		'inLanguage'      => 'id-ID',
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => esc_url( home_url( '/?s={search_term_string}' ) ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);
}

/**
 * Bangun schema BreadcrumbList berdasarkan halaman saat ini.
 *
 * @since  1.0.0
 * @return array|null Schema JSON-LD atau null jika tidak relevan.
 */
function ukm_build_breadcrumb_schema() {
	$items = array();
	$pos   = 1;

	// Item pertama selalu: Beranda.
	$items[] = array(
		'@type'    => 'ListItem',
		'position' => $pos++,
		'name'     => __( 'Beranda', 'ukm-toko-theme' ),
		'item'     => esc_url( home_url( '/' ) ),
	);

	if ( is_singular( 'produk' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => __( 'Produk', 'ukm-toko-theme' ),
			'item'     => esc_url( get_post_type_archive_link( 'produk' ) ),
		);

		$terms = get_the_terms( get_the_ID(), 'kategori-produk' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term = reset( $terms );
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $pos++,
				'name'     => esc_html( $term->name ),
				'item'     => esc_url( get_term_link( $term ) ),
			);
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => esc_html( get_the_title() ),
			'item'     => esc_url( get_permalink() ),
		);

	} elseif ( is_singular( 'post' ) ) {
		$category = get_the_category();
		if ( $category ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $pos++,
				'name'     => esc_html( $category[0]->name ),
				'item'     => esc_url( get_category_link( $category[0]->term_id ) ),
			);
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => esc_html( get_the_title() ),
			'item'     => esc_url( get_permalink() ),
		);

	} elseif ( is_page() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => esc_html( get_the_title() ),
			'item'     => esc_url( get_permalink() ),
		);
	}

	if ( count( $items ) <= 1 ) {
		return null; // Hanya beranda — tidak perlu breadcrumb schema.
	}

	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

/**
 * Bangun schema Product untuk CPT 'produk'.
 *
 * @since  1.0.0
 * @return array Schema JSON-LD.
 */
function ukm_schema_produk_cpt() {
	$post_id = get_the_ID();
	$harga   = get_post_meta( $post_id, '_ukm_harga', true );
	$stok    = get_post_meta( $post_id, '_ukm_stok', true );
	$sku     = get_post_meta( $post_id, '_ukm_sku', true );
	$status  = get_post_meta( $post_id, '_ukm_status_produk', true );

	$availability = 'https://schema.org/InStock';
	if ( 'habis' === $status ) {
		$availability = 'https://schema.org/OutOfStock';
	} elseif ( 'pesan_dulu' === $status ) {
		$availability = 'https://schema.org/PreOrder';
	} elseif ( 'dihentikan' === $status ) {
		$availability = 'https://schema.org/Discontinued';
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => esc_html( get_the_title() ),
		'description' => esc_html( get_the_excerpt() ),
		'url'         => esc_url( get_permalink() ),
	);

	// Gambar produk.
	if ( has_post_thumbnail() ) {
		$image_url = get_the_post_thumbnail_url( $post_id, 'ukm-product-featured' );
		if ( $image_url ) {
			$schema['image'] = esc_url( $image_url );
		}
	}

	// SKU.
	if ( $sku ) {
		$schema['sku'] = esc_html( $sku );
	}

	// Penawaran harga.
	if ( $harga ) {
		$schema['offers'] = array(
			'@type'         => 'Offer',
			'price'         => number_format( (float) $harga, 0, '.', '' ),
			'priceCurrency' => 'IDR',
			'availability'  => $availability,
			'seller'        => array(
				'@type' => 'Organization',
				'name'  => esc_html( ukm_get_option( 'ukm_nama_toko', get_bloginfo( 'name' ) ) ),
			),
		);
	}

	// Kategori.
	$terms = get_the_terms( $post_id, 'kategori-produk' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$schema['category'] = esc_html( $terms[0]->name );
	}

	return $schema;
}

/**
 * Bangun schema Product untuk WooCommerce single product.
 *
 * @since  1.0.0
 * @return array Schema JSON-LD.
 */
function ukm_schema_woocommerce_product() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_the_ID() );
	}

	if ( ! $product ) {
		return array();
	}

	$price        = $product->get_price();
	$availability = $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'@id'         => esc_url( get_permalink() ) . '#product',
		'name'        => esc_html( $product->get_name() ),
		'description' => esc_html( $product->get_short_description() ?: $product->get_description() ),
		'url'         => esc_url( get_permalink() ),
		'sku'         => esc_html( $product->get_sku() ),
	);

	// Gambar produk.
	$image_id = $product->get_image_id();
	if ( $image_id ) {
		$image_url = wp_get_attachment_image_url( $image_id, 'ukm-product-featured' );
		if ( $image_url ) {
			$schema['image'] = esc_url( $image_url );
		}
	}

	// Penawaran harga.
	if ( $price ) {
		$schema['offers'] = array(
			'@type'         => 'Offer',
			'price'         => $price,
			'priceCurrency' => get_woocommerce_currency(),
			'availability'  => $availability,
			'url'           => esc_url( get_permalink() ),
		);
	}

	// Rating agregat jika ada ulasan.
	$rating_count = $product->get_rating_count();
	if ( $rating_count > 0 ) {
		$schema['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => number_format( $product->get_average_rating(), 1 ),
			'reviewCount' => absint( $rating_count ),
		);
	}

	return $schema;
}

/**
 * Bangun schema Article untuk single post blog.
 *
 * @since  1.0.0
 * @return array Schema JSON-LD.
 */
function ukm_schema_article() {
	$post_id       = get_the_ID();
	$author_id     = get_the_author_meta( 'ID' );
	$author_name   = get_the_author_meta( 'display_name' );
	$published     = get_the_date( 'c' );
	$modified      = get_the_modified_date( 'c' );

	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'Article',
		'headline'         => esc_html( get_the_title() ),
		'description'      => esc_html( get_the_excerpt() ),
		'url'              => esc_url( get_permalink() ),
		'datePublished'    => $published,
		'dateModified'     => $modified,
		'author'           => array(
			'@type' => 'Person',
			'name'  => esc_html( $author_name ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => esc_html( get_bloginfo( 'name' ) ),
		),
		'inLanguage'       => 'id-ID',
	);

	if ( has_post_thumbnail( $post_id ) ) {
		$image_url = get_the_post_thumbnail_url( $post_id, 'ukm-og-image' );
		if ( $image_url ) {
			$schema['image'] = array(
				'@type' => 'ImageObject',
				'url'   => esc_url( $image_url ),
			);
		}
	}

	return $schema;
}

// ============================================================
// Open Graph & Twitter Card
// ============================================================

/**
 * Output meta tag Open Graph dan Twitter Card.
 *
 * Catatan: Jika RankMath aktif, plugin tersebut akan menangani ini.
 * Fungsi ini hanya berjalan jika tidak ada plugin SEO yang aktif.
 *
 * @since 1.0.0
 */
function ukm_output_og_meta_tags() {
	// Jika ada plugin SEO aktif, biarkan mereka menangani OG tags.
	if ( function_exists( 'rank_math' ) || function_exists( 'wpseo_init' ) ) {
		return;
	}

	$og_title       = '';
	$og_description = '';
	$og_image       = '';
	$canonical      = wp_get_canonical_url();
	$og_url         = esc_url( $canonical ? $canonical : ( is_singular() ? get_permalink() : home_url( '/' ) ) );

	if ( is_singular() ) {
		$og_title       = get_the_title();
		$og_description = get_the_excerpt();
		$og_type        = 'article';

		if ( has_post_thumbnail() ) {
			$og_image = get_the_post_thumbnail_url( get_the_ID(), 'ukm-og-image' );
		}
	} elseif ( is_home() || is_front_page() ) {
		$og_title       = get_bloginfo( 'name' );
		$og_description = get_bloginfo( 'description' );
	} elseif ( is_archive() ) {
		$og_title       = get_the_archive_title();
		$og_description = get_the_archive_description();
	}

	// Default OG image fallback.
	if ( ! $og_image ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id, 'ukm-og-image' );
			if ( $logo ) {
				$og_image = $logo[0];
			}
		}
	}

	$og_site_name = esc_html( get_bloginfo( 'name' ) );
	?>
	<!-- Open Graph -->
	<meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>" />
	<meta property="og:url" content="<?php echo esc_url( $og_url ); ?>" />
	<meta property="og:title" content="<?php echo esc_attr( $og_title ); ?>" />
	<meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>" />
	<meta property="og:site_name" content="<?php echo esc_attr( $og_site_name ); ?>" />
	<meta property="og:locale" content="id_ID" />
	<?php if ( $og_image ) : ?>
	<meta property="og:image" content="<?php echo esc_url( $og_image ); ?>" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<?php endif; ?>

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo esc_attr( $og_title ); ?>" />
	<meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>" />
	<?php if ( $og_image ) : ?>
	<meta name="twitter:image" content="<?php echo esc_url( $og_image ); ?>" />
	<?php endif; ?>
	<?php
}
add_action( 'wp_head', 'ukm_output_og_meta_tags', 4 );

/**
 * Output link canonical.
 *
 * WordPress sudah menangani ini via wp_head() untuk post/page standar.
 * Fungsi ini menambahkan canonical untuk halaman arsip dan taksonomi.
 *
 * @since 1.0.0
 */
function ukm_output_canonical() {
	// Jika ada plugin SEO, biarkan mereka menangani.
	if ( function_exists( 'rank_math' ) || function_exists( 'wpseo_init' ) ) {
		return;
	}

	// WordPress sudah menangani canonical untuk singular pages.
	// Tambahkan hanya untuk halaman yang tidak ditangani WP secara default.
	if ( is_archive() || is_tax() ) {
		$canonical = get_term_link( get_queried_object() );
		if ( ! is_wp_error( $canonical ) ) {
			echo '<link rel="canonical" href="' . esc_url( $canonical ) . '" />' . "\n";
		}
	}
}
add_action( 'wp_head', 'ukm_output_canonical', 6 );

/**
 * Tambahkan hreflang ID sebagai persiapan multibahasa.
 *
 * Saat ini hanya untuk bahasa Indonesia.
 * Untuk multibahasa penuh, install WPML atau Polylang.
 *
 * @since 1.0.0
 */
function ukm_output_hreflang() {
	$current_url = esc_url( ( is_ssl() ? 'https' : 'http' ) . '://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) );

	echo '<link rel="alternate" hreflang="id" href="' . esc_url( $current_url ) . '" />' . "\n";
	echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $current_url ) . '" />' . "\n";
}
add_action( 'wp_head', 'ukm_output_hreflang', 7 );
