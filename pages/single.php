<?php include __DIR__.'/header.php' ?>

	<div class="post">
		<h2><a href="<?php echo $post->slug ?>"><?php echo $post->title ?></a></h2>
		<img src="<?php echo $post->image->src ?>" alt="<?php echo $post->title ?>" width="<?php echo $post->image->width ?>" height="<?php echo $post->image->height ?>" />
	</div>

	<p class="pagination">
		<?php if ($post->previous_post): ?>
		<span class="prev"><a href="<?php echo SITE_URL.$post->previous_post->slug ?>" title="Previous post">Previous post</a></span>
		<?php endif; ?>
		<?php if ($post->next_post): ?>
			<span class="next"><a href="<?php echo SITE_URL.$post->next_post->slug ?>" title="Next post">Next Post</a></span>
		<?php endif; ?>
	</p>

<?php include __DIR__.'/footer.php' ?>
