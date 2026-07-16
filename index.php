<?php
/**
 * Generic fallback template.
 */
get_header();
?>

<main id="main">
	<section class="page-hero page-hero--compact">
		<div class="section-inner">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
				<?php endwhile; ?>
			<?php else : ?>
				<h1><?php esc_html_e( 'Nothing found', 'tuula' ); ?></h1>
				<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the homepage', 'tuula' ); ?></a></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
