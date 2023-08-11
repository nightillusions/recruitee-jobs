<?php

require_once plugin_dir_path(dirname(__FILE__)) . 'helpers/getJobURL.php';

class RecruiteeRenderJob
{

  protected string $external_job_url;
  protected string $source;
  protected string $language;
  protected string $more;
  protected string $api_path;
  protected string $recruitee_url;
  protected string $jobs_url;
  protected bool $show_location;
  protected bool $show_tags;
  protected bool $hasPreviewText;
  protected bool $raw;
  protected bool $autop;
  protected bool $open_local;
  protected int $preview_size;
  protected int $job_id;
  protected $getJob;
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

  public function __construct($render_attributes)
  {
    $attributes = shortcode_atts([
      'recruitee_url' => '',
      'jobs_url' => '',
      'source' => '',
      'language' => '',
      'more' => '...',
      'preview_size' => '55',
      'api_path' => '',
      'show_location' => true,
      'show_tags' => true,
      'hasPreviewText' => true,
      'open_local' => true,
      'raw' => false,
      'autop' => true,
      'getJob' => null,
      'job_id' => 0
    ], $render_attributes);

    $this->external_job_url = empty($attributes['jobs_url']) ? $attributes['recruitee_url'] . '/o' : $attributes['jobs_url'];
    $this->source = $attributes['source'];
    $this->show_location = $attributes['show_location'];
    $this->show_tags = $attributes['show_tags'];
    $this->hasPreviewText = $attributes['hasPreviewText'];
    $this->raw = $attributes['raw'];
    $this->autop = $attributes['autop'];
    $this->language = $attributes['language'];
    $this->preview_size = $attributes['preview_size'];
    $this->more = $attributes['more'];
    $this->getJob = $attributes['getJob'];
    $this->open_local = $attributes['open_local'];
    $this->api_path = $attributes['api_path'];
    $this->recruitee_url = $attributes['recruitee_url'];
    $this->jobs_url = $attributes['jobs_url'];
    $this->job_id = $attributes['job_id'];
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
      echo "<a href='" . $this->getSingleLink($job) . "' target='_self'>";
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
      echo "<a class='recruitee-button' href='" . esc_url(getJobURL($job['slug'], $this->external_job_url, $this->source)) . "' target='_self'>" . esc_html__('Read more', 'recruitee-jobs') . "</a>";
      echo "</div>";
      echo "</figcaption>";
      echo "</figure>";
      echo "</article>";
    }

    echo "</div>";
  }


  public function getSingleLink(array $job): string
  {
    return $this->open_local ? esc_url(site_url('/recruitee-jobs') . '/' . $job['id'] . '/?url=' . urlencode_deep($this->recruitee_url) . '&api=' . urlencode_deep($this->api_path)) : esc_url($this->getJobURL($job['slug'], $this->external_job_url, $this->source));
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
      echo "<a href='" . $this->getSingleLink($job) . "' target='_self'>";
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

  function getJobURL(string $slug, string $external_job_url, string $source): string
  {
    $tracking = str_contains($external_job_url, '?') ? "&source=$source" : "?source=$source";
    return !empty($source) ? $external_job_url . '/' . $slug . $tracking : $external_job_url . '/' . $slug;
  }
}
