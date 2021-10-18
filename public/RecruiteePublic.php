<?php

class RecruiteePublic {
	private string $plugin_name;
	private string $version;

	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->loadShortcodes();
	}

	public function loadShortcodes() {

	}

	public function enqueueStyles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/recruitee-public.css', array(), $this->version, 'all' );
	}

	public function enqueueScripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/recruitee-public.js', array( 'jquery' ), $this->version, false );
	}
}