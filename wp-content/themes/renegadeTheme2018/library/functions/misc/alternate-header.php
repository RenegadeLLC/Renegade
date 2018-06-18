		<div class="clearfloat" id="masthead">
		<h1 class="title"><a href="<?php echo get_option('home'); ?>/" title="<?php _e('Return Home','Mimbo'); ?>"><?php bloginfo('name'); ?></a></h1>
			<div id="headerad">
				<ul id="navigation" class="clearfloat">
				<li><a href="<?php echo get_option('home'); ?>/"><span>Home</span></a></li>
				<li><a href="<?php echo get_option('home'); ?>/category/development"><span>Dev/Design</span></a></li>
				<li><a href="<?php echo get_option('home'); ?>/category/themes"><span>Themes</span></a></li>		
				<li><a href="<?php echo get_option('home'); ?>/category/other"><span>Other</span></a></li>		
				<li><a href="http://feeds.feedburner.com/Nometech"><img src="http://feeds.feedburner.com/~fc/Nometech?bg=1F242A&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
				<?php if (is_user_logged_in()) { ?><li><a href="<?php echo get_option('home'); ?>/wp-admin/"><span>Login</span></a></li><?php } ?>
				</ul>
			</div>
		</div>--><!-- end masthead -->
	</div>--><!-- end header wrap -->
	
	
					<div id="menu">
					<div class="pads">
						<ul id="nav" class="clearfix">
							<li class="<?php if (((is_home()) && !(is_paged())) or (is_archive() && !(is_category())) or (is_single()) or (is_paged()) or (is_search())) { ?>current-cat<?php } else { ?>cat-item<?php } ?>"><a href="<?php echo get_settings('home'); ?>"><?php _e( 'Home', 'wpbx' ) ?></a></li>
							<!-- change "depth=3" to suit your menu depth level, and change "exclude=x" with the category ID that you want exclude from the menu (multiple categories separated by , (comma) -->
							<?php wp_list_categories('orderby=ID&order=ASC&depth=3&title_li=&exclude='); ?>
					<li class="cat-item cat-item-49"><a href="http://nometech.com/community/category/sport/" title="View all posts filed under Sport">Forum</a> 
				</li> 
							<li id="m-subscribe"><a href="http://feeds.feedburner.com/nometech"><img src="http://feeds.feedburner.com/~fc/nometech?bg=e33258&amp;fg=ffffff&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
						</ul>
					</div>
				</div>
	