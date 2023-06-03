<?php

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/shortcodes/RecruiteeJobsRenderJob.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/helpers/getJobURL.php';

class RecruiteePublic
{
  private string $plugin_name;
  private string $version;

  public function __construct(string $plugin_name, string $version)
  {
    $this->plugin_name = $plugin_name;
    $this->version     = $version;
  }

  public function enqueueStyles()
  {
    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/recruitee-public.css', array(), $this->version, 'all');
  }

  public function enqueueScripts()
  {
    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/recruitee-public.js', array('jquery'), $this->version, false);
  }

  public function parseRequest()
  {
    echo "HELLO";
    var_dump("HELLO");
    if (isset($_GET['job']) && str_contains($_SERVER["REQUEST_URI"], '/recruitee-jobs')) {
      $jobID = !empty($_GET['job']) ? absint($_GET['job']) : 0;
      $recruitee_url = !empty($_GET['recruitee_url']) ? urldecode_deep($_GET['recruitee_url']) : 0;
      $api_path = !empty($_GET['api_path']) ? urldecode_deep($_GET['api_path']) : 0;

      add_filter('the_content', function () use ($jobID, $recruitee_url, $api_path) {
        $job = getRecruiteeJob($jobID, $recruitee_url, $api_path);
        var_dump($job);
      }, 1);
    }
  }
}
