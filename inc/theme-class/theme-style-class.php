<?php
class SeoaalThemeStyles {
   
   	private $seoaal_options;
	private $exists_fonts = array();
   
    function __construct() {
		$this->seoaal_options = get_option( 'seoaal_options' );
    }
	
	function seoaalThemeColor(){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options['theme-color'] ) && $seoaal_options['theme-color'] != '' ? $seoaal_options['theme-color'] : '#54a5f8';
	}
	function seoaalSecondaryColor(){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options['secondary-color'] ) && $seoaal_options['secondary-color'] != '' ? $seoaal_options['secondary-color'] : '#95ce69';
	}
	function seoaal_theme_opt($field){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options[$field] ) && $seoaal_options[$field] != '' ? $seoaal_options[$field] : '';
	}
	
	function seoaal_check_meta_value( $meta_key, $default_key ){
		$meta_opt = get_post_meta( get_the_ID(), $meta_key, true );
		$final_opt = isset( $meta_opt ) && ( empty( $meta_opt ) || $meta_opt == 'theme-default' ) ? $this->seoaal_theme_opt( $default_key ) : $meta_opt;
		return $final_opt;
	}
	
	function seoaal_container_width(){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options['site-width'] ) && $seoaal_options['site-width']['width'] != '' ? absint( $seoaal_options['site-width']['width'] ) . $seoaal_options['site-width']['units'] : '1140px';
	}
	
	function seoaal_dimension_width($field){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options[$field] ) && absint( $seoaal_options[$field]['width'] ) != '' ? absint( $seoaal_options[$field]['width'] ) . $seoaal_options[$field]['units'] : '';
	}
	
	function seoaal_dimension_height($field){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options[$field] ) && absint( $seoaal_options[$field]['height'] ) != '' ? absint( $seoaal_options[$field]['height'] ) . $seoaal_options[$field]['units'] : '';
	}
	
	function seoaal_border_settings($field){
		$seoaal_options = $this->seoaal_options;
		if( isset( $seoaal_options[$field] ) ):
		
			$boder_style = isset( $seoaal_options[$field]['border-style'] ) && $seoaal_options[$field]['border-style'] != '' ? $seoaal_options[$field]['border-style'] : '';
			$border_color = isset( $seoaal_options[$field]['border-color'] ) && $seoaal_options[$field]['border-color'] != '' ? $seoaal_options[$field]['border-color'] : '';
			
			if( isset( $seoaal_options[$field]['border-top'] ) && $seoaal_options[$field]['border-top'] != '' ):
				echo '
				border-top-width: '. $seoaal_options[$field]['border-top'] .';
				border-top-style: '. $boder_style .';
				border-top-color: '. $border_color .';';
			endif;
			
			if( isset( $seoaal_options[$field]['border-right'] ) && $seoaal_options[$field]['border-right'] != '' ):
				echo '
				border-right-width: '. $seoaal_options[$field]['border-right'] .';
				border-right-style: '. $boder_style .';
				border-right-color: '. $border_color .';';
			endif;
			
			if( isset( $seoaal_options[$field]['border-bottom'] ) && $seoaal_options[$field]['border-bottom'] != '' ):
				echo '
				border-bottom-width: '. $seoaal_options[$field]['border-bottom'] .';
				border-bottom-style: '. $boder_style .';
				border-bottom-color: '. $border_color .';';
			endif;
			
			if( isset( $seoaal_options[$field]['border-left'] ) && $seoaal_options[$field]['border-left'] != '' ):
				echo '
				border-left-width: '. $seoaal_options[$field]['border-left'] .';
				border-left-style: '. $boder_style .';
				border-left-color: '. $border_color .';';
			endif;
			
		endif;
	}
	
	function seoaal_padding_settings($field){
		$seoaal_options = $this->seoaal_options;
	if( isset( $seoaal_options[$field] ) ):
	
		echo isset( $seoaal_options[$field]['padding-top'] ) && $seoaal_options[$field]['padding-top'] != '' ? 'padding-top: '. $seoaal_options[$field]['padding-top'] .';' : '';
		echo isset( $seoaal_options[$field]['padding-right'] ) && $seoaal_options[$field]['padding-right'] != '' ? 'padding-right: '. $seoaal_options[$field]['padding-right'] .';' : '';
		echo isset( $seoaal_options[$field]['padding-bottom'] ) && $seoaal_options[$field]['padding-bottom'] != '' ? 'padding-bottom: '. $seoaal_options[$field]['padding-bottom'] .';' : '';
		echo isset( $seoaal_options[$field]['padding-left'] ) && $seoaal_options[$field]['padding-left'] != '' ? 'padding-left: '. $seoaal_options[$field]['padding-left'] .';' : '';
	endif;
	}
	
	function seoaal_margin_settings( $field ){
		$seoaal_options = $this->seoaal_options;
	if( isset( $seoaal_options[$field] ) ):
	
		echo isset( $seoaal_options[$field]['margin-top'] ) && $seoaal_options[$field]['margin-top'] != '' ? 'margin-top: '. $seoaal_options[$field]['margin-top'] .';' : '';
		echo isset( $seoaal_options[$field]['margin-right'] ) && $seoaal_options[$field]['margin-right'] != '' ? 'margin-right: '. $seoaal_options[$field]['margin-right'] .';' : '';
		echo isset( $seoaal_options[$field]['margin-bottom'] ) && $seoaal_options[$field]['margin-bottom'] != '' ? 'margin-bottom: '. $seoaal_options[$field]['margin-bottom'] .';' : '';
		echo isset( $seoaal_options[$field]['margin-left'] ) && $seoaal_options[$field]['margin-left'] != '' ? 'margin-left: '. $seoaal_options[$field]['margin-left'] .';' : '';
	endif;
	}
	
	function seoaal_link_color($field, $fun){
		$seoaal_options = $this->seoaal_options;
	echo isset( $seoaal_options[$field][$fun] ) && $seoaal_options[$field][$fun] != '' ? '
	color: '. $seoaal_options[$field][$fun] .';' : '';
	}
	
	function seoaal_get_link_color($field, $fun){
		$seoaal_options = $this->seoaal_options;
		return isset( $seoaal_options[$field][$fun] ) && $seoaal_options[$field][$fun] != '' ? $seoaal_options[$field][$fun] : '';
	}
	
	function seoaal_bg_rgba($field){
		$seoaal_options = $this->seoaal_options;
	echo isset( $seoaal_options[$field]['rgba'] ) && $seoaal_options[$field]['rgba'] != '' ? 'background: '. $seoaal_options[$field]['rgba'] .';' : '';
	}
	
	function seoaal_bg_settings($field){
		$seoaal_options = $this->seoaal_options;
		if( isset( $seoaal_options[$field] ) ):
	echo '
	'. ( isset( $seoaal_options[$field]['background-color'] ) && $seoaal_options[$field]['background-color'] != '' ?  'background-color: '. $seoaal_options[$field]['background-color'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['background-image'] ) && $seoaal_options[$field]['background-image'] != '' ?  'background-image: url('. $seoaal_options[$field]['background-image'] .');' : '' ) .'
	'. ( isset( $seoaal_options[$field]['background-repeat'] ) && $seoaal_options[$field]['background-repeat'] != '' ?  'background-repeat: '. $seoaal_options[$field]['background-repeat'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['background-position'] ) && $seoaal_options[$field]['background-position'] != '' ?  'background-position: '. $seoaal_options[$field]['background-position'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['background-size'] ) && $seoaal_options[$field]['background-size'] != '' ?  'background-size: '. $seoaal_options[$field]['background-size'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['background-attachment'] ) && $seoaal_options[$field]['background-attachment'] != '' ?  'background-attachment: '. $seoaal_options[$field]['background-attachment'] .';' : '' ) .'
	';
		endif;
	}
	
	function seoaal_custom_font_face_create( $font_family, $cf_names ){
	
		$upload_dir = wp_upload_dir();
		$f_type = array('eot', 'otf', 'svg', 'ttf', 'woff');
		if ( in_array( $font_family, $cf_names ) ){
			$t_font_folder = $font_family;
			$t_font_name = sanitize_title( $font_family );
			$font_path = $upload_dir['baseurl'] . '/custom-fonts/' . str_replace( "'", "", $t_font_folder .'/'. $t_font_name );
			echo '@font-face { font-family: '. $t_font_folder .';';
			echo "src: url('". esc_url( $font_path ) .".eot'); /* IE9 Compat Modes */ src: url('". esc_url( $font_path ) .".eot') format('embedded-opentype'), /* IE6-IE8 */ url('". esc_url( $font_path ) .".woff2') format('woff2'), /* Super Modern Browsers */ url('". esc_url( $font_path ) .".woff') format('woff'), /* Pretty Modern Browsers */ url('". esc_url( $font_path ) .".ttf')  format('truetype'), /* Safari, Android, iOS */ url('". esc_url( $font_path ) .".svg') format('svg'); /* Legacy iOS */ }";
		}
		
	}
	
	function seoaal_custom_font_check($field){
		$seoaal_options = $this->seoaal_options;
		$cf_names = get_option( 'seoaal_custom_fonts_names' );
		if ( !empty( $cf_names ) && !in_array( $seoaal_options[$field]['font-family'], $this->exists_fonts ) ){
			$this->seoaal_custom_font_face_create( $seoaal_options[$field]['font-family'], $cf_names );
			array_push( $this->exists_fonts, $seoaal_options[$field]['font-family'] );
		}
	}
	
	function seoaal_typo_generate($field){
		$seoaal_options = $this->seoaal_options;
		if( isset( $seoaal_options[$field] ) ):
	echo '
	'. ( isset( $seoaal_options[$field]['color'] ) && $seoaal_options[$field]['color'] != '' ?  'color: '. $seoaal_options[$field]['color'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['font-family'] ) && $seoaal_options[$field]['font-family'] != '' ?  'font-family: '. $seoaal_options[$field]['font-family'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['font-weight'] ) && $seoaal_options[$field]['font-weight'] != '' ?  'font-weight: '. $seoaal_options[$field]['font-weight'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['font-style'] ) && $seoaal_options[$field]['font-style'] != '' ?  'font-style: '. $seoaal_options[$field]['font-style'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['font-size'] ) && $seoaal_options[$field]['font-size'] != '' ?  'font-size: '. $seoaal_options[$field]['font-size'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['line-height'] ) && $seoaal_options[$field]['line-height'] != '' ?  'line-height: '. $seoaal_options[$field]['line-height'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['letter-spacing'] ) && $seoaal_options[$field]['letter-spacing'] != '' ?  'letter-spacing: '. $seoaal_options[$field]['letter-spacing'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['text-align'] ) && $seoaal_options[$field]['text-align'] != '' ?  'text-align: '. $seoaal_options[$field]['text-align'] .';' : '' ) .'
	'. ( isset( $seoaal_options[$field]['text-transform'] ) && $seoaal_options[$field]['text-transform'] != '' ?  'text-transform: '. $seoaal_options[$field]['text-transform'] .';' : '' ) .'
	';
		endif;
	}
	
	function seoaal_hex2rgba($color, $opacity = 1) {
	 
		$default = '';
		//Return default if no color provided
		if(empty($color))
			  return $default; 
		//Sanitize $color if "#" is provided 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
	 
			//Check if opacity is set(rgba or rgb)
			if( $opacity == 'none' ){
				$output = implode(",",$rgb);
			}elseif( $opacity ){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			}else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
			//Return rgb(a) color string
			return $output;
	}
}