<?php
/**
 * Front page — v2 design system (design-handoff redesign).
 *
 * Hero + trust strip + transparency comparison + loan-solution tabs +
 * how-it-works + live calculator + facts bar + FAQ + final CTA.
 * All numbers and claims come from real theme content (tuula_products(),
 * tuula_opt()); no fabricated stats or testimonials.
 */
get_header();

$apply_url    = tuula_page_url( 'apply' );
$services_url = tuula_page_url( 'services' );
$process_url  = tuula_page_url( 'process' );
$faqs_url     = tuula_page_url( 'faqs' );

$hero_eyebrow = tuula_field( 'hero_eyebrow', __( 'Tuula Financial Services Limited', 'tuula' ) );
$hero_title   = tuula_field( 'hero_title', __( 'Flexible loans for real life and business in Uganda', 'tuula' ) );
$hero_copy    = tuula_field( 'hero_copy', __( 'Get practical financing for school fees, emergencies, logbooks, assets, working capital and larger company needs with guidance before you apply.', 'tuula' ) );

$hero_cta_primary   = tuula_field( 'hero_cta_primary', __( 'Apply now', 'tuula' ) );
$hero_cta_secondary = tuula_field( 'hero_cta_secondary', __( 'Explore loan services', 'tuula' ) );

$products = tuula_products();

/* Photo per loan panel — one unique photo per product, no repeats across the site. */
$panel_photos = array(
	'panel-business.jpg',
	'panel-school-fees.jpg',
	'panel-logbook.jpg',
	'panel-asset.jpg',
	'panel-emergency.jpg',
	'hero-uganda.jpg',
);

$img_base  = get_template_directory_uri() . '/assets/images/';
$check_svg = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
?>

