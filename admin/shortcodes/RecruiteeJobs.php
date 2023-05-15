<?php

class RecruiteeJobs
{

  protected string $your_company;
  protected string $mode;
  protected string $department;
  protected array $tags = [];
  protected string $jobs_url;
  protected string $language;
  protected int $preview_size;
  protected bool $hasPreviewText;
  protected string $more;
  protected bool $raw;
  protected bool $autop;
  protected bool $show_tags;
  protected bool $show_location;
  protected string $source;
  protected array $allowed_html = [
    'a' => [
      'href' => [],
      'title' => [],
      'target' => [],
    ],
    'p' => [],
    'br' => [],
    'em' => [],
    'strong' => [],
    'h1' => [],
    'h2' => [],
    'h3' => [],
    'ul' => [],
    'li' => [],
  ];
  protected string $recruitee_url = 'https://PLACEHOLDER.recruitee.com';
  protected string $api_path = '/api/offers/';
  protected string $external_job_url;
  protected string $open_local = false;

  public function __construct($shortcode_attributes)
  {
    $attributes = shortcode_atts([
      'company' => '',
      'mode' => 'tiles',
      'department' => '',
      'tags' => '',
      'url' => '',
      'language' => '',
      'preview_size' => '55',
      'more' => '...',
      'raw' => false,
      'show_tags' => true,
      'show_location' => true,
      'source' => '',
      'local' => false,
    ], $shortcode_attributes);

    $tags = (!empty($attributes['tags'])) ? explode(",", esc_attr($attributes['tags'])) : [];
    $company = esc_attr($attributes['company']);
    $mode = esc_attr($attributes['mode']);
    $department = esc_attr($attributes['department']);
    $jobs_url = esc_attr($attributes['url']);
    $language = esc_attr($attributes['language']);
    $preview_size = (int)esc_attr($attributes['preview_size']);
    $more = esc_attr($attributes['more']);
    $raw = boolval(esc_attr($attributes['raw']));
    $show_tags = boolval(esc_attr($attributes['show_tags']));
    $show_location = boolval(esc_attr($attributes['show_location']));
    $open_local = boolval(esc_attr($attributes['local']));
    $source = esc_attr($attributes['source']);

    $this->tags = $tags;
    $this->your_company = $company;
    $this->mode = $mode;
    $this->department = $department;
    $this->recruitee_url = str_replace("PLACEHOLDER", $company, $this->recruitee_url);
    $this->jobs_url = rtrim($jobs_url, '/');
    $this->language = $language;
    $this->preview_size = $preview_size;
    $this->hasPreviewText = boolval($this->preview_size);
    $this->more = $more;
    $this->raw = $raw;
    $this->autop = true;
    $this->show_tags = $show_tags;
    $this->show_location = $show_location;
    $this->open_local = $open_local;
    $this->source = $source;
    $this->external_job_url = empty($jobs_url) ? $this->recruitee_url . '/o' : $jobs_url;
  }

  public function renderRecruiteeJobs(): void
  {
    if ($this->hasErrors()) {
      $this->renderErrors();

      return;
    }

    $jobs = $this->getRecruiteeJobs();

    if (!$jobs || empty($jobs)) {
      esc_html__('No jobs found!', 'recruitee-jobs');

      return;
    }

    switch ($this->mode) {
      case 'list':
        $this->renderList($jobs);
        break;
      case 'tiles':
      default:
        $this->renderTiles($jobs);
        break;
    }
  }

  public function renderJob()
  {
  }

  /**
   * @since 1.4.0
   */
  public function renderTiles(array $jobs): void
  {
    echo "<div class='recruitee-jobs-container'>";

    foreach ($jobs as $job) {
      echo "<article class='recruitee-job' >";
      echo "<figure class='no-image'>";
      echo "<figcaption>";
      echo "<a href='" . esc_url($this->getJobURL($job['slug'])) . "' target='_self'>";
      echo "<h3>" . esc_html($job['title']) . "</h3>";
      echo "</a>";
      if ($this->show_location || $this->show_tags) {
        echo "<div class='recruitee-meta'>";
        if ($this->show_location && $job['location']) {
          echo "<div class='recruitee-location'>";
          echo wp_kses(esc_html($job['location']), $this->allowed_html);
          echo "</div>";
        }
        if ($this->show_tags && $job['tags']) {
          echo "<div class='recruitee-tags'>";
          echo wp_kses(esc_html(implode(', ', $job['tags'])), $this->allowed_html);
          echo "</div>";
        }
        echo "</div>";
      }
      if ($this->hasPreviewText) {
        echo wp_kses($this->getTeaserText($job), $this->allowed_html);
      }
      echo "<div class='recruitee-read-more'>";
      echo "<a class='recruitee-button' href='" . esc_url($this->getJobURL($job['slug'])) . "' target='_self'>" . esc_html__('Read more', 'recruitee-jobs') . "</a>";
      echo "</div>";
      echo "</figcaption>";
      echo "</figure>";
      echo "</article>";
    }

    echo "</div>";
  }

