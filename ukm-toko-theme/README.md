# ukm-toko-theme

Tema WordPress custom untuk UKM toko sembako. Dibangun menggunakan standar WordPress modern tanpa page builder, dengan fokus pada performa tinggi, SEO teknis, dan keamanan production-ready.

## Fitur Utama

- **Full Responsive** — Mobile-first dengan breakpoint 640px / 768px / 1024px / 1280px
- **Custom Post Types** — `produk` (katalog sembako) dan `klien` (data mitra)
- **Taksonomi Custom** — `kategori-produk` hierarkis dengan 4 kategori default
- **ACF Support** — Field groups via ACF gratis + native meta boxes sebagai fallback
- **WooCommerce Integration** — Cart fragments, checkout fields, product gallery
- **Blok Gutenberg Custom** — Hero Banner, Product Grid, Testimonial Slider
- **SEO Teknis** — Schema JSON-LD (LocalBusiness, Product, Article), Open Graph, hreflang
- **Performa** — Critical CSS inline, lazy loading benar, self-hosted font Inter
- **Keamanan** — HTTP security headers, nonce pada semua form, sanitasi ketat
- **Siap Deploy** — Konfigurasi cPanel (.htaccess), GZIP, browser cache headers

## Struktur Tema

```
ukm-toko-theme/
├── inc/
│   ├── setup.php              # Theme support, nav menus, image sizes
│   ├── enqueue.php            # Enqueue CSS & JS
│   ├── customizer.php         # WordPress Customizer
│   ├── security.php           # HTTP headers, sanitasi, login limit
│   ├── cpt.php                # Custom Post Types
│   ├── taxonomy.php           # Custom Taxonomies
│   ├── acf.php                # ACF field groups & fallback meta boxes
│   ├── settings-page.php      # Halaman opsi global (fallback ACF Options Page)
│   ├── woocommerce.php        # WooCommerce support & kustomisasi
│   ├── seo.php                # Schema JSON-LD, OG, Twitter Card
│   └── template-functions.php # Helper template
├── template-parts/
│   ├── content.php            # Loop post blog
│   ├── content-produk.php     # Card produk CPT
│   ├── content-single.php     # Konten single post
│   └── content-none.php       # State kosong
├── assets/
│   ├── css/
│   │   ├── critical.css       # Critical CSS (di-inline di <head>)
│   │   ├── components.css     # Semua komponen UI
│   │   ├── editor-style.css   # Style editor Gutenberg
│   │   └── woocommerce.css    # Override WooCommerce
│   └── js/
│       ├── navigation.js      # Mobile menu, search panel, sticky header
│       ├── main.js            # Logika utama (varian produk, dll.)
│       └── customizer.js      # Customizer live preview
├── data/
│   └── seeder.php             # Data dummy 22 produk + 2 klien
├── front-page.php             # Halaman depan
├── archive-produk.php         # Arsip produk
├── single-produk.php          # Detail produk
├── single.php                 # Detail post blog
├── page.php                   # Halaman statis
├── archive.php                # Arsip blog
├── search.php                 # Hasil pencarian
├── 404.php                    # Halaman tidak ditemukan
├── header.php                 # Header global
├── footer.php                 # Footer global
├── index.php                  # Fallback template
├── style.css                  # Header tema + CSS variables + reset
├── functions.php              # Entry point tema
├── package.json               # Build pipeline (Gutenberg blocks)
└── .htaccess                  # Keamanan + performa Apache
```

## Instalasi Lokal (LocalWP)

1. Clone/copy folder `ukm-toko-theme` ke `wp-content/themes/`
2. Aktifkan tema di **Tampilan → Tema**
3. Install plugin yang direkomendasikan:
   - **Advanced Custom Fields** (gratis) — untuk field UI yang lebih baik
   - **RankMath SEO** — untuk OG tags dan sitemap otomatis
   - **WooCommerce** — untuk fitur e-commerce
4. Import data dummy via WP-CLI:
   ```bash
   wp eval-file wp-content/themes/ukm-toko-theme/data/seeder.php
   ```
5. Atur informasi toko di **Pengaturan → Toko UKM**
6. Buat menu di **Tampilan → Menu** dan pilih lokasi `Menu Utama`

## Deploy ke Shared Hosting (Niagahoster/Rumahweb)

1. Upload folder tema ke `public_html/wp-content/themes/` via cPanel File Manager atau FTP
2. Install WordPress jika belum ada
3. Aktifkan tema
4. Upload `.htaccess` ke root `public_html/` (merge dengan `.htaccess` WordPress yang ada)
5. Pastikan SSL Let's Encrypt sudah aktif di cPanel
6. Atur `WP_DEBUG` ke `false` di `wp-config.php`

## Konfigurasi Awal

### Informasi Toko
Masuk ke **Pengaturan → Toko UKM** dan isi:
- Nama toko, tagline, alamat lengkap
- Nomor WhatsApp (format: 6281234567890)
- Email, jam operasional
- URL media sosial

### Halaman Depan
Buat halaman baru dan atur sebagai halaman depan di **Pengaturan → Membaca**.
Tambahkan blok Gutenberg custom:
- **Hero Banner** — blok `ukm/hero-banner`
- **Product Grid** — blok `ukm/product-grid`
- **Testimonial Slider** — blok `ukm/testimonial-slider`

### WooCommerce
Jalankan Setup Wizard WooCommerce. Metode pembayaran default:
- **COD (Bayar di Tempat)** — aktif secara default
- **Transfer Bank Manual** — aktifkan di WooCommerce → Pengaturan → Pembayaran

## Checklist Pre-Launch

- [ ] Logo upload di Tampilan → Kustomisasi → Logo
- [ ] Halaman Beranda, Toko, Keranjang, Checkout, Akun Saya sudah dibuat
- [ ] Menu utama sudah diatur
- [ ] Informasi toko sudah diisi di Pengaturan → Toko UKM
- [ ] SSL aktif dan HTTPS bekerja
- [ ] Google Analytics / GTM dipasang (opsional)
- [ ] Sitemap RankMath sudah dikirim ke Google Search Console
- [ ] Lighthouse score ≥ 95 di semua halaman utama
- [ ] Uji form WooCommerce checkout end-to-end

## Standar Kode

- **Bahasa komentar/kode**: English (nama fungsi, variabel)
- **Bahasa komentar PHP**: Indonesia (penjelasan logika bisnis)
- **Prefix fungsi**: `ukm_`
- **Text domain**: `ukm-toko-theme`
- **Coding standard**: WordPress PHP Coding Standards (WPCS)
- **Sanitasi**: Semua input menggunakan `ukm_sanitize_text()`, `ukm_sanitize_html()`, atau fungsi WP bawaan

## Lisensi

GPL v2 atau lebih baru. Lihat [LICENSE](LICENSE) untuk detail.
