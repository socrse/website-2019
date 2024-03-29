<?php
/**
 * The template for displaying all single posts.
 *
 * @package alchem
 */

get_header(); 
$sidebar                 = alchem_option('blog_single_sidebar','none');
$page_title_bg_parallax  = esc_attr(alchem_option('page_title_bg_parallax','no'));
$page_title_bg_parallax  = $page_title_bg_parallax=="yes"?"parallax-scrolling":"";
$page_title_align        = esc_attr(alchem_option('page_title_align','left'));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<section class="page-title-bar title-<?php echo $page_title_align;?> no-subtitle <?php echo $page_title_bg_parallax;?>">
            <div class="container">
                <hgroup class="page-title text-light">
                    <h1><?php the_title();?></h1>
                    <!--<h3>This is a subtitle for the page.</h3>-->
                </hgroup>
                <?php alchem_get_breadcrumb(array("before"=>"<div class='breadcrumb-nav text-light'>","after"=>"</div>","show_browse"=>false,"separator"=>''));?>    
                <div class="clearfix"></div>            
            </div>
        </section>
 <div class="post-wrap">
            <div class="container">
                <div class="post-inner row <?php echo alchem_get_content_class($sidebar);?>">
                        <div class="col-main">
             <?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>
                        </div>
                        <?php if( $sidebar == 'left' || $sidebar == 'both'  ): ?>
       <div class="col-aside-left">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                            <?php get_sidebar('postleft');?>
                            </div>
                        </aside>
                    </div>
            <?php endif; ?>
            <?php if( $sidebar == 'right' || $sidebar == 'both'  ): ?>        
                    <div class="col-aside-right">
                        <div class="widget-area">
                           <?php get_sidebar('postright');?>
                            </div>
                    </div>
             <?php endif; ?>
                    </div>
                </div>
            </div>
      </article>
<?php get_footer(); ?>