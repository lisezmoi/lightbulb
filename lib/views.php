<?php

/* Views: prepare data for templates */

// 404
function page_404() {
  global $posts, $title;
  $posts = array_slice($posts, 0, RECENT_POSTS_404);
  $title = TITLE_FORMAT_404;
  header("HTTP/1.0 404 Not Found");
  include __DIR__.'/../pages/404.php';
}

// Home
function page_archive($page_num) {
  global $posts, $title;
  $pagination = new Pagination();
  $p = $pagination->calculate_pages(count($posts), POST_BY_PAGE, $page_num);
  $posts = array_slice($posts, ($page_num-1) * POST_BY_PAGE, POST_BY_PAGE);

  if ($page_num > 1) {
    $title = sprintf(TITLE_FORMAT_ARCHIVE, $page_num);
  }

  include __DIR__.'/../pages/home.php';
}

// Single
function page_single($post) {
  global $title;
  $title = sprintf(TITLE_FORMAT_SINGLE, $post->title);
  include __DIR__.'/../pages/single.php';
}
