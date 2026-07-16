<?php
/**
 * Template Name: Apply (Calculator + Request Form)
 *
 * v2 design system: four-step application wizard
 * (Loan product → Personal info → Loan details → Verification).
 *
 * The loan-details step reuses the theme's shared amortized calculator:
 * app.js drives the math via [data-calculator-form] (same code path as the
 * Home page calculator), theme-v2.js formats the slider displays via
 * [data-tv2-calc], and the wizard step logic lives in theme-v2.js under
 * [data-tv2-wizard]. Submission opens a pre-filled email draft to the real
 * Tuula team address (tuula_opt('email')) — the same lead-capture mechanism
 * the previous Apply form used; there is no loan-application backend on the
 * WordPress side (the real submission flow lives in the mobile app).
 */
get_header();

$page_title = tuula_field( 'page_hero_title', __( 'Apply for a loan', 'tuula' ) );
$page_intro = tuula_field( 'page_hero_intro', __( 'Takes about 4 minutes. Nothing here commits you — you can stop anytime.', 'tuula' ) );

$products = tuula_products();
$img_base = get_template_directory_uri() . '/assets/images/';

$step_labels = array(
	__( 'Loan Product', 'tuula' ),
	__( 'Personal Info', 'tuula' ),
	__( 'Loan Details', 'tuula' ),
	__( 'Verification', 'tuula' ),
);
?>

