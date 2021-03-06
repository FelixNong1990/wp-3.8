<?php
//////////////////////////////////////////////////////////////////
// Remove extra P tags
//////////////////////////////////////////////////////////////////
function avada_shortcodes_formatter($content) {
	$block = join("|",array("youtube", "vimeo", "soundcloud", "button", "dropcap", "highlight", "checklist", "tabs", "tab", "accordian", "toggle", "one_half", "one_third", "one_fourth", "two_third", "three_fourth", "tagline_box", "pricing_table", "pricing_column", "pricing_price", "pricing_row", "pricing_footer", "content_boxes", "content_box", "slider", "slide", "testimonials", "testimonial", "progress", "person", "recent_posts", "recent_works", "alert", "fontawesome", "social_links", "clients", "client", "title", "separator", "tooltip", "fullwidth", "map", "counters_circle", "counter_circle", "counters_box", "counter_box", "flexslider", "blog", "imageframe", "images", "image", "sharing", "featured_products_slider", "products_slider", "menu_anchor"));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}

add_filter('the_content', 'avada_shortcodes_formatter');
add_filter('widget_text', 'avada_shortcodes_formatter');

//////////////////////////////////////////////////////////////////
// Youtube shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('youtube', 'shortcode_youtube');
	function shortcode_youtube($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 600,
				'height' => 360,
				'autoplay' => "false"
			), $atts);

			$autoplay = "";
			if($atts['autoplay'] == "true" || $atts['autoplay'] == "yes") {
				$autoplay = "&amp;autoplay=1";
			}
			return '<div style="max-width:'.$atts['width'].'px;max-height:'.$atts['height'].'px;"><div class="video-shortcode"><iframe title="YouTube video player" width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.youtube.com/embed/' . $atts['id'] . '?wmode=transparent'.$autoplay.'" frameborder="0" allowfullscreen></iframe></div></div>';
	}

//////////////////////////////////////////////////////////////////
// Vimeo shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('vimeo', 'shortcode_vimeo');
	function shortcode_vimeo($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 600,
				'height' => 360,
				'autoplay' => "false"
			), $atts);

		$protocol = (is_ssl())? 's' : '';

		$autoplay = "";
		if($atts['autoplay'] == "true" || $atts['autoplay'] == "yes") {
			$autoplay = "?autoplay=1";
		}

		return '<div style="max-width:'.$atts['width'].'px;max-height:'.$atts['height'].'px;"><div class="video-shortcode"><iframe src="http'.$protocol.'://player.vimeo.com/video/' . $atts['id'] .$autoplay. '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" frameborder="0"></iframe></div></div>';
	}

//////////////////////////////////////////////////////////////////
// SoundCloud shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('soundcloud', 'shortcode_soundcloud');
	function shortcode_soundcloud($atts) {
		$atts = shortcode_atts(
			array(
				'url' => '',
				'width' => '100%',
				'height' => 81,
				'comments' => 'true',
				'auto_play' => 'true',
				'color' => 'ff7700',
			), $atts);

			if($atts['comments'] == 'yes') {
				$atts['comments'] = 'true';
			} elseif($atts['comments'] == 'no') {
				$atts['comments'] = 'false';
			}

			if($atts['auto_play'] == 'yes') {
				$atts['auto_play'] = 'true';
			} elseif($atts['auto_play'] == 'no') {
				$atts['auto_play'] = 'false';
			}

			if($atts['color']) {
				$atts['color'] = str_replace('#', '', $atts['color']);
			}

			return '<iframe width="'.$atts['width'].'" height="'.$atts['height'].'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '"></iframe>';
			//return '<object height="' . $atts['height'] . '" width="' . $atts['width'] . '"><param name="movie" value="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '"></param><param name="allowscriptaccess" value="always"></param><embed allowscriptaccess="always" height="' . $atts['height'] . '" src="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '" type="application/x-shockwave-flash" width="' . $atts['width'] . '"></embed></object>';
	}

//////////////////////////////////////////////////////////////////
// Button shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('button', 'shortcode_button');
	function shortcode_button($atts, $content = null) {
		extract(shortcode_atts(array(
			'link' => '',
            'border_color'			=> '',
            'border_width'			=> '',
            'color'               	=> 'default',
            'gradient_colors'	  	=> '',
            'gradient_hover_colors'	=> '',
			'size' => 'small',
			'target' => '_self',
            'text_color'			=> '',
            'shadow'				=> 'yes',
			'title' => '',
			'animation_type' => '',
			'animation_direction' => 'left',
			'animation_speed' => ''
		), $atts));

		static $avada_button_counter = 1;


        $styles = '';
        if( $color == 'custom' && ( $border_color || $border_width || $text_color || $gradient_colors || $gradient_hover_colors || $text_shadow ) ) {

			$general_styles = $gradient_styles = $gradient_hover_styles = '';
			$styles = '<style>';
			if( $border_color || $border_width ) {
				$general_styles .= 'border-style:solid;';
			}

			if( $border_color ) {
				$general_styles .= sprintf( 'border-color:%s!important;', $border_color );
			}

			if( $border_width ) {
				$general_styles .= sprintf( 'border-width:%s!important;', $border_width );
			}

			if( $text_color ) {
				$general_styles .= sprintf( 'color:%s!important;', $text_color );
			}

			if( $shadow == 'no' ) {
				$general_styles .= 'text-shadow:none !important;-webkit-box-shadow:none !important;-moz-box-shadow:none !important;box-shadow:none !important;';
			}

			if( $general_styles ) {
				$styles .= sprintf( 'a.button-%s,a.button-%s:hover{%s}', $avada_button_counter, $avada_button_counter, $general_styles );
			}

			if( $gradient_colors ) {

				$grad_colors = explode( ';', $gradient_colors );

				if( ! $grad_colors[1] ) {
					$grad_colors[1] = $grad_colors[0];
				}
				$gradient_styles =
				"background: {$grad_colors[0]};
				background-image: -webkit-gradient( linear, left bottom, left top, from( {$grad_colors[1]} ), to( {$grad_colors[0]} ) )!important;
				background-image: -webkit-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} )!important;
				background-image:    -moz-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} )!important;
				background-image:      -o-linear-gradient( bottom, {$grad_colors[1]}, {$grad_colors[0]} )!important;
				background-image: linear-gradient( to top, {$grad_colors[1]}, {$grad_colors[0]} )!important;";

				$styles .= sprintf( 'a.button-%s{%s}', $avada_button_counter, $gradient_styles );
			}

			if( $gradient_hover_colors ) {

				$grad_hover_colors = explode( ';', $gradient_hover_colors );

				if( ! $grad_hover_colors[1] ) {
					$grad_hover_colors[1] = $grad_hover_colors[0];
				}
				$gradient_hover_styles .=
				"background: {$grad_hover_colors[0]};
				background-image: -webkit-gradient( linear, left bottom, left top, from( {$grad_hover_colors[1]} ), to( {$grad_hover_colors[0]} ) )!important;
				background-image: -webkit-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} )!important;
				background-image:    -moz-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} )!important;
				background-image:      -o-linear-gradient( bottom, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} )!important;
				background-image: linear-gradient( to top, {$grad_hover_colors[1]}, {$grad_hover_colors[0]} )!important;";

				$styles .= sprintf( 'a.button-%s:hover{%s}', $avada_button_counter, $gradient_hover_styles );
			}

			$styles .= '</style>';
		}

		$direction_suffix = '';
		$animation_class = '';
		$animation_attribues = '';
		if($animation_type) {
			$animation_class = ' animated';
			if($animation_type != 'flash' && $animation_type != 'shake') {
				$direction_suffix = 'In'.ucfirst($animation_direction);
				$animation_type .= $direction_suffix;
			}
			$animation_attribues = ' animation_type="'.$animation_type.'"';

			if($animation_speed) {
				$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
			}
		}

		if(!$color || !isset($color)) {
			$color = 'default';
		}

		$html = $styles . '<a class="button-'.$avada_button_counter.' button ' . $size . ' ' . $color .$animation_class .'" title="' . $title . '" href="' . $link . '" target="' . $target . '"'.$animation_attribues.'>' .do_shortcode($content). '</a>';

		$avada_button_counter++;

		return $html;
	}

//////////////////////////////////////////////////////////////////
// Dropcap shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('dropcap', 'shortcode_dropcap');
	function shortcode_dropcap( $atts, $content = null ) {

		return '<span class="dropcap">' .do_shortcode($content). '</span>';

}

//////////////////////////////////////////////////////////////////
// Highlight shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('highlight', 'shortcode_highlight');
	function shortcode_highlight($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'color' => 'yellow',
			), $atts);

			if($atts['color'] == 'black') {
				return '<span class="highlight2" style="background-color:'.$atts['color'].';">' .do_shortcode($content). '</span>';
			} else {
				return '<span class="highlight1" style="background-color:'.$atts['color'].';">' .do_shortcode($content). '</span>';
			}

	}


//////////////////////////////////////////////////////////////////
// Check list shortcode
//////////////////////////////////////////////////////////////////
// Fontawesome icons list
$pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = plugin_dir_path( __FILE__ ) .'tinymce/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

global $icons;

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

add_shortcode('checklist', 'shortcode_checklist');
	function shortcode_checklist( $atts, $content = null ) {
		global $data, $icons;

		static $avada_checklist_box_counter = 1;

		extract(shortcode_atts(array(
			'icon' => 'arrow',
			'iconcolor' => '',
			'circle' => 'yes'
		), $atts));

		if(!$iconcolor) {
			$iconcolor = strtolower($data['checklist_icons_color']);
		}

	$css_attributes = "";
	if($icon != "arrow" && $icon != "asterik" && $icon != "cross") {
		$css_attributes = 	"content:'{$icons['icon-'.$icon]}'";
	}
	$str = "<style type='text/css'>
	#checklist-{$avada_checklist_box_counter} li:before{color:{$iconcolor} !important; {$css_attributes} }
	</style>";
	$str .= str_replace('<ul>', '<ul id="checklist-'.$avada_checklist_box_counter.'" class="list-icon circle-'.$circle.' list-icon-'.$icon.'">', $content);
	$str = str_replace('<li>', '<li>', $str);

	$str = do_shortcode($str);

	$avada_checklist_box_counter++;

	return $str;
}

//////////////////////////////////////////////////////////////////
// Tabs shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('tabs', 'shortcode_tabs');
	function shortcode_tabs( $atts, $content = null ) {
	global $data;

	extract(shortcode_atts(array(
		'layout' => 'horizontal',
		'backgroundcolor' => '',
		'inactivecolor' => ''
	), $atts));

	if(!$backgroundcolor) {
		$backgroundcolor = $data['tabs_bg_color'];
	}

	if(!$inactivecolor) {
		$inactivecolor = $data['tabs_inactive_color'];
	}

	static $avada_tabs_counter = 1;

	$out = "<style type='text/css'>
	#tabs-{$avada_tabs_counter},#tabs-{$avada_tabs_counter}.tabs-vertical .tabs,#tabs-{$avada_tabs_counter}.tabs-vertical .tab_content{border-color:{$inactivecolor} !important;}
	#tabs-{$avada_tabs_counter}.tabs-horizontal,#tabs-{$avada_tabs_counter}.tabs-vertical .tab_content{background-color:{$backgroundcolor} !important;}
	body #tabs-{$avada_tabs_counter}.shortcode-tabs .tab-hold .tabs li,body.dark #sidebar .tab-hold .tabs li{border-right:1px solid {$backgroundcolor};}
	body #tabs-{$avada_tabs_counter}.shortcode-tabs .tab-hold .tabs li:last-child{border-right-width:0 !important;}
	body #tabs-{$avada_tabs_counter}.shortcode-tabs .tab-hold .tabs li.no-border-right{border-right-width:0 !important;}
	body #tabs-{$avada_tabs_counter} .tab-hold .tabs li a{background:{$inactivecolor} !important;border-bottom:0 !important;color:{$data['body_text_color']};}
	body #tabs-{$avada_tabs_counter} .tab-hold .tabs li a:hover{background:{$backgroundcolor} !important;border-bottom:0 !important;}
	body #tabs-{$avada_tabs_counter} .tab-hold .tabs li.active a,body #tabs-{$avada_tabs_counter} .tab-hold .tabs li.active{background:{$backgroundcolor} !important;border-bottom:0 !important;}
	#sidebar .tab-hold .tabs li.active a{border-top-color:{$data['primary_color']} !important;}
	</style>";

	$out .= '<div id="tabs-'.$avada_tabs_counter.'" class="tab-holder shortcode-tabs clearfix tabs-'.$layout.'">';

	$out .= '<div class="tab-hold tabs-wrapper">';

	$out .= '<ul id="tabs" class="tabset tabs">';
	foreach ($atts as $key => $tab) {
		if($key != 'layout' && $key != 'backgroundcolor' && $key != 'inactivecolor') {
			$out .= '<li><a href="#' . $key . '">' . $tab . '</a></li>';
		}
	}
	$out .= '</ul>';

	$out .= '<div class="tab-box tabs-container">';

	$out .= do_shortcode($content) .'</div></div></div>';

	$avada_tabs_counter++;

	return $out;
}

add_shortcode('tab', 'shortcode_tab');
	function shortcode_tab( $atts, $content = null ) {
	extract(shortcode_atts(array(
	), $atts));

	$out = '';
	$out .= '<div id="tab' . $atts['id'] . '" class="tab tab_content">' . do_shortcode($content) .'</div>';

	return $out;
}

add_shortcode('fusion_tabs', 'shortcode_fusion_tabs');
	function shortcode_fusion_tabs( $atts, $content = null ) {
		$content = preg_replace('/tab\][^\[]*/','tab]', $content);
		$content = preg_replace('/^[^\[]*\[/','[', $content);

		$preg_match_all = preg_match_all( '/fusion_tab title="([^\"]+)"/i', $content, $matches );

		if($matches[1]) {
			foreach($matches[1] as $key => $title) {
				$sanitized_title = hash("adler32", $title, false);
				$sanitized_title = str_replace('-', '_', $sanitized_title);
				$tabs .= 'tab' . $sanitized_title . '="' . $title . '" ';
			}
		}

		$shortcode_wrapper = '[tabs ' . $tabs . ' layout="' . $atts['layout'] . '" backgroundcolor="' . $atts['backgroundcolor'] . '" inactivecolor="' . $atts['inactivecolor'] . '"]';
		$shortcode_wrapper .= $content;
		$shortcode_wrapper .= '[/tabs]';

		return do_shortcode($shortcode_wrapper);
	}

add_shortcode('fusion_tab', 'shortcode_fusion_tab');
	function shortcode_fusion_tab( $atts, $content = null ) {
		$sanitized_title = hash("adler32", $atts['title'], false);
		$sanitized_title = str_replace('-', '_', $sanitized_title);
		$shortcode_wrapper = '[tab id="' . $sanitized_title . '"]' . do_shortcode($content) . '[/tab]';

		return do_shortcode($shortcode_wrapper);
	}

