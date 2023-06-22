<?php


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


function ewp_is_keyword_included($content, $keywords)
{
	if ($keywords)
	{
		foreach ($keywords as $keyword) {
			if (!empty($keyword)) {
				if (strpos($content, $keyword) !== false) {
					return true;
				}
			}
		}
	}
    return false;
}


function ewp_rewrite_html($html)
{
    try {
		
		// Process Only GET Requests
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		  return $html;
		}
		
        // Detect non-HTML
        if (!isset($html) || trim($html) === '' || strcasecmp(substr($html, 0, 5), '<?xml') === 0 || trim($html)[0] !== "<") {
            return $html;
        }

        // Exclude on Pages
        $ewp_disabled_pages = get_option('ewp_disabled_pages');
        $current_url = home_url($_SERVER['REQUEST_URI']);
        if (ewp_is_keyword_included($current_url, $ewp_disabled_pages))
		{
            return $html;
        }
		
		// Exclude Logged-in Users
        if ( is_user_logged_in() ) {
            return $html;
        }
		
		// Disable in Mobile
		$ewp_css_mobile_disabled = get_option('ewp_css_mobile_disabled');
		$ewp_js_mobile_disabled = get_option('ewp_js_mobile_disabled');
		$ewp_video_mobile_disabled = get_option('ewp_video_mobile_disabled');
		
        // Parse HTML
        $newHtml = str_get_html($html);

        // Not HTML, return original
        if (!is_object($newHtml)) {
            return $html;
        }

        $ewp_css_include_list = get_option('ewp_css_include_list');
		$ewp_js_include_list = get_option('ewp_js_include_list');
		$ewp_video_include_list = get_option('ewp_video_include_list');


		// CSS Delay
		foreach ($newHtml->find("link[!rel],link[rel='preload'],link[rel='stylesheet']") as $link) {
			
			if($ewp_css_mobile_disabled == "yes"){
				if ( wp_is_mobile() ) {
				break;
				}
			}
		
            if (ewp_is_keyword_included($link->outertext, $ewp_css_include_list)) {
                $link->setAttribute("data-type", "kppassive");
                if ($link->getAttribute("href")) {
                    $link->setAttribute("data-kplinkhref", $link->getAttribute("href"));
                    $link->setAttribute("href", "data:text/css;charset=utf-8;base64,LypibGFuayov");
                } else {
                    $link->setAttribute("data-kplinkhref", "data:text/css;base64,".base64_encode($link->innertext));
                    $link->innertext="";
                }
            }
        }
		
		
		// JS Delay
        foreach ($newHtml->find("script[!type],script[type='text/javascript']") as $script) {
			
			if($ewp_js_mobile_disabled == "yes"){
				if ( wp_is_mobile() ) {
				break;
				}
			}
			
            if (ewp_is_keyword_included($script->outertext, $ewp_js_include_list)) {
                $script->setAttribute("data-type", "kppassive");
                if ($script->getAttribute("src")) {
                    $script->setAttribute("data-kpscriptsrc", $script->getAttribute("src"));
                    $script->removeAttribute("src");
                } else {
                    $script->setAttribute("data-kpscriptsrc", "data:text/javascript;base64,".base64_encode($script->innertext));
                    $script->innertext="";
                }
            }
        }
		
		//Video Delay
		foreach ($newHtml->find("video,video[src],source[src],iframe[src]") as $video){
			
			if($ewp_video_mobile_disabled == "yes"){
				if ( wp_is_mobile() ) {
				break;
				}
			}
			
			if (ewp_is_keyword_included($video->outertext, $ewp_video_include_list)) {
                $video->setAttribute("data-type", "kppassive");
                if ($video->getAttribute("src"))
				{
                    $video->setAttribute("data-kpvideosrc", $video->getAttribute("src"));
                    $video->removeAttribute("src");
                } else {
                    /*$video->setAttribute("data-kpvideosrc", "data:video/mp4;base64,".base64_encode($video->innertext));
                    $video->innertext="";*/
                }
            }
        }

        return $newHtml;
    } catch (Exception $e) {
        return $html;
    }
}

if (!is_admin()) {
    ob_start("ewp_rewrite_html");
}

// W3TC HTML rewrite
add_filter('w3tc_process_content', function ($buffer) {
    if ( is_admin() ) return $buffer;
    return ewp_rewrite_html($buffer);
});