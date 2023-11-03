<?php

/*
Plugin Name: PearlLanguage
 Plugin URI: http://pearllanguage.org/
Description: Pearl Language
    Version: 1.0
     Author: Martien van Steenbergen (latest)
     Author: Martijn van Steenbergen (original)
 Author URI: https://martijn.van.steenbergen.nl/
*/

add_filter('the_content', array('PearlLanguage', 'find_pearls'));
add_action('wp_head', array('PearlLanguage', 'insert_css'));

class PearlLanguage {

		static function find_pearls($the_content) {

		// patterns like {{p|en|name}} or {{p|nl|naam}}

		$pattern = '({{p\|((en)|(nl))\|([^}]+)}})';

				if (preg_match_all($pattern, $the_content, $matches, PREG_SET_ORDER)) {

						foreach ($matches as $match) {

								$pearl = $match[4];
								$lang = $match[1];

								$pearl_title = "$pl &raquo; " . ucwords($pearl);
								$pearl_url = urlencode(str_replace(' ', '_', $pearl));

								$pl = "Pearl Language";
								$domain = "http://pearllanguage.org";
								if ($lang == "nl") {
										$pl = "Pareltaal";
										$domain = "http://pareltaal.nl";
								}

								$pearl_html = '<a class="pearl"'
										. 'href="'
										. $domain
										. "/"
										. $pearl_url
										. '" title="'
										. $pearl_title
										. '">'
										. $pearl
										. '</a>'
										;

								$the_content = str_replace($match[0], $pearl_html, $the_content);
						}
				}
				return $the_content;
		}

static function insert_css() {
		echo '<link rel="stylesheet" href="'
		. get_bloginfo('url')
		. '/wp-content/plugins/pearllanguage/pearllanguage.css"'
		. 'type="text/css" />'
		. "\n\n"
		;
}

}

?>
