<?
function getJobURL(string $slug, string $external_job_url, string $source): string
{
  $tracking = str_contains($external_job_url, '?') ? "&source=$source" : "?source=$source";
  return !empty($source) ? $external_job_url . '/' . $slug . $tracking : $external_job_url . '/' . $slug;
}

function str_contains($haystack, $needle): bool
{
  if (!function_exists('str_contains')) {
    return $needle !== '' && mb_strpos($haystack, $needle) !== false;
  } else {
    return str_contains($haystack, $needle);
  }
}

function getRecruiteeJob(string $id, string $recruitee_url, string $api_path): array
{
  $apiURL = $recruitee_url . $api_path . $id;

  $response = wp_remote_get(esc_url($apiURL));
  $json = (array) json_decode(wp_remote_retrieve_body($response), true);

  if ($json && array_key_exists("offer", $json)) {
    return $json['offer'];
  }

  return [];
}