  /**
   * @since 1.4.0
   */
  public function renderList(array $jobs): void
  {
    echo "<div class='recruitee-jobs-container-list'>";
    echo "<ul class='recruitee-list'>";

    foreach ($jobs as $job) {
      echo "<li class='recruitee-item'>";
      echo "<a href='" . esc_url($this->getJobURL($job['slug'])) . "' target='_self'>";
      echo "<span class='recruitee-headline'>" . esc_html($job['title']) . "</span>";

      if ($this->show_location || $this->show_tags) {
        echo "<span class='recruitee-meta'>";
        echo " - ";
        echo "(";
        if ($this->show_location && $job['location']) {
          echo "<span class='recruitee-location'>";
          echo wp_kses(esc_html($job['location']), $this->allowed_html);
          echo "</span>";
        }
        if ($this->show_location && $job['location'] && $this->show_tags && $job['tags']) {
          echo " | ";
        }
        if ($this->show_tags && $job['tags']) {
          echo "<span class='recruitee-tags'>";
          echo wp_kses(esc_html(implode(', ', $job['tags'])), $this->allowed_html);
          echo "</span>";
        }
        echo ")";
        echo " - ";
        echo "</span>";
      }

      if ($this->hasPreviewText) {
        $this->raw = 1;
        $this->autop = 0;
        echo wp_kses($this->getTeaserText($job), $this->allowed_html);
      }

      echo "</a>";
      echo "</li>";
    }

    echo "</ul>";
    echo "</div>";
  }

  public function hasErrors(): bool
  {
    return empty($this->your_company);
  }

  public function renderErrors(): void
  {
    $errors = [];

    if (empty($this->your_company)) {
      $errors = [...$errors, __('No subdomain entered!', 'recruitee-jobs')];
    }
    if (count($errors) > 0) {
      echo "<div class='recruitee-jobs-errors-container'>";
      echo "<ul class='recruitee-jobs-errors'>";
      foreach ($errors as $error) {
        echo "<li>esc_html($error)</li>";
      }
      echo "</ul>";
      echo "</div>";
    }
  }

  public function getRecruiteeJobs(): array
  {
    $apiURL = $this->recruitee_url . $this->api_path;
    $jobs = [];

    if (!empty($this->department)) {
      $apiURL = $apiURL . "?department=" . $this->department;
    }

    if (!$this->tags) {
      $recruitee_jobs = get_transient('rj_recruitee_jobs');

      if (false === $recruitee_jobs) {
        $response = wp_remote_get(esc_url($apiURL));
        set_transient('rj_recruitee_jobs', $response, 60 * 60);
      }

      $json = (array) json_decode(wp_remote_retrieve_body($recruitee_jobs), true);

      if ($json && array_key_exists("offers", $json)) {
        return $json['offers'];
      }

      return [];
    }

    foreach ($this->tags as $tag) {
      $recruitee_jobs_tags[$tag] = get_transient('rj_recruitee_jobs_' . $tag);

      if ($recruitee_jobs_tags[$tag] && false === $recruitee_jobs_tags[$tag]) {
        $response = wp_remote_get(esc_url("$apiURL&tag=$tag"));
        set_transient('rj_recruitee_jobs_' . $tag, $response, 60 * 60);
      }

      $json = (array) json_decode(wp_remote_retrieve_body($recruitee_jobs_tags[$tag]), true);
      if ($json && array_key_exists("offers", $json)) {
        array_push($jobs, ...$json['offers']);
      }
    }

    return $jobs;
  }

  public function getRecruiteeJob(string $id): array
  {
    $apiURL = $this->recruitee_url . $this->api_path . $id;

    $response = wp_remote_get(esc_url($apiURL));
    $json = (array) json_decode(wp_remote_retrieve_body($response), true);

    if ($json && array_key_exists("offer", $json)) {
      return $json['offer'];
    }

    return [];
  }

  public function getJobURL(string $slug): string
  {
    $tracking = $this->str_contains($this->external_job_url, '?') ? "&source=$this->source" : "?source=$this->source";
    return !empty($this->source) ? $this->external_job_url . '/' . $slug . $tracking : $this->external_job_url . '/' . $slug;
  }

  private function str_contains($haystack, $needle): bool
  {
    if (!function_exists('str_contains')) {
      return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    } else {
      return str_contains($haystack, $needle);
    }
  }

  public function getTeaserText(array $job): string
  {
    if (!empty($this->language)) {
      $htmlText = $job['translations'][$this->language]['description'];
    } else {
      $htmlText = $job['description'];
    }
    if ($this->raw) {
      $rawText = $this->autop ? wpautop(strip_tags($htmlText)) : strip_tags($htmlText);

      return html_entity_decode(wp_trim_words(htmlspecialchars($rawText), $this->preview_size, $this->more));
    }

    $rawText = strip_tags($htmlText, array_keys($this->allowed_html));

    return force_balance_tags(html_entity_decode(wp_trim_words(htmlspecialchars($rawText), $this->preview_size, $this->more)));
  }
}
