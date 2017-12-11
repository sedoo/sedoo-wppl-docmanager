<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sedoo
 */

get_header(); 

get_template_part( 'template-parts/header-content', 'archive' );
// global $post;
?>

	<div id="content-area" class="wrapper archives">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

			<section role="listNews" class="posts">
			<?php
                while ( have_posts() ) : the_post();
                global $post;
				$categories = get_the_terms( $post->ID, 'sedoo-type-document');
				$medias = get_attached_media( '' );
				
				?>
				<div class="post-container">
                <article role="embed-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title();?>
                            </a>
                        </h3>     
                        
                        <?php 
                        if (get_the_post_thumbnail()) {
                        ?>
                        <figure>
                        <?php the_post_thumbnail( 'illustration-article' ); ?>
                        </figure>
                        <?php 
                        }
                        ?>        

                    </header>
					
					<section>
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
										<a href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a>
									</h4>
								</article>	
						
							<?php endwhile; ?>
					
										
						<?php endif; ?>
					</section>


                    <section>
                    <?php if($post->post_content != "") : ?>			
                    <div class="post-excerpt">	    		            			            	                                                                                            
                            <?php //the_excerpt(); ?>
                        </div>
                        <?php endif; ?>
                    </section>
                    <footer>
                        <?php sedoo_docmanager_show_categories($categories);?>
                        
                        <?php theme_aeris_meta(); ?>
                    </footer>
                </article>
				<?php
					// get_template_part( 'template-parts/content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</div>
				<?php
				endwhile; // End of the loop.
				?>				
			</section>
			<?php 
				the_posts_navigation();
				?>
			<?php
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>
		
		</main><!-- #main -->
		<?php 
		// get_sidebar();
		?>
	</div><!-- #content-area -->
<?php
get_footer();
?>

