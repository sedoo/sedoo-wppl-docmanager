<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sedoo
 */

get_header(); 

while ( have_posts() ) : the_post();
$categories = get_the_terms( $post->ID, 'sedoo-type-document');
$categoriesSlugRewrite = "sedoo-type-document";

?>

	<div id="content-area" class="wrapper">
		<main id="main" class="site-main">	
			<div class="wrapper-content">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										
					<header>
						<h1><?php the_title(); ?></h1>
						<div>
							<?php 
							if( function_exists('sedoo_show_categories') ){
								sedoo_show_categories($categories, $categoriesSlugRewrite);
							}
							?>
							<p class="post-meta"><?php the_date(); ?></p>
						</div>
					</header>
				
					<section class="wrapper-content">

						<?php 
							the_content();
						?>
					</section>
					<?php
					if ( ! post_password_required() ) {
					?>
					<section class="wrapper-content">
						<h2>Files</h2>
						<?php
							if( have_rows('fichiers') ): ?>
						
							<?php while( have_rows('fichiers') ): the_row(); 
						
								$file = get_sub_field('fichier');
								?>
								<article class="fileList" style="display:flex;align-items:center;padding:0 10px;">
									<figure style="width:25px;margin-right:10px;">
										<img src="<?php echo $file['icon']; ?>"> 
									</figure>
									<p>
										<a href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a><br>
										<small>(<?php echo $file['filename']; ?>)</small>
									</p>
								</article>
						
							<?php endwhile; ?>
						
											
						<?php endif; ?>
					</section>
					<?php
					}
					?>
				</article>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
endwhile; // End of the loop.

// get_sidebar();
get_footer();
