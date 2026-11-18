<?php
/**
 * Template Name: Services (Loan Products)
 *
 * v2 design system: page head, six real loan products (via tuula_products()
 * and the tv2 variant of tuula_product_card()) plus the refinancing and
 * technical-assistance cards, the service-details grid, the audience chips
 * and the final CTA band with the real contact facts.
 */
get_header();

$apply_url   = tuula_page_url( 'apply' );
$contact_url = tuula_page_url( 'contact' );

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Loan services', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( 'Tuula Credit loan services in Uganda', 'tuula' ) );
$hero_intro   = tuula_field( 'page_hero_intro', __( 'Compare the loan products, use cases and documents customers commonly ask about before applying.', 'tuula' ) );
?>

<main id="main" class="tv2-services-page">

	<section class="tv2-page-head tv2-page-head--section" aria-labelledby="services-title">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-page-title" id="services-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-page-sub"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<!-- All services -->
	<section class="tv2-section" id="services" aria-labelledby="services-list-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'All services', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="services-list-title"><?php esc_html_e( 'Choose the loan category that fits the need.', 'tuula' ); ?></h2>
			<p class="tv2-lead"><?php esc_html_e( 'Each product can start through the Apply page, where the calculator and request form collect the basic information Tuula needs for a callback.', 'tuula' ); ?></p>
		</div>

		<div class="tv2-svc-grid">
			<?php
			foreach ( tuula_products() as $product ) {
				tuula_product_card( $product, true, 'tv2' );
			}
			?>
			<article class="tv2-svc-card" id="refinancing">
				<div class="tv2-svc-card__top">
					<span class="tv2-svc-card__icon" aria-hidden="true">R</span>
				</div>
				<h3><?php esc_html_e( 'Refinancing and top-ups', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Speak to the Tuula team if you need to review an active facility, compare repayment options or request additional support.', 'tuula' ); ?></p>
				<ul class="tv2-svc-card__points">
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Active facility review', 'tuula' ); ?></li>
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Repayment comparison', 'tuula' ); ?></li>
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Capacity-based assessment', 'tuula' ); ?></li>
				</ul>
				<a class="tv2-link" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Discuss refinancing', 'tuula' ); ?> →</a>
			</article>
			<article class="tv2-svc-card" id="technical-assistance">
				<div class="tv2-svc-card__top">
					<span class="tv2-svc-card__icon" aria-hidden="true">T</span>
				</div>
				<h3><?php esc_html_e( 'Technical assistance', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Business guidance and practical support for entrepreneurs who need help thinking through growth, viability and financing structure.', 'tuula' ); ?></p>
				<ul class="tv2-svc-card__points">
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Business review', 'tuula' ); ?></li>
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Growth planning', 'tuula' ); ?></li>
					<li><?php echo tuula_svc_check_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Finance readiness', 'tuula' ); ?></li>
				</ul>
				<a class="tv2-link" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Talk to an advisor', 'tuula' ); ?> →</a>
			</article>
		</div>
	</section>

	<!-- Service details -->
	<section class="tv2-section tv2-section--alt" aria-labelledby="depth-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Service details', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="depth-title"><?php esc_html_e( 'Built for the situations people actually borrow for.', 'tuula' ); ?></h2>
		</div>

		<div class="tv2-detail-grid">
			<article>
				<h3><?php esc_html_e( 'Loans for business growth', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For enterprises that need capital to expand, purchase stock, manage cash flow, acquire premises, take on a project or invest in production capacity.', 'tuula' ); ?></p>
			</article>
			<article>
				<h3><?php esc_html_e( 'Loans for school fees', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For parents, guardians and caretakers who need short-term education finance before the school term, during registration or when expenses arrive together.', 'tuula' ); ?></p>
			</article>
			<article>
				<h3><?php esc_html_e( 'Loans against a vehicle logbook', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For vehicle owners who want to unlock cash from a registered motor vehicle while keeping the car available for daily movement or business use.', 'tuula' ); ?></p>
			</article>
			<article>
				<h3><?php esc_html_e( 'Loans for emergencies', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For unexpected medical bills, rent pressure, urgent household needs, transport costs, business interruptions or a temporary gap in income.', 'tuula' ); ?></p>
			</article>
			<article>
				<h3><?php esc_html_e( 'Loans for equipment and assets', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For companies, farms, clinics and operators who need machinery, specialized tools, agricultural equipment, medical devices or production assets.', 'tuula' ); ?></p>
			</article>
			<article>
				<h3><?php esc_html_e( 'Loans with repayment guidance', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'For borrowers who want to understand the estimated monthly repayment, possible documentation and responsible borrowing limits before they commit.', 'tuula' ); ?></p>
			</article>
		</div>
	</section>

	<!-- Who we serve -->
	<section class="tv2-section" aria-labelledby="audience-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Who we serve', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="audience-title"><?php esc_html_e( 'Finance for families, SMEs and institutions across Uganda.', 'tuula' ); ?></h2>
		</div>
		<div class="tv2-audience">
			<div><?php esc_html_e( 'Parents and guardians paying school fees', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'SMEs managing working capital', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Vehicle owners seeking logbook loans', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Farmers and agribusiness operators', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Medical and professional practices', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Institutions with capital needs', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Traders and service businesses', 'tuula' ); ?></div>
			<div><?php esc_html_e( 'Households handling emergency costs', 'tuula' ); ?></div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="tv2-cta" aria-labelledby="services-contact-title">
		<div class="tv2-cta__inner">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Next step', 'tuula' ); ?></p>
			<h2 id="services-contact-title"><?php esc_html_e( 'Estimate a repayment for the service you need.', 'tuula' ); ?></h2>
			<p><?php esc_html_e( 'Open the Apply page to calculate an indicative monthly repayment and submit the request to Tuula Credit.', 'tuula' ); ?></p>
			<div class="tv2-cta__row">
				<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php esc_html_e( 'Calculate and apply →', 'tuula' ); ?></a>
				<a class="tv2-btn tv2-btn--ghost" href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact us', 'tuula' ); ?></a>
			</div>
			<p class="tv2-cta__note">
				<?php echo esc_html( tuula_opt( 'phone_display' ) ); ?> · <?php echo esc_html( tuula_opt( 'email' ) ); ?> · <?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?>
			</p>
		</div>
	</section>

</main>

<?php get_footer(); ?>
