<?php

/* Routes: redirect URLs to functions */

function routes($request, &$posts) {
  global $title;

  $page = '404';
  $page_num = 1;

  // Home
  if ($request === '/' || $request === '') {
    $page = 'archive';
    return page_archive(1);

  // Archive pages (page 2, etc.)
  } else if (preg_match("/page\/([0-9]+)\/?/", $request, $matches)) {
    $page = 'archive';
    $page_num = (int)$matches[1];
    if (count($posts) <= ($page_num-1) * POST_BY_PAGE) {
      return page_404();
    }
    return page_archive($page_num);

  // Single page
  } else if (preg_match("/([-a-z0-9\-]+)\/?/", $request, $matches)) {

    $page_slug = $matches[1];
    if (!isset($posts[$page_slug])) return page_404();

    $page = 'single';
    $post = $posts[$page_slug];

    // Previous
    $post->previous_post = NULL;
    reset($posts);
    while(key($posts) !== $page_slug) next($posts);
    prev($posts);
    if (key($posts)) $post->previous_post = $posts[key($posts)];

    // Next
    $post->next_post = NULL;
    reset($posts);
    while(key($posts) !== $page_slug) next($posts);
    next($posts);
    if (key($posts)) $post->next_post = $posts[key($posts)];

    return page_single($post);
  }
}
