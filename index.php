<?php

require_once __DIR__.'/config.php';
require_once __DIR__.'/lib/utils.php';
require_once __DIR__.'/lib/routes.php';
require_once __DIR__.'/lib/pagination.class.php';
require_once __DIR__.'/lib/views.php';

$request = (isset($_GET['r']))? $_GET['r'] : '/';
$posts = get_posts();

$title = SITE_NAME;

routes($request, $posts);
