<?php
/**
 * Template Name: Terms & Conditions
 *
 * v2 design system: simple legal-copy page (per Terms.dc.html).
 *
 * IMPORTANT — the section copy below is generic starting-point boilerplate
 * for a Ugandan lending business. It is NOT legal advice and MUST be
 * reviewed and approved by Tuula's own lawyer before the page is published
 * on the live site. It deliberately avoids naming a specific regulator or
 * licence number; counsel should add the correct regulatory references.
 */
get_header();

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Legal', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Terms & Conditions', 'tuula' ) );

$email   = tuula_opt( 'email' );
$updated = get_the_modified_date();

$sections = array(
	array(
		'title' => __( '1. Who these terms apply to', 'tuula' ),
		'body'  => __( 'These terms apply to anyone who applies for or holds a loan product with Tuula Financial Services Limited, or who uses this website. Applying for a loan does not guarantee approval, and browsing the site or submitting an enquiry does not create any obligation on either side.', 'tuula' ),
	),
	array(
		'title' => __( '2. Loan offers and eligibility', 'tuula' ),
		'body'  => __( 'Any interest rate, term or repayment figure shown on this site — including the loan calculator — is an indicative estimate, not an offer. Your actual terms depend on our assessment of your application, identity documents and any security provided, and are confirmed to you in writing before you are asked to accept anything.', 'tuula' ),
	),
	array(
		'title' => __( '3. Borrower obligations and repayments', 'tuula' ),
		'body'  => __( 'You are responsible for providing accurate information and genuine documents with your application, and for repaying your loan according to the schedule set out in your signed loan agreement. If your circumstances change and you expect to miss a payment, contact us before the due date — we would rather adjust a plan with you than apply penalties.', 'tuula' ),
	),
	array(
		'title' => __( '4. Fees', 'tuula' ),
		'body'  => __( 'Every fee that applies to your loan is itemised in your offer before you sign. We do not add charges that were not disclosed upfront. Charges for late or missed payments, where they apply, are set out in your loan agreement.', 'tuula' ),
	),
	array(
		'title' => __( '5. Website use and liability', 'tuula' ),
		'body'  => __( 'This site is provided for information and to let you enquire about or apply for our products. We aim to keep the information accurate, but rates, products and terms can change — always confirm details directly with a loan officer before making financial decisions. To the extent permitted by law, we are not liable for decisions made solely on the basis of indicative figures shown on this site.', 'tuula' ),
	),
	array(
		'title' => __( '6. Governing law and contact', 'tuula' ),
		/* translators: %s: contact email address. */
		'body'  => sprintf( __( 'These terms are governed by the laws of Uganda, and our services are provided in accordance with applicable Ugandan financial services regulations. Questions about these terms can be sent to %s or raised in person at our Kitintale office in Kampala.', 'tuula' ), $email ),
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
