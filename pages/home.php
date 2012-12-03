<?php include __DIR__.'/header.php' ?>
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
	<?php include __DIR__.'/pagination.php' ?>
<?php include __DIR__.'/footer.php' ?>
