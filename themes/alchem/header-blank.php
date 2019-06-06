<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
    <?php

	    $custom_font_woff = alchem_option('custom_font_woff');
		$custom_font_svg  = alchem_option('custom_font_svg');
		$custom_font_eot  = alchem_option('custom_font_eot');
		
		$is_custom_font = ( $custom_font_woff  && $custom_font_svg && $custom_font_eot);

	if ( $is_custom_font ): 
	echo  "<style type='text/css'>
	   @font-face {
		font-family: 'selfFont';
		src: url(".esc_url(alchem_option('custom_font_eot')).");
		src:
			url('".esc_url(alchem_option('custom_font_eot'))."?#iefix') format('eot'),
			url(".esc_url(alchem_option('custom_font_woff')).") format('woff'),
			url(".esc_url(alchem_option('custom_font_ttf')).") format('truetype'),
			url('".esc_url(alchem_option('custom_font_svg'))."#selfFont') format('svg');
		font-weight: 400;
		font-style: normal;
		}</style>";
	
 endif; 
 
	?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>