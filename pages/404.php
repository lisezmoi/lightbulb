<?php include __DIR__.'/header.php' ?>

	<h1>Not found!</h1>

	<h2>Recent posts:</h2>
	<ol>
		<?php foreach ($posts as $slug => $post): ?>
			<li>
				<article>
					<h1><a href="<?php echo SITE_URL . $slug ?>"><?php echo $post->title ?></a></h1>
					<img src="<?php echo $post->image->src ?>" alt="<?php echo $post->title ?>" width="<?php echo $post->image->width ?>" height="<?php echo $post->image->height ?>" />
				</article>
			</li>
		<?php endforeach ?>
	</ol>

<?php include __DIR__.'/footer.php' ?>
