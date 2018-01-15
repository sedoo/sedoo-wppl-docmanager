<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sedoo
 */

get_header(); 

$categories = get_the_terms( $post->ID, 'sedoo-type-document');  

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/header-content', 'page' );
?>

	<div id="content-area" class="wrapper sidebar">
		<main id="main" class="site-main" role="main">
		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									
				<header>
			        <?php sedoo_docmanager_show_categories($categories);?>
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
								<h4>
									<a href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a><br>
									<small><?php echo $file['filename']; ?></small>
								</h4>
							</article>
					
						<?php endwhile; ?>
					
										
					<?php endif; ?>
				</section>
				<?php
				}
				?>

				<footer>
					<span class="icon-user"></span><?php the_author();?>
					<span class="icon-clock"></span><?php the_time( get_option( 'date_format' ) );?>
					<?php 
					// if ( get_edit_post_link() ) : 
					// 	edit_post_link(
					// 		sprintf(
					// 			/* translators: %s: Name of current post */
					// 			esc_html__( 'Edit %s', 'theme-aeris' ),
					// 			the_title( '<span class="screen-reader-text">"', '"</span>', false )
					// 		),
					// 		'<span class="edit-link">',
					// 		'</span>'
					// 	);
					// endif; 

					the_post_navigation();

					?>
				</footer><!-- .entry-meta -->
			</article>
			<?php			

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		</main><!-- #main -->
		
		<?php 
		get_sidebar();
		?>
	</div><!-- #primary -->
<?php
endwhile; // End of the loop.

// get_sidebar();
get_footer();
