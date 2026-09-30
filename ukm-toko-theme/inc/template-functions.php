<?php
/**
 * Fungsi pembantu untuk template.
 *
 * @package ukm-toko-theme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Format angka ke format Rupiah.
 *
 * @since  1.0.0
 * @param  float  $angka  Nilai numerik.
 * @param  bool   $prefix Sertakan prefix "Rp" atau tidak.
 * @return string Teks Rupiah yang sudah diformat.
 */
function ukm_format_rupiah( $angka, $prefix = true ) {
	$formatted = number_format( (float) $angka, 0, ',', '.' );
	return $prefix ? 'Rp ' . $formatted : $formatted;
}

/**
 * Ambil meta field produk dengan nilai default.
 *
 * Mendukung dua sumber: ACF (jika aktif) dan WordPress post meta.
 *
 * @since  1.0.0
 * @param  string $field_name Nama field.
 * @param  int    $post_id    ID post (default: post saat ini).
 * @param  mixed  $default    Nilai default jika kosong.
 * @return mixed Nilai field.
 */
function ukm_get_produk_field( $field_name, $post_id = null, $default = '' ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	// Coba ambil dari ACF terlebih dahulu.
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $field_name, $post_id );
		if ( '' !== $value && null !== $value ) {
			return $value;
		}
	}

	// Fallback ke post meta dengan prefix underscore.
	$meta_key = '_' . $field_name;
	$value    = get_post_meta( $post_id, $meta_key, true );

	return ( '' !== $value ) ? $value : $default;
}

/**
 * Tampilkan thumbnail produk dengan lazy loading.
 *
 * Gambar LCP (gambar utama di halaman single) tidak menggunakan lazy load.
 *
 * @since  1.0.0
 * @param  int    $post_id     ID post.
 * @param  string $size        Ukuran gambar.
 * @param  bool   $is_lcp      True jika gambar ini adalah elemen LCP.
 * @param  string $placeholder URL gambar placeholder jika tidak ada thumbnail.
 * @return void
 */
function ukm_product_thumbnail( $post_id = null, $size = 'ukm-product-thumb', $is_lcp = false, $placeholder = '' ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$loading = $is_lcp ? 'eager' : 'lazy';
	$decoding = $is_lcp ? 'sync' : 'async';

	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail(
			$post_id,
			$size,
			array(
				'loading'  => $loading,
				'decoding' => $decoding,
				'class'    => 'ukm-product-card__image',
				'alt'      => esc_attr( get_the_title( $post_id ) ),
			)
		);
	} else {
		// Placeholder jika tidak ada gambar.
		$placeholder_url = $placeholder ?: UKM_THEME_URI . 'assets/images/placeholder-produk.svg';
		printf(
			'<img src="%s" alt="%s" class="ukm-product-card__image" width="520" height="390" loading="%s" decoding="%s" />',
			esc_url( $placeholder_url ),
			esc_attr( get_the_title( $post_id ) ),
			esc_attr( $loading ),
			esc_attr( $decoding )
		);
	}
}

/**
 * Tampilkan badge status produk (Tersedia, Habis, dll.).
 *
 * @since  1.0.0
 * @param  int $post_id ID post.
 * @return void
 */
function ukm_produk_status_badge( $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	$status = ukm_get_produk_field( '_ukm_status_produk', $post_id, 'tersedia' );

	$badge_map = array(
		'tersedia'   => array( 'label' => __( 'Tersedia', 'ukm-toko-theme' ), 'class' => 'ukm-badge--primary' ),
		'habis'      => array( 'label' => __( 'Stok Habis', 'ukm-toko-theme' ), 'class' => 'ukm-badge--error' ),
		'pesan_dulu' => array( 'label' => __( 'Pesan Dulu', 'ukm-toko-theme' ), 'class' => 'ukm-badge--gray' ),
		'dihentikan' => array( 'label' => __( 'Tidak Tersedia', 'ukm-toko-theme' ), 'class' => 'ukm-badge--gray' ),
	);

	if ( isset( $badge_map[ $status ] ) ) {
		$badge = $badge_map[ $status ];
		printf(
			'<span class="ukm-badge %s">%s</span>',
			esc_attr( $badge['class'] ),
			esc_html( $badge['label'] )
		);
	}
}

