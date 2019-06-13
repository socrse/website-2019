<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package nopasare
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function alchem_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'alchem_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alchem_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	if ( is_front_page() ){
		$classes[] = 'has-slider';
	}

	return $classes;
}
add_filter( 'body_class', 'alchem_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
/*function alchem_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'alchem' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'alchem_wp_title', 10, 2 );*/


if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function alchem_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'alchem_slug_render_title' );
}


  function alchem_title( $title ) {
  if ( $title == '' ) {
  return __('Untitled','alchem'); 
  } else {
  return $title;
  }
  }
  add_filter( 'the_title', 'alchem_title' );
  

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function alchem_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'alchem_setup_author' );
global $wp_embed;
add_filter( 'the_excerpt', array( $wp_embed, 'autoembed' ), 9 );

function alchem_add_pages_link( $content ){
	$pages = wp_link_pages( 
		array( 
			'before' => '<div>' . __( 'Page: ', 'alchem' ),
			'after' => '</div>',
			'echo' => false ) 
	);
	if ( $pages == '' ){
		return $content;
	}
	return $content . $pages;
}
add_filter( 'the_content', 'alchem_add_pages_link' );

add_filter( 'the_password_form', 'alchem_password_form' );
function alchem_password_form(){
    global $post;
    
    $form = '
    <form class="password-form" action="/wp-login.php?action=postpass" method="post">
    <p>' . __( 'This post is password protected. To read it please enter the password below.', 'alchem' ) . '</p>
    <input type="password" value="" name="post_password" id="password-' . $post->ID . '"/>
    </form>';
    return $form;
}

