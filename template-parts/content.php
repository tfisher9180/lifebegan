<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LifeBegan
 */

?>

<div class="entry-background" style="background-image: url('');">
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; ?>
	</header><!-- .entry-header -->
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="article-content-wrapper">
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php lifebegan_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

		<div class="entry-content">
			<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'lifebegan' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lifebegan' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php lifebegan_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .article-content-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->
