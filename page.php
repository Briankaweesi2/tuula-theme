<?php
/**
 * Default page template (used by pages without a dedicated template,
 * e.g. the privacy policy).
 */
get_header();
?>

<main id="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="page-hero page-hero--compact">
			<div class="section-inner">
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<section class="section">
			<div class="section-inner entry-content">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
