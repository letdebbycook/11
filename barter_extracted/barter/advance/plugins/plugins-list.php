<?php
/**
 * TGMPA plugin installer config
 */
function barter_register_required_plugins() {
	/**
	 * Array of configuration settings. Amend each line as needed.
	 */

	tgmpa(
		array(
			array(
				'name'               => esc_html__( 'SKT Templates – Elementor & Gutenberg templates', 'barter' ),
				'slug'               => 'skt-templates',
				'required'           => false,
				'version'            => BARTER_MIN_COMPANION_VERSION,
				'force_activation'   => false,
				'force_deactivation' => false,
			)
		)
	);
}


add_action('tgmpa_register', 'barter_register_required_plugins');