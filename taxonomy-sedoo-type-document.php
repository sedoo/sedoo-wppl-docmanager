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

			<section class="post-wrapper sedoo_blocks_listearticle">
			<?php
                while ( have_posts() ) : the_post();
                global $post;
				$categories = get_the_terms( $post->ID, 'sedoo-type-document');
				$medias = get_attached_media( '' );
				
				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
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
                    <?php if($post->post_content != "") : ?>			
                    <div class="post-excerpt">	    		            			            	                                                                                            
                            <?php the_excerpt(); ?>
                        </div>
                        <?php endif; ?>
                    </section>
					<?php
					if ( ! post_password_required() ) {
					?>
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
									<p>
										<a href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a>
									</p>
								</article>	
						
							<?php endwhile; ?>
					
										
						<?php endif; ?>
					</section>
					<?php
					}
					?>                    
                </article>
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