/**
 * Tampilkan breadcrumb tema (sederhana, tanpa plugin).
 *
 * Untuk breadcrumb yang lebih kaya, gunakan plugin NavXT atau RankMath.
 *
 * @since 1.0.0
 */
function ukm_breadcrumb() {
	// Jika RankMath aktif, gunakan breadcrumb RankMath.
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
		return;
	}

	$crumbs = array();

	// Beranda selalu ada.
	$crumbs[] = array(
		'label' => __( 'Beranda', 'ukm-toko-theme' ),
		'url'   => home_url( '/' ),
	);

	if ( is_singular( 'produk' ) ) {
		$crumbs[] = array(
			'label' => __( 'Produk', 'ukm-toko-theme' ),
			'url'   => get_post_type_archive_link( 'produk' ),
		);

		$terms = get_the_terms( get_the_ID(), 'kategori-produk' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term     = reset( $terms );
			$crumbs[] = array(
				'label' => $term->name,
				'url'   => get_term_link( $term ),
			);
		}

		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

	} elseif ( is_post_type_archive( 'produk' ) ) {
		$crumbs[] = array( 'label' => __( 'Produk', 'ukm-toko-theme' ), 'url' => '' );

	} elseif ( is_singular( 'post' ) ) {
		$category = get_the_category();
		if ( $category ) {
			$crumbs[] = array(
				'label' => $category[0]->name,
				'url'   => get_category_link( $category[0]->term_id ),
			);
		}
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

	} elseif ( is_page() ) {
		// Untuk halaman berjenjang.
		$ancestors = get_post_ancestors( get_the_ID() );
		if ( $ancestors ) {
			$ancestors = array_reverse( $ancestors );
			foreach ( $ancestors as $ancestor_id ) {
				$crumbs[] = array(
					'label' => get_the_title( $ancestor_id ),
					'url'   => get_permalink( $ancestor_id ),
				);
			}
		}
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

	} elseif ( is_category() || is_tax() ) {
		$crumbs[] = array( 'label' => single_term_title( '', false ), 'url' => '' );

	} elseif ( is_search() ) {
		$crumbs[] = array(
			'label' => sprintf(
				/* translators: %s: istilah pencarian. */
				__( 'Hasil untuk: %s', 'ukm-toko-theme' ),
				get_search_query()
			),
			'url' => '',
		);

	} elseif ( is_404() ) {
		$crumbs[] = array( 'label' => __( 'Halaman Tidak Ditemukan', 'ukm-toko-theme' ), 'url' => '' );
	}

	if ( count( $crumbs ) <= 1 ) {
		return; // Tidak tampilkan breadcrumb di beranda.
	}

	echo '<nav class="ukm-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'ukm-toko-theme' ) . '">';

	$last_index = count( $crumbs ) - 1;

	foreach ( $crumbs as $index => $crumb ) {
		if ( $index === $last_index ) {
			// Item terakhir: tidak ada link, tandai sebagai halaman saat ini.
			echo '<span class="ukm-breadcrumb__current" aria-current="page">' . esc_html( $crumb['label'] ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $crumb['url'] ) . '" class="ukm-breadcrumb__link">' . esc_html( $crumb['label'] ) . '</a>';
			echo '<span class="ukm-breadcrumb__separator" aria-hidden="true">/</span>';
		}
	}

	echo '</nav>';
}

/**
 * Tampilkan pagination loop produk / post.
 *
 * @since 1.0.0
 */