//////////////////////////////////////////////////////////////////
// Accordian
//////////////////////////////////////////////////////////////////
add_shortcode('accordian', 'shortcode_accordian');
	function shortcode_accordian( $atts, $content = null ) {
	$out = '';
	$out .= '<div class="accordian">';
	$out .= do_shortcode($content);
	$out .= '</div>';

   return $out;
}

//////////////////////////////////////////////////////////////////
// Toggle shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('toggle', 'shortcode_toggle');
	function shortcode_toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title'      => '',
		'open' => 'no'
	), $atts));

	$toggleclass = '';
	$toggleclass2 = '';
	$togglestyle = 'display: none;';

	if($open == 'yes'){
		$toggleclass = "active";
		$toggleclass2 = "default-open";
		$togglestyle = "display: block;";
	}

	$out = '';
	$out .= '<h5 class="toggle '.$toggleclass.'"><a href="#"><span class="arrow"></span>' .$title. '</a></h5>';
	$out .= '<div class="toggle-content '.$toggleclass2.'" style="'.$togglestyle.'">';
	$out .= do_shortcode($content);
	$out .= '</div>';

   return $out;
}

//////////////////////////////////////////////////////////////////
// Column one_half shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_half', 'shortcode_one_half');
	function shortcode_one_half($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_half last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_half">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_third', 'shortcode_one_third');
	function shortcode_one_third($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_third last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_third">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column two_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('two_third', 'shortcode_two_third');
	function shortcode_two_third($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="two_third last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="two_third">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_fourth', 'shortcode_one_fourth');
	function shortcode_one_fourth($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_fourth last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_fourth">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column three_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('three_fourth', 'shortcode_three_fourth');
	function shortcode_three_fourth($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="three_fourth last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="three_fourth">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Tagline box shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('tagline_box', 'shortcode_tagline_box');
	function shortcode_tagline_box($atts, $content = null) {
		global $data;

		static $tagline_box_counter = 1;

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'shadow' => 'no',
			'shadowopacity' => '0.7',
			'border' => '0px',
			'bordercolor' => '',
			'highlightposition' => 'left',
			'linktarget' => '_self',
			'buttoncolor' => 'default',
			'animation_type' => '',
			'animation_direction' => 'left',
			'animation_speed' => ''
		), $atts));

		$direction_suffix = '';
		$animation_class = '';
		$animation_attribues = '';
		if($animation_type) {
			$animation_class = ' animated';
			if($animation_type != 'flash' && $animation_type != 'shake') {
				$direction_suffix = 'In'.ucfirst($animation_direction);
				$animation_type .= $direction_suffix;
			}
			$animation_attribues = ' animation_type="'.$animation_type.'"';

			if($animation_speed) {
				$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
			}
		}

		if(!$backgroundcolor) {
			$backgroundcolor = $data['tagline_bg'];
		}

		if(!$bordercolor) {
			$bordercolor = $data['tagline_border_color'];
		}

		if(!$buttoncolor) {
			$buttoncolor = 'default';
		}

		$class = '';

		if($shadow == 'yes') {
			$class = 'tagline-shadow';
		}

		$str = "<style type='text/css'>#reading-box-container-{$tagline_box_counter} .tagline-shadow:before,#reading-box-container-{$tagline_box_counter} .tagline-shadow:after{opacity:{$shadowopacity};}</style>";
		$str .= '<div class="reading-box-container clearfix'.$animation_class.'" id="reading-box-container-'.$tagline_box_counter.'"'.$animation_attribues.'><section class="reading-box '.$class.'" style="background-color:'.$backgroundcolor.' !important;border-width:'.$border.';border-color:'.$bordercolor.'!important;border-'.$highlightposition.'-width:3px !important;border-'.$highlightposition.'-color:'.$data['primary_color'].'!important;border-style:solid;">';
			if((isset($atts['link']) && $atts['link']) && (isset($atts['button']) && $atts['button'])):
			$str .= '<a href="'.$atts['link'].'" target="'.$linktarget.'" class="continue button large '.$buttoncolor.'">'.$atts['button'].'</a>';
			endif;
			if(isset($atts['title']) && $atts['title']):
			$str .= '<h2>'.$atts['title'].'</h2>';
			endif;
			if(isset($atts['description']) && $atts['description']):
			$str.= '<p>'.$atts['description'].'</p>';
			endif;
			if(isset($atts['link']) && $atts['link'] && isset($atts['button']) && $atts['button']):
			$str .= '<a href="'.$atts['link'].'" target="'.$linktarget.'" class="continue mobile-button button large '.$buttoncolor.'">'.$atts['button'].'</a>';
			endif;
		$str .= '</section></div>';

		$tagline_box_counter++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing table
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_table', 'shortcode_pricing_table');
	function shortcode_pricing_table($atts, $content = null) {
		global $data;

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'bordercolor' => '',
			'dividercolor' => ''
		), $atts));

		static $avada_pricing_table_counter = 1;

		if(!$backgroundcolor) {
			$backgroundcolor = $data['pricing_bg_color'];
		}

		if(!$bordercolor) {
			$bordercolor = $data['pricing_border_color'];
		}

		if(!$dividercolor) {
			$dividercolor = $data['pricing_divider_color'];
		}

		$str = "<style type='text/css'>
		#pricing-table-{$avada_pricing_table_counter}.full-boxed-pricing{background-color:{$bordercolor} !important;}
		#pricing-table-{$avada_pricing_table_counter} .column{background-color:{$backgroundcolor} !important;border-color:{$dividercolor} !important;}
		#pricing-table-{$avada_pricing_table_counter}.sep-boxed-pricing .column{background-color:{$bordercolor} !important;}
		#pricing-table-{$avada_pricing_table_counter} .column li{border-color:{$dividercolor} !important;}
		#pricing-table-{$avada_pricing_table_counter} li.normal-row{background-color:{$backgroundcolor} !important;}
		#pricing-table-{$avada_pricing_table_counter}.full-boxed-pricing li.title-row{background-color:{$backgroundcolor} !important;}
		#pricing-table-{$avada_pricing_table_counter} li.pricing-row,#pricing-table-{$avada_pricing_table_counter} li.footer-row{background-color:{$bordercolor} !important;}
		</style>";

		if($atts['type'] == '2') {
			$type = 'sep';
		} elseif($atts['type'] == '1') {
			$type = 'full';
		} else {
			$type = 'third';
		}
		$str .= '<div id="pricing-table-'.$avada_pricing_table_counter.'" class="'.$type.'-boxed-pricing">';
		$str .= do_shortcode($content);
		$str .= '</div><div class="clear"></div>';

		$avada_pricing_table_counter++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Column
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_column', 'shortcode_pricing_column');
	function shortcode_pricing_column($atts, $content = null) {
		$str = '<div class="column">';
		$str .= '<ul>';
		if($atts['title']):
		$str .= '<li class="title-row">'.$atts['title'].'</li>';
		endif;
		$str .= do_shortcode($content);
		$str .= '</ul>';
		$str .= '</div>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Row
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_price', 'shortcode_pricing_price');
	function shortcode_pricing_price($atts, $content = null) {
		$str = '';
		$str .= '<li class="pricing-row">';
		if(isset($atts['currency']) && !empty($atts['currency']) && isset($atts['price']) && (!empty($atts['price']) || ($atts['price'] == '0')) ) {
			$class = '';
			$price = explode('.', $atts['price']);
			if($price[1]){
				$class .= 'price-with-decimal';
			}
			$str .= '<div class="price '.$class.'">';
				$str .= '<strong>'.$atts['currency'].'</strong>';
				$str .= '<em class="exact_price">'.$price[0].'</em>';
				if($price[1]){
					$str .= '<sup>'.$price[1].'</sup>';
				}
				if($atts['time']) {
					$str .= '<em class="time">'.$atts['time'].'</em>';
				}
			$str .= '</div>';
		} else {
			$str .= do_shortcode($content);
		}
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Row
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_row', 'shortcode_pricing_row');
	function shortcode_pricing_row($atts, $content = null) {
		$str = '';
		$str .= '<li class="normal-row">';
		$str .= do_shortcode($content);
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Footer
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_footer', 'shortcode_pricing_footer');
	function shortcode_pricing_footer($atts, $content = null) {
		$str = '';
		$str .= '<li class="footer-row">';
		$str .= do_shortcode($content);
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Content box shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('content_boxes', 'shortcode_content_boxes');
	function shortcode_content_boxes($atts, $content = null) {
		global $data;

		extract(shortcode_atts(array(
			'layout' => 'icon-with-title',
			'iconcolor' => '',
			'circlecolor' => '',
			'circlebordercolor' => '',
			'backgroundcolor' => ''
		), $atts));

		static $avada_content_box_counter = 1;

		if(!$iconcolor) {
			$iconcolor = $data['icon_color'];
		}

		if(!$circlecolor) {
			$circlecolor = $data['icon_circle_color'];
		}

		if(!$circlebordercolor) {
			$circlebordercolor = $data['icon_border_color'];
		}

		if(!$backgroundcolor) {
			$backgroundcolor = $data['content_box_bg_color'];
		}

		$str = "<style type='text/css'>
		#content-boxes-{$avada_content_box_counter} article.col{background-color:{$backgroundcolor} !important;}
		#content-boxes-{$avada_content_box_counter} .fontawesome-icon.circle-yes{color:{$iconcolor} !important;background-color:{$circlecolor} !important;border-color: {$circlebordercolor} !important;}
		#content-boxes-{$avada_content_box_counter} a:hover .fontawesome-icon.circle-yes{background-color: {$data['primary_color']} !important;border-color:{$data['primary_color']} !important;}
		</style>";

		preg_match_all('/(\[content_box (.*?)\](.*?)\[\/content_box\])/s', $content, $matches);
		if( is_array( $matches ) && !empty( $matches ) ) {
			$columns = count($matches[0]);
			if( $columns > 0 ) {
				$columns = $columns;
			} else if( $columns > 4 ) {
				$columns = 4;
			} else if ( !$columns ) {
				$columns = 4;
			}
		} else {
			$columns = 4;
		}
		$str .= '<section class="clearfix columns content-boxes content-boxes-'.$layout.' columns-'.$columns.'" id="content-boxes-'.$avada_content_box_counter.'">';
		$str .= do_shortcode($content);
		$str .= '</section>';

		$avada_content_box_counter++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Content box shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('content_box', 'shortcode_content_box');
	function shortcode_content_box($atts, $content = null) {

		extract(shortcode_atts(array(
			'link' => '',
			'linktarget' => '_self',
			'width' => '35',
			'height' => '35',
			'animation_type' => '',
			'animation_direction' => 'left',
			'animation_speed' => '',
			'img_id' => '',
		), $atts));

		$direction_suffix = '';
		$animation_class = '';
		$animation_attribues = '';
		if($animation_type) {
			$animation_class = ' animated';
			if($animation_type != 'flash' && $animation_type != 'shake') {
				$direction_suffix = 'In'.ucfirst($animation_direction);
				$animation_type .= $direction_suffix;
			}
			$animation_attribues = ' animation_type="'.$animation_type.'"';

			if($animation_speed) {
				$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
			}
		}

		$str = '';
		if(!empty($atts['last']) && $atts['last'] == 'yes'):
		$str .= '<article class="col last">';
		else:
		$str .= '<article class="col">';
		endif;

		if((isset($atts['image']) && $atts['image']) || (isset($atts['title']) && $atts['title'])):
			if(!empty($atts['image'])) {
				$margin_left = -$atts['image_width']/2;
				$margin_top = 0;
				if($atts['image_height'] < 64) {
					$margin_top = strval((64 - $atts['image_height'])/2).'px';
				}
				$padding_left = $atts['image_width']+10;
				$img_id = "id".strval(mt_rand());
				$str .= "<style type='text/css'>
				.content-boxes-icon-boxed .col .heading-and-icon img#{$img_id} { width:{$atts['image_width']}px; height:{$atts['image_height']}px; margin-left:{$margin_left}px !important;margin-top:{$margin_top} !important;}
				.content-boxes-icon-on-side .col-content-container.{$img_id} { padding-left:{$padding_left}px !important; }
				</style>";
			}
			if(!empty($atts['image']) || !empty($atts['icon'])){
				$str .=	'<div class="heading heading-and-icon">';
			} else {
				$str .=	'<div class="heading">';
			}

			if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']) {
				$str .= '<a href="'.$atts['link'].'" target="'.$linktarget.'">';
			}


		if(isset($atts['image']) && $atts['image']):
		if($animation_type) {
			$animation_class = 'class="animated"';
		}
		$str .= '<img id="'.$img_id.'" src="'.$atts['image'].'" width="'.$atts['image_width'].'" height="'.$atts['image_height'].'" alt="" '.$animation_class.' '.$animation_attribues.'>';
		elseif(!empty($atts['icon']) && $atts['icon']):
			$str .= '<i class="fontawesome-icon medium circle-yes icon-'.$atts['icon'].$animation_class.'" '.$animation_attribues.'></i>';
		endif;
		if($atts['title']):
		$str .= '<h2>'.$atts['title'].'</h2>';
		endif;
		if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']) {
			$str .= '</a>';
		}
		$str .= '</div>';
		endif;

		$str .= '<div class="col-content-container '.$img_id.'">';

		$str .= do_shortcode($content);

		if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']):
		$str .= '<span class="more"><a href="'.$atts['link'].'" target="'.$linktarget.'">'.$atts['linktext'].'</a></span>';
		endif;

		$str .= '</div>';

		$str .= '</article>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Slider
//////////////////////////////////////////////////////////////////
add_shortcode('slider', 'shortcode_slider');
	function shortcode_slider($atts, $content = null) {
		wp_enqueue_script( 'jquery.flexslider' );

		extract(shortcode_atts(array(
			'width' => '100%',
			'height' => '100%'
		), $atts));
		$str = '';
		$str .= '<div class="flexslider clearfix" style="max-width:'.$width.';height:'.$height.';">';
		$str .= '<ul class="slides">';
		$str .= do_shortcode($content);
		$str .= '</ul>';
		$str .= '</div>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Slide
//////////////////////////////////////////////////////////////////
add_shortcode('slide', 'shortcode_slide');
	function shortcode_slide($atts, $content = null) {
		extract(shortcode_atts(array(
			'alt' => '',
			'linktarget' => '_self',
			'lightbox' => 'no'
		), $atts));

		if($lightbox == 'yes') {
			$rel = 'prettyPhoto';
		} else {
			$rel = '';
		}

		$str = '';
		$title = 'title=""';
		if(!$alt) {
			$src = str_replace('&#215;', 'x', $content);
			if(!empty($atts['link']) && $atts['link']) {
				$image_id = tf_get_attachment_id_from_url($atts['link']);
			} else {
				$image_id = tf_get_attachment_id_from_url($src);
			}

			if($image_id) {
				$alt_att = 'alt="'. get_post_meta($image_id, '_wp_attachment_image_alt', true).'"';
				$title = 'title="'. get_post_field("post_excerpt", $image_id).'"';
			}
		} else {
			$alt_att = 'alt="' . $alt . '"';
		}

		if(!empty($atts['type']) && $atts['type'] == 'video') {
			$str .= '<li>';
		} else {
			$str .= '<li class="image">';
		}

		if(isset($atts['link']) && empty($atts['link']) && !$atts['link'] && $atts['type'] == 'image') {
			$atts['link'] = $src;
		}
		if(!empty($atts['link']) && $atts['link']):
		$str .= '<a href="'.$atts['link'].'" target="'.$linktarget.'" rel="'.$rel.'" '.$title.'>';
		endif;
		if(!empty($atts['type']) && $atts['type'] == 'video') {
			$str .= '<div class="full-video">'.do_shortcode($content).'</div>';
		} else {
			$str .= '<img src="'.str_replace('&#215;', 'x', $content).'" '. $alt_att.' />';
		}
		if(!empty($atts['link']) && $atts['link']):
		$str .= '</a>';
		endif;
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Testimonials
//////////////////////////////////////////////////////////////////
add_shortcode('testimonials', 'shortcode_testimonials');
	function shortcode_testimonials($atts, $content = null) {
		global $data;

		wp_enqueue_script( 'jquery.cycle' );

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'textcolor' => ''
		), $atts));

		static $avada_testimonials_id = 1;

		if(!$backgroundcolor) {
			$backgroundcolor = $data['testimonial_bg_color'];
		}


		if(!$textcolor) {
			$textcolor = $data['testimonial_text_color'];
		}

		$str = "<style type='text/css'>
		#testimonials-{$avada_testimonials_id} q{background-color:{$backgroundcolor} !important;color:{$textcolor} !important;}
		#testimonials-{$avada_testimonials_id} .review blockquote div:after{border-top-color:{$backgroundcolor} !important;}
		</style>
		";

		$str .= '<div id="testimonials-'.$avada_testimonials_id.'" class="reviews clearfix">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		$avada_testimonials_id++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
add_shortcode('testimonial', 'shortcode_testimonial');
	function shortcode_testimonial($atts, $content = null) {
		if(!isset($atts['gender'])) {
			$atts['gender'] = 'male';
		}
		$str = '';
		$str .= '<div class="review '.$atts['gender'].'">';
		$str .= '<blockquote>';
		$str .= '<q>';
		$str .= do_shortcode($content);
		$str .= '</q>';
		if($atts['name']):
			$str .= '<div class="clearfix"><span class="company-name">';
			$str .= '<strong>'.$atts['name'].'</strong>';
			if($atts['company']):
				if(!empty($atts['link']) && $atts['link']):
				$str .= '<a href="'.$atts['link'].'" target="'.$atts['target'].'">';
				endif;
				$str .= ',<span> '.$atts['company'].'</span>';
				if(!empty($atts['link']) && $atts['link']):
				$str .= '</a>';
				endif;
			endif;
			$str .= '</span></div>';
		endif;
		$str .= '</blockquote>';
		$str .= '</div>';

		return $str;
	}


//////////////////////////////////////////////////////////////////
// Progess Bar
//////////////////////////////////////////////////////////////////
add_shortcode('progress', 'shortcode_progress');
function shortcode_progress($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'jquery.waypoint' );

	extract(shortcode_atts(array(
		'filledcolor' => '',
		'unfilledcolor' => '',
		'value' => '70',
		'unit' => ''
	), $atts));

	if(!$filledcolor) {
		$filledcolor = $data['counter_filled_color'];
	}

	if(!$unfilledcolor) {
		$unfilledcolor = $data['counter_unfilled_color'];
	}

	$html = '';
	$html .= '<div class="progress-bar" style="background-color:'.$unfilledcolor.' !important;border-color:'.$unfilledcolor.' !important;">';
	$html .= '<div class="progress-bar-content" data-percentage="'.$atts['percentage'].'" style="width: ' . $atts['percentage'] . '%;background-color:'.$filledcolor.' !important;border-color:'.$filledcolor.' !important;">';
	$html .= '</div>';
	$html .= '<span class="progress-title">' . $content . ' ' . $atts['percentage'];
	if(isset($atts['unit']) && $atts['unit']) {
		$html .= $atts['unit'].'</span>';
	} else {
		$html .= '</span>';
	}
	$html .= '</div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Person
//////////////////////////////////////////////////////////////////
add_shortcode('person', 'shortcode_person');
function shortcode_person($atts, $content = null) {
	global $data;

	$html = '';
	$html .= '<div class="person">';
	if($atts['picture']):
		if($atts['pic_link']):
			$html .= '<a href="'.$atts['pic_link'].'"><img class="person-img" src="' . $atts['picture'] . '" alt="' . $atts['name'] . '" /></a>';
		else:
			$html .= '<img class="person-img" src="' . $atts['picture'] . '" alt="' . $atts['name'] . '" />';
		endif;
	endif;

	if(!isset($atts['linktarget'])) {
		$atts['linktarget'] = '';
	}

	if($atts['name'] || $atts['title'] || $atts['facebooklink'] || $atts['twitterlink'] || $atts['linkedinlink'] || $content) {
		$html .= '<div class="person-desc">';
		$icons_color_scheme = "person-author-light";
		if($data['social_links_color'] == 'Dark') {
			$icons_color_scheme = "person-author-dark";
		}
		$nofollow = '';
		if($data['nofollow_social_links']) {
			$nofollow = ' rel="nofollow"';
		}
			$html .= '<div class="person-author '.$icons_color_scheme.' clearfix">';
				$html .= '<div class="person-author-wrapper"><span class="person-name">' . $atts['name'] . '</span>';
				$html .= '<span class="person-title">' . $atts['title'] . '</span></div>';
				if(isset($atts['facebook']) && $atts['facebook']) {
					$html .= '<span class="social-icon"><a href="' . $atts['facebook'] . '" target="'.$atts['linktarget'].'" class="facebook"'.$nofollow.'>Facebook</a><div class="popup">
						<div class="holder">
							<p>Facebook</p>
						</div>
					</div></span>';
				}
				if(isset($atts['twitter']) && $atts['twitter']) {
					$html .= '<span class="social-icon"><a href="' . $atts['twitter'] . '" target="'.$atts['linktarget'].'" class="twitter"'.$nofollow.'>Twitter</a><div class="popup">
						<div class="holder">
							<p>Twitter</p>
						</div>
					</div></span>';
				}
				if(isset($atts['linkedin']) && $atts['linkedin']) {
					$html .= '<span class="social-icon"><a href="' . $atts['linkedin'] . '" target="'.$atts['linktarget'].'" class="linkedin"'.$nofollow.'>LinkedIn</a><div class="popup">
						<div class="holder">
							<p>LinkedIn</p>
						</div>
					</div></span>';
				}
				if(isset($atts['dribbble']) && $atts['dribbble']) {
					$html .= '<span class="social-icon"><a href="' . $atts['dribbble'] . '" target="'.$atts['linktarget'].'" class="dribbble"'.$nofollow.'>Dribbble</a><div class="popup">
						<div class="holder">
							<p>Dribbble</p>
						</div>
					</div></span>';
				}
				if(isset($atts['rss']) && $atts['rss']) {
					$html .= '<span class="social-icon"><a href="' . $atts['rss'] . '" target="'.$atts['linktarget'].'" class="rss"'.$nofollow.'>RSS</a><div class="popup">
						<div class="holder">
							<p>RSS</p>
						</div>
					</div></span>';
				}
				if(isset($atts['youtube']) && $atts['youtube']) {
					$html .= '<span class="social-icon"><a href="' . $atts['youtube'] . '" target="'.$atts['linktarget'].'" class="youtube"'.$nofollow.'>YouTube</a><div class="popup">
						<div class="holder">
							<p>YouTube</p>
						</div>
					</div></span>';
				}
				if(isset($atts['pinterest']) && $atts['pinterest']) {
					$html .= '<span class="social-icon"><a href="' . $atts['pinterest'] . '" target="'.$atts['linktarget'].'" class="tf-pinterest"'.$nofollow.'>Pinterest</a><div class="popup">
						<div class="holder">
							<p>Pinterest</p>
						</div>
					</div></span>';
				}
				if(isset($atts['flickr']) && $atts['flickr']) {
					$html .= '<span class="social-icon"><a href="' . $atts['flickr'] . '" target="'.$atts['linktarget'].'" class="flickr"'.$nofollow.'>Flickr</a><div class="popup">
						<div class="holder">
							<p>Flickr</p>
						</div>
					</div></span>';
				}
				if(isset($atts['vimeo']) && $atts['vimeo']) {
					$html .= '<span class="social-icon"><a href="' . $atts['vimeo'] . '" target="'.$atts['linktarget'].'" class="vimeo"'.$nofollow.'>Vimeo</a><div class="popup">
						<div class="holder">
							<p>Vimeo</p>
						</div>
					</div></span>';
				}
				if(isset($atts['tumlr']) && $atts['tumblr']) {
					$html .= '<span class="social-icon"><a href="' . $atts['tumblr'] . '" target="'.$atts['linktarget'].'" class="tumblr"'.$nofollow.'>Tumblr</a><div class="popup">
						<div class="holder">
							<p>Tumblr</p>
						</div>
					</div></span>';
				}
				if(isset($atts['google']) && $atts['google']) {
					$html .= '<span class="social-icon"><a href="' . $atts['google'] . '" target="'.$atts['linktarget'].'" class="google"'.$nofollow.'>Google+</a><div class="popup">
						<div class="holder">
							<p>Google+</p>
						</div>
					</div></span>';
				}
				if(isset($atts['digg']) && $atts['digg']) {
					$html .= '<span class="social-icon"><a href="' . $atts['digg'] . '" target="'.$atts['linktarget'].'" class="digg"'.$nofollow.'>Digg</a><div class="popup">
						<div class="holder">
							<p>Digg</p>
						</div>
					</div></span>';
				}
				if(isset($atts['blogger']) && $atts['blogger']) {
					$html .= '<span class="social-icon"><a href="' . $atts['blogger'] . '" target="'.$atts['linktarget'].'" class="blogger"'.$nofollow.'>Blogger</a><div class="popup">
						<div class="holder">
							<p>Blogger</p>
						</div>
					</div></span>';
				}
				if(isset($atts['skype']) && $atts['skype']) {
					$html .= '<span class="social-icon"><a href="' . $atts['skype'] . '" target="'.$atts['linktarget'].'" class="skype"'.$nofollow.'>Skype</a><div class="popup">
						<div class="holder">
							<p>Skype</p>
						</div>
					</div></span>';
				}
				if(isset($atts['myspace']) && $atts['myspace']) {
					$html .= '<span class="social-icon"><a href="' . $atts['myspace'] . '" target="'.$atts['linktarget'].'" class="myspace"'.$nofollow.'>Myspace</a><div class="popup">
						<div class="holder">
							<p>Myspace</p>
						</div>
					</div></span>';
				}
				if(isset($atts['deviantart']) && $atts['deviantart']) {
					$html .= '<span class="social-icon"><a href="' . $atts['deviantart'] . '" target="'.$atts['linktarget'].'" class="deviantart"'.$nofollow.'>Deviantart</a><div class="popup">
						<div class="holder">
							<p>Deviantart</p>
						</div>
					</div></span>';
				}
				if(isset($atts['yahoo']) && $atts['yahoo']) {
					$html .= '<span class="social-icon"><a href="' . $atts['yahoo'] . '" target="'.$atts['linktarget'].'" class="yahoo"'.$nofollow.'>Yahoo</a><div class="popup">
						<div class="holder">
							<p>Yahoo</p>
						</div>
					</div></span>';
				}
				if(isset($atts['reddit']) && $atts['reddit']) {
					$html .= '<span class="social-icon"><a href="' . $atts['reddit'] . '" target="'.$atts['linktarget'].'" class="reddit"'.$nofollow.'>Reddit</a><div class="popup">
						<div class="holder">
							<p>Reddit</p>
						</div>
					</div></span>';
				}
				if(isset($atts['forrst']) && $atts['forrst']) {
					$html .= '<span class="social-icon"><a href="' . $atts['forrst'] . '" target="'.$atts['linktarget'].'" class="forrst"'.$nofollow.'>Forrst</a><div class="popup">
						<div class="holder">
							<p>Forrst</p>
						</div>
					</div></span>';
				}
				if(isset($atts['email']) && $atts['email']) {
					$html .= '<span class="social-icon"><a href="mailto:' . $atts['email'] . '" target="'.$atts['linktarget'].'" class="email">Email</a><div class="popup">
						<div class="holder">
							<p>Email</p>
						</div>
					</div></span>';
				}
			$html .= '<div class="clear"></div></div>';
			$html .= '<div class="person-content">' . do_shortcode($content) . '</div>';
		$html .= '</div>';
	}
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Recent Posts
//////////////////////////////////////////////////////////////////
add_shortcode('recent_posts', 'shortcode_recent_posts');
function shortcode_recent_posts($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'jquery.flexslider' );

	extract(shortcode_atts(array(
		'layout' => 'default',
		'columns' => 1,
		'number_posts' => 4,
		'exclude_cats' =>  '',
		'excerpt_words' => '15',
		'excerpt' => 'no',
		'strip_html' => 'yes',
		'cat_id' => '',
		'cat_slug' => '',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type) {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	if(!isset($atts['columns'])) {
		$atts['columns'] = 3;
	}

	if(!isset($atts['excerpt_words'])) {
		$atts['excerpt_words'] = 15;
	}

	if(!isset($atts['number_posts'])) {
		$atts['number_posts'] = 3;
	}

	if(!isset($atts['strip_html'])) {
		$atts['strip_html'] = 'true';
	}

	if($atts['strip_html'] == 'yes') {
		$atts['strip_html'] = 'true';
	} elseif($atts['strip_html'] == 'no') {
		$atts['strip_html'] = 'false';
	}

	if(!empty($atts['cat_id']) && $atts['cat_id']){
		$query_atts['category_name'] = $atts['cat_id'];
	} elseif(!empty($atts['cat_slug']) && $atts['cat_slug']){
		$query_atts['category_name'] = $atts['cat_slug'];
	}
	$query_atts['posts_per_page'] = $atts['number_posts'];

	if($exclude_cats) {
		$cats_to_exclude = explode(',', $exclude_cats);
		foreach($cats_to_exclude as $cat_to_exclude) {
			$idObj = get_category_by_slug($cat_to_exclude);
			if($idObj) {
				$cats_id_to_exclude[] = $idObj->term_id;
			}
		}
		if($cats_id_to_exclude) {
			$query_atts['category__not_in'] = $cats_id_to_exclude;
		}
	}

	wp_reset_query();

	$recent_posts = new WP_Query($query_atts);
	if($layout == 'default'):
		$attachment = '';
		$html = '<div class="avada-container">';
		$html .= '<section class="columns columns-'.$atts['columns'].'" style="width:100%">';
		$html .= '<div class="holder">';
		$count = 1;
		while($recent_posts->have_posts()): $recent_posts->the_post();
		$html .= '<article class="col">';
		if($atts['thumbnail'] == "yes"):
		if($data['legacy_posts_slideshow']):
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => $data['posts_slideshow_number']-1,
			'post_status' => null,
			'post_mime_type' => 'image',
			'post_parent' => get_the_ID(),
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'exclude' => get_post_thumbnail_id()
		);
		$attachments = get_posts($args);
		if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
		$html .= '<div class="flexslider floated-post-slideshow'.$animation_class.'"'.$animation_attribues.'>';
			$html .= '<ul class="slides">';
				if(get_post_meta(get_the_ID(), 'pyre_video', true)):
				$html .= '<li><div class="full-video">';
					$html .= get_post_meta(get_the_ID(), 'pyre_video', true);
				$html .= '</div></li>';
				endif;
				if(has_post_thumbnail()):
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'recent-posts');
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id());
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'.$attachment_image[0].'" alt="'.get_the_title().'" /></a>
				</li>';
				endif;
				if($data['posts_slideshow']):
				foreach($attachments as $attachment):
				$attachment_image = wp_get_attachment_image_src($attachment->ID, 'recent-posts');
				$full_image = wp_get_attachment_image_src($attachment->ID, 'full');
				$attachment_data = wp_get_attachment_metadata($attachment->ID);
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'. $attachment_image[0].'" alt="'.$attachment->post_title.'" /></a>
				</li>';
				endforeach;
				endif;
			$html .= '</ul>
		</div>';
		endif;
		else:
		if(has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
		$html .= '<div class="flexslider floated-post-slideshow'.$animation_class.'"'.$animation_attribues.'>';
			$html .= '<ul class="slides">';
				if(get_post_meta(get_the_ID(), 'pyre_video', true)):
				$html .= '<li><div class="full-video">';
					$html .= get_post_meta(get_the_ID(), 'pyre_video', true);
				$html .= '</div></li>';
				endif;
				if(has_post_thumbnail()):
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'recent-posts');
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id());
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'.$attachment_image[0].'" alt="'.get_the_title().'" /></a>
				</li>';
				endif;
				if($data['posts_slideshow']):
				$i = 2;
				while($i <= $data['posts_slideshow_number']):
				$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
				if($attachment_new_id):
				$attachment_image = wp_get_attachment_image_src($attachment_new_id, 'recent-posts');
				$full_image = wp_get_attachment_image_src($attachment_new_id, 'full');
				$attachment_data = wp_get_attachment_metadata($attachment_new_id);
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'. $attachment_image[0].'" alt="" /></a>
				</li>';
				endif; $i++; endwhile;
				endif;
			$html .= '</ul>
		</div>';
		endif;
		endif;
		endif;
		if($atts['title'] == "yes"):
		$html .= '<h4><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h4>';
		endif;
		if($atts['meta'] == "yes"):
		$html .= '<ul class="meta">';
		$html .= '<li><em class="date">'.get_the_time($data['date_format'], get_the_ID()).'</em></li>';
		if(get_comments_number(get_the_ID()) >= 1):
		$html .= '<li><a href="'.get_permalink(get_the_ID()).'">'.get_comments_number(get_the_ID()).' '.__('Comments', 'Avada').'</a></li>';
		endif;
		$html .= '</ul>';
		endif;
		if($atts['excerpt'] == "yes"):
		$stripped_content = tf_content( $atts['excerpt_words'], $atts['strip_html'] );
		$html .= '<p>'.$stripped_content.'</p>';
		endif;
		$html .= '</article>';
		$count++;
		endwhile;
		$html .= '</div>';
		$html .= '</section>';
		$html .= '</div>';
	elseif($layout == 'thumbnails-on-side'):
		$attachment = '';
		$html = '<div class="avada-container layout-'.$layout.' layout-columns-'.$columns.'">';
		$html .= '<section class="columns columns-'.$atts['columns'].'" style="width:100%">';
		$html .= '<div class="holder">';
		$count = 1;
		while($recent_posts->have_posts()): $recent_posts->the_post();
		$html .= '<article class="col clearfix">';
		if($atts['thumbnail'] == "yes"):
		if($data['legacy_posts_slideshow']):
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => $data['posts_slideshow_number']-1,
			'post_status' => null,
			'post_mime_type' => 'image',
			'post_parent' => get_the_ID(),
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'exclude' => get_post_thumbnail_id()
		);
		$attachments = get_posts($args);
		if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
		$html .= '<div class="flexslider floated-post-slideshow'.$animation_class.'"'.$animation_attribues.'>';
			$html .= '<ul class="slides">';
				if(get_post_meta(get_the_ID(), 'pyre_video', true)):
				$html .= '<li><div class="full-video">';
					$html .= get_post_meta(get_the_ID(), 'pyre_video', true);
				$html .= '</div></li>';
				endif;
				if(has_post_thumbnail()):
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio-two');
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id());
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'.$attachment_image[0].'" alt="'.get_the_title().'" /></a>
				</li>';
				endif;
				if($data['posts_slideshow']):
				foreach($attachments as $attachment):
				$attachment_image = wp_get_attachment_image_src($attachment->ID, 'portfolio-two');
				$full_image = wp_get_attachment_image_src($attachment->ID, 'full');
				$attachment_data = wp_get_attachment_metadata($attachment->ID);
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'. $attachment_image[0].'" alt="'.$attachment->post_title.'" /></a>
				</li>';
				endforeach;
				endif;
			$html .= '</ul>
		</div>';
		endif;
		else:
		if(has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
		$html .= '<div class="flexslider floated-post-slideshow'.$animation_class.'"'.$animation_attribues.'>';;
			$html .= '<ul class="slides">';
				if(get_post_meta(get_the_ID(), 'pyre_video', true)):
				$html .= '<li><div class="full-video">';
					$html .= get_post_meta(get_the_ID(), 'pyre_video', true);
				$html .= '</div></li>';
				endif;
				if(has_post_thumbnail()):
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio-two');
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id());
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'.$attachment_image[0].'" alt="'.get_the_title().'" /></a>
				</li>';
				endif;
				if($data['posts_slideshow']):
				$i = 2;
				while($i <= $data['posts_slideshow_number']):
				$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
				if($attachment_new_id):
				$attachment_image = wp_get_attachment_image_src($attachment_new_id, 'portfolio-two');
				$full_image = wp_get_attachment_image_src($attachment_new_id, 'full');
				$attachment_data = wp_get_attachment_metadata($attachment_new_id);
				$html .= '<li>
					<a href="'.get_permalink(get_the_ID()).'" rel=""><img src="'. $attachment_image[0].'" alt="" /></a>
				</li>';
				endif; $i++; endwhile;
				endif;
			$html .= '</ul>
		</div>';
		endif;
		endif;
		endif;
		$html .= '<div class="recent-posts-content">';
		if($atts['title'] == "yes"):
		$html .= '<h4><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h4>';
		endif;
		if($atts['meta'] == "yes"):
		$html .= '<ul class="meta">';
		$html .= '<li>'.get_the_time($data['date_format'], get_the_ID()).'</li>';
		if(get_comments_number(get_the_ID()) >= 1):
		$html .= '<li><a href="'.get_permalink(get_the_ID()).'">'.get_comments_number(get_the_ID()).' '.__('Comments', 'Avada').'</a></li>';
		endif;
		$html .= '</ul>';
		endif;
		if($atts['excerpt'] == "yes"):
		$stripped_content = tf_content( $atts['excerpt_words'], $atts['strip_html'] );
		$html .= $stripped_content;
		endif;
		$html .= '</div>';
		$html .= '</article>';
		$count++;
		endwhile;
		$html .= '</div>';
		$html .= '</section>';
		$html .= '</div>';
	elseif($layout == 'date-on-side'):
		$attachment = '';
		$html = '<div class="avada-container layout-'.$layout.' layout-columns-'.$columns.'">';
		$html .= '<section class="columns columns-'.$atts['columns'].'" style="width:100%">';
		$html .= '<div class="holder">';
		$count = 1;
		while($recent_posts->have_posts()): $recent_posts->the_post();
		$html .= '<article class="col clearfix">';
		$html .= '<div class="date-and-formats">
			<div class="date-box">
				<span class="date">'.get_the_time('j').'</span>
				<span class="month-year">'.get_the_time('m, Y').'</span>
			</div>';
			$html .= '<div class="format-box">';
				switch(get_post_format()) {
					case 'gallery':
						$format_class = 'camera-retro';
						break;
					case 'link':
						$format_class = 'link';
						break;
					case 'image':
						$format_class = 'picture';
						break;
					case 'quote':
						$format_class = 'quote-left';
						break;
					case 'video':
						$format_class = 'film';
						break;
					case 'audio':
						$format_class = 'headphones';
						break;
					case 'chat':
						$format_class = 'comments-alt';
						break;
					default:
						$format_class = 'book';
						break;
				}
				$html .= '<i class="icon-'.$format_class.'"></i>
			</div>
		</div>';
		$html .= '<div class="recent-posts-content">';
		if($atts['title'] == "yes"):
		$html .= '<h4><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h4>';
		endif;
		if($atts['meta'] == "yes"):
		$html .= '<ul class="meta">';
		$html .= '<li>'.get_the_time($data['date_format'], get_the_ID()).'</li>';
		if(get_comments_number(get_the_ID()) >= 1):
		$html .= '<li><a href="'.get_permalink(get_the_ID()).'">'.get_comments_number(get_the_ID()).' '.__('Comments', 'Avada').'</a></li>';
		endif;
		$html .= '</ul>';
		endif;
		if($atts['excerpt'] == "yes"):
		$stripped_content = tf_content( $atts['excerpt_words'], $atts['strip_html'] );
		$html .= $stripped_content;
		endif;
		$html .= '</div>';
		$html .= '</article>';
		$count++;
		endwhile;
		$html .= '</div>';
		$html .= '</section>';
		$html .= '</div>';
	endif;

	wp_reset_query();

	return $html;
}

//////////////////////////////////////////////////////////////////
// Recent Works
//////////////////////////////////////////////////////////////////
add_shortcode('recent_works', 'shortcode_recent_works');
function shortcode_recent_works($atts, $content = null) {
	global $data;

	static $recent_works_counter = 1;

	wp_enqueue_script( 'jquery.isotope' );
	wp_enqueue_script( 'jquery.carouFredSel' );

	extract(shortcode_atts(array(
		'layout' => 'carousel',
		'filters' => 'true',
		'columns' => 4,
		'cat_slug' => '',
		'number_posts' => 10,
		'excerpt_words' => 15,
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type) {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	if($columns == 1) {
		$columns_words = 'one';
		$portfolio_image_size = 'full';
	} elseif($columns == 2) {
		$columns_words = 'two';
		$portfolio_image_size = 'portfolio-two';
	} elseif($columns == 3) {
		$columns_words = 'three';
		$portfolio_image_size = 'portfolio-three';
	} elseif($columns == 4) {
		$columns_words = 'four';
		$portfolio_image_size = 'portfolio-four';
	}

	if($filters == 'yes') {
		$filters = 'true';
	} elseif($filters == 'no') {
		$filters = 'false';
	}

	$html = '';

	wp_reset_query();

	if($layout == 'carousel') {
	$html .= '<div class="recent-works-carousel related-posts related-projects'.$animation_class.'"'.$animation_attribues.'>';
	$html .= '<div id="carousel" class="es-carousel-wrapper">';
	$html .= '<div class="es-carousel">';
	$html .= '<ul class="">';
					if(isset($atts['number_posts']) && !empty($atts['number_posts'])) {
						$number_posts = $atts['number_posts'];
					} else {
						$number_posts = 10;
					}
					$args = array(
						'post_type' => 'avada_portfolio',
						'paged' => 1,
						'posts_per_page' => $number_posts,
					);
					if(isset($atts['cat_id']) && !empty($atts['cat_id'])){
						$cat_id = explode(',', $atts['cat_id']);
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'portfolio_category',
								'field' => 'slug',
								'terms' => $cat_id
							)
						);
					} elseif(isset($atts['cat_slug']) && !empty($atts['cat_slug'])){
						$cat_id = explode(',', $atts['cat_slug']);
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'portfolio_category',
								'field' => 'slug',
								'terms' => $cat_id
							)
						);
					}

					$works = new WP_Query($args);
					while($works->have_posts()): $works->the_post();
					if(has_post_thumbnail()):
					$html .= '<li>';
						$html .= '<div class="image" aria-haspopup="true">';
								if($data['image_rollover']):
								$html .= get_the_post_thumbnail(get_the_ID(), 'related-img');
								else:
								$html .= '<a href="'.get_permalink(get_the_ID()).'">'.get_the_post_thumbnail(get_the_ID(), 'related-img').'</a>';
								endif;
								//$html .= '<a href="'.get_permalink(get_the_ID()).'">'.get_the_post_thumbnail(get_the_ID(), 'related-img').'</a>';
								if(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'link') {
									$link_icon_css = 'display:inline-block;';
									$zoom_icon_css = 'display:none;';
								} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'zoom') {
									$link_icon_css = 'display:none;';
									$zoom_icon_css = 'display:inline-block;';
								} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'no') {
									$link_icon_css = 'display:none;';
									$zoom_icon_css = 'display:none;';
								} else {
									$link_icon_css = 'display:inline-block;';
									$zoom_icon_css = 'display:inline-block;';
								}

								$link_target = "";
								$icon_url_check = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true); if(!empty($icon_url_check)) {
									$icon_permalink = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true);
									if(get_post_meta(get_the_ID(), 'pyre_link_icon_target', true) == "yes") {
										$link_target = ' target="_blank"';
									}
								} else {
									$icon_permalink = get_permalink(get_the_ID());
								}
								$html .= '<div class="image-extras">';
									$html .= '<div class="image-extras-content">';
									$html .= '<a style="'.$link_icon_css.'" class="icon link-icon" style="margin-right:3px;" href="'.$icon_permalink.'">';
										$html .= 'Permalink';
									$html .= '</a>';
									$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
									if(get_post_meta(get_the_ID(), 'pyre_video_url', true)) {
										$full_image[0] = get_post_meta(get_the_ID(), 'pyre_video_url', true);
									}
									$html .= '<a style="'.$zoom_icon_css.'" class="icon gallery-icon" href="'.$full_image[0].'" rel="prettyPhoto[gallery_recent_'.$recent_works_counter.']">Gallery</a>';
									if($data['title_link_image_rollover']) {
										$html .= '<h3 class="entry-title"><a href="'.$icon_permalink.'"'.$link_target.'>'.get_the_title().'</a></h3>';
									} else {
										$html .= '<h3 class="entry-title">'.get_the_title().'</h3>';
									}
									$html .= '</div>
								</div>
						</div>
					</li>';
					endif; endwhile;
				$html .= '</ul>
			</div>
			<div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div>
		</div>
	</div>';
	wp_reset_query();
	} elseif($layout == 'grid') {
		$html .= '<div class="portfolio portfolio-grid clearfix portfolio-'.$columns_words.$animation_class.'"'.$animation_attribues.' data-columns="'.$columns_words.'">';

		$portfolio_category = get_terms('portfolio_category');
		if($portfolio_category && $filters == 'true'):
		$html .= '<ul class="portfolio-tabs clearfix">
			<li class="active"><a data-filter="*" href="#">'.__('All', 'Avada').'</a></li>';
			foreach($portfolio_category as $portfolio_cat):
			if($atts['cat_slug']):
			$cat_slug = preg_replace('/\s+/', '', $atts['cat_slug']);
			$cat_slug = explode(',', $cat_slug);
			if(in_array($portfolio_cat->slug, $cat_slug)):
			$html .='<li><a data-filter=".'.$portfolio_cat->slug.'" href="#">'.$portfolio_cat->name.'</a></li>';
			endif;
			else:
			$html .= '<li><a data-filter=".'.$portfolio_cat->slug.'" href="#">'.$portfolio_cat->name.'</a></li>';
			endif;
			endforeach;
		$html .= '</ul>';
		endif;

		$html .= '<div class="portfolio-wrapper">';

		$args = array(
			'post_type' => 'avada_portfolio',
			'posts_per_page' => $number_posts
		);
		if(isset($atts['cat_id']) && !empty($atts['cat_id'])){
			$cat_id = explode(',', $atts['cat_id']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cat_id
				)
			);
		} elseif(isset($atts['cat_slug']) && !empty($atts['cat_slug'])){
			$cat_id = explode(',', $atts['cat_slug']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cat_id
				)
			);
		}
		$gallery = new WP_Query($args);
		while($gallery->have_posts()): $gallery->the_post();
			if(has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
				$item_classes = '';
				$item_cats = get_the_terms(get_the_ID(), 'portfolio_category');
				if($item_cats):
				foreach($item_cats as $item_cat) {
					$item_classes .= $item_cat->slug . ' ';
				}
				endif;

				$permalink = get_permalink();

				$html .= '<div class="portfolio-item '.$item_classes.'">';
					if(has_post_thumbnail()):
					$html .= '<div class="image" aria-haspopup="true">';
						if($data['image_rollover']):
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $portfolio_image_size);
						$html .= '<img src="'.$thumbnail[0].'" alt="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'" />';
						else:
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $portfolio_image_size);
						$html .= '<a href="'.$permalink.'">'.'<img src="'.$thumbnail[0].'" alt="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'" />'.'</a>';
						endif;
						if(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'link') {
							$link_icon_css = 'display:inline-block;';
							$zoom_icon_css = 'display:none;';
						} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'zoom') {
							$link_icon_css = 'display:none;';
							$zoom_icon_css = 'display:inline-block;';
						} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'no') {
							$link_icon_css = 'display:none;';
							$zoom_icon_css = 'display:none;';
						} else {
							$link_icon_css = 'display:inline-block;';
							$zoom_icon_css = 'display:inline-block;';
						}

						$link_target = "";
						$icon_url_check = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true); if(!empty($icon_url_check)) {
							$icon_permalink = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true);
							if(get_post_meta(get_the_ID(), 'pyre_link_icon_target', true) == "yes") {
								$link_target = ' target="_blank"';
							}
						} else {
							$icon_permalink = get_permalink(get_the_ID());
						}
						$html .= '<div class="image-extras">
							<div class="image-extras-content">';
								$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
								$html .= '<a style="'.$link_icon_css.'" class="icon link-icon" href="'.$icon_permalink.'">Permalink</a>';

								if(get_post_meta(get_the_ID(), 'pyre_video_url', true)) {
									$full_image[0] = get_post_meta(get_the_ID(), 'pyre_video_url', true);
								}

								$html .= '<a style="'.$zoom_icon_css.'" class="icon gallery-icon" href="'.$full_image[0].'" rel="prettyPhoto[gallery_recent_'.$recent_works_counter.']" title="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'"><img style="display:none;" alt="'.get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true).'" />Gallery</a>';
								if($data['title_link_image_rollover']) {
									$html .= '<h3 class="entry-title"><a href="'.$icon_permalink.'"'.$link_target.'>'.get_the_title().'</a></h3>';
								} else {
									$html .= '<h3 class="entry-title">'.get_the_title().'</h3>';
								}
								$html .= '<h4>'.get_the_term_list(get_the_ID(), 'portfolio_category', '', ', ', '').'</h4>';
							$html .= '</div>
						</div>
					</div>';
					endif;
				$html .= '</div>';
			endif;
		endwhile;
		wp_reset_query();

		$html .= '</div>';

		$html .= '</div>';
	} elseif($layout == 'grid-with-excerpts') {
		$html .= '<div class="portfolio clearfix portfolio-'.$columns_words.'-text portfolio-'.$columns_words.'" data-columns="'.$columns_words.'">';

		$portfolio_category = get_terms('portfolio_category');
		if($portfolio_category && $filters == 'true'):
		$html .= '<ul class="portfolio-tabs clearfix">
			<li class="active"><a data-filter="*" href="#">'.__('All', 'Avada').'</a></li>';
			foreach($portfolio_category as $portfolio_cat):
			if($atts['cat_slug']):
			$cat_slug = preg_replace('/\s+/', '', $atts['cat_slug']);
			$cat_slug = explode(',', $cat_slug);
			if(in_array($portfolio_cat->slug, $cat_slug)):
			$html .='<li><a data-filter=".'.$portfolio_cat->slug.'" href="#">'.$portfolio_cat->name.'</a></li>';
			endif;
			else:
			$html .= '<li><a data-filter=".'.$portfolio_cat->slug.'" href="#">'.$portfolio_cat->name.'</a></li>';
			endif;
			endforeach;
		$html .= '</ul>';
		endif;

		$html .= '<div class="portfolio-wrapper">';

		$args = array(
			'post_type' => 'avada_portfolio',
			'posts_per_page' => $number_posts
		);
		if(isset($atts['cat_id']) && !empty($atts['cat_id'])){
			$cat_id = explode(',', $atts['cat_id']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cat_id
				)
			);
		} elseif(isset($atts['cat_slug']) && !empty($atts['cat_slug'])){
			$cat_id = explode(',', $atts['cat_slug']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cat_id
				)
			);
		}
		$gallery = new WP_Query($args);
		while($gallery->have_posts()): $gallery->the_post();
			if(has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
				$item_classes = '';
				$item_cats = get_the_terms(get_the_ID(), 'portfolio_category');
				if($item_cats):
				foreach($item_cats as $item_cat) {
					$item_classes .= $item_cat->slug . ' ';
				}
				endif;

				$permalink = get_permalink(get_the_ID());

				$html .= '<div class="portfolio-item '.$item_classes.'">';
					if(has_post_thumbnail()):
					$html .= '<div class="image'.$animation_class.'"'.$animation_attribues.' aria-haspopup="true">';
						if($data['image_rollover']):
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $portfolio_image_size);
						$html .= '<img src="'.$thumbnail[0].'" alt="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'" />';
						else:
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $portfolio_image_size);
						$html .= '<a href="'.$permalink.'"><img src="'.$thumbnail[0].'" alt="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'" /></a>';
						endif;
						if(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'link') {
							$link_icon_css = 'display:inline-block;';
							$zoom_icon_css = 'display:none;';
						} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'zoom') {
							$link_icon_css = 'display:none;';
							$zoom_icon_css = 'display:inline-block;';
						} elseif(get_post_meta(get_the_ID(), 'pyre_image_rollover_icons', true) == 'no') {
							$link_icon_css = 'display:none;';
							$zoom_icon_css = 'display:none;';
						} else {
							$link_icon_css = 'display:inline-block;';
							$zoom_icon_css = 'display:inline-block;';
						}

						$link_target = "";
						$icon_url_check = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true); if(!empty($icon_url_check)) {
							$icon_permalink = get_post_meta(get_the_ID(), 'pyre_link_icon_url', true);
							if(get_post_meta(get_the_ID(), 'pyre_link_icon_target', true) == "yes") {
								$link_target = ' target="_blank"';
							}
						} else {
							$icon_permalink = get_permalink(get_the_ID());
						}
						$html .= '<div class="image-extras">
							<div class="image-extras-content">';
								$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
								$html .= '<a style="'.$link_icon_css.'" class="icon link-icon" href="'.$icon_permalink.'">Permalink</a>';

								if(get_post_meta(get_the_ID(), 'pyre_video_url', true)) {
									$full_image[0] = get_post_meta(get_the_ID(), 'pyre_video_url', true);
								}

								$html .= '<a style="'.$zoom_icon_css.'" class="icon gallery-icon" href="'.$full_image[0].'" rel="prettyPhoto[gallery_recent_'.$recent_works_counter.']" title="'.get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())).'"><img style="display:none;" alt="'.get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true).'" />Gallery</a>';
								if($data['title_link_image_rollover']) {
									$html .= '<h3 class="entry-title"><a href="'.$icon_permalink.'"'.$link_target.'>'.get_the_title().'</a></h3>';
								} else {
									$html .= '<h3 class="entry-title">'.get_the_title().'</h3>';
								};
								$html .= '<h4>'.get_the_term_list(get_the_ID(), 'portfolio_category', '', ', ', '').'</h4>';
							$html .= '</div>
						</div>
					</div>';
					$html .= '<div class="portfolio-content">
						<h2><a href="'.$permalink.'">'.get_the_title().'</a></h2>
						<h4>'.get_the_term_list(get_the_ID(), 'portfolio_category', '', ', ', '').'</h4>';

						$excerpt_length = $excerpt_words;

						$stripped_content = strip_shortcodes( tf_content( $excerpt_length, $data['strip_html_excerpt'] ) );
						$html .= $stripped_content;

						if($columns == 1):
						$html .= '<div class="buttons">
							<a href="'.$permalink.'" class="green button small">'.__('Learn More', 'Avada').'</a>';
							if(get_post_meta(get_the_ID(), 'pyre_project_url', true)):
							$html .= '<a href="'.get_post_meta(get_the_ID(), 'pyre_project_url', true).'" class="green button small">'.__('View Project', 'Avada').'</a>';
							endif;
						$html .= '</div>';
						endif;
					$html .= '</div>';
					endif;
				$html .= '</div>';
			endif;
		endwhile;
		wp_reset_query();

		$html .= '</div>';

		$html .= '</div>';
	}

	$recent_works_counter++;

	return $html;
}


