<?php
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/RecruiteeLoader.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/RecruiteeI18n.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/RecruiteeCustomRoute.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/RecruiteeAdmin.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'public/RecruiteePublic.php';

class RecruiteePlugin
{
  protected RecruiteeLoader $loader;
  protected RecruiteeCustomRoute $custom_route;
  protected string $plugin_name;
  protected string $version;

  public function __construct()
  {
    if (defined('RECRUITEE_PLUGIN_VERSION')) {
      $this->version = RECRUITEE_PLUGIN_VERSION;
    } else {
      $this->version = '1.0.0';
    }
    $this->plugin_name = 'recruitee-jobs';

    $this->addCustomRoute();
    $this->loadDependencies();
    $this->setLocale();
    $this->defineAdminHooks();
    $this->definePublicHooks();
  }

  private function addCustomRoute()
  {
    add_action('parse_request', function () {
      if (/* isset($_GET['job']) &&  */str_contains($_SERVER["REQUEST_URI"], '/recruitee-jobs')) {

        $tokens = explode('/', $_SERVER["REQUEST_URI"]);
        $jobID = $tokens[sizeof($tokens) - 2]; #!empty($_GET['job']) ? absint($_GET['job']) : 0;
        $recruitee_url = !empty($_GET['url']) ? urldecode_deep($_GET['url']) : 0;
        $api_path = !empty($_GET['api']) ? urldecode_deep($_GET['api']) : 0;

        add_filter('the_content', function ($content) use ($jobID, $recruitee_url, $api_path) {
          $apiURL = $recruitee_url . $api_path . $jobID;

          var_dump($apiURL);

          $response = wp_remote_get(esc_url($apiURL));
          $json = (array) json_decode(wp_remote_retrieve_body($response), true);

          var_dump($response);
          if ($json && array_key_exists("offer", $json)) {
            return $content . $json['offer'];
          }

          return $content;
          #$job = getRecruiteeJob($jobID, $recruitee_url, $api_path);

        }, 1);
      }
    });
    #$this->custom_route = new RecruiteeCustomRoute('recruitee-jobs/(.+?)/?$', array('job'), 'public/RecruiteeJobTemplate.php', true);
  }

  private function loadDependencies()
  {
    $this->loader = new RecruiteeLoader();
  }

  private function setLocale()
  {
    $RecruiteeI18n = new RecruiteeI18N();
    $this->loader->addAction('init', $RecruiteeI18n, 'loadTextdomain');
    $this->loader->addAction('load_textdomain_mofile', $RecruiteeI18n, 'loadTextdomainMofiles', 10, 2);
  }

  private function defineAdminHooks()
  {
    $RecruiteeAdmin = new RecruiteeAdmin($this->getPluginName(), $this->getVersion());
    $this->loader->addAction('init', $RecruiteeAdmin, 'loadShortcodes');
    $this->loader->addAction('admin_enqueue_scripts', $RecruiteeAdmin, 'enqueueStyles');
    $this->loader->addAction('admin_enqueue_scripts', $RecruiteeAdmin, 'enqueueScripts');
  }

  public function getPluginName(): string
  {
    return $this->plugin_name;
  }

  public function getVersion(): string
  {
    return $this->version;
  }

  private function definePublicHooks()
  {
    $RecruiteePublic = new RecruiteePublic($this->getPluginName(), $this->getVersion());
    $this->loader->addAction('wp_enqueue_scripts', $RecruiteePublic, 'enqueueStyles');
    $this->loader->addAction('wp_enqueue_scripts', $RecruiteePublic, 'enqueueScripts');
    $this->loader->addAction('parse_request', $RecruiteePublic, 'parseRequest');
  }

  public function run()
  {
    $this->loader->run();
  }

  public function getLoader(): RecruiteeLoader
  {
    return $this->loader;
  }
}
