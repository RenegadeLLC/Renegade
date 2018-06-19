<div id="sidebardomtabswrap">
		<div id="tabbed">
			<div class="domtab">
			  <ul class="domtabs">
				<li><a href="#t1">Popular</a></li>
				<li><a href="#t2">Latest</a></li>
				<li><a href="#t3">Tags</a></li>
			  </ul>
			</div>
			<div>	
				<a name="t1" id="t1"></a>
				<br /><br />
				<ul>
				<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 5");
				foreach ($result as $post) {
				setup_postdata($post);
				$postid = $post->ID;
				$title = $post->post_title;
				$commentcount = $post->comment_count;
				if ($commentcount != 0) { ?>
				<li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>">
				<?php echo $title ?></a> {<?php echo $commentcount ?>}</li>
				<?php } } ?>
				</ul>
			</div>
			<div>
				<a name="t2" id="t2"></a>
				<br /><br />
				<ul>
				<?php wp_get_archives('type=postbypost&limit=5'); ?>
				</ul>
			</div>
			<div>
				<a name="t3" id="t3"></a>
				<?php wp_tag_cloud(''); ?>
			</div>
		</div>
	</div>