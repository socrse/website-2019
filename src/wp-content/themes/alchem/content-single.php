<?php
/**
 * @package alchem
 */
 $display_image = alchem_option('single_display_image');
?>
<section class="post-main" role="main" id="content">
                                <article class="post-entry text-left">
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
                                    <div class="entry-main">
                                        <div class="entry-header">      
                                            <?php if(alchem_option('display_post_title') == 'yes'):?>                          
                                            <h1 class="entry-title"><?php the_title();?></h1>
                                            <?php endif;?>
                                           <?php alchem_posted_on();?>
                                        </div>
                                        <div class="entry-content"> 
                                        <?php the_content(); ?>
                                        
                                        </div>
                                        
                                        <div class="entry-footer">
                                        <?php
												if(get_the_tag_list()) {
													echo get_the_tag_list('<ul class="entry-tags no-border pull-left"><li>','</li><li>','</li></ul>');
												}
												
												$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
												?>
                                            <ul class="entry-share no-border pull-right">
                                                <li><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_title();?>&url=<?php the_permalink();?>"><i class="fa fa-twitter fa-fw"></i></a></li>
                                                <li><a  target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>"><i class="fa fa-facebook fa-fw"></i></a></li>
                                                <li><a  target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>&source=<?php echo $feat_image;?>&summary=<?php the_excerpt();?>"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                                <li><a  target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&description=<?php the_excerpt();?>&media=<?php echo $feat_image;?>"><i class="fa fa-pinterest fa-fw"></i></a></li>
                                                <li><a  target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>&source=<?php echo $feat_image;?>&summary=<?php the_excerpt();?>"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                                <li><a target="_blank"  href="http://www.reddit.com/submit/?url=<?php the_permalink();?>"><i class="fa fa-reddit fa-fw"></i></a></li>
                                                <li><a target="_blank"  href="http://vk.com/share.php?url=<?php the_permalink();?>&title=<?php the_title();?>"><i class="fa fa-vk fa-fw"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                                <div class="post-attributes">
                                    <!--About Author-->
                                    <?php if(alchem_option('display_author_info_box') == 'yes'):?>
                                    <div class="about-author">
                                        <h3><?php _e( 'About the author', 'alchem' );?>: <?php the_author_link(); ?></h3>
                                        <div class="author-avatar">
                                           <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>
                                        </div>
                                        <div class="author-description">
                                            <?php the_author_meta('description');?>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <!--About Author End-->
                                    <!--Related Posts-->
                                    <?php 
									$related_number = alchem_option('related_number',8);
									$related        = alchem_get_related_posts($post->ID, $related_number,'post'); 
									
									?>
			                        <?php if($related->have_posts()): 
									        $date_format = alchem_option('date_format','M d, Y');
									?>
            
                                    <div class="related-posts">
                                        <h3><?php _e( 'Related Posts', 'alchem' );?></h3>
                                        <div class="multi-carousel alchem-related-posts owl-carousel owl-theme">
                                        
                                            <?php while($related->have_posts()): $related->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
                            <?php //$full_image  = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); 
							       $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'related-post');
							?>
                                            <div class="owl-item">
                                            <div class="post-grid-box">
                                                                <div class="img-box figcaption-middle text-center from-left fade-in">
                                                                    <a href="<?php the_permalink(); ?>">
                                                                        <img src="<?php echo $thumb_image[0];?>" class="feature-img"/>
                                                                        <div class="img-overlay">
                                                                            <div class="img-overlay-container">
                                                                                <div class="img-overlay-content">
                                                                                    <i class="fa fa-link"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>                                                  
                                                                </div>
                                                                <div class="img-caption">
                                                                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                                                    <ul class="entry-meta">
                                                                        <li class="entry-date"><i class="fa fa-calendar"></i><?php echo get_the_date( $date_format );?></li>
                                                                        <li class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            </div>
                                            <?php endif; endwhile; ?>
                                        </div>
                                    </div>
                                    <?php wp_reset_postdata(); endif; ?>
                                    <!--Related Posts End-->
                                    <!--Comments Area-->                                
                                     <div class="comments-area text-left"> 
                                     <?php
											// If comments are open or we have at least one comment, load up the comment template
											if ( comments_open()  ) :
												comments_template();
											endif;
										?>
                                     
                                     </div>
                                    <!--Comments End-->                
                                </div>
                            </section>