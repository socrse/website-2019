<?php
global $orientation, $overlay_content;
if( !$orientation ) $orientation = 'top';
if( !$overlay_content ) $overlay_content = '1';

//overlay_content: 1, button 2, title 3, title & tags 4, link

$taxonomy  = 'portfolio_tags';
$tax_terms = wp_get_post_terms($post->ID,$taxonomy);
$tags      = array();
if( $tax_terms ){
foreach ($tax_terms as $tax_term) {
$tags[] = '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ,'alchem'), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a>';
}
}
$tags_str = implode(', ',$tags);

$action = 'from-'.$orientation;
if($overlay_content == '5')
$action = 'img-zoom-in';
?>
<article class="portfolio-box">
  <div class="feature-img-box">
    <div class="img-box figcaption-middle text-center <?php echo $action;?> fade-in">
   <?php if($overlay_content == '2' || $overlay_content == '4' || $overlay_content == '5'):?>
   <a href="<?php the_permalink();?>">
   <?php endif;?>
      <?php 
														the_post_thumbnail("portfolio-thumb");
														$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
														$featured_image = $image[0];
													  ?>
                                              <div class="img-overlay <?php if( $overlay_content == '4' ){echo 'light';} if( $overlay_content == '5' ){ echo 'primary';}?>">
                                                <div class="img-overlay-container">
                                                  <div class="img-overlay-content">
                                                    <?php if($overlay_content == '1'):?>
                                                    <div class="img-overlay-icons">
                                                    <a href="<?php the_permalink();?>"><i class="fa fa-link"></i></a>
                                                    <a rel="portfolio-image" href="<?php echo $featured_image;?>"><i class="fa fa-search"></i></a>
                                                     </div>
                                                    <?php endif;?>
                                                    <?php if($overlay_content == '2'):?>
                                                    <h3 class="img-overlay-title"><?php the_title();?></h3>
                                                    <?php endif;?>
                                                    <?php if($overlay_content == '3'):?>
                                                        <a href="<?php the_permalink();?>"><div class="img-overlay-total-link"></div></a>
                                                        <a href="<?php the_permalink();?>"><h3 class="img-overlay-title"><?php the_title();?></h3></a>
                                                        <div class="entry-category"><?php echo $tags_str;?></div>
                                                      <?php endif;?>
                                                      <?php if( $overlay_content == '4' || $overlay_content == '5' ):?>
                                                      <i class="fa fa-link"></i>
                                                      <?php endif;?>
                                                      
                                                  </div>
                                                </div>
                                              </div>
                                              <?php if( $overlay_content == '2' || $overlay_content == '4' || $overlay_content == '5' ):?>
                                  </a>
                                  <?php endif;?>
                                            </div>
                                          </div>
                                          <div class="entry-main text-center">
                                            <div class="entry-header"> <a href="<?php the_permalink();?>">
                                              <h1 class="entry-title">
                                                <?php the_title();?>
                                              </h1>
                                              </a> </div>
                                            <div class="entry-meta">
                                              <div class="entry-category">
                                                <?php echo $tags_str; ?>
      </div>
    </div>
  </div>
</article>