add_action( 'widgets_init', 'alchem_widgets' );
function alchem_widgets(){
	global $sidebars ;
	  $sidebars =   array(
            ''  => __( 'No Sidebar', 'alchem' ),
		    'default_sidebar'  => __( 'Default Sidebar', 'alchem' ),
			'sidebar-1'  => __( 'Sidebar 1', 'alchem' ),
			'sidebar-2'  => __( 'Sidebar 2', 'alchem' ),
			'sidebar-3'  => __( 'Sidebar 3', 'alchem' ),
			'sidebar-4'  => __( 'Sidebar 4', 'alchem' ),
			'sidebar-5'  => __( 'Sidebar 5', 'alchem' ),
			'sidebar-5'  => __( 'Sidebar 5', 'alchem' ),
			'sidebar-6'  => __( 'Sidebar 6', 'alchem' ),
			'footer_widget_1'  => __( 'Footer Widget 1', 'alchem' ),
			'footer_widget_2'  => __( 'Footer Widget 2', 'alchem' ),
			'footer_widget_3'  => __( 'Footer Widget 3', 'alchem' ),
			'footer_widget_4'  => __( 'Footer Widget 4', 'alchem' ),
			'left_sidebar_404'  => __( '404 Page Left Sidebar', 'alchem' ),
			'right_sidebar_404'  => __( '404 Page Right Sidebar', 'alchem' ),
          );
	  
	  foreach( $sidebars as $k => $v ){
		  if( $k !='' ){
		  register_sidebar(array(
			'name' => $v,
			'id'   => $k,
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		  }
		  }
	    
		
		
		
}


/**
 * Convert Hex Code to RGB
 * @param  string $hex Color Hex Code
 * @return array       RGB values
 */
 
function alchem_hex2rgb( $hex ) {
		if ( strpos( $hex,'rgb' ) !== FALSE ) {

			$rgb_part = strstr( $hex, '(' );
			$rgb_part = trim($rgb_part, '(' );
			$rgb_part = rtrim($rgb_part, ')' );
			$rgb_part = explode( ',', $rgb_part );

			$rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

		} elseif( $hex == 'transparent' ) {
			$rgb = array( '255', '255', '255', '0' );
		} else {

			$hex = str_replace( '#', '', $hex );

			if( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );
		}

		return $rgb; // returns an array with the rgb values
	}




add_filter('upload_mimes', 'alchem_filter_mime_types');
function alchem_filter_mime_types($mimes)
{
	$mimes['ttf'] = 'font/ttf';
	$mimes['woff'] = 'font/woff';
	$mimes['svg'] = 'font/svg';
	$mimes['eot'] = 'font/eot';

	return $mimes;
}


/* =============================================================================
Include the  Google Fonts 
========================================================================== */



global $of_options,$default_theme_fonts;

   // default fonts used in this theme, even though there are no google fonts
   $default_theme_fonts = array(

            'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
            "'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
            "'Bookman Old Style', serif" => "'Bookman Old Style', serif",
            "'Comic Sans MS', cursive" => "'Comic Sans MS', cursive",
            "Courier, monospace" => "Courier, monospace",
            "Garamond, serif" => "Garamond, serif",
            "Georgia, serif" => "Georgia, serif",
            "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
            "'MS Sans Serif', Geneva, sans-serif" => "'MS Sans Serif', Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif" => "'MS Serif', 'New York', sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
            "Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
            "'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
            "'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
			
   );

 defined('OF_FONT_DEFAULTS') or define('OF_FONT_DEFAULTS', serialize($default_theme_fonts));


include_once( get_template_directory().'/inc/google-fonts.php' );
global $google_fonts_array;

function of_filter_recognized_font_families( $array, $field_id ) {
  
  global $google_fonts_array;
  
  // loop through the cached google font array if available and append to default fonts
  $font_array = array();
  if($google_fonts_array){
  foreach($google_font_array as $index => $value){
  $font_array[$value['family']] = $value['family'];
  }
  }
  
  // put both arrays together
  $array = array_merge(unserialize(OF_FONT_DEFAULTS), $font_array);
  
  return $array;
  
}


// get  typography


 function alchem_get_typography($value){
 global $google_fonts_array,$default_theme_fonts;
 $return = "";
if ( is_array($value) && alchem_array_keys_exists( $value, array( 'font-color', 'font-family', 'font-size', 'font-style', 'font-variant', 'font-weight', 'letter-spacing', 'line-height', 'text-decoration', 'text-transform' ) ) ) {
          $font = array();
          
          if ( ! empty( $value['font-color'] ) )
            $font[] = "color: " . $value['font-color'] . " !important;";
          
		  
          if ( ! empty( $value['font-family'] ) ) {
		        if( isset($google_fonts_array[$value['font-family']]) )
                $font[] = "font-family: " . $google_fonts_array[$value['font-family']]['family'] . ";";
				else
				$font[] = "font-family: " . $default_theme_fonts[$value['font-family']] . ";";
          }
          
          if ( ! empty( $value['font-size'] ) )
            $font[] = "font-size: " . $value['font-size'] . ";";
          
          if ( ! empty( $value['font-style'] ) )
            $font[] = "font-style: " . $value['font-style'] . ";";
          
          if ( ! empty( $value['font-variant'] ) )
            $font[] = "font-variant: " . $value['font-variant'] . ";";
          
          if ( ! empty( $value['font-weight'] ) )
            $font[] = "font-weight: " . $value['font-weight'] . ";";
            
          if ( ! empty( $value['letter-spacing'] ) )
            $font[] = "letter-spacing: " . $value['letter-spacing'] . ";";
          
          if ( ! empty( $value['line-height'] ) )
            $font[] = "line-height: " . $value['line-height'] . ";";
          
          if ( ! empty( $value['text-decoration'] ) )
            $font[] = "text-decoration: " . $value['text-decoration'] . ";";
          
          if ( ! empty( $value['text-transform'] ) )
            $font[] = "text-transform: " . $value['text-transform'] . ";";
          
          /* set $value with font properties or empty string */
          $return = ! empty( $font ) ? implode( " ", $font ) : '';

        } 
		return $return;
		}



/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function alchem_get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', 'alchem');
    if ( false === $one ) $one = __( '1 Comment', 'alchem');
    if ( false === $more ) $more = __( '% Comments', 'alchem');
    if ( false === $none ) $none = __( 'Comments Off', 'alchem');
 
    $number = get_comments_number( $id );
 
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
	
 
    if ( post_password_required() ) {
     
        return '';
    }
 
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else { // if comments_popup_script() is not in the template, display simple comment link
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $css_class ) ) {
        $str .= ' class="'.$css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'alchem'), $title ) ) . '">';
    $str .= alchem_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function alchem_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'alchem') : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', 'alchem') : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', 'alchem') : $one;
 
    return apply_filters('comments_number', $output, $number);
}

