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
