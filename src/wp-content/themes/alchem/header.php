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
		$is_custom_font   = ( $custom_font_woff  && $custom_font_svg && $custom_font_eot);

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
<?php
 global  $page_meta,$post,$banner_position,$banner_type;
  $detect                      = new Mobile_Detect;
  $display_top_bar             = alchem_option('display_top_bar','yes');
  $header_background_parallax  = alchem_option('header_background_parallax','');
  $header_top_padding          = alchem_option('header_top_padding','');
  $header_bottom_padding       = alchem_option('header_bottom_padding','');
  $header_background_parallax  = $header_background_parallax=="yes"?"parallax-scrolling":"";
  $top_bar_left_content        = alchem_option('top_bar_left_content','info');
  $top_bar_right_content       = alchem_option('top_bar_right_content','info');
  
  //sticky
  $enable_sticky_header         = alchem_option('enable_sticky_header','yes');
  $enable_sticky_header_tablets = alchem_option('enable_sticky_header_tablets','yes');
  $enable_sticky_header_mobiles = alchem_option('enable_sticky_header_mobiles','yes');
  $logo_position                = alchem_option('logo_position','left');
  $header_overlay               = alchem_option('header_overlay','no');
 
  $overlay = '';
  if( $header_overlay == 'yes')
  $overlay = 'overlay';
			  
 $layout     = esc_attr(alchem_option('layout','wide'));
 $full_width = isset($page_meta['full_width'])?$page_meta['full_width']:'no';
 $wrapper    = '';
 $body_class = '';
 if( $layout == 'boxed' )
 $wrapper    = ' wrapper-boxed container ';
 
 if( $full_width == 'yes' )
 $body_class     = 'page-full-width';
 
 if(isset($page_meta['nav_menu']) && $page_meta['nav_menu'] !='')
 $theme_location = $page_meta['nav_menu'];
 else
 $theme_location = 'primary'; 
 
 $header_position = isset($page_meta['header_position'])?$page_meta['header_position']:'top';
 switch( $header_position ){
	 case "top":
	 break;
	 case "left":
	 $body_class   .= ' side-header';
	 $wrapper       = '';
	 $logo_position = 'center';
	 $overlay = '';
	 break;
	 case "right":
	 $body_class   .= ' side-header side-header-right';
	 $wrapper       = '';
	 $logo_position = 'center';
	 $overlay       = '';
	 break;
	 } 
// slider
 $banner_type     = isset($page_meta['slider_banner'])?$page_meta['slider_banner']:'0';
 $banner_position = isset($page_meta['banner_position'])?$page_meta['banner_position']:'1';
 if( $banner_type != '0' && $banner_type != '' ):
 if( $banner_position == '2'):
 $body_class   .= ' slider-above-header';
 else:
 $body_class   .= ' slider-below-header';
 endif;
 endif;
?>
<body <?php body_class($body_class); ?>>
    <div class="wrapper <?php echo $wrapper;?>">   
    <div class="top-wrap">
    <?php if( $banner_position == '2'):
	           alchem_get_page_slider( $banner_type );
			   endif;
	?>
        <header class="header-wrap <?php echo $overlay; ?> logo-<?php echo $logo_position;?>">
        <?php if( $display_top_bar == 'yes' ):?>
            <div class="top-bar">
                <div class="container">
                    <div class="top-bar-left">
                          <?php  alchem_get_topbar_content( $top_bar_left_content );?>
                    </div>
                    <div class="top-bar-right">
                    <?php alchem_get_topbar_content( $top_bar_right_content );?>
                    </div>
                </div>
				<div class="clear"></div>
            </div>
            <?php endif;?>
            
             <?php 
					       $logo        = alchem_option('default_logo','');
					       $logo_retina = alchem_option('default_logo_retina');
						   $logo        = ( $logo == '' ) ? $logo_retina : $logo;
						   
						   $sticky_logo        = alchem_option('sticky_logo','');
						   $sticky_logo_retina = alchem_option('sticky_logo_retina');
						   $sticky_logo        = ( $sticky_logo == '' ) ? $sticky_logo_retina : $sticky_logo;
						   
					?>
            
            <div class="main-header <?php echo $header_background_parallax; ?>">
                <div class="container">
                    <div class="logo-box">
                  <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if( $logo ):?>
                        <img class="site-logo normal_logo" alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($logo); ?>" />
                     <?php endif;?>
                       <?php
					if( $logo_retina ):
					$pixels ="";
					if(is_numeric(alchem_option('retina_logo_width')) && is_numeric(alchem_option('retina_logo_height'))):
					$pixels ="px";
					endif; ?>
					<img src="<?php echo $logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo alchem_option('retina_logo_width').$pixels; ?>;max-height:<?php echo alchem_option('retina_logo_height').$pixels; ?>; height: auto !important" class="site-logo retina_logo" />
					<?php endif; ?>
                     </a>
                        <div class="name-box">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                            <span class="site-tagline"><?php bloginfo('description'); ?></span>
                        </div>
                    </div>
                    <button class="site-nav-toggle">
                        <span class="sr-only"><?php _e( 'Toggle navigation', 'alchem' );?></span>
                        <i class="fa fa-bars fa-2x"></i>
                    </button>
                    <nav class="site-nav" role="navigation">
                    <?php 
					 wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
					?>
                    </nav>
                </div>
            </div>
            <?php if( $enable_sticky_header == 'yes' && $header_position !='left' && $header_position !='right' ):?>
            <?php if( !$detect->isTablet() || ( $detect->isTablet() && $enable_sticky_header_tablets == 'yes' ) || ( $detect->isMobile() && !$detect->isTablet() && $enable_sticky_header_mobiles == 'yes' )  ):?>
           <!-- sticky header -->
           <div class="fxd-header logo-<?php echo $logo_position;?>">
                <div class="container">
                    <div class="logo-box text-left">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                    
                    <?php if( $sticky_logo ):?>
                        <img class="site-logo normal_logo" alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($sticky_logo); ?>" />
                     <?php endif;?>
                     
                       <?php
					if( $sticky_logo_retina ):
					$pixels ="";
					if( is_numeric(alchem_option('sticky_logo_width_for_retina_logo')) && is_numeric(alchem_option('sticky_logo_height_for_retina_logo')) ):
					$pixels ="px";
					endif; ?>
					<img src="<?php echo $sticky_logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo alchem_option('sticky_logo_width_for_retina_logo').$pixels; ?>;max-height:<?php echo alchem_option('sticky_logo_height_for_retina_logo').$pixels; ?>; height: auto !important" class="site-logo retina_logo" />
					<?php endif; ?>
                     </a>
                        <div class="name-box">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                            <span class="site-tagline"><?php bloginfo('description'); ?></span>
                        </div>
                    </div>
                    <button class="site-nav-toggle">
                        <span class="sr-only"><?php _e( 'Toggle navigation', 'alchem' );?></span>
                        <i class="fa fa-bars fa-2x"></i>
                    </button>
                    <nav class="site-nav" role="navigation">
                        <?php 
					 wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
					?>
                    </nav>
                </div>
            </div>
            <?php endif;?>
             <?php endif; ?>            
            <div class="clear"></div>
        </header>
        
         <?php if( $banner_position == '1'):
            alchem_get_page_slider( $banner_type );
			   endif;
	?>
	</div>