// get summary

 function alchem_get_summary(){
	 
	 $excerpt_or_content        = alchem_option('excerpt_or_content','excerpt');
	 $excerpt_length            = alchem_option('excerpt_length','55');
	 if( $excerpt_or_content == 'full_content' ){
	 $output = get_the_content();
	 }
	 else{
	 $output = get_the_excerpt();
	 if( is_numeric($excerpt_length) && $excerpt_length !=0  )
	 $output = alchem_content_length($output, $excerpt_length );
	 }
	 return  $output;
	 }
	 
 function alchem_content_length($content, $limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
    }

// get post content css class
 function alchem_get_content_class( $sidebar = '' ){
	 
	 if( $sidebar == 'left' )
	 return 'left-aside';
	 if( $sidebar == 'right' )
	 return 'right-aside';
	 if( $sidebar == 'both' )
	 return 'both-aside';
	  if( $sidebar == 'none' )
	 return 'no-aside';
	 
	 return 'no-aside';
	 
	 }
	

 // get breadcrumbs
 function alchem_get_breadcrumb( $options = array()){
   global $post,$wp_query ;
    $postid = isset($post->ID)?$post->ID:"";
	
   $show_breadcrumb = "";
   if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) { 
    $postid = $wp_query->get_queried_object_id();
   }
  
   if(isset($postid) && is_numeric($postid)){
    $show_breadcrumb = get_post_meta( $postid, '_alchem_show_breadcrumb', true );
	}
	if($show_breadcrumb == 'yes' || $show_breadcrumb==""){

               alchem_breadcrumb_trail( $options);           
	}
	   
	}
	
	
 // footer tracking code
	
 function alchem_tracking_code(){
   $tracking_code = alchem_option('tracking_code');
   echo $tracking_code;
 } 

add_action('wp_footer', 'alchem_tracking_code'); 

 // Space before </head>
	
 function alchem_space_before_head(){
   $space_before_head = alchem_option('space_before_head');
   echo $space_before_head;
 } 

add_action('wp_head', 'alchem_space_before_head'); 


 // Space before </body>
	
 function alchem_space_before_body(){
   $space_before_body = alchem_option('space_before_body');
   echo $space_before_body;
 } 

add_action('wp_footer', 'alchem_space_before_body'); 

// get social icon

function alchem_get_social( $position, $class = 'top-bar-sns',$placement='top',$target='_blank'){
	global $social_icons;
   $return = '';
   $rel    = '';
   
   $social_links_nofollow  = alchem_option( 'social_links_nofollow','no' ); 
   $social_new_window = alchem_option( 'social_new_window','yes' );  
   if( $social_new_window == 'no')
   $target = '_self';
   
   if( $social_links_nofollow == 'yes' )
   $rel    = 'nofollow';
   
   if(is_array($social_icons) && !empty($social_icons)):
   $return .= '<ul class="'.esc_attr($class).'">';
   $i = 1;
   foreach($social_icons as $sns_list_item){
	 
		 $icon = alchem_option( $position.'_social_icon_'.$i,'' );  
		 $title = alchem_option( $position.'_social_title_'.$i,'' );
		 $link = alchem_option( $position.'_social_link_'.$i,'' );  
	if(  $icon !="" ){
	 $return .= '<li><a target="'.esc_attr($target).'" rel="'.$rel.'" href="'.esc_url($link).'" data-placement="'.esc_attr($placement).'" data-toggle="tooltip" title="'.esc_attr( $title).'"><i class="fa fa-'.esc_attr( $icon).'"></i></a></li>';
	} 
	$i++;
	} 
	$return .= '</ul>';
	endif;
	return $return ;
	}
	

