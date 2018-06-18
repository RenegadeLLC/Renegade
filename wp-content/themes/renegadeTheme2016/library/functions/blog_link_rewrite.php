	<?php
/**
 * @package Renegade
 */
?>

<?php 
function filter_post_link($permalink, $post) {
    if ($post->post_type != 'post')
        return $permalink;
    return 'blog'.$permalink;
}
add_filter('pre_post_link', 'filter_post_link', 10, 2);


add_action( 'generate_rewrite_rules', 'add_blog_rewrites' );
function add_blog_rewrites( $wp_rewrite ) {
    $wp_rewrite->rules = array(
        'blog/([^/]+)/?$' => 'index.php?name=$matches[1]',
        'blog/[^/]+/attachment/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
        'blog/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
        'blog/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
        'blog/([^/]+)/trackback/?$' => 'index.php?name=$matches[1]&tb=1',
        'blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'blog/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?name=$matches[1]&paged=$matches[2]',
        'blog/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?name=$matches[1]&cpage=$matches[2]',
        'blog/([^/]+)(/[0-9]+)?/?$' => 'index.php?name=$matches[1]&page=$matches[2]',
        'blog/[^/]+/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
        'blog/[^/]+/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
        'blog/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
    ) + $wp_rewrite->rules;
}
?>