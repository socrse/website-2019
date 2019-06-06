<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	if( is_child_theme() ){	
		$themename = str_replace("_child","",$themename ) ;
		}
	if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'en' )
	$themename = $themename.ICL_LANGUAGE_CODE;
	
	return $themename;
}

global $social_icons;

$social_icons = array(
    array('title'=>'Facebook','icon' => 'facebook', 'link'=>'#'),
array ('title'=>'Twitter','icon' => 'twitter', 'link'=>'#'), 
	array('title'=>'LinkedIn','icon' => 'linkedin', 'link'=>'#'),
array  ('title'=>'YouTube','icon' => 'youtube', 'link'=>'#'),
array('title'=>'Skype','icon' => 'skype', 'link'=>'#'),
array ('title'=>'Pinterest','icon' => 'pinterest', 'link'=>'#'),
array('title'=>'Google+','icon' => 'google-plus', 'link'=>'#'),
    array('title'=>'Email','icon' => 'envelope', 'link'=>'#'),
array ('title'=>'RSS','icon' => 'rss', 'link'=>'#')
        );


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'alchem'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	
	global $social_icons,$sidebars ;

	// Test data
	$test_array = array(
		'one' => __( 'One', 'alchem' ),
		'two' => __( 'Two', 'alchem' ),
		'three' => __( 'Three', 'alchem' ),
		'four' => __( 'Four', 'alchem' ),
		'five' => __( 'Five', 'alchem' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'alchem' ),
		'two' => __( 'Pancake', 'alchem' ),
		'three' => __( 'Omelette', 'alchem' ),
		'four' => __( 'Crepe', 'alchem' ),
		'five' => __( 'Waffle', 'alchem' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	
	global $google_fonts_array,$default_theme_fonts;
	$google_fonts_array_option[''] =  __( '-- None --', 'alchem' );
	
	if($google_fonts_array){
	foreach($google_fonts_array as $index => $value){

	$google_fonts_array_option[$value['family'] ] = $value['family'];
	}
	}
	
	
	$default_theme_fonts_option[''] =  __( '-- Select Font --', 'alchem' );
	if($default_theme_fonts){
	foreach($default_theme_fonts as $index => $value){
	$default_theme_fonts_option[$index] =  $value;
	}
	}
	
	
  $choices =  array( 
          
            'yes'   => __( 'Yes', 'alchem' ),
            'no' => __( 'No', 'alchem' )
 
        );
  $choices_reverse =  array( 
          
           'no'=> __( 'No', 'alchem' ),
            'yes' => __( 'Yes', 'alchem' )
         
        );

  $align =  array( 
          
          'left' => __( 'left', 'alchem' ),
          'right' => __( 'right', 'alchem' ),
           'center'  => __( 'center', 'alchem' )         
        );
  $repeat = array( 
          
          'repeat' => __( 'repeat', 'alchem' ),
          'repeat-x'  => __( 'repeat-x', 'alchem' ),
          'repeat-y' => __( 'repeat-y', 'alchem' ),
          'no-repeat'  => __( 'no-repeat', 'alchem' )
          
        );
  
  $position =  array( 
          
         'top left' => __( 'top left', 'alchem' ),
          'top center' => __( 'top center', 'alchem' ),
          'top right' => __( 'top right', 'alchem' ),
           'center left' => __( 'center left', 'alchem' ),
           'center center'  => __( 'center center', 'alchem' ),
           'center right' => __( 'center right', 'alchem' ),
           'bottom left'  => __( 'bottom left', 'alchem' ),
           'bottom center'  => __( 'bottom center', 'alchem' ),
           'bottom right' => __( 'bottom right', 'alchem' )
            
        );
  
  $opacity   =  array_combine(range(0.1,1,0.1), range(0.1,1,0.1));
  $font_size =  array_combine(range(1,100,1), range(1,100,1));
  
  
    $options = array();
					  
	$options[] = array(
		'icon' => 'fa-dashboard',
		'name' => __('General', 'alchem'),
		'type' => 'heading'
		);   
	   
	   	// General
		// Scheme
	$options[] =	array(
        'id'          => 'scheme_titled',
        'name'       => __( 'Scheme Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'general_tab_section',
        
        'class'       => 'sub_section_titled',
        
      );
		
		$options[] = array(
        'id'          => 'scheme',
        'name'       => __( 'Primary Color', 'alchem' ),
        'desc'        => '',
        'std'         => '#fdd200',
        'type'        => 'color',
        'section'     => 'general_tab_section',
        
        'class'       => '',
        
      );
		
	
		$options[] = array(
        'id'          => 'responsive_titled',
        'name'       => __( 'Responsive Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'general_tab_section',
        
        'class'       => 'sub_section_titled',
        
      );
		
		$options[] = array(
        'id'          => 'responsive',
        'name'       => __( 'Responsive Design', 'alchem' ),
        'desc'        => __( 'Apply or not', 'alchem' ),
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'general_tab_section',
        'class'       => '',
		'options'     => $choices
      );
		
		$options[] = array(
        'id'          => 'tracking_titled',
        'name'       => __( 'Tracking', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'general_tab_section',
        
        'class'       => 'sub_section_titled',
        
      );
		
	 $options[] =  array(
        'id'          => 'tracking_code',
        'name'       => __( 'Tracking Code', 'alchem' ),
        'desc'        => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code inside script tags.', 'alchem' ),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general_tab_section',
        'rows'        => '8',
        
        'class'       => '',
        
      );
	 $options[] =  array(
        'id'          => 'space_before_head',
        'name'       => __( 'Space before &lt;/head&gt;', 'alchem' ),
        'desc'        => __( 'Add code before the head tag.', 'alchem' ),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general_tab_section',
        'rows'        => '6',
        
        'class'       => '',
        
      );
	 $options[] =  array(
        'id'          => 'space_before_body',
        'name'       => __( 'Space before &lt;/body&gt;', 'alchem' ),
        'desc'        => __( 'Add code before the body tag.', 'alchem' ),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general_tab_section',
        'rows'        => '6',
        
        'class'       => '',
        
      );
	  
		//Site Width
	$options[] = array(
		'icon' => 'fa-arrows-h', 
		'name' => __('Site Width', 'alchem'),
		'type' => 'heading'
		);		
     $options[] = array(
        'id'          => 'layout',
        'name'       => __( 'Layout', 'alchem' ),
        'desc'        => __( 'Select boxed or wide layout.', 'alchem' ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        'options'     => array( 
        
          'boxed'     => __( 'Boxed', 'alchem' ),
            
		    'wide'     => __( 'Wide', 'alchem' ),
           
         
        )
      );
	$options[] = 	 array(
        'id'          => 'site_width',
        'name'       => __( 'Site Width', 'alchem' ),
        'desc'        => __( 'Controls the overall site width. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '1170px',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );
	$options[] =  array(
        'id'          => 'content_width_titled_1',
        'name'       => __( 'Content Width/Sidebar Width', 'alchem' ),
        'desc'        => __( 'These settings are used on pages with 1 sidebar. Total values must add up to 100.', 'alchem' ),
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'site_width_tab_section',
        
        'class'       => 'sub_section_titled',
        
      );
		 
	 $options[] = array(
        'id'          => 'content_width_1',
        'name'       => __( 'Content Width', 'alchem' ),
        'desc'        => __( 'Controls the overall site width. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );
		  
	 $options[] = array(
        'id'          => 'sidebar_width',
        'name'       => __( 'Sidebar Width', 'alchem' ),
        'desc'        => __( 'Controls the overall site width. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );		
		$options[] =  array(
        'id'          => 'content_width_titled_2',
        'name'       => __( 'Content Width/Left Sidebar Width/Right Sidebar Width', 'alchem' ),
        'desc'        => __( 'These settings are used on pages with 2 sidebars. Total values must add up to 100.', 'alchem' ),
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'site_width_tab_section',
        
        'class'       => 'sub_section_titled',
        
      );
		 
		$options[] = array(
        'id'          => 'content_width_2',
        'name'       => __( 'Content Width', 'alchem' ),
        'desc'        => __( 'Controls the width of the content area. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );
		  
		$options[] =    array(
        'id'          => 'sidebar_width_1',
        'name'       => __( 'Sidebar 1 Width', 'alchem' ),
        'desc'        => __( 'Controls the width of the sidebar 1. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );
		$options[] =     array(
        'id'          => 'sidebar_width_2',
        'name'       => __( 'Sidebar 2 Width', 'alchem' ),
        'desc'        => __( 'Controls the width of the sidebar 2. In px or %, ex: 100% or 1170px.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'site_width_tab_section',
        
        'class'       => '',
        
      );
	 // header
	 
	$options[] =  array(
		'icon' => 'fa-h-square', 
		'name' => __('Header', 'alchem'),
		'type' => 'heading'
		);
		

		  
		  ////
		$options[] =   	 array(
        'id'          => 'header_background_titled',
        'name'       => __( 'Header Background', 'alchem' ).' <span data-accordion="accordion-group-header_background" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'header_tab_section',
        'rows'        => '4',
        'class'       => 'section-accordion close',
        
      );
		
		$options[] = array(
        'id'          => 'header_overlay',
        'name'       => __( 'Header Overlay', 'alchem' ),
        'desc'        => '',
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
		'options'     => $choices_reverse
      );
		
		
		$options[] = array(
        'id'          => 'header_background_image',
        'name'       => __( 'Header Background Image', 'alchem' ),
        'desc'        => __( 'Background Image For Header Area', 'alchem' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
        
      );
		$options[] = array(
        'id'          => 'header_background_full',
        'name'       => __( '100% Background Image', 'alchem' ),
        'desc'        => __( 'Turn on to have the header background image display at 100% in width and height and scale according to the browser size.', 'alchem' ),
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
		'options'     => $choices
      );
		$options[] = array(
        'id'          => 'header_background_parallax',
        'name'       => __( 'Parallax Background Image', 'alchem' ),
        'desc'        => __( 'Turn on to enable parallax scrolling on the background image for header top positions.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
		'options'     => $choices_reverse
      );
		
		$options[] =  array(
        'id'          => 'header_background_repeat',
        'name'       => __( 'Background Repeat', 'alchem' ),
        'desc'        => __( 'Select how the background image repeats.', 'alchem' ),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
        'options'     => $repeat
      );
		$options[] =  array(
        'id'          => 'header_top_padding',
        'name'       => __( 'Header Top Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '0px',
        'type'        => 'text',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
        
      );
		 $options[] = array(
        'id'          => 'header_bottom_padding',
        'name'       => __( 'Header Bottom Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '0px',
        'type'        => 'text',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-header_background',
        
      );
		 
	////
	 $options[] = array(
        'id'          => 'top_bar_options',
        'name'       => __( 'Top Bar Options', 'alchem' ).' <span data-accordion="accordion-group-3" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'header_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
		$options[] = array(
        'id'          => 'display_top_bar',
        'name'       => __( 'Display Top Bar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-3',
        'options'     => $choices
      );
	$options[] = array(
        'id'          => 'top_bar_background_color',
        'name'       => __( 'Background Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
		$options[] =  array(
        'id'          => 'top_bar_left_content',
        'name'       => __( 'Left Content', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-3',
        'options'     => array( 
          'info'     => __( 'info', 'alchem' ),
          'sns'     => __( 'sns', 'alchem' ),
          'menu'     => __( 'menu', 'alchem' ),
          'none'     => __( 'none', 'alchem' ),
           
        )
      );	 
		$options[] = array(
        'id'          => 'top_bar_right_content',
        'name'       => __( 'Right Content', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-3',
        'options'     => array( 
          'info'     => __( 'info', 'alchem' ),
            
          'sns'     => __( 'sns', 'alchem' ),
            
          'menu'     => __( 'menu', 'alchem' ),
            
          'none'     => __( 'none', 'alchem' ),
           
        ),
	
      );		 
		$options[] = array(
        'id'          => 'top_bar_info_color',
        'name'       => __( 'Info Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'header_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
	$options[] = 	array(
        'id'          => 'top_bar_info_content',
        'name'       => __( 'Info Content', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'header_tab_section',
        'rows'        => '4',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
		$options[] = array(
        'id'          => 'top_bar_menu_color',
        'name'       => __( 'Menu Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
				
 $options[] = array(
        'id'          => 'social_links',
        'name'       => __( 'Social Links', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'header_tab_section',
        'rows'        => '4',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
		if( $social_icons ):
$i = 1;
 foreach($social_icons as $social_icon){
	
	 $options[] =  array(
        'id'          => 'header_social_title_'.$i,
        'name'       => __( 'Social Title', 'alchem' ) .' '.$i,
        'desc'        => '',
        'std'         => $social_icon['title'],
        'type'        => 'text',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
 $options[] = array(
        'id'          => 'header_social_icon_'.$i,
        'name'       => __( 'Social Icon', 'alchem' ).' '.$i,
        'desc'        => __( 'FontAwesome Icon', 'alchem' ),
        'std'         => $social_icon['icon'],
        'type'        => 'text',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
 $options[] = array(
        'id'          => 'header_social_link_'.$i,
        'name'       => __( 'Social Icon Link', 'alchem' ).' '.$i,
        'desc'        => '',
        'std'         => $social_icon['link'],
        'type'        => 'text',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );

	 $i++;
	 }
	endif;	
	
		
 $options[] =  array(
        'id'          => 'top_bar_social_icons_color',
        'name'       => __( 'Social Icons Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        
      );
$options[] = array(
        'id'          => 'top_bar_social_icons_tooltip_position',
        'name'       => __( 'Social Icon Tooltip Position', 'alchem' ),
        'desc'        => '',
        'std'         => 'bottom',
        'type'        => 'select',
        'section'     => 'header_tab_section',
        'class'       => 'accordion-group-item accordion-group-3',
        'options'     => array( 
          'left'     => __( 'left', 'alchem' ),
            
		   'right'     => __( 'right', 'alchem' ),
            
          'bottom'     => __( 'bottom', 'alchem' ),
           
        ),
	
      );
		
// Sticky Header
 $options[] =   array(
		'icon' => 'fa-thumb-tack', 
		'name' => __('Sticky Header', 'alchem'),
		'type' => 'heading'
		);
		
		
$options[] =  array(
        'id'          => 'enable_sticky_header',
        'name'       => __( 'Enable Sticky Header', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] = array(
        'id'          => 'enable_sticky_header_tablets',
        'name'       => __( 'Enable Sticky Header on Tablets', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] = array(
        'id'          => 'enable_sticky_header_mobiles',
        'name'       => __( 'Enable Sticky Header on Mobiles', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
		
$options[] =  array(
        'id'          => 'sticky_header_opacity',
        'name'       => __( 'Sticky Header Opacity', 'alchem' ),
        'desc'        => '',
        'std'         => '0.7',
        'type'        => 'select',
        'section'     => 'sticky_header_tab_section',
        'options' =>$opacity,
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'sticky_header_menu_item_padding',
        'name'       => __( 'Sticky Header Menu Item Padding', 'alchem' ),
        'desc'        => __( 'Controls the space between each menu item in the sticky header. Use a number without \'px\', default is 0. ex: 10', 'alchem' ),
        'std'         => '0',
        'type'        => 'text',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'sticky_header_navigation_font_size',
        'name'       => __( 'Sticky Header Navigation Font Size', 'alchem' ),
        'desc'        => __( 'Controls the font size of the menu items in the sticky header. Use a number without \'px\', default is 14. ex: 14', 'alchem' ),
        'std'         => '14',
        'type'        => 'text',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'sticky_header_logo_width',
        'name'       => __( 'Sticky Header Logo Width', 'alchem' ),
        'desc'        => __( 'Controls the logo width in the sticky header. Use a number without \'px\'.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'sticky_header_tab_section',
        
        'class'       => '',
        
      );
	
	//// logo
$options[] =  array(
		'icon' => 'fa-star', 
		'name' => __('Logo', 'alchem'),
		'type' => 'heading'
		);
$options[] = array(
        'id'          => 'logo',
        'name'       => __( 'Logo', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'logo_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );
$options[] = array(
        'id'          => 'default_logo',
        'name'       => __( 'Upload Logo', 'alchem' ),
        'desc'        => __( 'Select an image file for your logo.', 'alchem' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
	
$options[] =  array(
        'id'          => 'default_logo_retina',
        'name'       => __( 'Upload Logo (Retina Version @2x)', 'alchem' ),
        'desc'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'alchem' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'retina_logo_width',
        'name'       => __( 'Standard Logo Width for Retina Logo', 'alchem' ),
        'desc'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );

$options[] =  array(
        'id'          => 'retina_logo_height',
        'name'       => __( 'Standard Logo Height for Retina Logo', 'alchem' ),
        'desc'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
	
$options[] =  array(
        'id'          => 'sticky_header_logo',
        'name'       => __( 'Sticky Header Logo', 'alchem' ).' <span data-accordion="accordion-group-4" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'logo_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
$options[] = array(
        'id'          => 'sticky_logo',
        'name'       => __( 'Upload Logo', 'alchem' ),
        'desc'        => __( 'Select an image file for your logo.', 'alchem' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'logo_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-4',
        
      );
	
$options[] =  array(
        'id'          => 'sticky_logo_retina',
        'name'       => __( 'Upload Logo (Retina Version @2x)', 'alchem' ),
        'desc'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'alchem' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'logo_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-4',
        
      );
$options[] = array(
        'id'          => 'sticky_logo_width_for_retina_logo',
        'name'       => __( 'Sticky Logo Width for Retina Logo', 'alchem' ),
        'desc'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-4',
        
      );
$options[] = array(
        'id'          => 'sticky_logo_height_for_retina_logo',
        'name'       => __( 'Sticky Logo Height for Retina Logo', 'alchem' ),
        'desc'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-4',
        
      );
	
$options[] =  array(
        'id'          => 'logo_left_margin',
        'name'       => __( 'Logo Left Margin', 'alchem' ),
        'desc'        => __( 'Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'logo_right_margin',
        'name'       => __( 'Logo Right Margin', 'alchem' ),
        'desc'        => __( 'Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'logo_top_margin',
        'name'       => __( 'Logo Top Margin', 'alchem' ),
        'desc'        => __( 'Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'logo_bottom_margin',
        'name'       => __( 'Logo Bottom Margin', 'alchem' ),
        'desc'        => __( 'Use a number without \'px\', ex: 40', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'logo_tab_section',
        
        'class'       => '',
        
      );
	
	// Favicon Options
$options[] =  array(
		'icon' => 'fa-heart', 
		'name' => __('Favicon Options', 'alchem'),
		'type' => 'heading'
		);
	 
$options[] =  array(
        'id'          => 'default_favicon',
        'name'       => __( 'Upload Favicon', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'favicon_options_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'iphone_favicon',
        'name'       => __( 'Favicon for Iphone', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'favicon_options_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'iphone_retina_favicon',
        'name'       => __( 'Favicon for Iphone (Retina Version @2x)', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'favicon_options_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'ipad_favicon',
        'name'       => __( 'Favicon for Ipad', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'favicon_options_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'ipad_retina_favicon',
        'name'       => __( 'Favicon for Ipad (Retina Version @2x)', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'favicon_options_tab_section',
        
        'class'       => '',
        
      );
   

// page title bar options
$options[] =  array(
		'icon' => 'fa-list-alt', 
		'name' => __('Page Title Bar', 'alchem'),
		'type' => 'heading'
		);
$options[] = array(
        'id'          => 'page_title_bar_options',
        'name'       => __( 'Page Title Bar Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'page_title_bar_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );
$options[] =  array(
        'id'          => 'enable_page_title_bar',
        'name'       => __( 'Enable Page Title Bar', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
   
$options[] =  array(
        'id'          => 'page_title_bar_top_padding',
        'name'       => __( 'Page Title Bar Top Padding', 'alchem' ),
        'desc'        => __( 'In pixels, ex: 210px', 'alchem' ),
        'std'         => '210px',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => 'mini',
        
      );
   
$options[] =  array(
        'id'          => 'page_title_bar_bottom_padding',
        'name'       => __( 'Page Title Bar Bottom Padding', 'alchem' ),
        'desc'        => __( 'In pixels, ex: 160px', 'alchem' ),
        'std'         => '160px',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => 'mini',
        
      );
$options[] =  array(
        'id'          => 'page_title_bar_mobile_top_padding',
        'name'       => __( 'Page Title Bar Mobile Top Padding', 'alchem' ),
        'desc'        => __( 'In pixels, ex: 70px', 'alchem' ),
        'std'         => '70px',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => 'mini',
        
      );
   
$options[] =  array(
        'id'          => 'page_title_bar_mobile_bottom_padding',
        'name'       => __( 'Page Title Bar Mobile Bottom Padding', 'alchem' ),
        'desc'        => __( 'In pixels, ex: 50px', 'alchem' ),
        'std'         => '50px',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => 'mini',
        
      );

$options[] =  array(
        'id'          => 'page_title_bar_background',
        'name'       => __( 'Page Title Bar Background', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'page_title_bar_retina_background',
        'name'       => __( 'Page Title Bar Background (Retina Version @2x)', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        
      );
   
$options[] =  array(
        'id'          => 'page_title_bg_full',
        'name'       => __( '100% Background Image', 'alchem' ),
        'desc'        => __( 'Select yes to have the page title bar background image display at 100% in width and height and scale according to the browser size.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] = array(
        'id'          => 'page_title_bg_parallax',
        'name'       => __( 'Parallax Background Image', 'alchem' ),
        'desc'        => __( 'Select yes to enable parallax background image when scrolling.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
	
$options[] =  array(
        'id'          => 'page_title_align',
        'name'       => __( 'Page Title Align', 'alchem' ),
        'desc'        => '',
        'std'         => 'left',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $align
      );
	
$options[] =   array(
        'id'          => 'breadcrumb_options',
        'name'       => __( 'Breadcrumb Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'page_title_bar_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );
 
 $options[] =  array(
        'id'          => 'display_breadcrumb',
        'name'       => __( 'Display breadcrumb', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] =  array(
        'id'          => 'breadcrumbs_on_mobile_devices',
        'name'       => __( 'Breadcrumbs on Mobile Devices', 'alchem' ),
        'desc'        => __( 'Check to display breadcrumbs on mobile devices.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'breadcrumb_menu_prefix',
        'name'       => __( 'Breadcrumb Menu Prefix', 'alchem' ),
        'desc'        => __( 'The text before the breadcrumb menu.', 'alchem' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'breadcrumb_menu_separator',
        'name'       => __( 'Breadcrumb Menu Separator', 'alchem' ),
        'desc'        => __( 'Choose a separator between the single breadcrumbs.', 'alchem' ),
        'std'         => '/',
        'type'        => 'text',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'breadcrumb_show_post_type_archive',
        'name'       => __( 'Show Custom Post Type Archives on Breadcrumbs', 'alchem' ),
        'desc'        => __( 'Check to display custom post type archives in the breadcrumb path.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'breadcrumb_show_categories',
        'name'       => __( 'Show Post Categories on Breadcrumbs', 'alchem' ),
        'desc'        => __( 'Check to display custom post type archives in the breadcrumb path.', 'alchem' ),
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'page_title_bar_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
 
 // footer
 $options[] =  array(
		'icon' => 'fa-hand-o-down', 
		'name' => __('Footer', 'alchem'),
		'type' => 'heading'
		);

 
$options[] =   array(
        'id'          => 'general_footer_options',
        'name'       => __( 'General Footer Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'footer_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );
$options[] =  array(
        'id'          => 'footer_special_effects',
        'name'       => __( 'Footer Special Effects', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => array( 
          'none'     => __( 'None', 'alchem' ),
            
          'footer_sticky'     => __( 'Sticky Footer', 'alchem' ),
           
        ),
	
      );
 

$options[] =  array(
        'id'          => 'footer_widgets_area_options',
        'name'       => __( 'Footer Widgets Area Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'footer_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );

$options[] =  array(
        'id'          => 'display_footer_widgets',
        'name'       => __( 'Display footer widgets?', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] =  array(
        'id'          => 'footer_columns',
        'name'       => __( 'Number of Footer Columns', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => array( 
          '1'     => '1',
            
          '2'     => '2',
            
          '3'     => '3',
            
          '4'     => '4',
           
        ),
	
      );
$options[] =  array(
        'id'          => 'footer_background_image',
        'name'       => __( 'Upload Background Image', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'footer_bg_full',
        'name'       => __( '100% Background Image', 'alchem' ),
        'desc'        => __( 'Select yes to have the footer widgets area background image display at 100% in width and height and scale according to the browser size.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'footer_parallax_background',
        'name'       => __( 'Parallax Background Image', 'alchem' ),
        'desc'        => '',
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'footer_background_repeat',
        'name'       => __( 'Background Repeat', 'alchem' ),
        'desc'        => '',
        'std'         => 'repeat',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $repeat
      );
$options[] =  array(
        'id'          => 'footer_background_position',
        'name'       => __( 'Background Position', 'alchem' ),
        'desc'        => '',
        'std'         => 'top left',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $position
      );
$options[] =  array(
        'id'          => 'footer_top_padding',
        'name'       => __( 'Footer Top Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '60px',
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'footer_bottom_padding',
        'name'       => __( 'Footer Bottom Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '40px',
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'copyright_options',
        'name'       => __( 'Copyright Options', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'footer_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );
$options[] =  array(
        'id'          => 'display_copyright_bar',
        'name'       => __( 'Display Copyright Bar', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] =  array(
        'id'          => 'copyright_text',
        'name'       => __( 'Copyright Text', 'alchem' ),
        'desc'        => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'alchem' ),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'footer_tab_section',
        'rows'        => '4',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'copyright_top_padding',
        'name'       => __( 'Copyright Top Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '40px',
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'copyright_bottom_padding',
        'name'       => __( 'Copyright Bottom Padding', 'alchem' ),
        'desc'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'alchem' ),
        'std'         => '40px',
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
 
$options[] =  array(
        'id'          => 'social_icon_options',
        'name'       => __( 'Social Icon Options', 'alchem' ).' <span data-accordion="accordion-group-footer_social" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'footer_tab_section',
        'rows'        => '4',
        'class'       => 'sub_section_titled section-accordion close',
        
      );

if( $social_icons ):
$i = 1;
 foreach($social_icons as $social_icon){
	
	 $options[] =  array(
        'id'          => 'footer_social_title_'.$i,
        'name'       => __( 'Social Title', 'alchem' ) .' '.$i,
        'desc'        => '',
        'std'         => $social_icon['title'],
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        'class'       => 'accordion-group-item accordion-group-footer_social',
        
      );
 $options[] = array(
        'id'          => 'footer_social_icon_'.$i,
        'name'       => __( 'Social Icon', 'alchem' ).' '.$i,
        'desc'        => __( 'FontAwesome Icon', 'alchem' ),
        'std'         => $social_icon['icon'],
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        'class'       => 'accordion-group-item accordion-group-footer_social',
        
      );
 $options[] = array(
        'id'          => 'footer_social_link_'.$i,
        'name'       => __( 'Social Icon Link', 'alchem' ).' '.$i,
        'desc'        => '',
        'std'         => $social_icon['link'],
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        'class'       => 'accordion-group-item accordion-group-footer_social',
        
      );

	 $i++;
	 }
	endif;	
$options[] =  array(
        'id'          => 'footer_social_icons_color',
        'name'       => __( 'Social Icons Color', 'alchem' ),
        'desc'        => '',
        'std'         => '#c5c7c9',
        'type'        => 'color',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
		
$options[] =  array(
        'id'          => 'footer_social_icons_boxed',
        'name'       => __( 'Social Icons Boxed', 'alchem' ),
        'desc'        => '',
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => $choices
      );
$options[] = array(
        'id'          => 'footer_social_icons_box_color',
        'name'       => __( 'Social Icons Box Color', 'alchem' ),
        'desc'        => '',
        'std'         => '#ffffff',
        'type'        => 'color',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
$options[] = array(
        'id'          => 'footer_social_icons_boxed_radius',
        'name'       => __( 'Social Icons Boxed Radius', 'alchem' ),
        'desc'        => __( 'In pixels, ex: 10px.', 'alchem' ),
        'std'         => '10px',
        'type'        => 'text',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        
      );
		 
$options[] =  array(
        'id'          => 'footer_social_icons_tooltip_position',
        'name'       => __( 'Social Icon Tooltip Position', 'alchem' ),
        'desc'        => '',
        'std'         => 'top',
        'type'        => 'select',
        'section'     => 'footer_tab_section',
        
        'class'       => '',
        'options'     => array( 
          'top'     => __( 'Top', 'alchem' ),
            
          'bottom'     => __( 'Bottom', 'alchem' ),
           
        ),
	
      );


 //Sidebar
 
$options[] =  array(
		'icon' => 'fa-columns', 
		'name' => __('Sidebar', 'alchem'),
		'type' => 'heading'
		);
$options[] =  array(
        'id'          => 'sidebar_pages',
        'name'       => __( 'Pages', 'alchem' ).' <span data-accordion="accordion-group-5" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'sidebar_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
 
$options[] =  array(
        'id'          => 'left_sidebar_pages',
        'name'       => __( 'Left Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-5',
        'options'     => $sidebars,
	
      );
$options[] =  array(
        'id'          => 'right_sidebar_pages',
        'name'       => __( 'Right Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-5',
        'options'     => $sidebars,
	
      );
 

 
 //
$options[] =  array(
        'id'          => 'sidebar_blog_posts',
        'name'       => __( 'Blog Posts', 'alchem' ).' <span data-accordion="accordion-group-8" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'sidebar_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
 
$options[] =  array(
        'id'          => 'left_sidebar_blog_posts',
        'name'       => __( 'Left Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-8',
        'options'     => $sidebars,
	
      );
$options[] =  array(
        'id'          => 'right_sidebar_blog_posts',
        'name'       => __( 'Right Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-8',
        'options'     => $sidebars,
	
      );
 //
 
 
 //
$options[] =  array(
        'id'          => 'sidebar_blog_archive',
        'name'       => __( 'Blog Archive Category Pages', 'alchem' ).' <span data-accordion="accordion-group-10" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'sidebar_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
 
$options[] =  array(
        'id'          => 'left_sidebar_blog_archive',
        'name'       => __( 'Left Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-10',
        'options'     => $sidebars,
	
      );
$options[] =  array(
        'id'          => 'right_sidebar_blog_archive',
        'name'       => __( 'Right Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-10',
        'options'     => $sidebars,
	
      );

 
    //Sidebar search'
$options[] =  array(
        'id'          => 'sidebar_search',
        'name'       => __( 'Search Page', 'alchem' ).' <span data-accordion="accordion-group-14" class="fa fa-plus"></span>',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'sidebar_tab_section',
        'rows'        => '4',
        
        'class'       => 'section-accordion close',
        
      );
 
$options[] =  array(
        'id'          => 'left_sidebar_search',
        'name'       => __( 'Left Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-14',
        'options'     => $sidebars,
	
      );
$options[] =  array(
        'id'          => 'right_sidebar_search',
        'name'       => __( 'Right Sidebar', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'sidebar_tab_section',
        
        'class'       => 'accordion-group-item accordion-group-14',
        'options'     => $sidebars,
	
      );
 
 
 
 // Background
$options[] =  array(
		'icon' => 'fa-photo', 
		'name' => __('Background', 'alchem'),
		'type' => 'heading'
		);
 
$options[] =  array(
        'id'          => 'background_boxed',
        'name'       => __( 'BACKGROUND OPTIONS BELOW ONLY WORK IN BOXED MODE', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'background_tab_section',
        'rows'        => '4',
        
        'class'       => 'sub_section_titled',
        
      );

$options[] =  array(
        'id'          => 'bg_image_upload',
        'name'       => __( 'Background Image For Outer Areas In Boxed Mode', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        
      );
 
$options[] =  array(
        'id'          => 'bg_full',
        'name'       => __( '100% Background Image', 'alchem' ),
        'desc'        => __( 'Select yes to have the background image display at 100% in width and height and scale according to the browser size.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'bg_repeat',
        'name'       => __( 'Background Repeat', 'alchem' ),
        'desc'        => '',
        'std'         => 'repeat',
        'type'        => 'select',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        'options'     => $repeat
      );
 
$options[] =  array(
        'id'          => 'bg_color',
        'name'       => __( 'Background Color For Outer Areas In Boxed Mode', 'alchem' ),
        'desc'        => '',
        'std'         => '#ffffff',
        'type'        => 'color',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        
      );
 
$options[] =  array(
        'id'          => 'bg_pattern_option',
        'name'       => __( 'Background Pattern', 'alchem' ),
        'desc'        => __( 'Select yes to display a pattern in the background. If \'yes\' is selected, select the pattern from below.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );

$options[] =  array(
		'name' => __( 'Select a Background Pattern', 'alchem' ),
		'desc' => "",
		'id' => "bg_pattern",
		'std' => "1",
		'type' => "images",
		'options' => array(
			'1' => $imagepath . 'patterns/pattern1.png',
			'2' => $imagepath . 'patterns/pattern2.png',
			'3' => $imagepath . 'patterns/pattern3.png',
			'4' => $imagepath . 'patterns/pattern4.png',
			'5' => $imagepath . 'patterns/pattern5.png',
			'6' => $imagepath . 'patterns/pattern6.png',
			'7' => $imagepath . 'patterns/pattern7.png',
			'8' => $imagepath . 'patterns/pattern8.png',
			'9' => $imagepath . 'patterns/pattern9.png',
			'10' => $imagepath . 'patterns/pattern10.png',
		)
	);
 
$options[] =  array(
        'id'          => 'background_wide',
        'name'       => __( 'BACKGROUND OPTIONS BELOW WORK FOR BOXED & WIDE MODE', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'background_tab_section',
        'rows'        => '4',
        'class'       => 'sub_section_titled',
        
      );
$options[] =  array(
        'id'          => 'content_bg_image',
        'name'       => __( 'Background Image For Main Content Area', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        
      );
 
$options[] =  array(
        'id'          => 'content_bg_full',
        'name'       => __( '100% Background Image', 'alchem' ),
        'desc'        => __( 'Select yes to have the background image display at 100% in width and height and scale according to the browser size.', 'alchem' ),
        'std'         => 'no',
        'type'        => 'select',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        'options'     => $choices_reverse
      );
$options[] =  array(
        'id'          => 'content_bg_repeat',
        'name'       => __( 'Background Repeat', 'alchem' ),
        'desc'        => '',
        'std'         => 'repeat',
        'type'        => 'select',
        'section'     => 'background_tab_section',
        
        'class'       => '',
        'options'     => $repeat
      );
 
	


// slidershow

$options[] =  array(
		'icon' => 'fa-sliders',
		'name' => __('Slider Settings', 'alchem'),
		'type' => 'heading'
		);
 
$options[] =  array(
        'id'          => 'slider_autoplay',
        'name'       => __( 'Autoplay', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => '',
        'options'     =>  $choices
	
      );

$options[] =  array(
        'id'          => 'slideshow_speed',
        'name'       => __( 'Slideshow Speed', 'alchem' ),
        'desc'        => __( 'Controls the speed of slideshows for the [alchem_slider] shortcode and sliders within posts. ex: 1000 = 1 second.', 'alchem' ),
        'std'         => '3000',
        'type'        => 'text',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => 'mini',
        
      );
$options[] =  array(
        'id'          => 'display_slider_pagination',
        'name'       => __( 'Display Slider Pagination', 'alchem' ),
        'desc'        => '',
        'std'         => 'yes',
        'type'        => 'select',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => '',
        'options'     =>  $choices
	
      );
$options[] =  array(
        'id'          => 'caption_font_color',
        'name'       => __( 'Caption Font Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => '',
        
      );

$options[] =  array(
        'id'          => 'caption_heading_color',
        'name'       => __( 'Caption Heading h1-h6 Font Color', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'color',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => '',
        
      );
$options[] =  array(
        'id'          => 'caption_font_size',
        'name'       => __( 'Caption Font Size', 'alchem' ),
        'desc'        => '',
        'std'         => '14px',
        'type'        => 'text',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => 'mini',
        'options'     =>  ''
	
      );
/*array(
        'id'          => 'caption_width',
        'name'       => __( 'Caption Width', 'alchem' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => 'mini',
        'options'     =>  ''
	
      ),*/
$options[] =  array(
        'id'          => 'caption_alignment',
        'name'       => __( 'Caption Alignment', 'alchem' ),
        'desc'        => '',
        'std'         => 'left',
        'type'        => 'select',
        'section'     => 'slider_settings_tab_section',
        
        'class'       => '',
        'options'     =>  $align,
	
      );

// 404
$options[] =  array(
		'icon' => 'fa-frown-o',
		'name' => __('404 Page', 'alchem'),
		'type' => 'heading'
		);
$options[] =  array(
        'id'          => 'title_404',
        'name'       => __( '404 Page Title', 'alchem' ),
        'desc'        => '',
        'std'         => 'OOPS!',
        'type'        => 'text',
        'section'     => 'notfound_tab_section',
        
        'class'       => '',
        'options'     =>  ''
	
      );

$options[] =  array(
        'id'          => 'content_404',
        'name'       => __( '404 Page Content', 'alchem' ),
        'desc'        => '',
        'std'         => '<h1>OOPS!</h1><p>Can\'t find the page.</p>',
        'type'        => 'editor',
        'section'     => 'notfound_tab_section',
        
        'class'       => '',
        'options'     =>  ''
	
      );

$options[] =  array(
        'id'          => 'page_404_sidebar',
        'name'       => __( 'Sidebar Position', 'alchem' ),
        'desc'        => '',
        'std'         => 'none',
        'type'        => 'select',
        'section'     => 'notfound_tab_section',
        
        'class'       => '',
        'options'     => array( 
		  'none'     => __( 'None', 'alchem' ),
            
          'left'     => __( 'Left', 'alchem' ),
            
          'right'     => __( 'Right', 'alchem' ),
            
          'both'     => __( 'Both', 'alchem' ),
            
          
         
        ),
	
      );

//Custom CSS
$options[] =  array(
		'icon' => 'fa-css3',
		'name' => __('Custom CSS', 'alchem'),
		'type' => 'heading'
		);
$options[] =  array(
        'id'          => 'custom_css',
        'name'       => __( 'Custom CSS', 'alchem' ),
        'desc'        => '',
        'std'         => '#custom {
			}',
        'type'        => 'textarea',
        'section'     => 'custom_css_tab_section',
        'rows'        => '20',
        
        'class'       => '',
        
      );


	return $options;
}