// get top bar content

 function alchem_get_topbar_content( $type =''){

	 switch( $type ){
		 case "info":
		 echo '<div class="top-bar-info">';
		 echo alchem_option('top_bar_info_content');
		 echo '</div>';
		 break;
		 case "sns":
		 $tooltip_position = alchem_option('top_social_tooltip_position','bottom'); 
		 echo alchem_get_social('header','top-bar-sns',$tooltip_position);
		 break;
		 case "menu":
		 echo '<nav class="top-bar-menu">';
		 wp_nav_menu(array('theme_location'=>'top_bar_menu','depth'=>1,'fallback_cb' =>false,'container'=>'','container_class'=>'','menu_id'=>'','menu_class'=>'','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
		 echo '</nav>';
		 break;
		 case "none":
		
		 break;
		 }
	 }
	 
	// get related posts
	
 function alchem_get_related_posts($post_id, $number_posts = -1,$post_type = 'post') {
	$query = new WP_Query();

    $args = '';

	if($number_posts == 0) {
		return $query;
	}

	$args = wp_parse_args($args, array(
		'posts_per_page' => $number_posts,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'meta_key' => '_thumbnail_id',
        'category__in' => wp_get_post_categories($post_id),
		'post_type' =>$post_type 
	));

	$query = new WP_Query($args);

  	return $query;
}

// get favicon
 function alchem_favicon()
	{
	    $favicon                =  alchem_option('default_favicon');
		$iphone_favicon         =  alchem_option('iphone_favicon');
		$iphone_retina_favicon  =  alchem_option('iphone_retina_favicon');
		$ipad_favicon           =  alchem_option('ipad_favicon');
		$ipad_retina_favicon    =  alchem_option('ipad_retina_favicon');
		
		$detect = new Mobile_Detect;
		
		 if( $detect->is('ipad') && $ipad_favicon !='' )
		  $favicon = $ipad_favicon ;
		  
		if( $detect->is('iphone') && $iphone_favicon !='' )
	       $favicon = $iphone_favicon ;
		   
		$icon_link = "";
		if($favicon)
		{
			$type = "image/x-icon";
			if(strpos($favicon,'.png' )) $type = "image/png";
			if(strpos($favicon,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($favicon).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}
 add_action( 'wp_head', 'alchem_favicon' );
 
 // get nav memu search form
 function alchem_nav_searchform(){
	 echo get_search_form();
	 exit(0);
	 }
 add_action( 'wp_ajax_alchem_nav_searchform', 'alchem_nav_searchform' );
 add_action( 'wp_ajax_nopriv_alchem_nav_searchform', 'alchem_nav_searchform' );
 



// fix shortcodes

 function alchem_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']',
				']<br>' => ']',
				']\r\n' => ']',
				']\n' => ']',
				']\r' => ']',
				'\r\n[' => '[',
			);

			return strtr( $content, $replace_tags_from_to );
		}
		

	

//get page top slider

 function alchem_get_page_slider($slider_type,$css_class=""){
	  global  $page_meta;
	
	  $return       = '';
	  switch($slider_type){
		  case "layer":
		  if(isset($page_meta['layer_slider']) && is_numeric($page_meta['layer_slider']) && $page_meta['layer_slider']>0 )
		  $return        .= do_shortcode('[layerslider id="'.$page_meta['layer_slider'].'"]');
		  break;
		  case "rev":
		 
		   if(isset($page_meta['rev_slider']) && $page_meta['rev_slider'] !="" )
		  $return        .= do_shortcode('[rev_slider '.$page_meta['rev_slider'].']');
		  break;
		   case "magee_slider":
		  if(isset($page_meta['magee_slider']) && is_numeric($page_meta['magee_slider']) && $page_meta['magee_slider']>0 )
		  $return .= do_shortcode('[ms_slider id="'.$page_meta['magee_slider'].'"]');	  
		  break;
		  default:
		  return;
		  break;
		  }
	 echo  '<div class="slider-wrap"><div class="page-top-slider '.$css_class.'">'.$return.'</div></div>';
	 }
	 
 
 
/**
 * Infinite Scroll
 */
function alchem_infinite_scroll_js() {
    if( ! is_singular() ) { ?>
    <script>
	if( alchem_params.portfolio_grid_pagination_type == 'infinite_scroll' && typeof infinitescroll !=='undefined'){
    var infinite_scroll = {
        loading: {
            img: "<?php echo get_template_directory_uri(); ?>/images/AjaxLoader.gif",
            msgText: "<?php _e( 'Loading the next set of posts...', 'alchem' ); ?>",
            finishedMsg: "<?php _e( 'All posts loaded.', 'alchem' ); ?>"
        },
        "nextSelector":"a.next",
        "navSelector":".post-pagination",
        "itemSelector":".portfolio-box-wrap",
        "contentSelector":".portfolio-list-items"
    };
	
	jQuery('.portfolio-list-wrap .post-pagination').hide();
    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll,function(arrayOfNewElems){
			jQuery('.portfolio-box-wrap').css({ display: 'inline-block', opacity: 1});
			jQuery('#filters li span').removeClass('active');
			jQuery('#filters li:first span').addClass('active');
			jQuery("a[rel^='portfolio-image']").prettyPhoto();
			

      } );
	
	}
	if( alchem_params.blog_pagination_type == 'infinite_scroll' ){
		
		var infinite_scroll = {
        loading: {
            img: "<?php echo get_template_directory_uri(); ?>/images/AjaxLoader.gif",
            msgText: "<?php _e( 'Loading the next set of posts...', 'alchem' ); ?>",
            finishedMsg: "<?php _e( 'All posts loaded.', 'alchem' ); ?>"
        },
        "nextSelector":"a.next",
        "navSelector":".post-pagination",
        "itemSelector":".entry-box-wrap",
        "contentSelector":".blog-list-wrap"
    };
	
	jQuery('.blog-list-wrap .post-pagination').hide();
    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll );
		
		}
    </script>
    <?php
	
    }
}

add_action( 'wp_footer', 'alchem_infinite_scroll_js',100 );

function alchem_enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
	
			$tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />\n";
		}
		return $tag;
	}
