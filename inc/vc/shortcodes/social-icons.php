<?php 
/**
 * Seoaal Social Icons
 */
if ( ! function_exists( "seoaal_vc_social_icons_shortcode" ) ) {
	function seoaal_vc_social_icons_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_social_icons", $atts ); 
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';	
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.social-icons-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		$output .= '<div class="social-icons-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			$output .= isset( $title ) && $title != '' ? '<h3 class="social-icons-title">'. esc_html( $title ) .'</h3>' : '';
			
			$social_media = array( 
				'social-fb' => 'fa fa-facebook', 
				'social-twitter' => 'fa fa-twitter', 
				'social-instagram' => 'fa fa-instagram', 
				'social-linkedin' => 'fa fa-linkedin', 
				'social-pinterest' => 'fa fa-pinterest-p', 				
				'social-youtube' => 'fa fa-youtube-play', 
				'social-vimeo' => 'fa fa-vimeo', 
				'social-soundcloud' => 'fa fa-soundcloud', 
				'social-yahoo' => 'fa fa-yahoo', 
				'social-tumblr' => 'fa fa-tumblr',  
				'social-paypal' => 'fa fa-paypal', 
				'social-mailto' => 'fa fa-envelope-o', 
				'social-flickr' => 'fa fa-flickr', 
				'social-dribbble' => 'fa fa-dribbble', 
				'social-rss' => 'fa fa-rss' 
			);
			// Actived social icons from theme option output generate via loop
			$social_icons = '';
			foreach( $social_media as $key => $icon_class ){
				
				$social_field = str_replace( "-", "_", $key );
				
				if( isset( $$social_field ) && $$social_field != '' ){
					$social_url = $$social_field;
					$social_icons .= '<li>
									<a href="'. esc_url( $social_url ) .'" class="nav-link '. esc_attr( $key ) .'">
										<i class="'. esc_attr( $icon_class ) .'"></i>
									</a>
								</li>';
				}
			}
	
			$social_class = isset( $social_icons_type ) ? ' social-' . $social_icons_type : '';
			$social_class .= isset( $social_icons_fore ) ? ' social-' . $social_icons_fore : '';
			$social_class .= isset( $social_icons_hfore ) ? ' social-' . $social_icons_hfore : '';
			$social_class .= isset( $social_icons_bg ) ? ' social-' . $social_icons_bg : '';
			$social_class .= isset( $social_icons_hbg ) ? ' social-' . $social_icons_hbg : '';
			
			$output .= '<ul class="nav social-icons '. esc_attr( $social_class ) .'">';
				$output .= $social_icons;
			$output .= '</ul>';
		$output .= '</div><!-- .social-icons-wrapper -->';
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_social_icons_shortcode_map" ) ) {
	function seoaal_vc_social_icons_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Social Icons", "seoaal" ),
				"description"			=> esc_html__( "Social icons for link.", "seoaal" ),
				"base"					=> "seoaal_vc_social_icons",
				"category"				=> esc_html__( "Shortcodes", "seoaal" ),
				"icon"					=> "zozo-vc-icon",
				"params"				=> array(
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Extra Class", "seoaal" ),
						"param_name"	=> "extra_class",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title", "seoaal" ),
						"description"	=> esc_html__( "Here you put the day social shortcode title.", "seoaal" ),
						"param_name"	=> "title",
						"value" 		=> "",
					),
					array(
						"type"			=> "animation_style",
						"heading"		=> esc_html__( "Animation Style", "seoaal" ),
						"description"	=> esc_html__( "Choose your animation style.", "seoaal" ),
						"param_name"	=> "animation",
						'admin_label'	=> false,
                		'weight'		=> 0,
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the font color.", "seoaal" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Social Iocns Type", "seoaal" ),
						"param_name"	=> "social_icons_type",
						"img_lists" => array ( 
							"squared"	=> SEOAAL_ADMIN_URL . "/assets/images/social-icons/1.png",
							"rounded"	=> SEOAAL_ADMIN_URL . "/assets/images/social-icons/2.png",
							"circled"	=> SEOAAL_ADMIN_URL . "/assets/images/social-icons/3.png",
							"transparent"	=> SEOAAL_ADMIN_URL . "/assets/images/social-icons/4.png"
						),
						"default"		=> "transparent",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons shortcode text align", "seoaal" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Fore", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons fore color.", "seoaal" ),
						"param_name"	=> "social_icons_fore",
						"value"			=> array(
							esc_html__( "Black", "seoaal" )	=> "black",
							esc_html__( "White", "seoaal" )		=> "white",
							esc_html__( "Own Color", "seoaal" )	=> "own"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Fore Hover", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons fore hover color.", "seoaal" ),
						"param_name"	=> "social_icons_hfore",
						"value"			=> array(
							esc_html__( "Own Color", "seoaal" )	=> "h-own",
							esc_html__( "Black", "seoaal" )	=> "h-black",
							esc_html__( "White", "seoaal" )		=> "h-white"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons background color.", "seoaal" ),
						"param_name"	=> "social_icons_bg",
						"value"			=> array(
							esc_html__( "Transparent", "seoaal" )	=> "bg-transparent",
							esc_html__( "White", "seoaal" )		=> "bg-white",
							esc_html__( "Black", "seoaal" )		=> "bg-black",
							esc_html__( "Light", "seoaal" )		=> "bg-light",
							esc_html__( "Dark", "seoaal" )		=> "bg-dark",
							esc_html__( "Own Color", "seoaal" )	=> "bg-own"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background Hover", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons background hover color.", "seoaal" ),
						"param_name"	=> "social_icons_hbg",
						"value"			=> array(
							esc_html__( "Transparent", "seoaal" )	=> "hbg-transparent",
							esc_html__( "White", "seoaal" )		=> "hbg-white",
							esc_html__( "Black", "seoaal" )		=> "hbg-black",
							esc_html__( "Light", "seoaal" )		=> "hbg-light",
							esc_html__( "Dark", "seoaal" )		=> "hbg-dark",
							esc_html__( "Own Color", "seoaal" )	=> "hbg-own"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Facebook", "seoaal" ),
						"description"	=> esc_html__( "This is option for facebook social icon.", "seoaal" ),
						"param_name"	=> "social_fb",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Twitter", "seoaal" ),
						"description"	=> esc_html__( "This is option for twitter social icon.", "seoaal" ),
						"param_name"	=> "social_twitter",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Instagram", "seoaal" ),
						"description"	=> esc_html__( "This is option for instagram social icon.", "seoaal" ),
						"param_name"	=> "social_instagram",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Pinterest", "seoaal" ),
						"description"	=> esc_html__( "This is option for pinterest social icon.", "seoaal" ),
						"param_name"	=> "social_pinterest",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Youtube", "seoaal" ),
						"description"	=> esc_html__( "This is option for youtube social icon.", "seoaal" ),
						"param_name"	=> "social_youtube",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Vimeo", "seoaal" ),
						"description"	=> esc_html__( "This is option for vimeo social icon.", "seoaal" ),
						"param_name"	=> "social_vimeo",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Soundcloud", "seoaal" ),
						"description"	=> esc_html__( "This is option for soundcloud social icon.", "seoaal" ),
						"param_name"	=> "social_soundcloud",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Yahoo", "seoaal" ),
						"description"	=> esc_html__( "This is option for yahoo social icon.", "seoaal" ),
						"param_name"	=> "social_yahoo",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Tumblr", "seoaal" ),
						"description"	=> esc_html__( "This is option for tumblr social icon.", "seoaal" ),
						"param_name"	=> "social_tumblr",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Paypal", "seoaal" ),
						"description"	=> esc_html__( "This is option for paypal social icon.", "seoaal" ),
						"param_name"	=> "social_paypal",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Mailto", "seoaal" ),
						"description"	=> esc_html__( "This is option for mailto social icon.", "seoaal" ),
						"param_name"	=> "social_mailto",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Flickr", "seoaal" ),
						"description"	=> esc_html__( "This is option for flickr social icon.", "seoaal" ),
						"param_name"	=> "social_flickr",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Dribbble", "seoaal" ),
						"description"	=> esc_html__( "This is option for dribbble social icon.", "seoaal" ),
						"param_name"	=> "social_dribbble",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "RSS", "seoaal" ),
						"description"	=> esc_html__( "This is option for rss social icon.", "seoaal" ),
						"param_name"	=> "social_rss",
						"value" 		=> "",
						"group"			=> esc_html__( "Links", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_social_icons_shortcode_map" );