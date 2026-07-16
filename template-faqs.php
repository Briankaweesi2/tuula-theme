<?php
/**
 * Template Name: FAQs
 *
 * FAQ entries come from the ACF `faqs` repeater on this page when available
 * (same repeater the tuula-headless mu-plugin exposes over REST); otherwise
 * the approved prototype questions render as defaults.
 *
 * v2 design system: page head, the tv2 accordion (same .tv2-faq__item
 * markup and data-tv2-faq handler as the Home page FAQ — one item open
 * at a time), and the responsible-borrowing guidance split section.
 */
get_header();

$default_faqs = array(
	array(
		'question' => __( 'How do I apply for a Tuula Credit loan?', 'tuula' ),
		'answer'   => __( 'Start with the calculator, complete the request form and submit your contact details. The team will reach out with the documents and next steps for your loan type.', 'tuula' ),
	),
	array(
		'question' => __( 'What loan amount can I request?', 'tuula' ),
		'answer'   => __( "The amount depends on the loan purpose, repayment capacity, documentation, security where required and Tuula's credit assessment.", 'tuula' ),
	),
	array(
		'question' => __( 'Can I get a school fees loan?', 'tuula' ),
		'answer'   => __( 'Yes. Tuula supports short-term education needs such as tuition, hostel requirements and scholastic materials, subject to eligibility.', 'tuula' ),
	),
	array(
		'question' => __( 'How do logbook loans work?', 'tuula' ),
		'answer'   => __( 'A logbook loan uses a registered motor vehicle logbook as security. The team reviews ownership, vehicle details, repayment capacity and the requested amount.', 'tuula' ),
	),
	array(
		'question' => __( 'Do all loans need collateral?', 'tuula' ),
		'answer'   => __( 'Security requirements vary. Some facilities may require security or supporting documents, while others are reviewed based on the loan purpose and repayment capacity.', 'tuula' ),
	),
	array(
		'question' => __( 'Can I apply if I already have another loan?', 'tuula' ),
		'answer'   => __( 'You may still apply if you can demonstrate capacity to service both obligations. Tuula will review affordability before making a decision.', 'tuula' ),
	),
	array(
		'question' => __( 'Is the calculator a final offer?', 'tuula' ),
		'answer'   => __( 'No. It is an estimate to help you plan. Final terms are confirmed only after review and approval.', 'tuula' ),
	),
);

$faqs = tuula_field( 'faqs', array() );
if ( ! is_array( $faqs ) || empty( $faqs ) ) {
	$faqs = $default_faqs;
}

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'FAQs', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Common questions before applying for a loan.', 'tuula' ) );
$hero_intro   = tuula_field( 'page_hero_intro', __( 'These answers help customers understand the basics. The team can confirm exact requirements for each loan request.', 'tuula' ) );

$contact_url = tuula_page_url( 'contact' );
?>

<main id="main" class="tv2-faqs-page">

	<section class="tv2-page-head tv2-page-head--section" aria-labelledby="faq-title">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-page-title" id="faq-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-page-sub"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<!-- FAQ accordion -->
	<section class="tv2-section" aria-labelledby="faq-list-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Loan questions', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="faq-list-title"><?php esc_html_e( 'What customers ask most often.', 'tuula' ); ?></h2>
			<p class="tv2-lead"><?php esc_html_e( 'For personal advice, contact Tuula Credit or submit a request from the Apply page.', 'tuula' ); ?></p>
		</div>
		<div class="tv2-faq">
			<div class="tv2-faq__list" data-tv2-faq>
				<?php foreach ( $faqs as $index => $faq ) : ?>
					<div class="tv2-faq__item">
						<button type="button" aria-expanded="<?php echo 0 === $index ? 'true' : 'false'; ?>">
							<?php echo esc_html( $faq['question'] ?? '' ); ?>
						</button>
						<div<?php echo 0 === $index ? '' : ' hidden'; ?>>
							<p><?php echo esc_html( $faq['answer'] ?? '' ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="tv2-loan-more">
				<a class="tv2-link" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Still unsure? Ask the team directly →', 'tuula' ); ?></a>
			</p>
		</div>
	</section>

	<!-- Responsible borrowing guidance -->
	<section class="tv2-section tv2-section--alt" aria-labelledby="faq-guidance-title">
		<div class="tv2-guidance">
			<div class="tv2-guidance__head">
				<p class="tv2-eyebrow"><?php esc_html_e( 'Responsible borrowing', 'tuula' ); ?></p>
				<h2 class="tv2-h2" id="faq-guidance-title"><?php esc_html_e( 'A few things to confirm before accepting a facility.', 'tuula' ); ?></h2>
			</div>
			<div class="tv2-guidance__list">
				<p><?php esc_html_e( 'Ask for the full repayment amount, fees, repayment dates, penalties and any security requirement before accepting a loan.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'Borrow for a clear purpose and choose a repayment period that fits your income or cash-flow cycle.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'Speak to Tuula early if your repayment source changes or you need help reviewing your options.', 'tuula' ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
