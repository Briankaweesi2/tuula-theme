<?php
/**
 * Template Name: Process (Application Journeys)
 *
 * v2 design system: page head, the three applicant-type journeys
 * (Personal / Business / Corporate) as pill tabs — the same visual tab
 * pattern as the Home loan picker — switching numbered tv2-steps panels,
 * plus the preparation-guidance split section. Tab switching keeps the
 * existing data-process-tab / data-process-panel hooks that app.js drives.
 */
get_header();

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Application process', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Different loan paths need different review steps.', 'tuula' ) );
$hero_intro   = tuula_field( 'page_hero_intro', __( 'Personal borrowers, SMEs and large companies do not move through the same approval journey. This page explains how the flow changes by applicant type.', 'tuula' ) );

/* Step content: ACF repeaters override; approved prototype copy is the fallback. */
$default_steps = array(
	'personal'  => array(
		array( 'title' => __( 'Calculate', 'tuula' ), 'description' => __( 'Choose emergency, school fees, logbook or personal loan and review the estimated monthly repayment.', 'tuula' ) ),
		array( 'title' => __( 'Identify borrower', 'tuula' ), 'description' => __( 'Share name, phone, location, income source and the reason for borrowing.', 'tuula' ) ),
		array( 'title' => __( 'Verify documents', 'tuula' ), 'description' => __( 'Provide ID, income evidence, school invoice, logbook or other loan-specific documents.', 'tuula' ) ),
		array( 'title' => __( 'Decision and payout', 'tuula' ), 'description' => __( 'Tuula confirms eligibility, repayment terms and next steps before disbursement.', 'tuula' ) ),
	),
	'business'  => array(
		array( 'title' => __( 'Business need', 'tuula' ), 'description' => __( 'Define whether the finance is for stock, cash flow, equipment, contracts or expansion.', 'tuula' ) ),
		array( 'title' => __( 'Business profile', 'tuula' ), 'description' => __( 'Submit business registration details, owner contacts, trading location and operating history.', 'tuula' ) ),
		array( 'title' => __( 'Cash-flow review', 'tuula' ), 'description' => __( 'Share sales records, bank or mobile money activity, invoices, contracts or asset quotations.', 'tuula' ) ),
		array( 'title' => __( 'Offer structure', 'tuula' ), 'description' => __( 'Tuula reviews capacity, security where needed, repayment cycle and suitable facility size.', 'tuula' ) ),
	),
	'corporate' => array(
		array( 'title' => __( 'Facility request', 'tuula' ), 'description' => __( 'Capture the project, capital need, amount, tenor, purpose and decision timeline.', 'tuula' ) ),
		array( 'title' => __( 'Document pack', 'tuula' ), 'description' => __( 'Collect company registration, financial statements, board approvals and supporting contracts.', 'tuula' ) ),
		array( 'title' => __( 'Credit committee', 'tuula' ), 'description' => __( 'Review risk, collateral, sector exposure, repayment source and compliance requirements.', 'tuula' ) ),
		array( 'title' => __( 'Approval and monitoring', 'tuula' ), 'description' => __( 'Confirm terms, sign agreements, disburse in stages where needed and track repayment performance.', 'tuula' ) ),
	),
);

$journeys = array();
foreach ( $default_steps as $journey => $fallback_steps ) {
	$steps = tuula_field( $journey . '_steps', array() );
	if ( ! is_array( $steps ) || empty( $steps ) ) {
		$steps = $fallback_steps;
	}
	$journeys[ $journey ] = $steps;
}

/** Render one journey's numbered step list (tv2 steps component). */
$tuula_render_steps = function ( $steps ) {
	?>
	<div class="tv2-steps tv2-steps--process">
		<?php foreach ( array_values( $steps ) as $i => $step ) : ?>
			<div class="tv2-step">
				<div class="tv2-step__num"><?php echo esc_html( $i + 1 ); ?></div>
				<h3><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
				<p><?php echo esc_html( $step['description'] ?? '' ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
};
?>

<main id="main" class="tv2-process-page">

	<section class="tv2-page-head tv2-page-head--section" aria-labelledby="process-title">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-page-title" id="process-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-page-sub"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<!-- Journeys by applicant type -->
	<section class="tv2-section" aria-labelledby="process-tabs-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Our process', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="process-tabs-title"><?php esc_html_e( 'Select the customer category.', 'tuula' ); ?></h2>
			<p class="tv2-lead"><?php esc_html_e( 'The process is separated because a school fees request, an SME facility and a large company facility usually need different documents and review levels.', 'tuula' ); ?></p>
		</div>

		<div data-process-tabs>
			<div class="tv2-loan-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Loan process categories', 'tuula' ); ?>">
				<button type="button" class="tv2-loan-tab is-active" data-process-tab="personal" role="tab" aria-selected="true"><?php esc_html_e( 'Personal', 'tuula' ); ?></button>
				<button type="button" class="tv2-loan-tab" data-process-tab="business" role="tab" aria-selected="false"><?php esc_html_e( 'Business and SME', 'tuula' ); ?></button>
				<button type="button" class="tv2-loan-tab" data-process-tab="corporate" role="tab" aria-selected="false"><?php esc_html_e( 'Large companies', 'tuula' ); ?></button>
			</div>

			<div class="tv2-process-panel is-active" data-process-panel="personal">
				<?php $tuula_render_steps( $journeys['personal'] ); ?>
			</div>

			<div class="tv2-process-panel" data-process-panel="business" hidden>
				<?php $tuula_render_steps( $journeys['business'] ); ?>
			</div>

			<div class="tv2-process-panel" data-process-panel="corporate" hidden>
				<?php $tuula_render_steps( $journeys['corporate'] ); ?>
			</div>
		</div>
	</section>

	<!-- Preparation guidance -->
	<section class="tv2-section tv2-section--alt" aria-labelledby="process-guidance-title">
		<div class="tv2-guidance">
			<div class="tv2-guidance__head">
				<p class="tv2-eyebrow"><?php esc_html_e( 'Before approval', 'tuula' ); ?></p>
				<h2 class="tv2-h2" id="process-guidance-title"><?php esc_html_e( 'Prepare the right information early.', 'tuula' ); ?></h2>
			</div>
			<div class="tv2-guidance__list">
				<p><?php esc_html_e( 'Personal borrowers should prepare identification, contact details, income source and any loan-specific document such as a school invoice or vehicle logbook.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'Businesses should prepare business registration details, sales or cash-flow records, invoices, contracts, asset quotations and a clear reason for the facility.', 'tuula' ); ?></p>
				<p><?php esc_html_e( 'Large companies may need a fuller document pack, approvals, security details, repayment source, project notes and credit committee review.', 'tuula' ); ?></p>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
