<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package alchem
 */
 global  $page_meta;
 $pages_comments     = alchem_option('pages_comments','no');
 $display_image      = alchem_option('pages_featured_images','no');
 $display_page_title = isset($page_meta['display_page_title'])?$page_meta['display_page_title']:'yes';
?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if (  $display_image == 'yes' && has_post_thumbnail() ) : ?>
                                    <div class="feature-img-box">
                                        <div class="img-box figcaption-middle text-center from-top fade-in">
                                                 <?php the_post_thumbnail(); ?>
                                                <div class="img-overlay">
                                                    <div class="img-overlay-container">
                                                        <div class="img-overlay-content">
                                                            <i class="fa fa-plus"></i>
                                                        </div>
                                                    </div>                                                        
                                                </div>
                                        </div>                                                 
                                    </div>
                                    <?php endif;?>
   
	<div class="entry-content"><?php the_content(); ?><div class="comments-area text-left"> 
                                     <?php
											// If comments are open or we have at least one comment, load up the comment template
											if ( comments_open() && $pages_comments == 'yes'  ) :
												comments_template();
											endif;
										?>
                                     
                                     </div>
                                    <!--Comments End-->
        
	</div><!-- .entry-content -->

</article><!-- #post-## -->
