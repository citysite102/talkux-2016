<?php
/**
 * @package Gather - Event Landing Page Wordpress Theme
 * @author Cththemes - http://themeforest.net/user/cththemes
 * @date: 10-8-2015
 *
 * @copyright  Copyright ( C ) 2014 - 2015 cththemes.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

global $cththemes_options;
if(get_post_meta(get_the_ID(), 'cth_speaker_single_layout', true)){
	$sideBar = get_post_meta(get_the_ID(), 'cth_speaker_single_layout', true);
}else{
	$sideBar = $cththemes_options['blog_layout'];
}
//$single_header_subtitle = get_post_meta(get_the_ID(), '_cmb_single_header_subtitle', true);
get_header(); 

?>
<!-- 
 Sub Header - for inner pages
 ====================================== -->

<header id="top" class="sub-header">
    <div class="container">
        <h3 class="page-title wow fadeInDown"><?php single_post_title( ) ;?></h3>
        <?php cththemes_gather_breadcrumbs();?>
    </div>
    <!-- end .container -->
</header>
<!-- end .sub-header -->

<div class="container">
    <div class="row">
    <?php if($sideBar==='left_sidebar'&& is_active_sidebar('speaker_sidebar_widget' )):?>
		<div class="col-md-3 left-sidebar">
			<div class="sidebar">
    			<?php dynamic_sidebar('speaker_sidebar_widget' ); ?>
    		</div>
		</div>
	<?php endif;?>
	<?php if($sideBar==='fullwidth'|| !is_active_sidebar('speaker_sidebar_widget' ) ):?>
		<div class="col-md-12">
	<?php else:?>
		<div class="col-md-9">
	<?php endif;?>
		
		<?php while(have_posts()) : the_post(); ?>
			
			<article <?php post_class('cth-single blog-content' );?>>
            	<!-- <h4 class="article-title"><?php the_title( );?></h4> -->
				

				
				
				<div class="entry-content">
					<?php the_content();?>
				</div>
                <?php
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'cth-gather-plugins' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
				
				<?php //cththemes_gather_post_nav();?>


            </article>

            <?php
			// if ( comments_open() || get_comments_number() ) :
				
			//  	comments_template(); 
			 	
			// endif; ?>

		<?php endwhile;?>

		</div>
	<?php if($sideBar ==='right_sidebar'&& is_active_sidebar('speaker_sidebar_widget' )):?>
		<div class="col-md-3 right-sidebar">
	        <div class="sidebar">
	            <?php dynamic_sidebar('speaker_sidebar_widget' ); ?>
	        </div>
	    </div>
	<?php endif;?>
	</div>
</div>

<?php 
get_footer(); 
?>