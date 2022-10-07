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
 * Version:           1.3
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
const RECRUITEE_PLUGIN_VERSION = '1.0.0';

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

runRecruiteePlugin();
