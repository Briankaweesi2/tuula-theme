<?php
$tuula_services_url = tuula_page_url( 'services' );
?>
<footer class="tv2-footer">
	<div class="tv2-footer__grid">
		<div class="tv2-footer__about">
			<span class="tv2-logo tv2-logo--footer" role="img" aria-label="<?php esc_attr_e( 'Tuula Credit', 'tuula' ); ?>"></span>
			<p><?php echo esc_html( tuula_opt( 'footer_tagline', __( 'We help individuals, businesses and institutions build, preserve and manage wealth so they can pursue their financial goals.', 'tuula' ) ) ); ?></p>
		</div>
		<div>
			<h4><?php esc_html_e( 'Company', 'tuula' ); ?></h4>
			<div class="tv2-footer__links">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'tuula' ); ?></a>
				<a href="<?php echo esc_url( tuula_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About us', 'tuula' ); ?></a>
				<a href="<?php echo esc_url( $tuula_services_url ); ?>"><?php esc_html_e( 'Our loans', 'tuula' ); ?></a>
				<a href="<?php echo esc_url( tuula_page_url( 'process' ) ); ?>"><?php esc_html_e( 'Loan process', 'tuula' ); ?></a>
				<a href="<?php echo esc_url( tuula_page_url( 'faqs' ) ); ?>"><?php esc_html_e( 'FAQs', 'tuula' ); ?></a>
				<a href="<?php echo esc_url( tuula_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'tuula' ); ?></a>
			</div>
		</div>
		<div>
			<h4><?php esc_html_e( 'Loans', 'tuula' ); ?></h4>
			<div class="tv2-footer__links">
				<?php foreach ( tuula_products() as $tuula_footer_product ) : ?>
					<a href="<?php echo esc_url( $tuula_services_url . '#' . $tuula_footer_product['anchor'] ); ?>"><?php echo esc_html( $tuula_footer_product['title'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div>
			<h4><?php esc_html_e( 'Get in touch', 'tuula' ); ?></h4>
			<div class="tv2-footer__links">
				<a href="tel:<?php echo esc_attr( tuula_opt( 'phone_tel' ) ); ?>"><?php echo esc_html( tuula_opt( 'phone_display' ) ); ?></a>
				<a href="mailto:<?php echo esc_attr( tuula_opt( 'email' ) ); ?>"><?php echo esc_html( tuula_opt( 'email' ) ); ?></a>
				<a href="<?php echo esc_url( tuula_opt( 'whatsapp_url' ) ); ?>"><?php esc_html_e( 'WhatsApp us', 'tuula' ); ?></a>
				<span class="tv2-footer__muted"><?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?></span>
				<span class="tv2-footer__muted"><?php echo esc_html( tuula_opt( 'address_line_2' ) ); ?></span>
			</div>
		</div>
	</div>
	<div class="tv2-footer__bottom">
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Tuula Credit.</span>
		<div class="tv2-footer__legal">
			<a href="<?php echo esc_url( tuula_opt( 'facebook_url' ) ); ?>">Facebook</a>
			<a href="<?php echo esc_url( tuula_opt( 'twitter_url' ) ); ?>">Twitter</a>
			<?php
			/* Prefer the in-theme Privacy page when it exists; otherwise fall
			   back to the legacy `privacy_url` option (old live-site URL). */
			$tuula_privacy_page = get_page_by_path( 'privacy' );
			$tuula_privacy_href = $tuula_privacy_page instanceof WP_Post ? get_permalink( $tuula_privacy_page ) : tuula_opt( 'privacy_url' );
			?>
			<a href="<?php echo esc_url( $tuula_privacy_href ); ?>"><?php esc_html_e( 'Privacy Policy', 'tuula' ); ?></a>
			<a href="<?php echo esc_url( tuula_page_url( 'terms' ) ); ?>"><?php esc_html_e( 'Terms', 'tuula' ); ?></a>
		</div>
	</div>
</footer>

<a class="whatsapp" href="<?php echo esc_url( tuula_opt( 'whatsapp_url' ) ); ?>" aria-label="<?php esc_attr_e( 'Chat with Tuula Credit on WhatsApp', 'tuula' ); ?>">
	<span><?php esc_html_e( 'Need Help?', 'tuula' ); ?></span>
	<svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
		<path d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.31.635 4.47 1.737 6.32L3 29l7.36-2.19a12.44 12.44 0 0 0 5.641 1.36h.005c6.905 0 12.499-5.596 12.499-12.5C28.505 8.766 22.909 3.17 16.001 3Zm0 22.865h-.004a10.36 10.36 0 0 1-5.278-1.447l-.379-.225-3.939 1.172 1.052-3.84-.247-.394a10.34 10.34 0 0 1-1.586-5.531c0-5.727 4.658-10.386 10.386-10.386 2.775 0 5.383 1.082 7.345 3.046a10.316 10.316 0 0 1 3.041 7.35c0 5.727-4.663 10.255-10.391 10.255Zm5.693-7.735c-.312-.156-1.845-.911-2.13-1.015-.286-.104-.494-.156-.702.156-.208.312-.807 1.015-.989 1.223-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.549-.928-.828-1.554-1.85-1.736-2.163-.182-.312-.02-.481.136-.636.14-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.702-1.693-.963-2.318-.253-.61-.51-.527-.702-.537-.182-.008-.39-.01-.598-.01-.208 0-.546.078-.832.39-.286.312-1.09 1.066-1.09 2.6 0 1.535 1.116 3.018 1.272 3.226.156.208 2.196 3.353 5.32 4.702.744.321 1.324.513 1.777.657.746.237 1.425.204 1.962.124.599-.09 1.845-.754 2.105-1.483.26-.729.26-1.353.182-1.483-.078-.13-.286-.208-.598-.364Z"/>
	</svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
