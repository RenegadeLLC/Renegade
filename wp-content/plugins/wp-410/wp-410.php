<?php
/*
Plugin Name: 410 for WordPress
Plugin URI: https://wordpress.org/plugins/wp-410/
Description: Sends HTTP 410 (Gone) responses to requests for pages that no longer exist on your blog.
Version: 0.8.7
Author: Samir Shah
Author URI: http://rayofsolaris.net/
License: GPL2
*/

if( ! defined( 'ABSPATH' ) )
	exit;

class WP_410 {
	const db_version = 5;
	private $permalinks;
	private $table;

	function __construct() {
		$this->permalinks = (bool) get_option('permalink_structure');
		$this->table = $GLOBALS['wpdb']->prefix . '410_links';

		add_action( 'plugins_loaded',	array( $this, 'upgrade_check' )		);

		if( is_admin() )
			add_action( 'admin_menu',	array( $this, 'settings_menu' ) 	);
		else
			add_action( 'template_redirect', array( $this, 'check_for_410' ) 	);

		// these could theoretically happen both with/without is_admin()
		add_action('wp_insert_post', 	array( $this, 'note_inserted_post' ));
	}

	private function install_table() {
		// remember, two spaces after PRIMARY KEY otherwise WP borks
		$sql = "CREATE TABLE $this->table (
			gone_id MEDIUMINT unsigned NOT NULL AUTO_INCREMENT,
			gone_key VARCHAR(512) NOT NULL,
			gone_regex VARCHAR(512) NOT NULL,
			is_404 SMALLINT(1) unsigned NOT NULL DEFAULT 0,
			PRIMARY KEY  (gone_id),
			KEY is_404 (is_404)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	private function get_links(){
		global $wpdb;
		return $wpdb->get_results( "SELECT gone_key, gone_regex FROM $this->table WHERE is_404 = 0", OBJECT_K );	// indexed by gone_key
	}

	private function max_404_list_length() {
		return get_option( 'wp_410_max_404s', 50 );
	}

	private function get_404s(){
		global $wpdb;
		$this->concat_404_list();
		return $wpdb->get_results( "SELECT gone_key, gone_regex FROM $this->table WHERE is_404 = 1 ORDER BY gone_id DESC", OBJECT_K );	// indexed by gone_key
	}

	private function add_link( $key, $is_404 = false ){	// just supply the link
		global $wpdb;

		// 404 logging enabled?
		if( $is_404 && $this->max_404_list_length() == 0 )
			return;

		// build regex
		$parts = preg_split( '/(\*)/', $key, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		foreach( $parts as &$part ) if( '*' != $part )
			$part = preg_quote( $part, '|' );
		$parts = str_replace( '*', '.*', $parts );
		$regex = '|^' . implode( '', $parts ) . '$|i';

		// avoid duplicates - messy but MySQL doesn't allow url-length unique keys
		if( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `$this->table` WHERE `gone_key` = %s", $key ) ) )
			return 0;

		$wpdb->insert( $this->table, array( 'gone_key' => $key, 'gone_regex' => $regex, 'is_404' => intval( $is_404 ) ) );

		// Don't let 404 list grow forever
		if( $is_404 )
			$this->concat_404_list();
	}

	private function concat_404_list() {
		global $wpdb;
		$n = intval( $wpdb->get_var( "SELECT COUNT(*) FROM `$this->table` WHERE `is_404` = 1" ) - $this->max_404_list_length() );
		if( $n > 0 )
			$wpdb->query( "DELETE FROM `$this->table` WHERE is_404 = 1 ORDER BY gone_id LIMIT $n" );
	}

	private function convert_404( $key ) {
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( "UPDATE `$this->table` SET is_404 = 0 WHERE `gone_key` = %s LIMIT 1", $key ) );
	}

	private function remove_link( $key ){
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table WHERE gone_key = %s", array( $key ) ) );
	}

	function upgrade_check() {
		$options_version = get_option( 'wp_410_options_version', 0 );

		if( $options_version == self::db_version )	// nothing to do
			return;

		// last db change was in version 5
		if( $options_version < 5 )
			$this->install_table();

		if( $options_version < 3 ) {
			$old_links = get_option( 'wp_410_links_list', array() );
			$new_links = array();	 // just a simple array of links

			if( 0 == $options_version )	// links were stored just as links
				$new_links = array_map( 'rawurldecode', $old_links );
			elseif( 1 == $options_version ) // links were stored as array( link => regex ), We only need the link
				$new_links = array_map( 'rawurldecode', array_keys( $old_links ) );
			else // moved to using the database in db_version 3
				$new_links = array_keys( $old_links );

			foreach( $new_links as $link )
				$this->add_link( $link );

			delete_option( 'wp_410_links_list' );	// remove old option
		}

		update_option( 'wp_410_options_version', self::db_version );
	}

	function settings_menu() {
		add_submenu_page('plugins.php', '410 for WordPress', '410 for WordPress', 'manage_options', 'wp_410_settings', array( $this, 'settings_page') );
	}

	function settings_page() {
		$links = $this->get_links();
		$logged_404s = $this->get_404s();
		$links_to_add = array();

		// Entries to delete
		if( isset( $_POST['delete-from-410-list'] ) && !empty( $_POST['old_links_to_remove'] ) ) {
			check_admin_referer( 'wp-410-settings' );
			foreach( $_POST['old_links_to_remove'] as $key ) {
				$key = stripslashes( $key );
				if( isset( $links[$key] ) ) {
					$this->remove_link( $key );
					unset( $links[$key] );
				}
			}
		}
		// Entries to add, either manually or from 404 list
		else if ( isset( $_POST['add-to-410-list'] ) ) {
			check_admin_referer( 'wp-410-settings' );
			$failed_to_add = array();
			if( !empty( $_POST['links_to_add'] ) ) {
				foreach( preg_split( '/(\r?\n)+/', $_POST['links_to_add'], -1, PREG_SPLIT_NO_EMPTY ) as $link ) {
					$link = stripslashes( $link );
					if( $this->is_valid_url( $link ) ) {
						$this->add_link( $link );
					}
					else {
						$failed_to_add[] = '<code>' . htmlspecialchars( $link ) . '</code>';
					}
				}
			}

			if( !empty( $_POST['add_404s'] ) ) {
				foreach( $_POST['add_404s'] as $link ) {
					$link = stripslashes( $link );
					$this->convert_404( $link );
				}
			}

			// Update lists
			$links = $this->get_links();
			$logged_404s = $this->get_404s();

			if( $failed_to_add )
				echo '<div class="error"><p>The following entries could not be recognised as URLs that your WordPress site handles, and were not added to the list. This can be because the domain name and path does not match that of your WordPress site, or because pretty permalinks are disabled.</p><p>- ' . implode( '<br> - ', $failed_to_add ) .'</p></div>';
		}
		else if ( isset( $_POST['set-404-list-length'] ) ) {
			check_admin_referer( 'wp-410-settings' );
			update_option( 'wp_410_max_404s', intval( $_POST['max_404_list_length'] ) );
			$logged_404s = $this->get_404s();
		}

		if( !empty( $_POST ) )
			echo '<div id="message" class="updated fade"><p>Options updated.</p></div>';

		ksort( $links );
	?>
	<style>
	tr.invalid label {color: red}
	p.invalid {	background: #FFEBE8; border: 1px solid red; border-radius: 5px; padding: 5px 10px}
	.wp-410-table-wrap {max-width: 890px; max-height: 300px; overflow-y: scroll}
	</style>
	<div class="wrap">
	<h2>410 for WordPress</h2>
	<?php if( WP_CACHE ) :?>
		<div class="updated">
		<p><strong style="color: #900">Warning:</strong> It seems that a caching/performance plugin is active on this site. This plugin has only been tested with the following caching plugins:</p>
		<ul style="list-style: disc; margin-left: 2em">
		<li>W3 Total Cache</li>
		<li> WP Super Cache</li>
		</ul>
		<p><strong>Other caching plugins may cache responses to requests for pages that have been removed</strong>, in which case this plugin will not be able to intercept the requests and issue a 410 response header.</p>
		</div>
	<?php endif; ?>
	<p>This plugin will issue a HTTP 410 response to articles that no longer exist on your blog. This informs robots that the requested page has been permanently removed, and that they should stop trying to access it.</p>
	<p><strong>A 410 response will only be issued if WordPress has not found something valid to display for the requested URL.</strong></p>
	<h3>Obsolete URLs</h3>
	<form action="" method="post">
	<?php
	if( empty( $links ) ) {
		echo '<p>There are currently no obsolete URLs in this list. You can add some manually below.</p>';
	}
	else {
		echo '<p>The following URLs (or masks) will receive a 410 response. If you create or update an article whose URL matches one of those below, that URL will automatically be removed from the list.</p>';
		echo '<div class="wp-410-table-wrap"><table id="wp_gone_old_links" class="wp-list-table widefat fixed">';
		echo '<thead><th class="check-column"><input type="checkbox" id="select-all-410" /><label for="select-all-410" class="screen-reader-text"> Select all</label></th><th>Obsolete URL</th></thead>';
		echo '<tbody>';

		$invalid_links_exist = false;
		foreach( array_keys( $links ) as $k ) {
			$valid = $this->is_valid_url( $k );

			if( ! $valid )
				$invalid_links_exist = true;

			$k_attr = esc_attr( $k );
			$k = htmlspecialchars( $k );
			$class = $valid ? '' : 'class="invalid"';

			echo "<tr $class><td><input type='checkbox' name='old_links_to_remove[]' id='wp-410-$k_attr' value='$k_attr' /></td><td><label for='wp-410-$k_attr'><code>$k</code></label></td</tr>";
		}
		echo '</tbody></table></div>';

		if( $invalid_links_exist )
			echo '<p class="invalid">Warning: WordPress is not able to issue 410 responses for the URLs marked in red above. This is because those URLs are not handled by your WordPress installation. This can be because the domain name and path does not match that of your WordPress site, or because pretty permalinks are disabled.</p>';

		wp_nonce_field( 'wp-410-settings' );
		echo '<p class="submit"><input class="button button-primary" type="submit" name="delete-from-410-list" value="Delete selected entries" /></p>';
	}
	?>
	</form>

	<h3>Recent 404 errors</h3>
	<p>Recent 404 (Page Not Found) errors on your site are shown here, so that you can easily add them to the list above.</p>
	<form action="" method="post">
	<p><label>Maximum number of 404 errors to keep: <input type="number" size="3" name="max_404_list_length" value="<?php echo $this->max_404_list_length(); ?>" /></label> <input class="button button-secondary" type="submit" name="set-404-list-length" value="Save" /> (setting this to zero will disable logging).</p>
	<?php wp_nonce_field( 'wp-410-settings' ); ?>
	</form>
	<form action="" method="post">
	<?php
	if( empty( $logged_404s ) ) {
		if( $this->max_404_list_length() )
			echo '<p>There are currently no 404 errors reported.</p>';
	}
	else {
		echo '<p>Below are recent 404 (Page Not Found) errors that have occurred on your site. You can add these to the list of obsolete URLs.</p>';
		echo '<div class="wp-410-table-wrap"><table id="wp_gone_404s" class="wp-list-table widefat fixed">';
		echo '<thead><th class="check-column"><input type="checkbox" id="select-all-404" /><label for="select-all-404" class="screen-reader-text"> Select all</label></th><th>URL</th></thead>';
		echo '<tbody>';

		foreach( array_keys( $logged_404s ) as $k ) {
			$k_attr = esc_attr( $k );
			$k = htmlspecialchars( $k );
			echo "<tr><td><input type='checkbox' name='add_404s[]' id='wp-404-$k_attr' value='$k_attr' /></td><td><label for='wp-404-$k_attr'><code>$k</code></label></td></tr>";
		}
		echo '</tbody></table></div>';
		wp_nonce_field( 'wp-410-settings' );
		echo '<p class="submit"><input class="button button-primary" type="submit" name="add-to-410-list" value="Add selected entries to 410 list" /></p>';
	}
	?>
	</form>

	<h3>Manually add URLs</h3>
	<form action="" method="post">
	<p>You can manually add items to the list by entering them below. Please enter one <strong>fully qualified</strong> URL per line.</p>
	<p>Use <code>*</code> as a wildcard character. So <code>http://www.example.com/*/music/</code> will match all URLs ending in <code>/music/</code>.</p>
	<textarea name="links_to_add" rows="8" cols="80"></textarea>
	<?php wp_nonce_field( 'wp-410-settings' ); ?>
	<p class="submit"><input class="button button-primary" type="submit" name="add-to-410-list" value="Add entries to 410 list" /></p>
	</form>

	<h3>410 reponse message</h3>
	<p>By default, the plugin issues the following plain-text message as part of the 410 response: <code>Sorry, the page you requested has been permanently removed.</code></p>
	<?php
		if( locate_template( '410.php' ) )
			echo '<p><strong>A template file <code>410.php</code> has been detected in your theme directory. This file will be used to display 410 responses.</strong> To revert back to the default message, remove the file from your theme directory.</p>';
		else
			echo '<p>If you would like to use your own template instead, simply place a file called <code>410.php</code> in your theme directory, containing your template. Have a look at your theme\'s <code>404.php</code> template to see what it should look like.</p>';
	?>
	</div>
	<script>
	jQuery(function($){
		$("#wp-gone-captcha-settings input").change( function(){
			$("#message").slideUp('slow');
		});
		$("#select-all-410, #select-all-404").change(function() {
			var el = $(this);
			el.closest("table").find("tbody input").prop("checked", el.is(":checked"));
		});
	});
	</script>
<?php
	}

	private function is_valid_url ( $link ) {
		// Determine whether WP will handle a request for this URL
		$wp_path = parse_url( home_url( '/' ), PHP_URL_PATH );
		$link_path = parse_url( $link, PHP_URL_PATH );

		if( strpos( $link_path, $wp_path ) !== 0 )
			return false;

		if( !$this->permalinks ) {
			$req = preg_replace( '|' . preg_quote( $wp_path, '|' ) . '/?|' , '', $link_path );
			if( strlen( $req ) && $req[0] != '?' )	// this is a pretty permalink, but pretty permalinks are disabled
				return false;
		}

		return true;
	}

	function note_inserted_post( $id ) {
		$post = get_post( $id );

		if( 'revision' == $post->post_type || 'draft' == $post->post_status )
			return;

		// Check our list of URLs against the new/updated post's permalink, and if they match, scratch it from our list
		$created_links = array();

		$created_links[] = rawurldecode( get_permalink( $id ) );
		$created_links[] = get_post_comments_feed_link( $id );	// back compat

		if( $this->permalinks )
			$created_links[] .= $created_links[0] . '*';

		foreach( $created_links as $link )
			$this->remove_link( $link );
	}

	function check_for_410() {
		// Don't mess if Wordpress has found something to display
		if( !is_404() )
			return;

		$links = $this->get_links();
		$req  = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$req = rawurldecode( $req );

		foreach( $links as $link ) {
			if( @preg_match( $link->gone_regex, $req ) ) {
				define( 'DONOTCACHEPAGE', true );		// WP Super Cache and W3 Total Cache recognise this
				status_header( 410 );
				do_action( 'wp_410_response' );	// you can use this to customise the response message

				if( ! locate_template( '410.php', true ) )
					echo 'Sorry, the page you requested has been permanently removed.';

				exit;
			}
		}

		// no hit, log 404
		$this->add_link( $req, true );
	}
}

new WP_410();
