<?php

/**
 * Calls the class on the post edit screen.
 */
function alchem_call_metaboxClass() {
    new alchem_metaboxClass();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'alchem_call_metaboxClass' );
    add_action( 'load-post-new.php', 'alchem_call_metaboxClass' );
}

/** 
 * The Class.
 */
class alchem_metaboxClass {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'alchem_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'alchem_save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function alchem_add_meta_box( $post_type ) {
            $post_types = array( 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'some_meta_box_name'
			,__( 'Alchem Metabox Options', 'alchem' )
			,array( $this, 'alchem_render_meta_box_content' )
			,$post_type
			,'advanced'
			,'high'
		);
            }
	}
// get alchem sliders from plugin magee shrotcodes

 public static function alchem_sliders_meta(){
	 $alchem_sliders[] = array(
            'label'       => __( 'Select a slider', 'alchem' ),
            'value'       => ''
          );
	$alchem_custom_slider = new WP_Query( array( 'post_type' => 'magee_slider', 'post_status'=>'publish', 'posts_per_page' => -1 ) );
	while ( $alchem_custom_slider->have_posts() ) {
		$alchem_custom_slider->the_post();

		$alchem_sliders[] = array(
            'label'       => get_the_title(),
            'value'       => get_the_ID()
          );
	}
	wp_reset_postdata();
	return $alchem_sliders;
	 }
  
	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function alchem_save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		

		// Check if our nonce is set.
		if ( ! isset( $_POST['alchem_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['alchem_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'alchem_inner_custom_box' ) )
			return $post_id;
			
			

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		//$show_breadcrumb        = sanitize_text_field( $_POST['alchem_show_breadcrumb'] );
		//$alchem_layout          = sanitize_text_field( $_POST['alchem_layout'] );

		if( isset($_POST) && $_POST ){
			
			
		$post_metas                      = array();
		//$post_metas['header_position']   =  isset($_POST['header_position'])?$_POST['header_position']:'top';
		$post_metas['full_width']        =  isset($_POST['full_width'])?$_POST['full_width']:'no';
		$post_metas['padding_top']       =  isset($_POST['padding_top'])?$_POST['padding_top']:'';
		$post_metas['padding_bottom']    =  isset($_POST['padding_bottom'])?$_POST['padding_bottom']:'';
		$post_metas['display_title_bar'] =  isset($_POST['display_title_bar'])?$_POST['display_title_bar']:'yes';
		$post_metas['nav_menu']          =  isset($_POST['nav_menu'])?$_POST['nav_menu']:'';
		$post_metas['page_layout']       =  isset($_POST['page_layout'])?$_POST['page_layout']:'none';
		$post_metas['left_sidebar']      =  isset($_POST['left_sidebar'])?$_POST['left_sidebar']:'';
		$post_metas['right_sidebar']     =  isset($_POST['right_sidebar'])?$_POST['right_sidebar']:'';
		$post_metas['slider_banner']     =  isset($_POST['slider_banner'])?$_POST['slider_banner']:'0';
		$post_metas['banner_position']   =  isset($_POST['banner_position'])?$_POST['banner_position']:'1';
		$post_metas['magee_slider']      =  isset($_POST['magee_slider'])?$_POST['magee_slider']:'';
		
			 
		$alchem_post_meta = json_encode( $post_metas );
		// Update the meta field.
		update_post_meta( $post_id, '_alchem_post_meta', $alchem_post_meta );
		}

	
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function alchem_render_meta_box_content( $post ) {
	
	   global $wp_registered_sidebars;
	   
	   $magee_sliders = self::alchem_sliders_meta();
	   
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'alchem_inner_custom_box', 'alchem_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
	    $page_meta  = get_post_meta( $post->ID ,'_alchem_post_meta',true);
		if( $page_meta  ){
		$page_metas = @json_decode( $page_meta,true );
	    extract( $page_metas );
		}
	
		/************ get nav menus*************/
		
		$nav_menus[] = array(
            'label'       => __( 'Default', 'alchem' ),
            'value'       => ''
          );
		$menus = get_registered_nav_menus();
		
		foreach ( $menus as $location => $description ) {
		$nav_menus[] = array(
					'label'       => $description,
					'value'       => $location
				  );
			
		}
		
		/* sidebars */

	  $sidebars[] = array(
				  'label'       => __( 'Default', 'alchem' ),
				  'value'       => ''
				);
	  
	  foreach( $wp_registered_sidebars as $key => $value){
		  
		  $sidebars[] = array(
				  'label'       => $value['name'],
				  'value'       => $value['id'],
				);
		  }
		  
		 // $header_position = isset( $header_position )?$header_position:'top';
		  $full_width      = isset( $full_width )?$full_width:'no';
		  $padding_top     = isset( $padding_top )?$padding_top:'';
		  $padding_bottom  = isset( $padding_bottom )?$padding_bottom:'';
		  $display_title_bar = isset( $display_title_bar )?$display_title_bar:'yes';
		  $page_layout     = isset( $page_layout )?$page_layout:'none';
		  $slider_banner   = isset( $slider_banner )?$slider_banner:'0';
		  $banner_position = isset( $banner_position )?$banner_position:'1';
	
		  
		  
		// Display the form, using the current value.
		
		/*echo '<p class="meta-options"><label for="header_position"  style="display: inline-block;width: 150px;">';
		_e( 'Header Position', 'alchem' );
		echo '</label> ';
		echo '<select name="header_position" id="header_position">
		<option '.selected($header_position,'top',false).' value="top">'.__("Top","alchem").'</option>
		<option '.selected($header_position,'left',false).' value="left">'.__("Left","alchem").'</option>
		<option '.selected($header_position,'right',false).' value="right">'.__("Right","alchem").'</option>
		</select></p>';*/
		
		
		echo '<p class="meta-options"><label for="full_width"  style="display: inline-block;width: 150px;">';
		_e( 'Content Full Width', 'alchem' );
		echo '</label> ';
		echo '<select name="full_width" id="full_width">
		<option '.selected($full_width,'no',false).' value="no">'.__("No","alchem").'</option>
		<option '.selected($full_width,'yes',false).' value="yes">'.__("Yes","alchem").'</option>
		</select></p>';
		
		
		echo '<p class="meta-options"><label for="padding_top"  style="display: inline-block;width: 150px;">';
		_e( 'Padding Top', 'alchem' );
		echo '</label> ';
		echo '<input name="padding_top" id="padding_top" value="'.$padding_top.'" type="text" />';
		echo '</p>';
		
		echo '<p class="meta-options"><label for="padding_bottom"  style="display: inline-block;width: 150px;">';
		_e( 'Padding Bottom', 'alchem' );
		echo '</label> ';
		echo '<input name="padding_bottom" id="padding_bottom" value="'.$padding_bottom.'" type="text" />';
		echo '</p>';
		
		echo '<p class="meta-options"><label for="display_title_bar"  style="display: inline-block;width: 150px;">';
		_e( 'Display Title Bar', 'alchem' );
		echo '</label> ';
		echo '<select name="display_title_bar" id="display_title_bar">
		<option '.selected($display_title_bar,'yes',false).' value="yes">'.__("Yes","alchem").'</option>
		<option '.selected($display_title_bar,'no',false).' value="no">'.__("No","alchem").'</option>
		</select></p>';
		
		echo '<p class="meta-options"><label for="nav_menu"  style="display: inline-block;width: 150px;">';
		_e( 'Select Nav Menu', 'alchem' );
		echo '</label> ';
		echo '<select name="nav_menu" id="nav_menu">';
		foreach( $nav_menus as $nav_menu_item ){
		echo '<option '.selected($nav_menu,$nav_menu_item['value'],false).' value="'.$nav_menu_item['value'].'">'.$nav_menu_item['label'].'</option>';
		}
		echo '</select></p>';
		
		echo '<p class="meta-options"><label for="page_layout"  style="display: inline-block;width: 150px;">';
		_e( 'Page Layout', 'alchem' );
		echo '</label> ';
		echo '<select name="page_layout" id="page_layout">
		<option '.selected($page_layout,'none',false).' value="none">'.__("No Sidebar","alchem").'</option>
		<option '.selected($page_layout,'left',false).' value="left">'.__("Left Sidebar","alchem").'</option>
		<option '.selected($page_layout,'right',false).' value="right">'.__("Right Sidebar","alchem").'</option>
		<option '.selected($page_layout,'both',false).' value="both">'.__("Both Sidebar","alchem").'</option>
		</select></p>';
		
		
		echo '<p class="meta-options"><label for="left_sidebar"  style="display: inline-block;width: 150px;">';
		_e( 'Select Left Sidebar', 'alchem' );
		echo '</label> ';
		echo '<select name="left_sidebar" id="left_sidebar">';
		foreach( $sidebars as $sidebar ){
		echo '<option '.selected($left_sidebar,$sidebar['value'],false).' value="'.$sidebar['value'].'">'.$sidebar['label'].'</option>';
		}
		echo '</select></p>';
		
		echo '<p class="meta-options"><label for="right_sidebar"  style="display: inline-block;width: 150px;">';
		_e( 'Select Right Sidebar', 'alchem' );
		echo '</label> ';
		echo '<select name="right_sidebar" id="right_sidebar">';
		foreach( $sidebars as $sidebar ){
		echo '<option '.selected($right_sidebar,$sidebar['value'],false).' value="'.$sidebar['value'].'">'.$sidebar['label'].'</option>';
		}
		echo '</select></p>';
		
		
		echo '<p class="meta-options"><label for="slider_banner"  style="display: inline-block;width: 150px;">';
		_e( 'Slider Banner', 'alchem' );
		echo '</label> ';
		echo '<select name="slider_banner" id="slider_banner">
		<option '.selected($slider_banner,'0',false).' value="0">'.__("Disable","alchem").'</option>
		<option '.selected($slider_banner,'magee_slider',false).' value="magee_slider">'.__("Magee Slider","alchem").'</option>
		</select></p>';
		
		echo '<p class="meta-options"><label for="banner_position"  style="display: inline-block;width: 150px;">';
		_e( 'Banner Position', 'alchem' );
		echo '</label> ';
		echo '<select name="banner_position" id="banner_position">
		<option '.selected($banner_position,'1',false).' value="1">'.__("Below Header","alchem").'</option>
		<option '.selected($banner_position,'2',false).' value="2">'.__("Above Header","alchem").'</option>
		</select></p>';
		
		
		echo '<p class="meta-options"><label for="magee_slider"  style="display: inline-block;width: 150px;">';
		_e( 'Select Magee Slider', 'alchem' );
		echo '</label> ';
		echo '<select name="magee_slider" id="magee_slider">';
		foreach( $magee_sliders as $magee_slider_item ){
		echo '<option '.selected($magee_slider,$magee_slider_item['value'],false).' value="'.$magee_slider_item['value'].'">'.$magee_slider_item['label'].'</option>';
		}
		echo '</select></p>';
		
	}
}