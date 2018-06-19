<?php


/**
 * Removes wpautop and improper nesting of p and br tags
 */

if (!function_exists("prime_remove_autop")) {
    function prime_remove_autop($content)
    {
        $content = do_shortcode(shortcode_unautop($content));
        $content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
        return $content;
    }
}


?>