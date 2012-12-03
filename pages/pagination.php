<p class="pagination">
	<?php if ($p['previous'] && $p['current'] != 1): ?>
	<span class="prev"><a href="<?php echo get_archive_url($p['current']-1) ?>" title="Previous page">Previous page</a></span>
	<?php endif ?>
	<?php if ($p['last'] != 1): ?>
	<span class="count">
		<?php echo $p['current'] . '/' . $p['last'] ?>
	</span>
	<?php endif ?>
	<?php if ($p['next'] && $p['next'] != 1 && $p['current'] != $p['last']): ?>
	<span class="next"><a href="<?php echo get_archive_url($p['current']+1) ?>" title="Next page">Next page</a></span>
	<?php endif ?>
</p>
