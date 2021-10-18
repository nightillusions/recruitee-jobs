<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/RecruiteeShortcodes.php';

class RecruiteeAdmin {
	private string $plugin_name;
	private string $version;
	protected RecruiteeShortcodes $shortcodes;

	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function loadShortcodes() {
		$this->shortcodes = new RecruiteeShortcodes($this->plugin_name, $this->version);
	}

	public function enqueueStyles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/recruitee-admin.css', array(), $this->version, 'all' );
	}

	public function enqueueScripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/recruitee-admin.js', array( 'jquery' ), $this->version, false );
	}

}