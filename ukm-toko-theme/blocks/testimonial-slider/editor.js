/**
 * Editor script untuk UKM: Testimonial Slider (ukm/testimonial-slider).
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
  var Button = components.Button;

  registerBlockType('ukm/testimonial-slider', {
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;

      var judul = attributes.judul;
      var label = attributes.label;
      var deskripsi = attributes.deskripsi;
      var testimoni = attributes.testimoni || [];
      var autoplay = attributes.autoplay !== false;
      var delayDetik = attributes.delayDetik || 5;

      var activeSlide = 0;

      // Inspector Controls
      var inspector = el(
        InspectorControls,
        { key: 'inspector' },
        el(
          PanelBody,
          { title: __('Header Seksi', 'ukm-toko-theme'), initialOpen: true },
          el(TextControl, {
            label: __('Badge / Label', 'ukm-toko-theme'),
            value: label,
            onChange: function (val) { setAttributes({ label: val }); }
          }),
          el(TextControl, {
            label: __('Judul', 'ukm-toko-theme'),
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
          { title: __('Pengaturan Slider & Autoplay', 'ukm-toko-theme'), initialOpen: false },
          el(ToggleControl, {
            label: __('Aktifkan Autoplay Otomatis', 'ukm-toko-theme'),
            checked: autoplay,
            onChange: function (val) { setAttributes({ autoplay: val }); }
          }),
          el(RangeControl, {
            label: __('Durasi Antar Slide (detik)', 'ukm-toko-theme'),
            value: delayDetik,
            min: 2,
            max: 15,
            step: 1,
            onChange: function (val) { setAttributes({ delayDetik: val }); }
          })
        ),
        el(
          PanelBody,
          { title: __('Kelola Data Testimoni (' + testimoni.length + ')', 'ukm-toko-theme'), initialOpen: true },
          testimoni.map(function (item, index) {
            return el(
              'div',
              {
                key: index,
                style: {
                  marginBottom: '16px',
                  padding: '12px',
                  backgroundColor: '#F8FAFC',
                  borderRadius: '6px',
                  border: '1px solid #E2E8F0'
                }
              },
              el('strong', { style: { display: 'block', marginBottom: '8px', fontSize: '13px' } }, 'Testimoni #' + (index + 1)),
              el(TextControl, {
                label: __('Nama Pelanggan', 'ukm-toko-theme'),
                value: item.nama || '',
                onChange: function (val) {
                  var updated = testimoni.slice();
                  updated[index] = Object.assign({}, updated[index], {
                    nama: val,
                    inisial: val ? val.split(' ').map(function (w) { return w[0]; }).join('').substring(0, 2).toUpperCase() : 'US'
                  });
                  setAttributes({ testimoni: updated });
                }
              }),
              el(TextControl, {
                label: __('Peran / Pekerjaan', 'ukm-toko-theme'),
                value: item.peran || '',
                onChange: function (val) {
                  var updated = testimoni.slice();
                  updated[index] = Object.assign({}, updated[index], { peran: val });
                  setAttributes({ testimoni: updated });
                }
              }),
              el(TextareaControl, {
                label: __('Isi Ulasan', 'ukm-toko-theme'),
                value: item.ulasan || '',
                rows: 2,
                onChange: function (val) {
                  var updated = testimoni.slice();
                  updated[index] = Object.assign({}, updated[index], { ulasan: val });
                  setAttributes({ testimoni: updated });
                }
              }),
              el(RangeControl, {
                label: __('Rating Bintang', 'ukm-toko-theme'),
                value: item.bintang || 5,
                min: 1,
                max: 5,
                onChange: function (val) {
                  var updated = testimoni.slice();
                  updated[index] = Object.assign({}, updated[index], { bintang: val });
                  setAttributes({ testimoni: updated });
                }
              }),
              testimoni.length > 1 ? el(Button, {
                isDestructive: true,
                isSmall: true,
                style: { marginTop: '8px' },
                onClick: function () {
                  var updated = testimoni.filter(function (_, i) { return i !== index; });
                  setAttributes({ testimoni: updated });
                }
              }, __('Hapus Ulasan Ini', 'ukm-toko-theme')) : null
            );
          }),
          el(Button, {
            isPrimary: true,
            onClick: function () {
              var newItem = {
                nama: 'Pelanggan Baru',
                peran: 'Pelanggan Toko',
                ulasan: 'Pelayanan sangat memuaskan dan produk sesuai ekspektasi.',
                bintang: 5,
                inisial: 'PB',
                fotoUrl: ''
              };
              setAttributes({ testimoni: testimoni.concat([newItem]) });
            }
          }, __('+ Tambah Ulasan Baru', 'ukm-toko-theme'))
        )
      );

      // Live Editor Preview
      var currentItem = testimoni[0] || {
        nama: 'Nama Pelanggan',
        peran: 'Pelanggan',
        ulasan: 'Ulasan pelanggan akan muncul di sini...',
        bintang: 5,
        inisial: 'NP'
      };

      var preview = el(
        'div',
        {
          key: 'preview',
          className: 'ukm-editor-testimonial-preview',
          style: {
            backgroundColor: '#F8FAFC',
            border: '1px dashed #CBD5E1',
            borderRadius: '8px',
            padding: '24px',
            textAlign: 'center'
          }
        },
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
        el('h3', { style: { fontSize: '20px', fontWeight: '700', margin: '4px 0 16px 0', color: '#0F172A' } }, judul || __('Kata Pelanggan', 'ukm-toko-theme')),
        el(
          'div',
          {
            style: {
              maxWidth: '540px',
              margin: '0 auto',
              backgroundColor: '#ffffff',
              padding: '24px',
              borderRadius: '8px',
              boxShadow: '0 2px 6px rgba(0,0,0,0.06)',
              border: '1px solid #E2E8F0'
            }
          },
          el('div', { style: { color: '#F59E0B', fontSize: '18px', marginBottom: '12px' } }, '★★★★★'),
          el('blockquote', { style: { margin: '0 0 16px 0', fontStyle: 'italic', color: '#334155', fontSize: '14px', lineHeight: '1.6' } },
            '"' + (currentItem.ulasan || '') + '"'
          ),
          el('div', { style: { display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '10px' } },
            el('div', {
              style: {
                width: '38px',
                height: '38px',
                borderRadius: '50%',
                backgroundColor: '#2D6A4F',
                color: '#ffffff',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: '700',
                fontSize: '13px'
              }
            }, currentItem.inisial || 'PL'),
            el('div', { style: { textAlign: 'left' } },
              el('strong', { style: { display: 'block', fontSize: '13px', color: '#0F172A' } }, currentItem.nama || ''),
              el('span', { style: { fontSize: '11px', color: '#64748B' } }, currentItem.peran || '')
            )
          )
        ),
        el('div', { style: { marginTop: '12px', fontSize: '12px', color: '#64748B' } },
          __('Menampilkan 1 dari ' + testimoni.length + ' ulasan (Slider aktif otomatis di frontend)', 'ukm-toko-theme')
        )
      );

      return [inspector, preview];
    },

    save: function () {
      return null;
    }
  });
})(window.wp);