<main id="main" class="tv2-apply">
	<div class="tv2-page">

		<div class="tv2-page-head">
			<h1 class="tv2-page-title"><?php echo esc_html( $page_title ); ?></h1>
			<p class="tv2-page-sub"><?php echo esc_html( $page_intro ); ?></p>
		</div>

		<!-- Stepper -->
		<div class="tv2-stepper" data-wizard-stepper aria-hidden="false">
			<span class="tv2-stepper__fill" data-wizard-fill aria-hidden="true"></span>
			<?php foreach ( $step_labels as $i => $label ) : ?>
				<div class="tv2-stepper__item<?php echo 0 === $i ? ' is-active' : ''; ?>" data-wizard-item>
					<span class="tv2-stepper__dot">
						<span class="tv2-stepper__num"><?php echo (int) ( $i + 1 ); ?></span>
						<svg class="tv2-stepper__check" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 6L9 17l-5-5" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
					<span class="tv2-stepper__label"><?php echo esc_html( $label ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Wizard. data-calculator-form: app.js computes the shared amortized
		     estimate; data-tv2-calc: theme-v2.js formats slider displays. -->
		<form class="tv2-wizard" id="calculator" data-tv2-wizard data-calculator-form data-tv2-calc>
			<input type="hidden" name="loanType" data-wizard-product-input>

			<!-- Step 1: loan product -->
			<section data-wizard-step="1" aria-label="<?php esc_attr_e( 'Step 1: select a loan product', 'tuula' ); ?>">
				<h2 class="tv2-step-title"><?php esc_html_e( 'Select a loan product', 'tuula' ); ?></h2>
				<div class="tv2-product-grid">
					<?php
					foreach ( $products as $product ) :
						/* The preset link each product already carries (same source
						   the Home panels use) gives the canonical loanType label
						   plus example amount/term/rate for the calculator step. */
						$preset = array();
						$query  = wp_parse_url( $product['url'], PHP_URL_QUERY );
						if ( $query ) {
							parse_str( $query, $preset );
						}
						$loan_label = ! empty( $preset['loanType'] ) ? $preset['loanType'] : $product['title'];
						?>
						<button
							type="button"
							class="tv2-product-card"
							data-wizard-product="<?php echo esc_attr( $loan_label ); ?>"
							<?php if ( ! empty( $preset['amount'] ) ) : ?>data-amount="<?php echo esc_attr( $preset['amount'] ); ?>"<?php endif; ?>
							<?php if ( ! empty( $preset['term'] ) ) : ?>data-term="<?php echo esc_attr( $preset['term'] ); ?>"<?php endif; ?>
							<?php if ( ! empty( $preset['rate'] ) ) : ?>data-rate="<?php echo esc_attr( $preset['rate'] ); ?>"<?php endif; ?>
						>
							<span class="tv2-product-card__icon" aria-hidden="true"><?php echo esc_html( $product['icon'] ); ?></span>
							<span class="tv2-product-card__name"><?php echo esc_html( $product['title'] ); ?></span>
							<span class="tv2-product-card__desc"><?php echo esc_html( $product['copy'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</section>

			<!-- Step 2: personal info -->
			<section data-wizard-step="2" hidden aria-label="<?php esc_attr_e( 'Step 2: personal information', 'tuula' ); ?>">
				<h2 class="tv2-step-title"><?php esc_html_e( 'Tell us about yourself', 'tuula' ); ?></h2>
				<div class="tv2-field-grid">
					<label class="tv2-field">
						<span><?php esc_html_e( 'Full name', 'tuula' ); ?></span>
						<input type="text" name="fullName" autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'tuula' ); ?>" required>
					</label>
					<label class="tv2-field">
						<span><?php esc_html_e( 'Phone number', 'tuula' ); ?></span>
						<input type="tel" name="phone" autocomplete="tel" placeholder="+256 7XX XXX XXX" required>
					</label>
				</div>
				<div class="tv2-field-grid">
					<label class="tv2-field">
						<span><?php esc_html_e( 'Email address (optional)', 'tuula' ); ?></span>
						<input type="email" name="email" autocomplete="email" placeholder="name@example.com">
					</label>
					<label class="tv2-field">
						<span><?php esc_html_e( 'National ID number (optional)', 'tuula' ); ?></span>
						<input type="text" name="nin" autocomplete="off" placeholder="CM XXXXXXXXXXX">
					</label>
				</div>
				<label class="tv2-field">
					<span><?php esc_html_e( 'Employment / business status', 'tuula' ); ?></span>
					<select name="employment">
						<option value=""><?php esc_html_e( 'Select…', 'tuula' ); ?></option>
						<option value="Employed (Salary)"><?php esc_html_e( 'Employed (Salary)', 'tuula' ); ?></option>
						<option value="Self-Employed / Business Owner"><?php esc_html_e( 'Self-Employed / Business Owner', 'tuula' ); ?></option>
						<option value="Freelancer / Contract"><?php esc_html_e( 'Freelancer / Contract', 'tuula' ); ?></option>
						<option value="Other"><?php esc_html_e( 'Other', 'tuula' ); ?></option>
					</select>
				</label>
			</section>

			<!-- Step 3: loan details (shared calculator) -->
			<section data-wizard-step="3" hidden aria-label="<?php esc_attr_e( 'Step 3: loan details', 'tuula' ); ?>">
				<h2 class="tv2-step-title"><?php esc_html_e( 'Loan details', 'tuula' ); ?></h2>
				<div class="tv2-calc tv2-calc--embedded">
					<div class="tv2-calc__row">
						<div class="tv2-calc__labels">
							<span><?php esc_html_e( 'Amount needed', 'tuula' ); ?></span>
							<output data-amount-display>UGX 5,000,000</output>
						</div>
						<input type="range" name="amount" min="500000" max="50000000" step="100000" value="5000000" aria-label="<?php esc_attr_e( 'Loan amount in Ugandan shillings', 'tuula' ); ?>">
					</div>
					<div class="tv2-calc__row">
						<div class="tv2-calc__labels">
							<span><?php esc_html_e( 'Repayment term', 'tuula' ); ?></span>
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
					<p class="tv2-calc__result-label tv2-calc__total-line">
						<?php esc_html_e( 'Total repayment:', 'tuula' ); ?> <span data-total>—</span>
					</p>
				</div>
				<label class="tv2-field">
					<span><?php esc_html_e( "What's the loan for? (optional, helps us respond faster)", 'tuula' ); ?></span>
					<textarea name="purpose" rows="4" placeholder="<?php esc_attr_e( 'e.g. Restocking inventory for my shop', 'tuula' ); ?>"></textarea>
				</label>
				<p class="tv2-form-note"><?php esc_html_e( 'Estimates are indicative only, not final offers. Final terms are confirmed after Tuula reviews your request.', 'tuula' ); ?></p>
			</section>

			<!-- Step 4: verification -->
			<section data-wizard-step="4" hidden aria-label="<?php esc_attr_e( 'Step 4: review and verify', 'tuula' ); ?>">
				<h2 class="tv2-step-title"><?php esc_html_e( 'Review & verify', 'tuula' ); ?></h2>
				<p class="tv2-step-sub"><?php esc_html_e( "Check your details below — this is exactly what we'll use to reach you.", 'tuula' ); ?></p>

				<div class="tv2-review">
					<div class="tv2-review__row">
						<span><?php esc_html_e( 'Loan product', 'tuula' ); ?></span>
						<strong data-review-product>—</strong>
					</div>
					<div class="tv2-review__row">
						<span><?php esc_html_e( 'Applicant', 'tuula' ); ?></span>
						<strong data-review-name>—</strong>
					</div>
					<div class="tv2-review__row">
						<span><?php esc_html_e( 'Contact', 'tuula' ); ?></span>
						<strong data-review-contact>—</strong>
					</div>
					<div class="tv2-review__row">
						<span><?php esc_html_e( 'Amount / term', 'tuula' ); ?></span>
						<strong data-review-amount>—</strong>
					</div>
					<div class="tv2-review__row">
						<span><?php esc_html_e( 'Estimated monthly payment', 'tuula' ); ?></span>
						<strong data-review-monthly>—</strong>
					</div>
				</div>

				<div class="tv2-docnote">
					<strong><?php esc_html_e( 'Documents are verified after you submit', 'tuula' ); ?></strong>
					<small><?php esc_html_e( 'Keep your National ID and any loan-specific documents (logbook, fees invoice, quotation) ready. The Tuula team confirms exactly what is needed when they call — nothing uploads here, and this will not hold up your request.', 'tuula' ); ?></small>
				</div>

				<label class="tv2-check">
					<input type="checkbox" name="consent" data-wizard-consent>
					<span><?php esc_html_e( 'I confirm the details above are accurate and agree that Tuula Credit may contact me about this loan request. I understand submitting does not obligate me to accept any offer.', 'tuula' ); ?></span>
				</label>
			</section>

			<!-- Wizard navigation -->
			<div class="tv2-wizard__nav" data-wizard-nav>
				<button type="button" class="tv2-btn tv2-btn--ghost" data-wizard-back hidden>← <?php esc_html_e( 'Back', 'tuula' ); ?></button>
				<span class="tv2-wizard__spacer" aria-hidden="true"></span>
				<button type="button" class="tv2-btn tv2-btn--primary" data-wizard-next disabled><?php esc_html_e( 'Continue →', 'tuula' ); ?></button>
			</div>
			<p class="tv2-form-note tv2-wizard__status" data-wizard-status hidden><?php esc_html_e( 'Submitting opens an email draft to the Tuula team with your request details.', 'tuula' ); ?></p>
		</form>

		<!-- Success state (replaces the form after submit) -->
		<div class="tv2-success" data-wizard-success hidden>
			<span class="tv2-success__icon" aria-hidden="true">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			<h2><?php esc_html_e( 'Request ready to send', 'tuula' ); ?></h2>
			<p data-wizard-success-copy><?php esc_html_e( 'We have opened an email draft with your details — press send in your email app and the Tuula Credit team will call you to continue your application.', 'tuula' ); ?></p>
			<p class="tv2-form-note">
				<?php esc_html_e( 'Prefer to talk first?', 'tuula' ); ?>
				<a class="tv2-link" href="tel:<?php echo esc_attr( tuula_opt( 'phone_tel' ) ); ?>"><?php echo esc_html( tuula_opt( 'phone_display' ) ); ?></a>
				·
				<a class="tv2-link" href="<?php echo esc_url( tuula_opt( 'whatsapp_url' ) ); ?>"><?php esc_html_e( 'WhatsApp the team', 'tuula' ); ?></a>
			</p>
		</div>

	</div>
</main>

<?php get_footer(); ?>