add_filter( 'style_loader_tag', 'alchem_enqueue_less_styles', 5, 2);
	

	
	
 function alchem_colourBrightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

function alchem_sanitize_allowedposttags(){
	global $allowedposttags;
    $allowedposttags['span'] = array (
                        'class' => array (),
                        'dir' => array (),
                        'align' => array (),
                        'lang' => array (),
                        'style' => array (),
                        'title' => array (),
						'data-accordion' => array (),
                        'xml:lang' => array()
						
						);

}
add_action( 'admin_init', 'alchem_sanitize_allowedposttags' );



function alchem_optionscheck_change_santiziation() {

    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'alchem_of_sanitize_textarea_custom' );

}

function alchem_of_sanitize_textarea_custom($input) {

    global $allowedposttags;

        $of_custom_allowedtags["script"] = array(
             "type" => array(),  
			  "src" => array(), 
    );
      $of_custom_allowedtags["style"] = array(
             "type" => array(),  
    );
	   $of_custom_allowedtags["link"] = array(
             "rel" => array(),  
			  "href" => array(), 
			  "media" => array(), 
			  "type" => array(), 
    );
	  

        $of_custom_allowedtags = array_merge($of_custom_allowedtags, $allowedposttags);

        $output = wp_kses( $input, $of_custom_allowedtags);

    return $output;

}
add_action('admin_init','alchem_optionscheck_change_santiziation', 100); 

   /**
 * alchem admin panel menu
 */
 
   add_action( 'optionsframework_page_title_after','alchem_options_page_title' );

function alchem_options_page_title() { ?>

		          <ul class="options-links">
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/alchem-theme.html' ); ?>" target="_blank"><?php _e( 'Upgrade to Pro', 'alchem' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/wordpress-themes' ); ?>" target="_blank"><?php _e( 'MageeWP Themes', 'alchem' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/manuals/theme-guide-alchem.html' ); ?>" target="_blank"><?php _e( 'Manual', 'alchem' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/documents/faq/' ); ?>" target="_blank"><?php _e( 'FAQ', 'alchem' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/knowledges/' ); ?>" target="_blank"><?php _e( 'Knowledge', 'alchem' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.mageewp.com/forums/alchem-theme/' ); ?>" target="_blank"><?php _e( 'Support Forums', 'alchem' ); ?></a></li>
                  </ul>
      			
<?php
}