<?php
/**
 * Template Name: Contact
 *
 * v2 design system: three contact-method cards (call, WhatsApp, visit),
 * then an office photo + the shared tuula_contact_card() beside a message
 * form. The form submits directly to the server (tuula_handle_contact_submit()
 * in functions.php), which emails the real Tuula address via wp_mail();
 * it falls back to a mailto draft only if the request itself fails to reach
 * the server.
 */
get_header();

$hero_eyebrow = tuula_field( 'page_hero_eyebrow', __( 'Get in touch', 'tuula' ) );
$hero_title   = tuula_field( 'page_hero_title', __( "We're easy to reach.", 'tuula' ) );
$hero_intro   = tuula_field( 'page_hero_intro', __( 'Call, WhatsApp, visit the Kitintale office or send a message — the team responds during business hours.', 'tuula' ) );

$img_base = get_template_directory_uri() . '/assets/images/';
?>

<main id="main" class="tv2-contact">

	<section class="tv2-page-head tv2-page-head--section" aria-labelledby="contact-title">
		<p class="tv2-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1 class="tv2-page-title" id="contact-title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="tv2-page-sub"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<section class="tv2-section tv2-contact-section" aria-label="<?php esc_attr_e( 'Ways to contact Tuula Credit', 'tuula' ); ?>">

		<!-- Contact method cards -->
		<div class="tv2-contact-cards">
			<a class="tv2-contact-card" href="tel:<?php echo esc_attr( tuula_opt( 'phone_tel' ) ); ?>">
				<span class="tv2-contact-card__icon" aria-hidden="true">
					<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6 19.8 19.8 0 01-3.1-8.7A2 2 0 014.1 2h3a2 2 0 012 1.7c.1.9.3 1.8.6 2.7a2 2 0 01-.4 2.1L8 9.9a16 16 0 006 6l1.4-1.4a2 2 0 012.1-.4c.9.3 1.8.5 2.7.6a2 2 0 011.8 2.2z"></path></svg>
				</span>
				<h3><?php esc_html_e( 'Call the team', 'tuula' ); ?></h3>
				<p><?php echo esc_html( tuula_opt( 'phone_display' ) ); ?></p>
			</a>
			<a class="tv2-contact-card" href="<?php echo esc_url( tuula_opt( 'whatsapp_url' ) ); ?>">
				<span class="tv2-contact-card__icon" aria-hidden="true">
					<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a4 4 0 01-4 4H8l-5 3V6a4 4 0 014-4h10a4 4 0 014 4v9z" stroke-linejoin="round"></path></svg>
				</span>
				<h3><?php esc_html_e( 'WhatsApp support', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'Start a WhatsApp chat', 'tuula' ); ?></p>
			</a>
			<div class="tv2-contact-card">
				<span class="tv2-contact-card__icon" aria-hidden="true">
					<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 0118 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
				</span>
				<h3><?php esc_html_e( 'Visit our branch', 'tuula' ); ?></h3>
				<p><?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?><br><?php echo esc_html( tuula_opt( 'address_line_2' ) ); ?></p>
			</div>
		</div>

		<!-- Photo + contact card | message form -->
		<div class="tv2-contact-grid">
			<div class="tv2-contact-aside">
				<div class="tv2-contact-photo">
					<img src="<?php echo esc_url( $img_base . 'contact-street.jpg' ); ?>" alt="<?php esc_attr_e( 'Street outside the Tuula Credit office area in Kampala', 'tuula' ); ?>">
				</div>
				<?php tuula_contact_card(); ?>
			</div>

			<div class="tv2-contact-form-card">
				<h3><?php esc_html_e( 'Send us a message', 'tuula' ); ?></h3>
				<p><?php esc_html_e( 'We respond during business hours. Your message is sent straight to the Tuula team.', 'tuula' ); ?></p>
				<form data-tv2-contact-form>
					<div class="tv2-field-grid">
						<label class="tv2-field">
							<span><?php esc_html_e( 'Full name', 'tuula' ); ?></span>
							<input type="text" name="fullName" autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'tuula' ); ?>" required>
						</label>
						<label class="tv2-field">
							<span><?php esc_html_e( 'Email (optional)', 'tuula' ); ?></span>
							<input type="email" name="email" autocomplete="email" placeholder="name@example.com">
						</label>
					</div>
					<div class="tv2-field-grid">
						<label class="tv2-field">
							<span><?php esc_html_e( 'Phone number', 'tuula' ); ?></span>
							<input type="tel" name="phone" autocomplete="tel" placeholder="+256 7XX XXX XXX" required>
						</label>
					</div>
					<label class="tv2-field">
						<span><?php esc_html_e( 'Message', 'tuula' ); ?></span>
						<textarea name="message" rows="5" placeholder="<?php esc_attr_e( 'How can we help?', 'tuula' ); ?>" required></textarea>
					</label>
					<button type="submit" class="tv2-btn tv2-btn--primary tv2-btn--block"><?php esc_html_e( 'Send message', 'tuula' ); ?></button>
					<p class="tv2-form-note" data-contact-status><?php printf( esc_html__( 'Your message goes straight to %s.', 'tuula' ), esc_html( tuula_opt( 'email' ) ) ); ?></p>
				</form>
			</div>
		</div>

	</section>
</main>

<?php get_footer(); ?>