//////////////////////////////////////////////////////////////////
// Alert Message
//////////////////////////////////////////////////////////////////
add_shortcode('alert', 'shortcode_alert');
function shortcode_alert($atts, $content = null) {

	extract(shortcode_atts(array(
		'type' => 'general',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type) {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}
	$html = '';
	$html .= '<div class="alert '.$atts['type'].$animation_class.'"'.$animation_attribues.'>';
		$html .= '<div class="msg">'.do_shortcode($content).'</div>';
		$html .= '<a href="#" class="toggle-alert">Toggle</a>';
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// FontAwesome Icons
//////////////////////////////////////////////////////////////////
add_shortcode('fontawesome', 'shortcode_fontawesome');
function shortcode_fontawesome($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'iconcolor' => '',
		'circlecolor' => '',
		'circlebordercolor' => '',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type) {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = 'animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	if(!$iconcolor) {
		$iconcolor = $data['icon_color'];
	}

	if(!$circlecolor) {
		$circlecolor = $data['icon_circle_color'];
	}

	if(!$circlebordercolor) {
		$circlebordercolor = $data['icon_border_color'];
	}

	$style = 'color:'.$iconcolor.' !important;';

	if($atts['circle'] == 'yes') {
		$style .= 'background-color:'.$circlecolor.' !important;border:1px solid '.$circlebordercolor.' !important;';
	}

	$html = '<i style="'.$style.'"class="fontawesome-icon '.$atts['size'].' circle-'.$atts['circle'].' icon-'.$atts['icon'].$animation_class.'"'.$animation_attribues.'></i>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Social Links
//////////////////////////////////////////////////////////////////
add_shortcode('social_links', 'shortcode_social_links');
function shortcode_social_links($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'colorscheme' => '',
		'linktarget' => '_self',
		'show_custom' => "no"
	), $atts));

	if(!$colorscheme) {
		$colorscheme = strtolower($data['social_links_color']);
	}

	$nofollow = '';
	if($data['nofollow_social_links']) {
		$nofollow = ' rel="nofollow"';
	}

	$html = '<div class="social_links_shortcode clearfix">';
	$html .= '<ul class="social-networks social-networks-'.$colorscheme.' clearfix">';
	foreach($atts as $key => $link) {
		if($link && $key != 'linktarget' && $key != 'colorscheme' && $key != 'show_custom') {

			if($key == "pinterest") {
				$html .= '<li class="tf-pinterest">';
			} else {
				$html .= '<li class="'.$key.'">';
			}
			$html .= '<a class="'.$key.'" href="'.$link.'" target="'.$linktarget.'"'.$nofollow.'>'.ucwords($key).'</a>
			<div class="popup">
				<div class="holder">
					<p>'.ucwords($key).'</p>
				</div>
			</div>
			</li>';
		}
	}
	if($atts['show_custom'] == "yes") {
		$html .= '<li class="custom"><a target="'.$linktarget.'" href="'.$data['custom_icon_link'].'"'.$nofollow.'><img src="'.$data['custom_icon_image'].'" alt="'.$data['custom_icon_name'].'"/></a>
			<div class="popup">
				<div class="holder">
					<p>'.$data['custom_icon_name'].'</p>
				</div>
			</div>
		</li>';
	}
	$html .= '</ul>';
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Clients container
//////////////////////////////////////////////////////////////////
add_shortcode('clients', 'shortcode_clients');
function shortcode_clients($atts, $content = null) {
	wp_enqueue_script( 'jquery.carouFredSel' );

	extract(shortcode_atts(array(
		'picture_size' => 'fixed'
	), $atts));

	$css_class = "related-posts";
	$carousel_class = "clients-carousel";
	if($picture_size != 'fixed') {
		$css_class = "";
		$carousel_class = "";
	}

	$picture_size == 'fixed';

	$html = '<div class="'.$css_class.' related-projects clientslider-container"><div id="carousel" class="'.$carousel_class.' es-carousel-wrapper"><div class="es-carousel"><ul>';
	$html .= do_shortcode($content);
	$html .= '</ul><div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div></div></div></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Client
//////////////////////////////////////////////////////////////////
add_shortcode('client', 'shortcode_client');
function shortcode_client($atts, $content = null) {
	extract(shortcode_atts(array(
		'linktarget' => '_self',
		'link' => '',
		'image' => '',
		'alt' => '',
	), $atts));

	$html = '<li>';
	if ($link) {
		$html .= '<a href="'.$link.'" target="'.$linktarget.'"><img src="'.$image.'" alt="'.$alt.'" /></a>';
	} else {
		$html .= '<img src="'.$image.'" alt="'.$alt.'" />';
	}
	$html .= '</li>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Title
//////////////////////////////////////////////////////////////////
add_shortcode('title', 'shortcode_title');
function shortcode_title($atts, $content = null) {

	$html = '<div class="title"><h'.$atts['size'].'>'.do_shortcode($content).'</h'.$atts['size'].'><div class="title-sep-container"><div class="title-sep"></div></div></div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Separator
//////////////////////////////////////////////////////////////////
add_shortcode('separator', 'shortcode_separator');
function shortcode_separator($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => 'none',
		'color' => '',
		'top'	=> '',
		'bottom' => ''
	), $atts));
	$html = '';
	$margin_bottom = '';
	if($style != 'none') {
		if( empty($bottom) ) {
			$margin_bottom = 'margin-bottom:'.$atts['top'].'px;';
		} else {
			$margin_bottom = 'margin-bottom:'.$atts['bottom'].'px;';
		}
	}

	$border_color = '';
	if($color) {
		if($style == 'single') {
			$border_color = 'background-color:' . $color . '!important;';
		} else {
			$border_color = 'border-color:' . $color . '!important;';
		}
	}
	$html .= '<div class="clearboth"></div><div class="demo-sep sep-'.$style.'" style="margin-top:'.$atts['top'].'px;'.$margin_bottom.$border_color.'"></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Tooltip
//////////////////////////////////////////////////////////////////
add_shortcode('tooltip', 'shortcode_tooltip');
function shortcode_tooltip($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => 'none',
	), $atts));

	$html = '<span class="tooltip-shortcode">';
	$html .= $content;
	$html .= '<span class="popup">
		<span class="holder">
			<span>'.$title.'</span>
		</span>
	</span>';
	$html .= '</span>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Full Width
