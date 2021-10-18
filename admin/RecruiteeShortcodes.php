<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/shortcodes/RecruiteeJobs.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/RecruiteeLoader.php';


class RecruiteeShortcodes {

	private string $plugin_name;
	private string $version;

	public function __construct(string $plugin_name, string $version) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->recruiteeJobs();
	}

	public function recruiteeJobs() {

		add_action( 'wp_enqueue_scripts', function () {
			wp_enqueue_style( $this->plugin_name . "-shortcode", plugin_dir_url( __FILE__ ) . 'shortcodes/css/recruitee-jobs.css', [], $this->version, 'all' );
		} );

		add_shortcode( $this->plugin_name, function ( $shortcode_attributes ) {
			$recruitee = new RecruiteeJobs( $shortcode_attributes );

			ob_start();

			echo "<div class='recruitee-jobs-container'>";
            $recruitee->renderRecruiteeJobs();
			echo "</div>";

			return ob_get_clean();
		} );
	}
}