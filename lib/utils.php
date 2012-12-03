<?php

function get_archive_url($page_num = 1) {
  if ($page_num == 1) return SITE_URL;
  return SITE_URL . "page/{$page_num}/";
}

function slugify($title) {
  $title = str_replace('…', '', $title);
  $title = str_replace('’', '', $title);
  $title = sanitize_title_with_dashes($title);
  return $title;
}

function get_cached_posts() {
  $cache_file = __DIR__.'/../cache.db';
  if (!is_readable($cache_file)) {
    return array();
  }
  return unserialize(file_get_contents($cache_file));
}

function write_cached_posts($posts) {
  $cache_file = __DIR__.'/../cache.db';
  if ((file_exists($cache_file) && !is_writable($cache_file)) || (!file_exists($cache_file) && !is_writable(dirname($cache_file)))) {
    return FALSE;
  }
  return file_put_contents($cache_file, serialize($posts));
}

/* Read, transforms and return posts */
function get_posts() {
  $raw_posts = file_get_contents(__DIR__.'/../posts.txt');
  $raw_posts = trim(str_replace("\n\n", "\n", str_replace("\n\r", "\n", $raw_posts)));
  $posts_lines = explode("\n", $raw_posts);
  $posts = array();
  foreach ($posts_lines as $key => $value) {
    // Title
    if ($key % 2 == 0) {
      $post_key = slugify($value);
      $posts[$post_key] = array(
        'title' => $value,
        'slug' => $post_key,
      );
    // Image
    } else {
      $post_key = slugify($posts_lines[$key-1]);
      $posts[$post_key]['image'] = (object)array(
        'src' => $value,
        'width' => NULL,
        'height' => NULL,
        'html_attributes' => NULL,
      );
      $posts[$post_key] = (object)$posts[$post_key];
    }
  }

  // Cached dimensions
  $cached_posts = get_cached_posts();
  array_walk($posts, function(&$post, $slug) use($cached_posts) {
    if (isset($cached_posts[$slug])) {
      $post->image->width = $cached_posts[$slug]['width'];
      $post->image->height = $cached_posts[$slug]['height'];
      $post->image->html_attributes = $cached_posts[$slug]['html_attributes'];
    }
  });

  return $posts;
}

/* WordPress functions. Thanks! */

/**
 * Encode the Unicode values to be used in the URI.
 */
function utf8_uri_encode( $utf8_string, $length = 0 ) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;

        $string_length = strlen( $utf8_string );
        for ($i = 0; $i < $string_length; $i++ ) {

                $value = ord( $utf8_string[ $i ] );

                if ( $value < 128 ) {
                        if ( $length && ( $unicode_length >= $length ) )
                                break;
                        $unicode .= chr($value);
                        $unicode_length++;
                } else {
                        if ( count( $values ) == 0 ) $num_octets = ( $value < 224 ) ? 2 : 3;

                        $values[] = $value;

                        if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
                                break;
                        if ( count( $values ) == $num_octets ) {
                                if ($num_octets == 3) {
                                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                                        $unicode_length += 9;
                                } else {
                                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                                        $unicode_length += 6;
                                }

                                $values = array();
                                $num_octets = 1;
                        }
                }
        }

        return $unicode;
}

/**
 * Sanitizes title, replacing whitespace and a few other characters with dashes.
 *
 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
 * Whitespace becomes a dash.
 */
function sanitize_title_with_dashes($title, $raw_title = '', $context = 'display') {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        // if (seems_utf8($title)) {
                if (function_exists('mb_strtolower')) {
                        $title = mb_strtolower($title, 'UTF-8');
                }
                $title = utf8_uri_encode($title, 200);
        // }

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);

        if ( 'save' == $context ) {
                // Convert nbsp, ndash and mdash to hyphens
                $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );

                // Strip these characters entirely
                $title = str_replace( array(
                        // iexcl and iquest
                        '%c2%a1', '%c2%bf',
                        // angle quotes
                        '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
                        // curly quotes
                        '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
                        '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
                        // copy, reg, deg, hellip and trade
                        '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
                ), '', $title );

                // Convert times to x
                $title = str_replace( '%c3%97', 'x', $title );
        }

        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        return $title;
}