//////////////////////////////////////////////////////////////////
add_shortcode('fullwidth', 'shortcode_fullwidth');
function shortcode_fullwidth($atts, $content = null) {
	extract(shortcode_atts(array(
		'autoplay' => 'no',
		'backgroundcolor' => '',
		'backgroundimage' => '',
		'backgroundrepeat' => 'no-repeat',
		'backgroundposition' => 'top left',
		'backgroundattachment' => 'scroll',
		'bordersize' => '1px',
		'bordercolor' => '',
		'menu_anchor' => '',
		'video_id' => '',
		'paddingtop' => '20px',
		'paddingbottom' => '20px',
		'video_type' => '',
	), $atts));

	$css = '';
	if($backgroundrepeat == 'no-repeat') {
		$css .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
	}

	$autoplay = "";
	if($atts['autoplay'] == "true" || $atts['autoplay'] == "yes") {
		$autoplay = "&amp;autoplay=1";
	}

	$video_class= '';
	if($video_type) {
		$video_class = ' video-background';
	}

	$html = '<div id="' . $menu_anchor .'" class="fullwidth-box'.$video_class.'" style="background-color:'.$backgroundcolor.';background-image:url('.$backgroundimage.');background-repeat:'.$backgroundrepeat.';background-position:'.$backgroundposition.';background-attachment:'.$backgroundattachment.';border-top:'.$bordersize.' solid '.$bordercolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';'.$css.'">';

	if($video_type) {
		$html .= '<div class="video-bg"><iframe title="YouTube video player" width="100%" height="100%" src="http://www.youtube.com/embed/' . $atts['video_id'] . '?wmode=transparent'.$autoplay.'" frameborder="0" allowfullscreen></iframe></div>';
		$html .= '<div class="video-content" style="padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';">';
	}
	$html .= '<div class="avada-row">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	if($video_type) {
		$html .= '</div>';
	}
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Section Separator
//////////////////////////////////////////////////////////////////
add_shortcode('section_separator', 'shortcode_section_sep');
function shortcode_section_sep($atts, $content = null) {
	extract(shortcode_atts(array(
		'backgroundcolor' => '',
		'bordersize' => '1px',
		'bordercolor' => '',
		'divider_candy' => '',
		'icon' => '',
		'icon_color' => '',
	), $atts));

	global $icons;

	static $avada_section_sep_counter = 1;


	$html = '<div id="section-separator-'.$avada_section_sep_counter.'" class="section-separator" style="border-top:'.$bordersize.' solid '.$bordercolor.';">';
	if($icon) {
		if(! $icon_color) {
			$icon_color = $bordercolor;
		}

		$icon_code = $icons[$icon];
		$style = '<style>#section-separator-'.$avada_section_sep_counter.'.section-separator .icon:after {color:'.$icon_color.'; content: "'. $icon_code .'"; }</style>';
		$html .= $style . '<div class="icon"></div>';
	}

	if($divider_candy == 'bottom') {
		$html .= '<div class="divider-candy bottom" style="background-color:'.$backgroundcolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';border-left:'.$bordersize.' solid '.$bordercolor.';"></div>';
	} elseif($divider_candy == 'top') {
		$html .= '<div class="divider-candy top" style="background-color:'.$backgroundcolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';border-left:'.$bordersize.' solid '.$bordercolor.';"></div>';
	} elseif( strpos($divider_candy, 'top') !== false && strpos($divider_candy, 'bottom') !== false ) {
		$html .= '<div class="divider-candy top" style="background-color:'.$backgroundcolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';border-left:'.$bordersize.' solid '.$bordercolor.';"></div><div class="divider-candy bottom" style="background-color:'.$backgroundcolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';border-left:'.$bordersize.' solid '.$bordercolor.';"></div>';
	}
	$html .= '</div>';

	$avada_section_sep_counter++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Google Map
//////////////////////////////////////////////////////////////////
add_shortcode('map', 'shortcode_google_map');
function shortcode_google_map($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'gmaps.api' );
	wp_enqueue_script( 'jquery.ui.map' );

	extract(shortcode_atts(array(
		'address' => '',
		'type' => 'satellite',
		'width' => '100%',
		'height' => '300px',
		'zoom' => '14',
		'scrollwheel' => 'true',
		'scale' => 'true',
		'zoom_pancontrol' => 'true',
		'popup' => 'true',
	), $atts));

	static $avada_map_counter = 1;

	if($scrollwheel == 'yes') {
		$scrollwheel = 'true';
	} elseif($scrollwheel == 'no') {
		$scrollwheel = 'false';
	}

	if($scale == 'yes') {
		$scale = 'true';
	} elseif($scale == 'no') {
		$scale = 'false';
	}

	if($zoom_pancontrol == 'yes') {
		$zoom_pancontrol = 'true';
	} elseif($zoom_pancontrol == 'no') {
		$zoom_pancontrol = 'false';
	}

	if($popup == 'yes') {
		$popup = 'true';
	} elseif($popup == 'no') {
		$popup = 'false';
	}

	$address = addslashes($address);
	$addresses = explode('|', $address);

	$markers = '';
	$marker_counter = 0;
	foreach($addresses as $address_string) {
		$markers .= "{
			id: 'gmap-{$avada_map_counter}-{$marker_counter}',
			address: '{$address_string}',
			html: {
				content: '{$address_string}',
				popup: {$popup}
			}
		},";
		$marker_counter++;
	}

	if(!$data['status_gmap']) {
		$html = "<script type='text/javascript'>
		jQuery(document).ready(function($) {
			window['gmap-{$avada_map_counter}'] = {
				address: '{$addresses[0]}',
				zoom: {$zoom},
				scrollwheel: {$scrollwheel},
				scaleControl: {$scale},
				navigationControl: {$zoom_pancontrol},
				maptype: '{$type}',
				markers: [{$markers}]
			};
			jQuery('#gmap-{$avada_map_counter}').goMap({
				address: '{$addresses[0]}',
				zoom: {$zoom},
				scrollwheel: {$scrollwheel},
				scaleControl: {$scale},
				navigationControl: {$zoom_pancontrol},
				maptype: '{$type}',
				markers: [{$markers}]
			});
		});
		</script>";
	}

	$html .= '<div class="shortcode-map" id="gmap-'.$avada_map_counter.'" style="width:'.$width.';height:'.$height.';">';
	$html .= '</div>';

	$avada_map_counter++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counters (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('counters_circle', 'shortcode_counters_circle');
function shortcode_counters_circle($atts, $content = null) {
	$html = '<div class="counters-circle clearfix">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counter (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('counter_circle', 'shortcode_counter_circle');
function shortcode_counter_circle($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'jquery.waypoint' );


	extract(shortcode_atts(array(
		'filledcolor' => '#A0CE4E',
		'unfilledcolor' => '#e3edd1',
		'value' => '70',
		'size' => '220',
		'speed' => '1500'
	), $atts));

	if(!$filledcolor) {
		$filledcolor = $data['counter_filled_color'];
	}

	if(!$unfilledcolor) {
		$unfilledcolor = $data['counter_unfilled_color'];
	}

	static $avada_counter_circle = 1;

	$multiplicator = $size / 220;
	$stroke_size = 11 * $multiplicator;
	$font_size = 50 * $multiplicator;
    $html .= '<div class="counter-circle-wrapper" style="height:'.$size.'px;width:'.$size.'px;line-height:'.$size.'px;">';
    $html .= '<div class="counter-circle-content" id="counter-circle-'.$avada_counter_circle.'" style="font-size:'.$font_size.'px;height:'.$size.'px;width:'.$size.'px;line-height:'.$size.'px;" data-percent="'.$value.'" data-unfilledcolor="'.$unfilledcolor.'" data-filledcolor="'.$filledcolor.'" data-size="'.$size.'" data-speed="'.$speed.'" data-strokesize="'.$stroke_size.'">';
    $html .= do_shortcode($content);
    $html .='</div></div>';

	$avada_counter_circle++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counters Box
//////////////////////////////////////////////////////////////////
add_shortcode('counters_box', 'shortcode_counters_box');
function shortcode_counters_box($atts, $content = null) {
	$html = '<div class="counters-box">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counter Box
//////////////////////////////////////////////////////////////////
add_shortcode('counter_box', 'shortcode_counter_box');
function shortcode_counter_box($atts, $content = null) {
	extract(shortcode_atts(array(
		'value' => '70',
		'unit' => ''
	), $atts));

	$html = '';
	$html .= '<div class="counter-box-wrapper">';
	$html .= '<div class="content-box-percentage">';
	$value = intval($value);

	$html .= '<span class="display-percentage" data-percentage="'.$value.'">0</span>';
	if($unit) {
		$html .= '<span class="percent">'.$atts['unit'].'</span>';
	}
	$html .= '</div>';
	$html .= '<div class="counter-box-content">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Flexslider
//////////////////////////////////////////////////////////////////
add_shortcode('flexslider', 'shortcode_flexslider');
function shortcode_flexslider($atts, $content = null) {
	extract(shortcode_atts(array(
		'layout' => 'posts',
		'excerpt' => '25',
		'category' => '',
		'limit' => '3',
		'id' => '',
		'lightbox' => 'no'
	), $atts));

	$shortcode = '';

	if($layout == 'posts') {
		if($id) {
			$shortcode .= 'id="'.$id.'"';
		}
		if($category) {
			$shortcode .= ' category="'.$category.'"';
		}
		$html = do_shortcode('[wooslider slider_type="posts" layout="text-bottom" overlay="natural" link_title="true" display_excerpt="false" limit="'.$limit.'" excerpt="'.$excerpt.'" '.$shortcode.']');
	} elseif($layout == 'posts-with-excerpt') {
		if($id) {
			$shortcode .= 'id="'.$id.'"';
		}
		if($category) {
			$shortcode .= ' category="'.$category.'"';
		}
		$html = do_shortcode('[wooslider slider_type="posts" layout="text-left" overlay="full" link_title="true" display_excerpt="true" limit="'.$limit.'" excerpt="'.$excerpt.'" '.$shortcode.']');
	} else {
		if($id) {
			$shortcode .= 'id="'.$id.'"';
		}
		$html = do_shortcode('[wooslider limit="'.$limit.'" slider_type="attachments" thumbnails="true" '.$shortcode.' lightbox="'.$lightbox.'"]');
	}

	return $html;
}


//////////////////////////////////////////////////////////////////
// Blog Shortcode. Credits: media-lounge.at
//////////////////////////////////////////////////////////////////
function blog_shortcode($atts) {
	global $data;
	global $post;

	wp_enqueue_script( '/js/jquery.flexslider-min' );

	if((is_front_page() || is_home() ) ) {
		$paged = (get_query_var('paged')) ?get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	// get specified number of posts per page
	if (isset($atts['number_posts']) && $atts['number_posts']) {
		$atts['number_posts'] = (int) $atts['number_posts'];

		$atts = shortcode_atts( array(
				'author'              => '',
				'author_name'		  => '',
				'category_name'       => '',
				'cat'      			  => '',
				'id'                  => false,
				'p'					  => false,
				'post__in'			  => false,
				'order'               => 'DESC',
				'orderby'             => 'date',
				'post_status'         => 'publish',
				'post_type'           => 'post',
				'posts_per_page'	  => (int) $atts['number_posts'],
				'nopaging'			  => false,
				'paged'				  => $paged,
				'tag'                 => '',
				'tax_operator'        => 'IN',
				'tax_term'            => false,
				'taxonomy'            => 'category',
				'title_meta'		  => '',
				'include_shortcodes'  => false,
				'layout' 			  => 'large',

				'cat_slug'			  => '',
				'exclude_cats'		  => '',
				'title'				  => true,
				'meta_all'			  => true,
				'meta_author' 		  => true,
				'meta_date' 		  => true,
				'meta_categories'  	  => true,
				'meta_comments'  	  => true,
				'meta_link'  	  	  => true,
				'thumbnail'			  => true,
				'excerpt'			  => true,
				'excerpt_words'		  => '50',
				'strip_html'		  => true,
				'paging'			  => true,
				'scrolling'		      => 'infinite',
				'blog_grid_columns'   => '3'
			), $atts );

	} else {
		// get all posts, i.e. default
		$atts = shortcode_atts( array(
				'author'              => '',
				'author_name'		  => '',
				'category_name'       => '',
				'cat'   		   	  => '',
				'id'                  => false,
				'p'					  => false,
				'post__in'			  => false,
				'order'               => 'DESC',
				'orderby'             => 'date',
				'post_status'         => 'publish',
				'post_type'           => 'post',
				'nopaging'			  => false,
				'paged'				  => $paged,
				'tag'                 => '',
				'tax_operator'        => 'IN',
				'tax_term'            => false,
				'taxonomy'            => 'category',
				'title_meta'		  => false,
				'include_shortcodes'  => false,
				'layout' 			  => 'large',

				'cat_slug'			  => '',
				'exclude_cats'		  => '',
				'title'				  => true,
				'meta_all'			  => true,
				'meta_author' 		  => true,
				'meta_date' 		  => true,
				'meta_categories'  	  => true,
				'meta_comments'  	  => true,
				'meta_link'  	  	  => true,
				'thumbnail'			  => true,
				'excerpt'			  => true,
				'excerpt_words'		  => '50',
				'strip_html'		  => true,
				'paging'			  => true,
				'scrolling'		      => 'infinite',
				'blog_grid_columns'   => '3'
			), $atts );
	}

	if(isset($atts['posts_per_page']) && $atts['posts_per_page'] == -1) {
		$atts['nopaging'] = true;
	}

	// setting attributes right for the php script
	($atts['title'] == "yes") ? ($atts['title'] = true) : ($atts['title'] = false);
	($atts['meta_all'] == "yes") ? ($atts['meta_all'] = true) : ($atts['meta_all'] = false);
	($atts['meta_author'] == "yes") ? ($atts['meta_author'] = true) : ($atts['meta_author'] = false);
	($atts['meta_date'] == "yes") ? ($atts['meta_date'] = true) : ($atts['meta_date'] = false);
	($atts['meta_categories'] == "yes") ? ($atts['meta_categories'] = true) : ($atts['meta_categories'] = false);
	($atts['meta_comments'] == "yes") ? ($atts['meta_comments'] = true) : ($atts['meta_comments'] = false);
	($atts['meta_link'] == "yes") ? ($atts['meta_link'] = true) : ($atts['meta_link'] = false);


	$cats_to_exclude = explode(',', $atts['exclude_cats']);
	if($cats_to_exclude) {
		foreach($cats_to_exclude as $cat_to_exclude) {
			$idObj = get_category_by_slug($cat_to_exclude);
			if($idObj) {
				$cats_id_to_exclude[] = $idObj->term_id;
			}
		}
		if($cats_id_to_exclude) {
			$atts['category__not_in'] = $cats_id_to_exclude;
		}
	}


	//checking if there are categories that are excluded using "-"; transform slugs to ids
	$cat_ids ='';
	$categories = explode(',', $atts['cat_slug']);
	if ( isset($categories) && $categories) {
		foreach ($categories as $category) {
			if(strpos($category, '-') === 0) {
				$cat_ids .= '-' .get_category_by_slug( $category )->cat_ID .',';
			} else {
				$cat_ids .= get_category_by_slug( $category )->cat_ID .',';
			}
		}
	}
	$atts['cat'] = substr($cat_ids, 0, -1);

	($atts['thumbnail'] == "yes") ? ($atts['thumbnail'] = true) : ($atts['thumbnail'] = false);
	($atts['thumbnail'] == "yes") ? ($atts['thumbnail'] = true) : ($atts['thumbnail'] = false);
	($atts['excerpt'] == "yes") ? ($atts['excerpt'] = true) : ($atts['excerpt'] = false);
	($atts['strip_html'] == "yes") ? ($atts['strip_html'] = 1) : ($atts['strip_html'] = 0);
	($atts['paging'] == "yes") ? ($atts['paging'] = true) : ($atts['paging'] = false);
	($atts['scrolling'] == "infinite") ? ($atts['paging'] = true) : ($atts['paging'] = $atts['paging']);

	$container_class = '';
	$post_class = '';
	if($atts['layout'] == 'large alternate') {
		$post_class = 'large-alternate';
	} elseif($atts['layout'] == 'medium alternate') {
		$post_class = 'medium-alternate';
	} elseif($atts['layout'] == 'grid') {
		$post_class = 'grid-post';
		if($atts['blog_grid_columns'] == 4) {
			$container_class = 'grid-layout grid-full-layout-4';
		} elseif($atts['blog_grid_columns'] == "3") {
			$container_class = 'grid-layout grid-full-layout-3';
		} else {
			$container_class = 'grid-layout';
		}
	} elseif($atts['layout'] == 'timeline') {
		$post_class = 'timeline-post';
		$container_class = 'timeline-layout';
		if(get_post_meta($post->ID, 'pyre_full_width', true) == 'no' && basename( get_page_template() ) != "full-width.php" || basename( get_page_template() ) == "100-width.php") {
			$container_class = 'timeline-layout timeline-sidebar-layout';
		}
	}

	$ml_query = new WP_Query($atts);

	$html = '';

	if ($atts['scrolling'] == "infinite") {
		$html .= '<div id="blog-infinite" class="blog-shortcode">';
		$posts_container_id = 'posts-container-infinite';
	} else {
		$html .= '<div id="blog" class="blog-shortcode">';
		$posts_container_id = 'posts-container-pagination';
	}
	if($atts['layout'] == 'timeline') {
		$html .= '<div class="timeline-icon"><i class="icon-comments-alt"></i></div>';
	}

	$html .= '<div id="'.$posts_container_id.'" class="' .$container_class .' clearfix">';

	$post_count = 1;

	$prev_post_timestamp = null;
	$prev_post_month = null;
	$first_timeline_loop = false;

	while( $ml_query->have_posts() ) :
		$ml_query->the_post();

		$post_timestamp = strtotime($post->post_date);
		$post_month = date('n', $post_timestamp);
		$post_year = get_the_date('o');
		$current_date = get_the_date('o-n');

		if($atts['layout'] == 'timeline') {
			if($prev_post_month != $post_month) {
				$html.= '<div class="timeline-date"><h3 class="timeline-title">' . get_the_date($data['timeline_date_format']) .'</h3></div>';
			}
		}
		$current_post_id = get_the_ID();
		$html .= '<div id="post-' .$current_post_id.'"';
		ob_start();
		post_class($post_class.getClassAlign($post_count).' clearfix');
		$html .= ob_get_clean() .'>';
			if($atts['layout'] == 'medium alternate') {
				$html.= '<div class="date-and-formats">
					<div class="date-box updated">
						<span class="date">' . get_the_time($data['alternate_date_format_day']) .'</span>
						<span class="month-year">' .get_the_time($data['alternate_date_format_month_year']) .'</span>
					</div>
					<div class="format-box">';

					switch(get_post_format()) {
						case 'gallery':
							$format_class = 'camera-retro';
							break;
						case 'link':
							$format_class = 'link';
							break;
						case 'image':
							$format_class = 'picture';
							break;
						case 'quote':
							$format_class = 'quote-left';
							break;
						case 'video':
							$format_class = 'film';
							break;
						case 'audio':
							$format_class = 'headphones';
							break;
						case 'chat':
							$format_class = 'comments-alt';
							break;
						default:
							$format_class = 'book';
							break;
					}

						$html.= '<i class="icon-' . $format_class .'"></i>
					</div>
				</div>';
			}

			if($atts['thumbnail']) {
				if($data['legacy_posts_slideshow']) {
					ob_start();
					include(locate_template('legacy-slideshow-blog-shortcode.php', false));
					//get_template_part('legacy-slideshow');
					$html .= ob_get_clean();
				} else {
					ob_start();
					include(locate_template('new-slideshow-blog-shortcode.php', false));
					//get_template_part('new-slideshow-blog-shortcode');
					$html .= ob_get_clean();

				}
			}

			$html.= '<div class="post-content-container">';
			if($atts['layout'] == 'timeline') {
				$html.= '<div class="timeline-circle"></div>
				<div class="timeline-arrow"></div>';
			}
			if($atts['layout'] != 'large alternate' && $atts['layout'] != 'medium alternate' && $atts['layout'] != 'grid'  && $atts['layout'] != 'timeline') {
				if($atts['title']) {
					$html.= '<h2 class="entry-title"><a href="' . get_permalink($current_post_id) .'">' .get_the_title() .'</a></h2>';
				}
			}
			if($atts['layout'] == 'large alternate') {
				$html.= '<div class="date-and-formats">
					<div class="date-box updated">
						<span class="date">' .get_the_time($data['alternate_date_format_day']) .'</span>
						<span class="month-year">' .get_the_time($data['alternate_date_format_month_year']) .'</span>
					</div>
					<div class="format-box">';

						switch(get_post_format()) {
							case 'gallery':
								$format_class = 'camera-retro';
								break;
							case 'link':
								$format_class = 'link';
								break;
							case 'image':
								$format_class = 'picture';
								break;
							case 'quote':
								$format_class = 'quote-left';
								break;
							case 'video':
								$format_class = 'film';
								break;
							case 'audio':
								$format_class = 'headphones';
								break;
							case 'chat':
								$format_class = 'comments-alt';
								break;
							default:
								$format_class = 'book';
								break;
						}

						$html.= '<i class="icon-' .$format_class .'"></i>
					</div>
				</div>';
			}


			$html.= '<div class="post-content">';
				if($atts['layout'] == 'large alternate' || $atts['layout'] == 'medium alternate'  || $atts['layout'] == 'grid' || $atts['layout'] == 'timeline') {
					if($atts['title']) {
						$html.= '<h2 class="post-title entry-title"><a href="' . get_permalink($current_post_id) .'">' . get_the_title() .'</a></h2>';
					}
					if($atts['meta_all']) {
						if($atts['layout'] == 'grid' || $atts['layout'] == 'timeline') {
							$html.= '<p class="single-line-meta vcard">';
							if($atts['meta_author']) {
								$html .= __('By', 'Avada') .' ';
								ob_start();
								the_author_posts_link();
								$html .= '<span class="fn">'.ob_get_clean().'</span><span class="sep">|</span>';
							}
							if($atts['meta_date']) {
								$html .= '<span class="updated">'.get_the_time($data["date_format"]).'</span><span class="sep">|</span>';
							}
							$html.= '</p>';
						} else {
							$html.= '<p class="single-line-meta vcard">';
							if($atts['meta_author']) {
								$html .= __('By', 'Avada') .' ';
								ob_start();
								the_author_posts_link();
								$html .= '<span class="fn">'.ob_get_clean().'</span><span class="sep">|</span>';
							}
							if($atts['meta_date']) {
								$html .= '<span class="updated">'.get_the_time($data["date_format"]).'</span><span class="sep">|</span>';
							}
							if($atts['meta_categories']) {
								ob_start();
								the_category(', ');
								$html .= ob_get_clean().'<span class="sep">|</span>';
							}
							if($atts['meta_comments']) {
								ob_start();
								comments_popup_link(__('0 Comments', 'Avada'), __('1 Comment', 'Avada'), '% '.__('Comments', 'Avada'));
								$html .= ob_get_clean().'<span class="sep">|</span>';
							}
							$html .= '</p>';
						}
					}
				}
				$html .= '<div class="content-sep"></div>';

				// get the post content according to the chosen kind of delivery
				if($atts['excerpt']) {
					// content of shortcodes should be displayed
					if (isset($atts['include_shortcodes']) && $atts['include_shortcodes'] == true) {
						$html .= avada_custom_excerpt();
					} else {
						// content of shortcodes will be cut out, i.e. standard
						$stripped_content = tf_content( $atts['excerpt_words'], $atts['strip_html'] );
						$html .= $stripped_content;
					}
				} else {
					global $more; $more = 0;
					$content = get_the_content('');
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$html .= $content;
				}

			$html .= '</div>
			<div style="clear:both;"></div>';

			if($atts['meta_all']) {
				$html .= '<div class="meta-info">';
					if($atts['layout'] == 'grid' || $atts['layout'] == 'timeline') {
						if($atts['layout'] != 'large alternate' && $atts['layout'] != 'medium alternate') {
							$html .= '<div class="alignleft">';
								if($atts['meta_link']) {
									$html .= '<a href="' .get_permalink($current_post_id) .'" class="read-more">' .__("Read More", "Avada") .'</a>';
								}
							$html .= '</div>';
						}
						$html .= '<div class="alignright">';
							if($atts['meta_comments']) {
								ob_start();
								comments_popup_link('<i class="icon-comments"></i>&nbsp;'.__('0', 'Avada'), '<i class="icon-comments"></i>&nbsp;'.__('1', 'Avada'), '<i class="icon-comments"></i>&nbsp;'.'%');
								$html .= ob_get_clean();
							}
						$html .= '</div>';
					} else {
						if($atts['layout'] != 'large alternate' && $atts['layout'] != 'medium alternate') {
							$html .= '<div class="alignleft vcard">';
								if($atts['meta_author']) {
									$html .= __('By', 'Avada') .' ';
									ob_start();
									the_author_posts_link();
									$html .= '<span class="fn">'.ob_get_clean().'</span><span class="sep">|</span>';
								}
								if($atts['meta_date']) {
									$html .= '<span class="updated">'.get_the_time($data["date_format"]).'</span><span class="sep">|</span>';
								}
								if($atts['meta_categories']) {
									ob_start();
									the_category(', ');
									$html .= ob_get_clean().'<span class="sep">|</span>';
								}
								if($atts['meta_comments']) {
									ob_start();
									comments_popup_link(__('0 Comments', 'Avada'), __('1 Comment', 'Avada'), '% '.__('Comments', 'Avada'));
									$html .= ob_get_clean().'<span class="sep">|</span>';
								}
							$html .= '</div>';
						}
						$html .= '<div class="alignright">';
							if($atts['meta_link']) {
								$html .= '<a href="' .get_permalink($current_post_id) .'" class="read-more">' .__("Read More", "Avada") .'</a>';
							}
						$html .= '</div>';
					}
				$html .= '</div>';
			}
			$html .= '</div>
		</div>';

		$prev_post_timestamp = $post_timestamp;
		$prev_post_month = $post_month;
		$post_count++;
	endwhile;

	$html .= '</div></div>';

	//no paging if only the latest posts are shown
	if ($atts['paging']) {
		$html .= avada_blog_shortcode_pagination($ml_query, $pages = '', $range = 2, $atts['scrolling']);
	}
	wp_reset_query();
	return $html;
}
add_shortcode( 'blog', 'blog_shortcode' );

if(!function_exists('avada_blog_shortcode_pagination')):
function avada_blog_shortcode_pagination($ml_query, $pages = '', $range = 2, $infinite_scrolling = false)
{
	$html = '';

	$showitems = ($range * 2)+1;

	if((is_front_page() || is_home() ) ) {
		$paged = (get_query_var('paged')) ?get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	if($pages == '') {
		global $wp_query;
		$pages = $ml_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}

	if(1 != $pages) {
		if ($infinite_scrolling == "infinite") {
        	$html .= '<div class="pagination infinite-scroll clearfix">';
        } else {
        	$html .= '<div class="pagination clearfix">';
        }

		if($paged > 1) $html .= '<a class="pagination-prev" href="'.get_pagenum_link($paged - 1).'"><span class="page-prev"></span>'.__('Previous', 'Avada').'</a>';

		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				if ($paged == $i) {
					$html .= '<span class="current">'.$i.'</span>';
				} else {
					$html .= '<a href="'.get_pagenum_link($i).'" class="inactive" >'.$i.'</a>';
				}
			}
		}

		if ($paged < $pages) $html .= '<a class="pagination-next" href="'.get_pagenum_link($paged + 1).'">'.__('Next', 'Avada').'<span class="page-next"></span></a>';
		$html .= '</div>';
	}
	return $html;
}
endif;

if(!function_exists('avada_custom_excerpt')):
function avada_custom_excerpt($text = '') {
	global $atts;

	$raw_excerpt = $text;
	$text = get_the_content('');
	$text = do_shortcode( $text );

	// strip html tags
	if($atts['strip_html']) {

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_length = apply_filters('excerpt_length', $atts['excerpt_words']);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

		$content = apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	//do not strip html tags
	} else {

		$content = explode(' ', $text, $atts['excerpt_words']);
		if (count($content)>=$atts['excerpt_words']) {
			array_pop($content);
			$content = implode(" ",$content).' <a href="'.get_permalink(). '">&#91;...&#93;</a>';
		} else {
			$content = implode(" ",$content);
		}
		$content = preg_replace('/\[.+\]/','', $content);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
	}
	return $content;
}
endif;

//////////////////////////////////////////////////////////////////
// Image Frame
//////////////////////////////////////////////////////////////////
add_shortcode('imageframe', 'shortcode_imageframe');
function shortcode_imageframe($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'style' => 'none',
		'bordercolor' => '',
		'bordersize' => '0',
		'stylecolor' => '',
		'align' => '',
		'lightbox' => 'no',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type) {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	static $avada_imageframe_id = 1;

	if(!$bordercolor) {
		$bordercolor = $data['imgframe_border_color'];
	}


	if(!$stylecolor) {
		$stylecolor = $data['imgframe_style_color'];
	}

	$getRgb = avada_hex2rgb($stylecolor);

	$html = "<style type='text/css'>";
	if( $align ) {
		if( $align != 'center' ) {
			$html .= "#imageframe-{$avada_imageframe_id}.imageframe{float:{$align};}";
		} else {
			$html .= "#imageframe-{$avada_imageframe_id} img{margin: 0 auto;}";
		}
	}
	$html .= "#imageframe-{$avada_imageframe_id}.imageframe img{border:{$bordersize} solid {$bordercolor};}
	#imageframe-{$avada_imageframe_id}.imageframe-glow img{
		-moz-box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
		-webkit-box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
		box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
	}
	#imageframe-{$avada_imageframe_id}.imageframe-dropshadow img{
		-moz-box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
		-webkit-box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
		box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
	}
	</style>
	";

	$html .= '<span id="imageframe-'.$avada_imageframe_id.'" class="imageframe imageframe-'.$style.$animation_class.'"'.$animation_attribues.'>';
	if($lightbox == "yes") {
		preg_match('/(src=["\'](.*?)["\'])/', $content, $src);
		$link = preg_split('/["\']/', $src[0]);
		$image_id = tf_get_attachment_id_from_url($link[1]);
		if($image_id) {
			$title_attr = get_post_field('post_excerpt', $image_id);
		} else {
			$title_attr = "";
		}
		$html .= '<a href="'.$link[1].'" rel="prettyPhoto" title="'.$title_attr.'">';
	}

	$has_alt = strpos($content, 'alt=""');
	if($has_alt!== false) {
		if($image_id) {
			$alt_tag = 'alt="'. get_post_meta($image_id, '_wp_attachment_image_alt', true).'"';
		} else {
			$alt_tag = 'alt=""';
		}
		$content = str_replace('alt=""', $alt_tag, $content);
	}
	$html .= do_shortcode($content);
	if($lightbox == "yes") {
	$html .= '</a>';
	}
	if($style == 'bottomshadow') {
	$html .= '<span class="imageframe-shadow-left"></span><span class="imageframe-shadow-right"></span>';
	}
	$html .= '</span>';

	$avada_imageframe_id++;

	if( $align == 'center' ) {
		$html = sprintf( '<div class="imageframe-align-center">%s</div>', $html );
	}

	return $html;
}

//////////////////////////////////////////////////////////////////
// Images
//////////////////////////////////////////////////////////////////
add_shortcode('images', 'shortcode_avada_images');
function shortcode_avada_images($atts, $content = null) {
	wp_enqueue_script( 'jquery.carouFredSel' );

	extract(shortcode_atts(array(
		'lightbox' => 'no',
		'picture_size' => 'fixed'
	), $atts));

	$class = '';

	if($lightbox == 'yes') {
		$class = 'lightbox-enabled';
	}

	$css_class = "related-posts";
	$carousel_class = "clients-carousel";
	if($picture_size != 'fixed') {
		$css_class = "";
		$carousel_class = "";
	}

	$picture_size = 'fixed';

	$html = '<div class="images-carousel-container '.$css_class.' related-projects '.$class.'"><div id="carousel" class="'.$carousel_class.' es-carousel-wrapper"><div class="es-carousel"><ul>';
	$html .= do_shortcode($content);
	$html .= '</ul><div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div></div></div></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Image
//////////////////////////////////////////////////////////////////
add_shortcode('image', 'shortcode_avada_image');
function shortcode_avada_image($atts, $content = null) {
	$image_id = tf_get_attachment_id_from_url($atts['image']);

	if(!$atts['alt'] && empty($atts['alt'])) {
		if($image_id) {
			$atts['alt'] = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		} else {
			$atts['alt'] = "";
		}
	}

	if($image_id) {
		$title_attr = get_post_field('post_excerpt', $image_id);
	} else {
		$title_attr = "";
	}

	if(!$atts['link'] && empty($atts['link'])) {
		$atts['link'] = $atts['image'];
	}

	$html = '<li>';
	$html .= '<a href="'.$atts['link'].'" target="'.$atts['linktarget'].'" title="'. $title_attr.'" ><img src="'.$atts['image'].'" alt="'.$atts['alt'].'" /></a>';
	$html .= '</li>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Social Sharing Box
//////////////////////////////////////////////////////////////////
add_shortcode('sharing', 'shortcode_sharing');
function shortcode_sharing($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'tagline' => '',
		'title' => '',
		'link' => '',
		'description' => '',
		'backgroundcolor' => '',
		'pinterest_image' => ''
	), $atts));

	if(!$backgroundcolor) {
		$backgroundcolor = $data['social_bg_color'];
	}

	$nofollow = '';
	if($data['nofollow_social_links']) {
		$nofollow = ' rel="nofollow"';
	}

	$html = '<div class="share-box" style="background-color:'.$backgroundcolor.';">
		<h4>'.$tagline.'</h4>
		<ul class="social-networks social-networks-'.strtolower($data['socialbox_icons_color']).'">';
			if($data['sharing_facebook']):
			$html .= '<li class="facebook">
				<a href="http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;='.$link.'&p&#91;images&#93;&#91;0&#93;=http://www.gravatar.com/avatar/2f8ec4a9ad7a39534f764d749e001046.png&p&#91;title&#93;='.$title.'" target="_blank"'.$nofollow.'>
					Facebook
				</a>
				<div class="popup">
					<div class="holder">
						<p>Facebook</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_twitter']):
			$html .= '<li class="twitter">
				<a href="http://twitter.com/home?status='.$title.' '.$link.'" target="_blank"'.$nofollow.'>
					Twitter
				</a>
				<div class="popup">
					<div class="holder">
						<p>Twitter</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_linkedin']):
			$html .= '<li class="linkedin">
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url='.$link.'&amp;title='.$title.'" target="_blank"'.$nofollow.'>
					LinkedIn
				</a>
				<div class="popup">
					<div class="holder">
						<p>LinkedIn</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_reddit']):
			$html .= '<li class="reddit">
				<a href="http://reddit.com/submit?url='.$link.'&amp;title='.$title.'" target="_blank"'.$nofollow.'>
					Reddit
				</a>
				<div class="popup">
					<div class="holder">
						<p>Reddit</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_tumblr']):
			$html .= '<li class="tumblr">
				<a href="http://www.tumblr.com/share/link?url='.urlencode($link).'&amp;name='.urlencode($title).'&amp;description='.urlencode($description).'" target="_blank"'.$nofollow.'>
					Tumblr
				</a>
				<div class="popup">
					<div class="holder">
						<p>Tumblr</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_google']):
			$html .= '<li class="google">
				<a href="https://plus.google.com/share?url='.$link.'" onclick="javascript:window.open(this.href,
  \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" target="_blank"'.$nofollow.'>
					Google +1
				</a>
				<div class="popup">
					<div class="holder">
						<p>Google +1</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_pinterest']):
			$html .= '<li class="tf-pinterest">
				<a href="http://pinterest.com/pin/create/button/?url='.urlencode($link).'&amp;description='.urlencode($title).'&amp;media='.urlencode($pinterest_image).'" target="_blank"'.$nofollow.'>
					Pinterest
				</a>
				<div class="popup">
					<div class="holder">
						<p>Pinterest</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_email']):
			$html .= '<li class="email">
				<a href="mailto:?subject='.$title.'&amp;body='.$link.'">
					Email
				</a>
				<div class="popup">
					<div class="holder">
						<p>Email</p>
					</div>
				</div>
			</li>';
			endif;
		$html .= '</ul>
	</div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Featured Products Slider
//////////////////////////////////////////////////////////////////
add_shortcode('featured_products_slider', 'avada_featured_products_slider');
function avada_featured_products_slider($atts, $content = null) {
	global $woocommerce, $data;

	$html = '';

	if(class_exists('Woocommerce')):

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'meta_key' => '_featured',
		'meta_value' => 'yes',
	);

	$html = '<div class="products-slider es-carousel">';

	$products = new WP_Query($args);
	if($products->have_posts()) {
		$html .= '<ul>';
		while($products->have_posts()): $products->the_post();
			if(has_post_thumbnail()):
			$html .= '<li>';
				$html .= '<div class="image" aria-haspopup="true">';
						if($data['image_rollover']):
						$html .= get_the_post_thumbnail(get_the_ID(), 'shop_single');
						else:
						$html .= '<a href="'.get_permalink(get_the_ID()).'">'.get_the_post_thumbnail(get_the_ID(), 'shop_single').'</a>';
						endif;

						$html .= '<div class="image-extras">';
							$html .= '<div class="image-extras-content">';
							$html .= '<h2><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h2>';
							$html .= get_the_term_list(get_the_ID(), 'product_cat', '<span class="cats">', ', ', '</span>');
							ob_start();
							woocommerce_get_template('loop/price.php');
							$price = ob_get_contents();
							ob_end_clean();
							if($price):
							$html .= $price;
							endif;
							$html .= '<div class="product-buttons clearfix">';
							ob_start();
							woocommerce_get_template('loop/add-to-cart.php');
							$cart_button = ob_get_contents();
							ob_end_clean();
							$html .= $cart_button;
							$html .= '<a href="'.get_permalink(get_the_ID()).'" class="show_details_button">Details</a>';
							$html .= '</div>';

							$html .= '</div>
						</div>
				</div>
			</li>';
			endif;
		endwhile;
		$html .= '</ul>';
	}

	$html .= '<div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div>';

	$html .= '</div>';

	endif;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Products Slider
//////////////////////////////////////////////////////////////////
add_shortcode('products_slider', 'avada_products_slider');
function avada_products_slider($atts, $content = null) {
	global $woocommerce, $data;

	extract(shortcode_atts(array(
		'cat_slug' => '',
		'number_posts' => 10,
		'show_cats' => 'yes',
		'show_price' => 'yes',
		'show_buttons' => 'yes',
		'picture_size' => 'fixed'
	), $atts));

	$html = '';

	if(class_exists('Woocommerce')):

	$number_posts = (int) $number_posts;

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $number_posts,
		'meta_query' => array(
			array(
				'key' => '_thumbnail_id',
				'compare' => '!=',
				'value' => null
			)
		)
	);

	if($cat_slug){
		$cat_id = explode(',', $cat_slug);
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $cat_id
			)
		);
	}

	$css_class = "related-posts";
	if($picture_size != 'fixed') {
		$css_class = "";
	}

	$html .= '<div class="'.$css_class.' related-projects simple-products-slider">';
	$html .= '<div id="carousel" class="es-carousel-wrapper">';
	$html .= '<div class="es-carousel">';

	$products = new WP_Query($args);
	if($products->have_posts()) {
		$html .= '<ul>';
		while($products->have_posts()): $products->the_post();
			if(has_post_thumbnail()):
			$html .= '<li>';
				$html .= '<div class="image" aria-haspopup="true">';
						if($data['image_rollover']):
						$html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog');
						else:
						$html .= '<a href="'.get_permalink(get_the_ID()).'">'.get_the_post_thumbnail(get_the_ID(), 'shop_catalog').'</a>';
						endif;

						$html .= '<div class="image-extras">';
							$html .= '<div class="image-extras-content">';
							$html .= '<h3><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h3>';
							if($show_cats == 'yes'):
							$html .= get_the_term_list(get_the_ID(), 'product_cat', '<span class="cats">', ', ', '</span>');
							endif;
							ob_start();
							woocommerce_get_template('loop/price.php');
							$price = ob_get_contents();
							ob_end_clean();
							if($price && $show_price == 'yes'):
							$html .= $price;
							endif;
							if($show_buttons == 'yes'):
							$html .= '<div class="product-buttons clearfix">';
							ob_start();
							woocommerce_get_template('loop/add-to-cart.php');
							$cart_button = ob_get_contents();
							ob_end_clean();
							$html .= $cart_button;
							$html .= '<a href="'.get_permalink(get_the_ID()).'" class="show_details_button">Details</a>';
							$html .= '</div>';
							endif;

							$html .= '</div>
						</div>
				</div>
			</li>';
			endif;
		endwhile;
		$html .= '</ul>';
	}

	$html .= '<div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div>';

	$html .= '</div></div></div>';

	endif;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Menu Anchor shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('menu_anchor', 'shortcode_menu_anchor');
	function shortcode_menu_anchor($atts) {
		$atts = shortcode_atts(
			array(
				'name' => '',
				'class' => '',
			), $atts);

		$classes = 'fusion-menu-anchor ' . $atts['class'];
		$html = sprintf( '<div id="%s" class="%s"></div>', $atts['name'], $classes );

		return $html;
	}

//////////////////////////////////////////////////////////////////
// Animation Shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('animation', 'avada_animations');
function avada_animations($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'type' => 'fade',
		'direction' => 'left',
		'speed' => '1',
	), $atts));

	$data['animation_type'] = $type;
	$data['animation_speed'] = $speed;
	$direction_suffix = '';
	if($type != 'flash' && $type != 'shake') {
		$direction_suffix = 'In'.ucfirst($direction);
		$data['animation_type'] = $type.$direction_suffix;
	}

	$html = do_shortcode($content);

	return $html;

}

//////////////////////////////////////////////////////////////////
// Attatchment ID helper functions
//////////////////////////////////////////////////////////////////
function tf_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$attachment_id = false;

	if ( '' == $attachment_url ) {
		return;
 	}

	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	}
	return $attachment_id;
}