function ukm_pagination() {
	$pagination = paginate_links(
		array(
			'prev_text' => '&larr; ' . __( 'Sebelumnya', 'ukm-toko-theme' ),
			'next_text' => __( 'Berikutnya', 'ukm-toko-theme' ) . ' &rarr;',
			'type'      => 'array',
		)
	);

	if ( ! $pagination ) {
		return;
	}

	echo '<nav class="ukm-pagination" aria-label="' . esc_attr__( 'Navigasi halaman', 'ukm-toko-theme' ) . '">';
	foreach ( $pagination as $page_link ) {
		echo wp_kses_post( $page_link );
	}
	echo '</nav>';
}

/**
 * Tampilkan tombol WhatsApp dengan pesan otomatis.
 *
 * @since  1.0.0
 * @param  string $nomor   Nomor WhatsApp (format internasional).
 * @param  string $pesan   Pesan default.
 * @param  string $label   Label tombol.
 * @param  string $class   Class CSS tambahan.
 * @return void
 */
function ukm_whatsapp_button( $nomor = '', $pesan = '', $label = '', $class = '' ) {
	if ( ! $nomor ) {
		$nomor = ukm_get_option( 'ukm_whatsapp_toko', '' );
	}

	if ( ! $nomor ) {
		return;
	}

	if ( ! $label ) {
		$label = __( 'Pesan via WhatsApp', 'ukm-toko-theme' );
	}

	$wa_url = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $nomor );

	if ( $pesan ) {
		$wa_url .= '?text=' . rawurlencode( $pesan );
	}

	printf(
		'<a href="%1$s" class="ukm-btn ukm-btn--primary ukm-wa-btn %3$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%2$s</a>',
		esc_url( $wa_url ),
		esc_html( $label ),
		esc_attr( $class )
	);
}

/**
 * Dapatkan URL gambar OG default (dari logo atau placeholder).
 *
 * @since  1.0.0
 * @return string URL gambar.
 */
function ukm_get_default_og_image() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo = wp_get_attachment_image_src( $custom_logo_id, 'ukm-og-image' );
		if ( $logo ) {
			return $logo[0];
		}
	}

	return UKM_THEME_URI . 'assets/images/og-default.jpg';
}

/**
 * Tambahkan class body berdasarkan kondisi halaman.
 *
 * @since  1.0.0
 * @param  array $classes Daftar class body yang ada.
 * @return array Daftar class yang sudah ditambahkan.
 */
function ukm_body_classes( $classes ) {
	// Tambahkan class untuk tipe halaman.
	if ( is_singular() ) {
		$classes[] = 'ukm-singular';
		$classes[] = 'ukm-post-type-' . get_post_type();
	}

	if ( is_archive() ) {
		$classes[] = 'ukm-archive';
	}

	if ( ! has_post_thumbnail() && is_singular() ) {
		$classes[] = 'ukm-no-featured-image';
	}

	// Apakah sidebar aktif?
	if ( is_active_sidebar( 'ukm-sidebar-blog' ) && ( is_single() || is_archive() || is_category() ) ) {
		$classes[] = 'ukm-has-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'ukm_body_classes' );

/**
 * Batasi panjang excerpt secara kustom.
 *
 * @since  1.0.0
 * @param  int $length Panjang default (kata).
 * @return int Panjang kustom.
 */
function ukm_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'ukm_excerpt_length' );

/**
 * Ganti elipsis excerpt WordPress dengan tanda "...".
 *
 * @since  1.0.0
 * @param  string $more Teks elipsis default.
 * @return string Teks elipsis kustom.
 */
function ukm_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'ukm_excerpt_more' );

/**
 * Tampilkan nomor hasil pencarian di atas loop search.
 *
 * @since 1.0.0
 */
function ukm_search_results_count() {
	if ( ! is_search() ) {
		return;
	}

	global $wp_query;
	$total = (int) $wp_query->found_posts;
	$query = get_search_query();

	printf(
		/* translators: 1: jumlah hasil, 2: istilah pencarian. */
		'<p class="ukm-search-count">' . esc_html__( 'Ditemukan %1$d hasil untuk "%2$s"', 'ukm-toko-theme' ) . '</p>',
		absint( $total ),
		esc_html( $query )
	);
}
