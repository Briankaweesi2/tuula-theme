<?php
/**
 * Template Name: Privacy Policy
 *
 * v2 design system: simple legal-copy page (per Privacy.dc.html).
 *
 * IMPORTANT — the section copy below is generic starting-point boilerplate
 * written to honestly reflect what this site/backend actually collects
 * (KYC documents, contact details, financial information for loan review).
 * It is NOT legal advice and MUST be reviewed and approved by Tuula's own
 * lawyer before the page is published on the live site. It deliberately
 * avoids naming a specific regulator or licence number; counsel should add
 * the correct regulatory references.
 */
get_header();

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Legal', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Privacy Policy', 'tuula' ) );

$email   = tuula_opt( 'email' );
$updated = get_the_modified_date();

$sections = array(
	array(
		'title' => __( '1. What we collect', 'tuula' ),
		'body'  => __( 'When you apply for a loan or contact us, we collect the information needed to assess your request: your name, phone number, email address, national ID and other identity (KYC) documents, employment details, and financial information such as your income, loan purpose and any security you offer. If you browse this website, we may also collect basic usage data (pages viewed, device type) to keep the site working well.', 'tuula' ),
	),
	array(
		'title' => __( '2. How we use it', 'tuula' ),
		'body'  => __( 'We use your information to assess loan applications, verify your identity, communicate with you about your application or account, disburse funds and manage repayments, and meet our legal and record-keeping obligations as a lending business operating in Uganda. We do not sell your personal data.', 'tuula' ),
	),
	array(
		'title' => __( '3. Who we share it with', 'tuula' ),
		'body'  => __( 'We may share limited information with credit reference bureaus, with regulators and authorities where the law requires it, and with service providers who help us operate (for example payment processors or IT providers) — only as needed to deliver our services or meet legal requirements, and never for their own marketing.', 'tuula' ),
	),
	array(
		'title' => __( '4. How we protect and keep it', 'tuula' ),
		'body'  => __( 'We take reasonable technical and organisational measures to keep your information secure and limit access to staff who need it to do their work. We retain application and account records for as long as required by applicable Ugandan financial services and data protection laws, and delete data we no longer have a legal or business reason to keep.', 'tuula' ),
	),
	array(
		'title' => __( '5. Your rights', 'tuula' ),
		'body'  => __( 'You can ask to see the personal data we hold about you, request that inaccurate information be corrected, and ask questions about how your data is used at any time, in line with applicable Ugandan data protection law. Use the contact details below and we will respond during business hours.', 'tuula' ),
	),
	array(
		'title' => __( '6. Contact us', 'tuula' ),
		/* translators: %s: contact email address. */
		'body'  => sprintf( __( 'Questions about this policy can be sent to %s or raised in person at our Kitintale office in Kampala.', 'tuula' ), $email ),
	),
);
?>

<main id="main" class="tv2-legal-page">
	<div class="tv2-legal">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-legal__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-legal__updated"><?php printf( esc_html__( 'Last updated: %s', 'tuula' ), esc_html( $updated ) ); ?></p>

		<div class="tv2-legal__body">
			<?php foreach ( $sections as $section ) : ?>
				<section>
					<h3><?php echo esc_html( $section['title'] ); ?></h3>
					<p><?php echo esc_html( $section['body'] ); ?></p>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
