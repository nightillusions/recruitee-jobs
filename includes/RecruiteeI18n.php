<?php

class RecruiteeI18N {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function loadTextdomain() {
		load_plugin_textdomain(
			'recruitee-jobs',
			false,
			dirname( plugin_basename( __FILE__ ), 2 ) . '/languages'
		);
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function loadTextdomainMofiles( $mofile, $domain ) {
		if ( 'recruitee-jobs' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
			$locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
			$mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
		}

		return $mofile;
	}
}