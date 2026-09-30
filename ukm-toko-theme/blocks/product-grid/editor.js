/**
 * Editor script untuk UKM: Product Grid (ukm/product-grid).
 * Menggunakan wp.element.createElement langsung tanpa proses build.
 *
 * @package ukm-toko-theme
 */
(function (wp) {
  var registerBlockType = wp.blocks.registerBlockType;
  var el = wp.element.createElement;
  var __ = wp.i18n.__;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var components = wp.components;
  var PanelBody = components.PanelBody;
  var TextControl = components.TextControl;
  var TextareaControl = components.TextareaControl;
  var RangeControl = components.RangeControl;
  var ToggleControl = components.ToggleControl;

  registerBlockType('ukm/product-grid', {
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;

      var judul = attributes.judul;
      var label = attributes.label;
      var deskripsi = attributes.deskripsi;
      var jumlah = attributes.jumlah || 8;
      var kategoriSlug = attributes.kategoriSlug || '';
      var kolom = attributes.kolom || 4;
      var tampilTombolLihatSemua = attributes.tampilTombolLihatSemua !== false;
      var tampilFilter = attributes.tampilFilter || false;

      // Inspector Controls
      var inspector = el(
        InspectorControls,
        { key: 'inspector' },
        el(
          PanelBody,
          { title: __('Header Seksi', 'ukm-toko-theme'), initialOpen: true },
          el(TextControl, {
            label: __('Badge / Label Kategori', 'ukm-toko-theme'),
            value: label,
            onChange: function (val) { setAttributes({ label: val }); }
          }),
          el(TextControl, {
            label: __('Judul Seksi', 'ukm-toko-theme'),
            value: judul,
            onChange: function (val) { setAttributes({ judul: val }); }
          }),
          el(TextareaControl, {
            label: __('Deskripsi Singkat', 'ukm-toko-theme'),
            value: deskripsi,
            rows: 2,
            onChange: function (val) { setAttributes({ deskripsi: val }); }
          })
        ),
        el(
          PanelBody,
          { title: __('Konfigurasi Grid & Query', 'ukm-toko-theme'), initialOpen: true },
          el(RangeControl, {
            label: __('Jumlah Produk Ditampilkan', 'ukm-toko-theme'),
            value: jumlah,
            min: 2,
            max: 24,
            step: 1,
            onChange: function (val) { setAttributes({ jumlah: val }); }
          }),
          el(RangeControl, {
            label: __('Jumlah Kolom (Desktop)', 'ukm-toko-theme'),
            value: kolom,
            min: 2,
            max: 4,
            step: 1,
            onChange: function (val) { setAttributes({ kolom: val }); }
          }),
          el(TextControl, {
            label: __('Filter Slug Kategori (Kosongkan untuk semua)', 'ukm-toko-theme'),
            value: kategoriSlug,
            help: __('Contoh: sembako, minuman, bumbu-dapur', 'ukm-toko-theme'),
            onChange: function (val) { setAttributes({ kategoriSlug: val }); }
          }),
          el(ToggleControl, {
            label: __('Tampilkan Tab Filter Kategori', 'ukm-toko-theme'),
            checked: tampilFilter,
            onChange: function (val) { setAttributes({ tampilFilter: val }); }
          }),
          el(ToggleControl, {
            label: __('Tampilkan Tombol "Lihat Semua Produk"', 'ukm-toko-theme'),
            checked: tampilTombolLihatSemua,
            onChange: function (val) { setAttributes({ tampilTombolLihatSemua: val }); }
          })
        )
      );

      // Dummy cards for editor preview
      var dummyItems = [];
      var previewCount = Math.min(jumlah, kolom * 2);
      for (var i = 0; i < previewCount; i++) {
        dummyItems.push(
          el(
            'div',
            {
              key: i,
              style: {
                backgroundColor: '#ffffff',
                border: '1px solid #E2E8F0',
                borderRadius: '8px',
                padding: '12px',
                boxShadow: '0 1px 3px rgba(0,0,0,0.05)'
              }
            },
            el('div', {
              style: {
                height: '110px',
                backgroundColor: '#F1F5F9',
                borderRadius: '6px',
                marginBottom: '10px',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                color: '#94A3B8',
                fontSize: '12px'
              }
            }, __('Gambar Produk', 'ukm-toko-theme')),
            el('div', { style: { fontSize: '11px', color: '#10B981', fontWeight: '600', marginBottom: '2px' } }, __('Kategori Sembako', 'ukm-toko-theme')),
            el('div', { style: { fontSize: '13px', fontWeight: '600', color: '#1E293B', marginBottom: '6px' } }, __('Nama Produk Contoh #' + (i + 1), 'ukm-toko-theme')),
            el('div', { style: { display: 'flex', justifyContent: 'space-between', alignItems: 'center' } },
              el('span', { style: { fontSize: '13px', fontWeight: '700', color: '#2D6A4F' } }, 'Rp 25.000'),
              el('span', { style: { fontSize: '11px', color: '#64748B' } }, __('Tersedia', 'ukm-toko-theme'))
            )
          )
        );
      }

      var preview = el(
        'div',
        {
          key: 'preview',
          className: 'ukm-editor-product-grid-preview',
          style: {
            backgroundColor: '#F8FAFC',
            border: '1px dashed #CBD5E1',
            borderRadius: '8px',
            padding: '24px'
          }
        },
        el(
          'div',
          { style: { textAlign: 'center', marginBottom: '20px' } },
          label ? el('span', {
            style: {
              display: 'inline-block',
              backgroundColor: '#D8F3DC',
              color: '#1B4332',
              padding: '3px 10px',
              borderRadius: '9999px',
              fontSize: '11px',
              fontWeight: '700',
              textTransform: 'uppercase',
              marginBottom: '6px'
            }
          }, label) : null,
          el('h3', { style: { fontSize: '20px', fontWeight: '700', margin: '4px 0', color: '#0F172A' } }, judul || __('Produk Tersedia', 'ukm-toko-theme')),
          deskripsi ? el('p', { style: { fontSize: '13px', color: '#64748B', margin: '0' } }, deskripsi) : null,
          kategoriSlug ? el('div', { style: { marginTop: '6px', fontSize: '12px', color: '#2D6A4F', fontStyle: 'italic' } }, 'Filter aktif: ' + kategoriSlug) : null
        ),
        el(
          'div',
          {
            style: {
              display: 'grid',
              gridTemplateColumns: 'repeat(' + kolom + ', 1fr)',
              gap: '14px',
              marginBottom: '16px'
            }
          },
          dummyItems
        ),
        tampilTombolLihatSemua ? el(
          'div',
          { style: { textAlign: 'center', marginTop: '16px' } },
          el('span', {
            style: {
              display: 'inline-block',
              padding: '8px 18px',
              border: '1px solid #2D6A4F',
              color: '#2D6A4F',
              borderRadius: '6px',
              fontSize: '13px',
              fontWeight: '600'
            }
          }, __('Lihat Semua Produk', 'ukm-toko-theme'))
        ) : null
      );

      return [inspector, preview];
    },

    save: function () {
      return null;
    }
  });
})(window.wp);
