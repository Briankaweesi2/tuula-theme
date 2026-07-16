<?php
/**
 * Template Name: About
 *
 * v2 design system: our-story hero, mission/photo split, six company
 * values, the at-a-glance facts bar (same real numbers as the Home page
 * facts bar — six products, four steps, three contact channels, one
 * Kitintale office; no invented client counts or disbursement totals),
 * a team/support photo section and the final CTA band.
 */
get_header();

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Our story', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Built to help Ugandans grow', 'tuula' ) );
$hero_intro   = tuula_field( 'page_hero_intro', __( 'Tuula Financial Services Limited helps individuals, businesses and institutions across Uganda access practical, clearly explained financing.', 'tuula' ) );

$apply_url   = tuula_page_url( 'apply' );
$contact_url = tuula_page_url( 'contact' );
$img_base    = get_template_directory_uri() . '/assets/images/';

$check_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';

$values = array(
	array(
		'title' => __( 'Transparency', 'tuula' ),
		'desc'  => __( 'Indicative monthly repayment, total interest and total cost shown before you commit to anything.', 'tuula' ),
	),
	array(
		'title' => __( 'Fair terms', 'tuula' ),
		'desc'  => __( 'Every figure in your offer is explained in plain language before you are asked to sign.', 'tuula' ),
	),
	array(
		'title' => __( 'Responsible lending', 'tuula' ),
		'desc'  => __( 'Guidance on eligibility, documents and repayment planning so you borrow what you can repay.', 'tuula' ),
	),
	array(
		'title' => __( 'Local presence', 'tuula' ),
		'desc'  => __( 'A real office in Kitintale, Kampala — people you can call, message or walk in and talk to.', 'tuula' ),
	),
	array(
		'title' => __( 'Speed', 'tuula' ),
		'desc'  => __( 'A four-step process designed to move as fast as your documents can be verified.', 'tuula' ),
	),
	array(
		'title' => __( 'Human support', 'tuula' ),
		'desc'  => __( 'WhatsApp, phone, email or a visit — a person reviews every request and answers every question.', 'tuula' ),
	),
);
?>

<main id="main" class="tv2-about-page">

	<section class="tv2-page-head tv2-page-head--section" aria-labelledby="about-title">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-page-title" id="about-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-page-sub"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<!-- Mission / story -->
	<section class="tv2-section" aria-labelledby="mission-title">
		<div class="tv2-about">
			<div class="tv2-about__photo">
				<img src="<?php echo esc_url( $img_base . 'about-story.jpg' ); ?>" alt="<?php esc_attr_e( 'A Tuula Credit advisor meeting a client in Uganda', 'tuula' ); ?>">
			</div>
			<div class="tv2-about__copy">
				<h2 class="tv2-h2" id="mission-title"><?php esc_html_e( 'Financing that starts with a conversation.', 'tuula' ); ?></h2>
				<p><?php esc_html_e( 'Tuula Financial Services Limited was established to help individuals, businesses and institutions in Uganda access the financial resources they need to build, preserve and grow what matters to them. We operate from Kitintale, Kampala and serve clients across Uganda.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'We take time to understand each client\'s situation and match them with the right product for their need — school fees, an emergency, a logbook loan, an asset, working capital or larger company financing. We believe financial services should be accessible and clearly explained, never intimidating.', 'tuula' ); ?></p>
				<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php esc_html_e( 'Apply for a loan →', 'tuula' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section class="tv2-section tv2-section--alt" aria-labelledby="values-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'What drives us', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="values-title"><?php esc_html_e( 'Our mission and values.', 'tuula' ); ?></h2>
		</div>
		<div class="tv2-values">
			<?php foreach ( $values as $value ) : ?>
				<div class="tv2-value">
					<span class="tv2-value__icon" aria-hidden="true"><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3><?php echo esc_html( $value['title'] ); ?></h3>
					<p><?php echo esc_html( $value['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- Facts bar (same established numbers as the Home page facts bar) -->
	<section class="tv2-statsbar" aria-label="<?php esc_attr_e( 'Tuula Credit at a glance', 'tuula' ); ?>">
		<div class="tv2-statsbar__grid">
			<div>
				<div class="tv2-statsbar__num">6</div>
				<div class="tv2-statsbar__label"><?php esc_html_e( 'Loan products', 'tuula' ); ?></div>
			</div>
			<div>
				<div class="tv2-statsbar__num">4</div>
				<div class="tv2-statsbar__label"><?php esc_html_e( 'Application steps', 'tuula' ); ?></div>
			</div>
			<div>
				<div class="tv2-statsbar__num">3</div>
				<div class="tv2-statsbar__label"><?php esc_html_e( 'Ways to reach the team', 'tuula' ); ?></div>
			</div>
			<div>
				<div class="tv2-statsbar__num">1</div>
				<div class="tv2-statsbar__label"><?php esc_html_e( 'Kitintale office, Kampala', 'tuula' ); ?></div>
			</div>
		</div>
	</section>

	<!-- Team / support -->
	<section class="tv2-section" aria-labelledby="team-title">
		<div class="tv2-about tv2-about--reverse">
			<div class="tv2-about__photo">
				<img src="<?php echo esc_url( $img_base . 'about-team.jpg' ); ?>" alt="<?php esc_attr_e( 'A member of the Tuula Credit team ready to help', 'tuula' ); ?>">
			</div>
			<div class="tv2-about__copy">
				<p class="tv2-eyebrow"><?php esc_html_e( 'The team', 'tuula' ); ?></p>
				<h2 class="tv2-h2" id="team-title"><?php esc_html_e( 'One team behind every request.', 'tuula' ); ?></h2>
				<p><?php esc_html_e( 'Every enquiry — whatever the loan type — is reviewed by the same team, so nothing gets lost between departments. You can reach us on WhatsApp, by phone, by email or by visiting the Kitintale office, before and after you apply.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'If a request is not approved, we explain what was missing and what you can adjust before applying again. An enquiry starts a conversation; it does not lock you into anything.', 'tuula' ); ?></p>
				<a class="tv2-btn tv2-btn--ghost" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Meet us — get in touch', 'tuula' ); ?></a>
			</div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="tv2-cta" aria-labelledby="about-cta-title">
		<div class="tv2-cta__inner">
			<h2 id="about-cta-title"><?php esc_html_e( 'Start your financial journey today.', 'tuula' ); ?></h2>
			<p><?php esc_html_e( 'Apply for a loan or get in touch to discuss which product is right for you.', 'tuula' ); ?></p>
			<div class="tv2-cta__row">
				<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php esc_html_e( 'Apply now →', 'tuula' ); ?></a>
				<a class="tv2-btn tv2-btn--ghost" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact us', 'tuula' ); ?></a>
			</div>
			<p class="tv2-cta__note">
				<?php echo esc_html( tuula_opt( 'phone_display' ) ); ?> · <?php echo esc_html( tuula_opt( 'email' ) ); ?> · <?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?>
			</p>
		</div>
	</section>

</main>

<?php get_footer(); ?>
