<?php
/**
 * Template part for displaying posts.
 *
 * @package Veggie
 */

/*
 * Code modified by gaurang sondagar ( 21-6-2018 )
 */

?>
<div class="col-md-2 col-sm-3 col-xs-6 single_blog_sec">
	<div class="blog-header-title">

		
		<div class="blog_image_inner">
			<a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) { ?>
				<?php the_post_thumbnail( 'thumbnail' ); ?>
                            <?php } else {
                                ?>
                            <img src="<?php echo get_stylesheet_directory_uri().'/images/noimage.png'; ?>" alt="Default Image">
                                <?php
                            } ?>
			</a>
		</div>
		

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</div><!-- .entry-header -->
</div>
