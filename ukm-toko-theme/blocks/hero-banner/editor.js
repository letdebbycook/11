/**
 * Editor script untuk UKM: Hero Banner (ukm/hero-banner).
 * Menggunakan wp.element.createElement langsung tanpa proses build / transpilasi.
 *
 * @package ukm-toko-theme
 */
(function (wp) {
  var registerBlockType = wp.blocks.registerBlockType;
  var el = wp.element.createElement;
  var __ = wp.i18n.__;
  var InspectorControls = wp.blockEditor.InspectorControls;
  var MediaUpload = wp.blockEditor.MediaUpload;
  var components = wp.components;
  var PanelBody = components.PanelBody;
  var TextControl = components.TextControl;
  var TextareaControl = components.TextareaControl;
  var SelectControl = components.SelectControl;
  var RangeControl = components.RangeControl;
  var Button = components.Button;

  registerBlockType('ukm/hero-banner', {
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;

      var judul = attributes.judul;
      var subjudul = attributes.subjudul;
      var label = attributes.label;
      var ctaLabel = attributes.ctaLabel;
      var ctaUrl = attributes.ctaUrl;
      var cta2Label = attributes.cta2Label;
      var cta2Url = attributes.cta2Url;
      var bgImageUrl = attributes.bgImageUrl;
      var alignment = attributes.alignment || 'center';
      var overlayOpacity = attributes.overlayOpacity || 50;

      // Inspector Controls (Sidebar Settings)
      var inspector = el(
        InspectorControls,
        { key: 'inspector' },
        el(
          PanelBody,
          { title: __('Pengaturan Teks & Konten', 'ukm-toko-theme'), initialOpen: true },
          el(TextControl, {
            label: __('Badge / Label Atas', 'ukm-toko-theme'),
            value: label,
            onChange: function (val) { setAttributes({ label: val }); }
          }),
          el(TextControl, {
            label: __('Judul Utama', 'ukm-toko-theme'),
            value: judul,
            onChange: function (val) { setAttributes({ judul: val }); }
          }),
          el(TextareaControl, {
            label: __('Subjudul / Deskripsi', 'ukm-toko-theme'),
            value: subjudul,
            rows: 3,
            onChange: function (val) { setAttributes({ subjudul: val }); }
          }),
          el(SelectControl, {
            label: __('Perataan Teks', 'ukm-toko-theme'),
            value: alignment,
            options: [
              { label: __('Tengah (Center)', 'ukm-toko-theme'), value: 'center' },
              { label: __('Rata Kiri (Left)', 'ukm-toko-theme'), value: 'left' },
              { label: __('Rata Kanan (Right)', 'ukm-toko-theme'), value: 'right' }
            ],
            onChange: function (val) { setAttributes({ alignment: val }); }
          })
        ),
        el(
          PanelBody,
          { title: __('Tombol Aksi (CTA)', 'ukm-toko-theme'), initialOpen: false },
          el(TextControl, {
            label: __('Teks Tombol Utama', 'ukm-toko-theme'),
            value: ctaLabel,
            onChange: function (val) { setAttributes({ ctaLabel: val }); }
          }),
          el(TextControl, {
            label: __('Link Tombol Utama (URL)', 'ukm-toko-theme'),
            value: ctaUrl,
            onChange: function (val) { setAttributes({ ctaUrl: val }); }
          }),
          el(TextControl, {
            label: __('Teks Tombol Kedua (Opsional)', 'ukm-toko-theme'),
            value: cta2Label,
            onChange: function (val) { setAttributes({ cta2Label: val }); }
          }),
          el(TextControl, {
            label: __('Link Tombol Kedua (URL)', 'ukm-toko-theme'),
            value: cta2Url,
            onChange: function (val) { setAttributes({ cta2Url: val }); }
          })
        ),
        el(
          PanelBody,
          { title: __('Latar Belakang & Overlay', 'ukm-toko-theme'), initialOpen: false },
          el(
            'div',
            { style: { marginBottom: '15px' } },
            el('label', { style: { display: 'block', marginBottom: '6px', fontWeight: '500' } }, __('Gambar Latar', 'ukm-toko-theme')),
            el(MediaUpload, {
              onSelect: function (media) {
                setAttributes({ bgImageUrl: media.url });
              },
              allowedTypes: ['image'],
              value: bgImageUrl,
              render: function (obj) {
                return el(
                  'div',
                  {},
                  el(Button, {
                    isSecondary: true,
                    onClick: obj.open
                  }, bgImageUrl ? __('Ganti Gambar', 'ukm-toko-theme') : __('Pilih Gambar Latar', 'ukm-toko-theme')),
                  bgImageUrl ? el(Button, {
                    isDestructive: true,
                    style: { marginLeft: '8px' },
                    onClick: function () { setAttributes({ bgImageUrl: '' }); }
                  }, __('Hapus', 'ukm-toko-theme')) : null
                );
              }
            })
          ),
          el(RangeControl, {
            label: __('Kegelapan Overlay Latar (%)', 'ukm-toko-theme'),
            value: overlayOpacity,
            min: 0,
            max: 90,
            step: 5,
            onChange: function (val) { setAttributes({ overlayOpacity: val }); }
          })
        )
      );

      // Live Editor Preview
      var overlayDec = (overlayOpacity || 50) / 100;
      var heroStyle = {
        textAlign: alignment,
        backgroundColor: '#1B4332',
        color: '#ffffff',
        padding: '60px 30px',
        borderRadius: '8px',
        position: 'relative',
        backgroundSize: 'cover',
        backgroundPosition: 'center'
      };

      if (bgImageUrl) {
        heroStyle.backgroundImage = 'linear-gradient(rgba(0,0,0,' + overlayDec + '), rgba(0,0,0,' + overlayDec + ')), url(' + bgImageUrl + ')';
      }

      var preview = el(
        'div',
        {
          key: 'preview',
          className: 'ukm-editor-hero-preview ukm-block-hero--align-' + alignment,
          style: heroStyle
        },
        label ? el('span', {
          style: {
            display: 'inline-block',
            backgroundColor: '#D8F3DC',
            color: '#1B4332',
            padding: '4px 12px',
            borderRadius: '9999px',
            fontSize: '12px',
            fontWeight: '600',
            textTransform: 'uppercase',
            letterSpacing: '0.05em',
            marginBottom: '16px'
          }
        }, label) : null,
        el('h2', {
          style: {
            color: '#ffffff',
            fontSize: '28px',
            fontWeight: '700',
            lineHeight: '1.25',
            margin: '0 0 12px 0'
          }
        }, judul || __('Judul Hero Toko', 'ukm-toko-theme')),
        subjudul ? el('p', {
          style: {
            color: 'rgba(255,255,255,0.9)',
            fontSize: '15px',
            maxWidth: '600px',
            margin: alignment === 'center' ? '0 auto 24px auto' : '0 0 24px 0',
            lineHeight: '1.5'
          }
        }, subjudul) : null,
        el(
          'div',
          { style: { display: 'flex', gap: '12px', justifyContent: alignment === 'center' ? 'center' : (alignment === 'right' ? 'flex-end' : 'flex-start') } },
          ctaLabel ? el('span', {
            style: {
              display: 'inline-block',
              backgroundColor: '#52B788',
              color: '#081C15',
              padding: '10px 20px',
              borderRadius: '6px',
              fontWeight: '600',
              fontSize: '14px'
            }
          }, ctaLabel) : null,
          cta2Label ? el('span', {
            style: {
              display: 'inline-block',
              border: '2px solid rgba(255,255,255,0.8)',
              color: '#ffffff',
              padding: '8px 18px',
              borderRadius: '6px',
              fontWeight: '600',
              fontSize: '14px'
            }
          }, cta2Label) : null
        )
      );

      return [inspector, preview];
    },

    save: function () {
      // Menggunakan Server-Side Rendering via PHP render_callback.
      return null;
    }
  });
})(window.wp);