<main id="main">

	<!-- Hero -->
	<section class="tv2-hero" aria-labelledby="hero-title">
		<div class="tv2-hero__grid">
			<div class="tv2-hero__content">
				<span class="tv2-hero__badge">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z" stroke-linejoin="round"></path></svg>
					<?php echo esc_html( $hero_eyebrow ); ?>
				</span>
				<h1 class="tv2-hero__title" id="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
				<p class="tv2-hero__copy"><?php echo esc_html( $hero_copy ); ?></p>
				<div class="tv2-hero__ctas">
					<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php echo esc_html( $hero_cta_primary ); ?> →</a>
					<a class="tv2-btn tv2-btn--ghost" href="#loan-solutions"><?php echo esc_html( $hero_cta_secondary ); ?></a>
				</div>
				<div class="tv2-hero__stats">
					<div>
						<div class="tv2-stat__num">6</div>
						<div class="tv2-stat__label"><?php esc_html_e( 'Loan products', 'tuula' ); ?></div>
					</div>
					<span class="tv2-divider" aria-hidden="true"></span>
					<div>
						<div class="tv2-stat__num">4</div>
						<div class="tv2-stat__label"><?php esc_html_e( 'Clear application steps', 'tuula' ); ?></div>
					</div>
					<span class="tv2-divider" aria-hidden="true"></span>
					<div>
						<div class="tv2-stat__num">1</div>
						<div class="tv2-stat__label"><?php esc_html_e( 'Team for every request', 'tuula' ); ?></div>
					</div>
				</div>
			</div>
			<div class="tv2-hero__media">
				<div class="tv2-hero__photo">
					<img src="<?php echo esc_url( $img_base . 'hero-portrait.jpg' ); ?>" alt="<?php esc_attr_e( 'Ugandan business owner served by Tuula Credit', 'tuula' ); ?>">
				</div>
				<div class="tv2-hero__float">
					<span class="tv2-hero__float-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
					</span>
					<span>
						<strong><?php esc_html_e( 'Estimate first', 'tuula' ); ?></strong>
						<small><?php esc_html_e( 'See your indicative monthly repayment before you commit.', 'tuula' ); ?></small>
					</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Trust strip -->
	<section class="tv2-trust" aria-label="<?php esc_attr_e( 'Why customers trust Tuula', 'tuula' ); ?>">
		<div class="tv2-trust__grid">
			<div class="tv2-trust__item">
				<span class="tv2-trust__icon" aria-hidden="true">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 10h18"></path></svg>
				</span>
				<span>
					<strong><?php esc_html_e( 'Estimates before commitments', 'tuula' ); ?></strong>
					<small><?php esc_html_e( 'Indicative monthly repayment, total interest and total repayment shown before you submit.', 'tuula' ); ?></small>
				</span>
			</div>
			<div class="tv2-trust__item">
				<span class="tv2-trust__icon" aria-hidden="true">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3" stroke-linecap="round"></path></svg>
				</span>
				<span>
					<strong><?php esc_html_e( 'One team, six products', 'tuula' ); ?></strong>
					<small><?php esc_html_e( 'Business, school fees, logbook, asset, emergency and personal loans through one review team.', 'tuula' ); ?></small>
				</span>
			</div>
			<div class="tv2-trust__item">
				<span class="tv2-trust__icon" aria-hidden="true">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a4 4 0 01-4 4H8l-5 3V6a4 4 0 014-4h10a4 4 0 014 4v9z" stroke-linejoin="round"></path></svg>
				</span>
				<span>
					<strong><?php esc_html_e( 'Reachable support', 'tuula' ); ?></strong>
					<small><?php esc_html_e( 'WhatsApp, phone, email or a visit to the Kitintale office — before and after you apply.', 'tuula' ); ?></small>
				</span>
			</div>
			<div class="tv2-trust__item">
				<span class="tv2-trust__icon" aria-hidden="true">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z" stroke-linejoin="round"></path></svg>
				</span>
				<span>
					<strong><?php esc_html_e( 'Responsible lending guidance', 'tuula' ); ?></strong>
					<small><?php esc_html_e( 'Help with eligibility, documents, full loan cost and repayment planning.', 'tuula' ); ?></small>
				</span>
			</div>
		</div>
	</section>

	<!-- Transparency / comparison -->
	<section class="tv2-section" aria-labelledby="compare-title">
		<div class="tv2-compare">
			<div>
				<p class="tv2-eyebrow"><?php esc_html_e( 'Borrow with clarity', 'tuula' ); ?></p>
				<h2 class="tv2-h2" id="compare-title"><?php esc_html_e( 'Know the full picture before you sign anything.', 'tuula' ); ?></h2>
				<p class="tv2-lead"><?php esc_html_e( 'Every Tuula Credit request starts with a clear repayment estimate and human guidance, so you can compare services, understand the process and prepare the right documents before committing.', 'tuula' ); ?></p>
			</div>
			<div class="tv2-compare__table">
				<div class="tv2-compare__row tv2-compare__row--head">
					<span></span>
					<span><?php esc_html_e( 'Typical lender', 'tuula' ); ?></span>
					<span class="tv2-compare__tuula-col"><?php esc_html_e( 'Tuula Credit', 'tuula' ); ?></span>
				</div>
				<div class="tv2-compare__row">
					<span class="tv2-compare__label"><?php esc_html_e( 'Repayment estimate', 'tuula' ); ?></span>
					<span class="tv2-compare__typical"><?php esc_html_e( 'Often after paperwork', 'tuula' ); ?></span>
					<span class="tv2-compare__tuula"><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Before you apply', 'tuula' ); ?></span>
				</div>
				<div class="tv2-compare__row">
					<span class="tv2-compare__label"><?php esc_html_e( 'Total cost of the loan', 'tuula' ); ?></span>
					<span class="tv2-compare__typical"><?php esc_html_e( 'Ask and wait', 'tuula' ); ?></span>
					<span class="tv2-compare__tuula"><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Shown upfront', 'tuula' ); ?></span>
				</div>
				<div class="tv2-compare__row">
					<span class="tv2-compare__label"><?php esc_html_e( 'Guidance', 'tuula' ); ?></span>
					<span class="tv2-compare__typical"><?php esc_html_e( 'Forms only', 'tuula' ); ?></span>
					<span class="tv2-compare__tuula"><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'A person you can talk to', 'tuula' ); ?></span>
				</div>
				<div class="tv2-compare__row">
					<span class="tv2-compare__label"><?php esc_html_e( 'Product range', 'tuula' ); ?></span>
					<span class="tv2-compare__typical"><?php esc_html_e( 'One-size-fits-all', 'tuula' ); ?></span>
					<span class="tv2-compare__tuula"><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php esc_html_e( 'Six loan products', 'tuula' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- Loan solutions (tab picker) -->
	<section class="tv2-section tv2-section--alt" id="loan-solutions" aria-labelledby="loan-solutions-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Loan services', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="loan-solutions-title"><?php esc_html_e( 'Loan solutions from Tuula Credit.', 'tuula' ); ?></h2>
			<p class="tv2-lead"><?php esc_html_e( 'Six core loan categories, each with its own use cases and documents. Pick one to see the details.', 'tuula' ); ?></p>
		</div>

		<div class="tv2-loan-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Loan products', 'tuula' ); ?>">
			<?php $i = 0; foreach ( $products as $product ) : ?>
				<button
					type="button"
					class="tv2-loan-tab<?php echo 0 === $i ? ' is-active' : ''; ?>"
					data-loan-tab="loan-<?php echo esc_attr( $product['anchor'] ); ?>"
					role="tab"
					aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
				><?php echo esc_html( $product['title'] ); ?></button>
			<?php $i++; endforeach; ?>
		</div>

		<div class="tv2-wrap">
			<?php
			$i = 0;
			foreach ( $products as $product ) :
				$photo = $panel_photos[ $i % count( $panel_photos ) ];

				/* Example figures come from the product's Apply-page preset link. */
				$preset = array();
				$query  = wp_parse_url( $product['url'], PHP_URL_QUERY );
				if ( $query ) {
					parse_str( $query, $preset );
				}
				?>
				<div
					class="tv2-loan-panel<?php echo 0 === $i ? ' is-active' : ''; ?>"
					data-loan-panel="loan-<?php echo esc_attr( $product['anchor'] ); ?>"
					<?php echo 0 === $i ? '' : 'hidden'; ?>
				>
					<div>
						<div class="tv2-loan-panel__title-row">
							<h3><?php echo esc_html( $product['title'] ); ?></h3>
							<?php if ( ! empty( $product['accent'] ) ) : ?>
								<span class="tv2-badge"><?php esc_html_e( 'Most requested', 'tuula' ); ?></span>
							<?php endif; ?>
						</div>
						<p class="tv2-loan-panel__copy"><?php echo esc_html( $product['copy'] ); ?></p>
						<?php if ( ! empty( $preset['term'] ) || ! empty( $preset['rate'] ) ) : ?>
							<div class="tv2-loan-panel__meta">
								<?php if ( ! empty( $preset['amount'] ) ) : ?>
									<div>
										<small><?php esc_html_e( 'Example amount', 'tuula' ); ?></small>
										<strong>UGX <?php echo esc_html( number_format( (float) $preset['amount'] ) ); ?></strong>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $preset['term'] ) ) : ?>
									<div>
										<small><?php esc_html_e( 'Example term', 'tuula' ); ?></small>
										<strong><?php echo esc_html( $preset['term'] ); ?> <?php esc_html_e( 'months', 'tuula' ); ?></strong>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $preset['rate'] ) ) : ?>
									<div>
										<small><?php esc_html_e( 'Calculator preset rate', 'tuula' ); ?></small>
										<strong><?php echo esc_html( $preset['rate'] ); ?>% <?php esc_html_e( 'p.a.', 'tuula' ); ?></strong>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['cta'] ); ?></a>
					</div>
					<ul class="tv2-loan-panel__features">
						<?php foreach ( $product['points'] as $point ) : ?>
							<li><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>
					<div class="tv2-loan-panel__photo">
						<img src="<?php echo esc_url( $img_base . $photo ); ?>" alt="" loading="lazy">
					</div>
				</div>
			<?php $i++; endforeach; ?>

			<p class="tv2-loan-more">
				<a class="tv2-link" href="<?php echo esc_url( $services_url ); ?>"><?php esc_html_e( 'Compare all services in detail →', 'tuula' ); ?></a>
			</p>
		</div>
	</section>

	<!-- How it works -->
	<section class="tv2-section" aria-labelledby="steps-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'How it works', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="steps-title"><?php esc_html_e( 'Apply for your loan in four clear steps.', 'tuula' ); ?></h2>
		</div>
		<div class="tv2-steps">
			<div class="tv2-step">
				<span class="tv2-step__num">1</span>
				<h3><?php esc_html_e( 'Calculate', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Choose a loan type and review the estimated monthly repayment before you commit.', 'tuula' ); ?></p>
			</div>
			<div class="tv2-step">
				<span class="tv2-step__num">2</span>
				<h3><?php esc_html_e( 'Submit your request', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Share your contact details, loan purpose and preferred contact time.', 'tuula' ); ?></p>
			</div>
			<div class="tv2-step">
				<span class="tv2-step__num">3</span>
				<h3><?php esc_html_e( 'Verify documents', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Provide ID, income evidence and any loan-specific documents for review.', 'tuula' ); ?></p>
			</div>
			<div class="tv2-step">
				<span class="tv2-step__num">4</span>
				<h3><?php esc_html_e( 'Decision and payout', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Tuula confirms eligibility, repayment terms and next steps before disbursement.', 'tuula' ); ?></p>
			</div>
		</div>
		<p class="tv2-loan-more">
			<a class="tv2-link" href="<?php echo esc_url( $process_url ); ?>"><?php esc_html_e( 'See the full process by customer type →', 'tuula' ); ?></a>
		</p>
	</section>

	<!-- Calculator -->
	<section class="tv2-section tv2-section--alt" id="calculator" aria-labelledby="calc-title">
		<div class="tv2-calc-grid">
			<div>
				<p class="tv2-eyebrow"><?php esc_html_e( 'Repayment calculator', 'tuula' ); ?></p>
				<h2 class="tv2-h2" id="calc-title"><?php esc_html_e( 'Estimate your monthly repayment.', 'tuula' ); ?></h2>
				<p class="tv2-lead"><?php esc_html_e( 'Move the sliders to see an indicative monthly payment, total interest and total repayment. Estimates are a guide only — final terms are confirmed with you during review.', 'tuula' ); ?></p>
			</div>
			<form class="tv2-calc" data-calculator-form data-tv2-calc aria-label="<?php esc_attr_e( 'Loan repayment calculator', 'tuula' ); ?>">
				<input type="hidden" name="loanType" value="<?php esc_attr_e( 'Personal loan', 'tuula' ); ?>">
				<div class="tv2-calc__row">
					<div class="tv2-calc__labels">
						<span><?php esc_html_e( 'Loan amount', 'tuula' ); ?></span>
						<output data-amount-display>UGX 5,000,000</output>
					</div>
					<input type="range" name="amount" min="500000" max="50000000" step="100000" value="5000000" aria-label="<?php esc_attr_e( 'Loan amount in Ugandan shillings', 'tuula' ); ?>">
				</div>
				<div class="tv2-calc__row">
					<div class="tv2-calc__labels">
						<span><?php esc_html_e( 'Term', 'tuula' ); ?></span>
						<output data-term-display><?php esc_html_e( '12 months', 'tuula' ); ?></output>
					</div>
					<input type="range" name="term" min="3" max="36" step="1" value="12" aria-label="<?php esc_attr_e( 'Loan term in months', 'tuula' ); ?>">
				</div>
				<div class="tv2-calc__row">
					<div class="tv2-calc__labels">
						<span><?php esc_html_e( 'Annual interest estimate', 'tuula' ); ?></span>
						<output data-rate-display>18% p.a.</output>
					</div>
					<input type="range" name="rate" min="10" max="24" step="0.5" value="18" aria-label="<?php esc_attr_e( 'Annual interest rate estimate', 'tuula' ); ?>">
				</div>
				<div class="tv2-calc__results" aria-live="polite">
					<div>
						<div class="tv2-calc__result-num tv2-calc__result-num--accent" data-monthly>—</div>
						<div class="tv2-calc__result-label"><?php esc_html_e( 'Monthly payment', 'tuula' ); ?></div>
					</div>
					<div>
						<div class="tv2-calc__result-num" data-principal-display>—</div>
						<div class="tv2-calc__result-label"><?php esc_html_e( 'Principal', 'tuula' ); ?></div>
					</div>
					<div>
						<div class="tv2-calc__result-num" data-interest>—</div>
						<div class="tv2-calc__result-label"><?php esc_html_e( 'Total interest', 'tuula' ); ?></div>
					</div>
				</div>
				<p class="tv2-calc__result-label" style="text-align:center;margin:0 0 18px;">
					<?php esc_html_e( 'Total repayment:', 'tuula' ); ?> <span data-total>—</span>
				</p>
				<a class="tv2-btn tv2-btn--primary" data-calc-apply href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php esc_html_e( 'Continue to application →', 'tuula' ); ?></a>
			</form>
		</div>
	</section>

	<!-- Facts bar -->
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

	<!-- FAQ -->
	<section class="tv2-section" aria-labelledby="faq-title">
		<div class="tv2-section-head">
			<p class="tv2-eyebrow"><?php esc_html_e( 'Questions, answered', 'tuula' ); ?></p>
			<h2 class="tv2-h2" id="faq-title"><?php esc_html_e( 'The things people worry about before applying.', 'tuula' ); ?></h2>
		</div>
		<div class="tv2-faq">
			<div class="tv2-faq__list" data-tv2-faq>
				<div class="tv2-faq__item">
					<button type="button" aria-expanded="false"><?php esc_html_e( 'Will I know the full cost of the loan before I commit?', 'tuula' ); ?></button>
					<div hidden><p><?php esc_html_e( 'Yes. Before you submit a request you can see an indicative monthly repayment, total interest and total repayment in the calculator, and the team confirms final terms with you during review.', 'tuula' ); ?></p></div>
				</div>
				<div class="tv2-faq__item">
					<button type="button" aria-expanded="false"><?php esc_html_e( 'What can I use as security?', 'tuula' ); ?></button>
					<div hidden><p><?php esc_html_e( 'It depends on the loan. A logbook loan uses a motor vehicle logbook registered in your name, and you keep using the vehicle during the loan period. Asset, business and personal loans are reviewed around purpose, capacity and the documents you can provide.', 'tuula' ); ?></p></div>
				</div>
				<div class="tv2-faq__item">
					<button type="button" aria-expanded="false"><?php esc_html_e( 'How fast is the process?', 'tuula' ); ?></button>
					<div hidden><p><?php esc_html_e( 'Timing depends on the loan type and how quickly your documents are verified. The four-step process is designed to keep you informed at every stage, and the team will tell you what to prepare so review moves as fast as possible.', 'tuula' ); ?></p></div>
				</div>
				<div class="tv2-faq__item">
					<button type="button" aria-expanded="false"><?php esc_html_e( 'What happens if my request is not approved?', 'tuula' ); ?></button>
					<div hidden><p><?php esc_html_e( 'The team explains what was missing — documents, security or repayment capacity — and what you can adjust before applying again. An enquiry starts a conversation; it does not lock you into anything.', 'tuula' ); ?></p></div>
				</div>
				<div class="tv2-faq__item">
					<button type="button" aria-expanded="false"><?php esc_html_e( 'How do I apply?', 'tuula' ); ?></button>
					<div hidden><p><?php esc_html_e( 'Start with the calculator, complete the request form and submit your contact details. The team will reach out with the documents and next steps for your loan type.', 'tuula' ); ?></p></div>
				</div>
			</div>
			<p class="tv2-loan-more">
				<a class="tv2-link" href="<?php echo esc_url( $faqs_url ); ?>"><?php esc_html_e( 'Read all FAQs →', 'tuula' ); ?></a>
			</p>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="tv2-cta" aria-labelledby="cta-title">
		<div class="tv2-cta__inner">
			<h2 id="cta-title"><?php esc_html_e( 'Ready to see your numbers?', 'tuula' ); ?></h2>
			<p><?php esc_html_e( 'Estimate your repayment, submit your request and Tuula Credit will reach out with the documents and next steps for your loan type.', 'tuula' ); ?></p>
			<div class="tv2-cta__row">
				<a class="tv2-btn tv2-btn--primary" href="<?php echo esc_url( $apply_url . '#calculator' ); ?>"><?php esc_html_e( 'Start my application →', 'tuula' ); ?></a>
				<a class="tv2-btn tv2-btn--ghost" href="<?php echo esc_url( tuula_opt( 'whatsapp_url' ) ); ?>"><?php esc_html_e( 'WhatsApp the team', 'tuula' ); ?></a>
			</div>
			<p class="tv2-cta__note">
				<?php echo esc_html( tuula_opt( 'phone_display' ) ); ?> · <?php echo esc_html( tuula_opt( 'email' ) ); ?> · <?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?>
			</p>
		</div>
	</section>

</main>

<?php get_footer(); ?>
