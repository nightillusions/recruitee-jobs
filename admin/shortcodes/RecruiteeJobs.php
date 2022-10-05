<?php

class RecruiteeJobs
{

    protected string $your_company;
    protected string $department;
    protected array $tags = [];
    protected string $jobs_url;
    protected string $language;
    protected int $preview_size;
    protected bool $hasPreviewText;
    protected string $more;
    protected bool $raw;
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

    public function __construct($shortcode_attributes)
    {
        $attributes = shortcode_atts([
            'company' => '',
            'department' => '',
            'tags' => '',
            'url' => '',
            'language' => 'de',
            'preview_size' => '55',
            'more' => '...',
            'raw' => false,
            'source' => '',
        ], $shortcode_attributes);

        $initialTags = explode(",", esc_attr($attributes['tags']));
        $tags = is_array($initialTags) ? $initialTags : [];
        $company = esc_attr($attributes['company']);
        $department = esc_attr($attributes['department']);
        $jobs_url = esc_attr($attributes['url']);
        $language = esc_attr($attributes['language']);
        $preview_size = (int)esc_attr($attributes['preview_size']);
        $more = esc_attr($attributes['more']);
        $raw = boolval(esc_attr($attributes['raw']));
        $source = esc_attr($attributes['source']);

        $this->tags = $tags;
        $this->your_company = $company;
        $this->department = $department;
        $this->recruitee_url = str_replace("PLACEHOLDER", $company, $this->recruitee_url);
        $this->jobs_url = rtrim($jobs_url, '/');
        $this->language = $language;
        $this->preview_size = $preview_size;
        $this->hasPreviewText = boolval($this->preview_size);
        $this->more = $more;
        $this->raw = $raw;
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
        }

        foreach ($jobs as $job) {
            echo "<article class='recruitee-job' >";
            echo "<figure class='no-image'>";
            echo "<figcaption>";
            echo "<a href='" . esc_url($this->getJobURL($job['slug'])) . "' target='_self'>";
            echo "<h3>" . esc_html($job['title']) . "</h3>";
            echo "</a>";
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
        $apiURL = $this->recruitee_url . $this->api_path . "?department=$this->department";
        $jobs = [];

        if (!$this->tags) {
            $response = wp_remote_get("$apiURL");

            return json_decode(wp_remote_retrieve_body($response), true)['offers'];
        }

        foreach ($this->tags as $tag) {
            $response = wp_remote_get("$apiURL&tag=$tag");
            $json = json_decode(wp_remote_retrieve_body($response), true);
            if($json && array_key_exists("offers", $json)){
              array_push($jobs, ...$json['offers']);
            }
        }

        return $jobs;
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
        $htmlText = $job['translations'][$this->language]['description'];
        if ($this->raw) {
            $rawText = strip_tags($htmlText);

            return wp_trim_words(htmlspecialchars($rawText), $this->preview_size, $this->more);
        }

        $rawText = strip_tags($htmlText, array_keys($this->allowed_html));

        return force_balance_tags(html_entity_decode(wp_trim_words(htmlspecialchars($rawText), $this->preview_size, $this->more)));
    }
}