<?php
/**
 * The template for displaying search results pages.
 *
 * @package Veggie Lite
 */

get_header(); ?>

<!-- Code: Dhara : display in search list same as blog style layout , Date 29-6-2-2018 -->
	
<style>
    .single_blog_sec h2.entry-title {
        display: inline-block;
        background: #e5e5e573;
        padding: 7px 10px;
        width: 100%;
        min-height: 130px;
        line-height: 22px;
    }
    .single_blog_sec h2.entry-title a {
        text-decoration: none;
        color: #5d5b5b;
    }
    
    .single_blog_sec h2.entry-title a:hover {
        text-decoration: none;
        box-shadow: none;
        color: #2c00f4;
    }
    .single_blog_sec {
        display: inline-block;
        margin-bottom: 50px;
    }
    .blog-header-title .entry-title > a {
        font-size: 16px;
        text-transform: capitalize;
    }
    .blog-header-title img {
        margin-bottom: 0 !important;
        width: 100%;
        height: 150px;
        border-bottom: 0;
    }
    .blog-header-title a img:hover {
        border-bottom: 0;
    }
    .blog_image_inner {
        position: relative;
        overflow: hidden;
        transition: all 3s;
    }
    .blog_image_inner img {
        transform: scale(1);
        transition: all 0.5s !important;
    }
    .blog_image_inner:hover img {
        transform: scale(1.3);
    } 
	.form-search{
	margin:20px 0;
	float:right
	}
	#search-button{
		margin: 0 20px;
    border: 1px solid;
    padding: 5px 10px;
    border-radius: 24px;
	}
</style>
  <!--Code Added By Dhara : Add search form for blog word search, Date : 29-6-2018 --> 
 <div class="container">
    <div class="row">
		<div class="form-search" >
			<form action="/" method="get">
					<input type="text" name="s" id="search" placeholder='  Search ..' value="<?php the_search_query(); ?>" />
				<input type="submit" alt="Search" id="search-button" name="Search" value="Search" />
			</form>
		</div>
	</div>
</div> 
<header class="page-header">
	<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'veggie-lite' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
</header><!-- .page-header -->
	<div class="three-third">
		<div id="primary" class="content-area sidebar-right-layout">
			<main id="main" class="site-main" role="main">
                <!--Code Added By Gaurang : html code added for wrap blog div, Date : 18-6-2018 -->                           
                <div class="container">
                    <div class="row">
                                    
			<?php 				
				if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 
						 get_template_part( 'template-parts/content' );
					?>

				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>
                                    </div>
                            </div>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .two_third -->
	<div class="one-third lastcolumn">
		<?php get_sidebar(); ?>
	</div><!-- .one_third -->


<?php get_footer(); ?>