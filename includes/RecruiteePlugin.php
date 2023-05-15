<?php
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/RecruiteeLoader.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/RecruiteeI18n.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/RecruiteeAdmin.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'public/RecruiteePublic.php';

class RecruiteePlugin
{
  protected RecruiteeLoader $loader;
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

    $this->loadDependencies();
    $this->setLocale();
    $this->defineAdminHooks();
    $this->definePublicHooks();
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
