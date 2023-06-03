<?php

/**
 *
 * @package           Recruitee_Jobs
 * @author            Pascal Jordin
 * @link              https://jordin.eu
 * @since             1.0.0
 * @copyright         2021 Pascal Jordin
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Jobs from Recruitee
 * Plugin URI:        https://wordpress.org/plugins/jobs-from-recruitee/
 * Description:       Easily display published jobs from Recruitee anywhere with shortcode.
 * Version:           1.4.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Pascal Jordin
 * Author URI:        https://jordin.eu
 * Text Domain:       recruitee-jobs
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Current plugin version.
 */
const RECRUITEE_PLUGIN_VERSION = '1.4.0';

/**
 * The code that runs during plugin activation.
 */
function activateRecruiteePlugin()
{
  require_once plugin_dir_path(__FILE__) . 'includes/RecruiteeActivator.php';
  RecruiteeActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivateRecruiteePlugin()
{
  require_once plugin_dir_path(__FILE__) . 'includes/RecruiteeDeactivator.php';
  RecruiteeDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activateRecruiteePlugin');
register_deactivation_hook(__FILE__, 'deactivateRecruiteePlugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/RecruiteePlugin.php';

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function runRecruiteePlugin()
{

  $plugin = new RecruiteePlugin();
  $plugin->run();
}

/* add_action('parse_request', function () {
  if (isset($_GET['job']) && str_contains($_SERVER["REQUEST_URI"], '/recruitee-jobs')) {
    $jobID = !empty($_GET['job']) ? absint($_GET['job']) : 0;
    $recruitee_url = !empty($_GET['recruitee_url']) ? urldecode_deep($_GET['recruitee_url']) : 0;
    $api_path = !empty($_GET['api_path']) ? urldecode_deep($_GET['api_path']) : 0;

    add_filter('the_content', function () use ($jobID, $recruitee_url, $api_path) {
      $job = getRecruiteeJob($jobID, $recruitee_url, $api_path);
      var_dump($job);
    }, 99);
  }
});

add_action('the_content', function () use ($jobID, $recruitee_url, $api_path) {
  $job = getRecruiteeJob($jobID, $recruitee_url, $api_path);
  var_dump($job);
  echo $job;
}); */

runRecruiteePlugin();
