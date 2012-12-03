<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/lib/utils.php';

header('Content-type: text/plain; charset=UTF-8');

$posts = get_posts();
$cached_posts = get_cached_posts();

foreach ($posts as $slug => $post) {
  if (isset($cached_posts[$slug])) { continue; }
  $imgsize = getimagesize($post->image->src);
  if ($imgsize) {
    $cached_posts[$slug] = array(
      'width' => $imgsize[0],
      'height' => $imgsize[1],
      'html_attributes' => $imgsize[3],
    );
  } else {
    $cached_posts[$slug] = array(
      'width' => NULL,
      'height' => NULL,
      'html_attributes' => '',
    );
  }
  echo "Fetched dimensions of “{$post->title}”.\n";
}

if (write_cached_posts($cached_posts)) {
  echo "Cache successfully written.";
} else {
  echo "Can not write the cache file.";
}
