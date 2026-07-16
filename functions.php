<?php
/**
 * Tuula Credit theme setup.
 *
 * All editable content is powered by ACF when available, and every ACF call
 * goes through tuula_field()/tuula_opt() so the theme renders complete,
 * approved prototype copy even when ACF is not installed.
 */

defined( 'ABSPATH' ) || exit;

define( 'TUULA_VERSION', '1.2.0' );

/* ------------------------------------------------------------------ *
 *  Real business facts (from the approved static prototype).
 *  These are the graceful-degradation defaults; ACF options override.
 * ------------------------------------------------------------------ */
function tuula_defaults() {
	return array(
		'phone_display'  => '+256 393 25 64 58',
		'phone_tel'      => '+256393256458',
		'email'          => 'info@tuulacredit.com',
		'whatsapp_url'   => 'https://web.whatsapp.com/send?phone=256777030520&text=Hello%2C+how+may+we+help',
		'address_line_1' => 'Plot 1200 Old Port Bell Road, Kitintale',
		'address_line_2' => '2nd Floor Hardware World Mall',
		'facebook_url'   => 'https://www.facebook.com/tuulacredit',
		'twitter_url'    => 'https://twitter.com/TuulaCredit1',
		'privacy_url'    => 'https://tuulacredit.com/tuula-credit-privacy-policy/',
	);
}

/** Null-safe ACF field with default (per-post). */
function tuula_field( $name, $default = '', $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
		if ( null !== $value && '' !== $value && array() !== $value ) {
			return $value;
		}
	}
	return $default;
}

/** Null-safe ACF option with prototype default. */
function tuula_opt( $name, $default = null ) {
	$defaults = tuula_defaults();
	if ( null === $default && isset( $defaults[ $name ] ) ) {
		$default = $defaults[ $name ];
	}
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, 'option' );
		if ( null !== $value && '' !== $value ) {
			return $value;
		}
	}
	return $default;
}

/** Permalink for a page by slug, with a sensible fallback. */
function tuula_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return home_url( user_trailingslashit( $slug ) );
}

/* ------------------------------------------------------------------ *
 *  Theme supports, menus.
 * ------------------------------------------------------------------ */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 220, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tuula' ),
	) );
} );

/* ------------------------------------------------------------------ *
 *  Assets.
 * ------------------------------------------------------------------ */
add_action( 'wp_enqueue_scripts', function () {
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'tuula-fonts',
		'https://fonts.bunny.net/css?family=overpass:400,500,600,700,800|lato:400,700|space-grotesk:600,700|inter:400,500,600,700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'tuula-base', $uri . '/assets/css/styles.css', array( 'tuula-fonts' ), TUULA_VERSION );
	wp_enqueue_style( 'tuula-theme', $uri . '/assets/css/theme.css', array( 'tuula-base' ), TUULA_VERSION );
	/* v2 design system: loads after the legacy stylesheets so `tv2-` components
	   (header, footer, redesigned front page) override where they need to. */
	wp_enqueue_style( 'tuula-theme-v2', $uri . '/assets/css/theme-v2.css', array( 'tuula-theme' ), TUULA_VERSION );

	wp_enqueue_script( 'tuula-app', $uri . '/assets/js/app.js', array(), TUULA_VERSION, true );
	/* v2 interactions: dark/light toggle, loan-solution tabs, calculator displays. */
	wp_enqueue_script( 'tuula-theme-v2', $uri . '/assets/js/theme-v2.js', array( 'tuula-app' ), TUULA_VERSION, true );
	wp_localize_script( 'tuula-app', 'TUULA', array(
		'applyUrl'      => tuula_page_url( 'apply' ),
		'email'         => tuula_opt( 'email' ),
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'contactNonce'  => wp_create_nonce( 'tuula_contact_submit' ),
	) );
} );

/* ------------------------------------------------------------------ *
 *  Contact form: real server-side email delivery via wp_mail().
 * ------------------------------------------------------------------ */
add_action( 'wp_ajax_tuula_contact_submit', 'tuula_handle_contact_submit' );
add_action( 'wp_ajax_nopriv_tuula_contact_submit', 'tuula_handle_contact_submit' );

function tuula_handle_contact_submit() {
	check_ajax_referer( 'tuula_contact_submit', 'nonce' );

	/* Honeypot: real visitors never fill this hidden field. */
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success();
	}

	$name    = isset( $_POST['fullName'] ) ? sanitize_text_field( wp_unslash( $_POST['fullName'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || '' === $phone || '' === $message ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in your name, phone number and message.', 'tuula' ) ), 400 );
	}

	if ( '' === $email || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'tuula' ) ), 400 );
	}

	$to      = tuula_opt( 'email' );
	$subject = sprintf( '[Tuula Credit website] Message from %s', $name );
	$body    = "New message from the Tuula Credit contact form:\n\n"
		. "Name: {$name}\n"
		. "Phone: {$phone}\n"
		. "Email: {$email}\n"
		. "\nMessage:\n{$message}\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$name} <{$email}>",
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'Sorry, your message could not be sent right now. Please call or WhatsApp us instead.', 'tuula' ) ), 500 );
	}

	tuula_send_contact_autoreply( $name, $email, $message );

	wp_send_json_success( array( 'message' => __( 'Thanks — your message has been sent. We will get back to you during business hours. Check your inbox (or spam folder) for our confirmation email.', 'tuula' ) ) );
}

/** Confirmation email sent to the visitor after a successful contact-form submission. */
function tuula_send_contact_autoreply( $name, $email, $message ) {
	$first_name = trim( strtok( $name, ' ' ) );
	$subject    = __( 'We received your message — Tuula Credit', 'tuula' );
	$body       = sprintf(
		"Hi %s,\n\nThanks for reaching out to Tuula Credit. We've received your message and a member of the team will get back to you during business hours.\n\nYour message:\n\"%s\"\n\nNeed a faster answer? Call or WhatsApp us on %s, or visit the office at %s, %s.\n\n— The Tuula Credit team\n%s",
		$first_name ? $first_name : $name,
		$message,
		tuula_opt( 'phone_display' ),
		tuula_opt( 'address_line_1' ),
		tuula_opt( 'address_line_2' ),
		home_url( '/' )
	);
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	wp_mail( $email, $subject, $body, $headers );
}

/* Pages rebuilt on the v2 design system get the fully themed (dark/light)
   body background; legacy templates keep their light styling until their
   own redesign pass. */
add_filter( 'body_class', function ( $classes ) {
	if ( is_front_page() || is_page_template( array( 'template-apply.php', 'template-contact.php', 'template-about.php', 'template-privacy.php', 'template-terms.php', 'template-services.php', 'template-process.php', 'template-faqs.php' ) ) ) {
		$classes[] = 'tv2';
	}
	return $classes;
} );

/* ------------------------------------------------------------------ *
 *  Navigation fallback (before menus are configured in wp-admin).
 * ------------------------------------------------------------------ */
function tuula_nav_fallback() {
	/* Header nav is deliberately short — Home, Process and FAQs stay
	   reachable via the logo (Home) and the footer (Process, FAQs). */
	$items = array(
		'apply'    => __( 'Apply', 'tuula' ),
		'services' => __( 'Services', 'tuula' ),
		'about'    => __( 'About', 'tuula' ),
		'contact'  => __( 'Contact', 'tuula' ),
	);
	foreach ( $items as $slug => $label ) {
		$url     = '' === $slug ? home_url( '/' ) : tuula_page_url( $slug );
		$current = '';
		if ( '' === $slug && ( is_front_page() || is_home() ) ) {
			$current = ' aria-current="page"';
		} elseif ( '' !== $slug && is_page( $slug ) ) {
			$current = ' aria-current="page"';
		}
		printf( '<a href="%s"%s>%s</a>', esc_url( $url ), $current, esc_html( $label ) );
	}
}

/**
 * Primary nav rendered as plain <a> links (the design system styles bare
 * anchors inside .site-nav). Uses the assigned menu when one exists,
 * otherwise falls back to the standard page map.
 */
function tuula_primary_nav() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );
		if ( $items ) {
			$current_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
			foreach ( $items as $item ) {
				$is_current = untrailingslashit( $item->url ) === untrailingslashit( $current_url );
				printf(
					'<a href="%s"%s>%s</a>',
					esc_url( $item->url ),
					$is_current ? ' aria-current="page"' : '',
					esc_html( $item->title )
				);
			}
			return;
		}
	}
	tuula_nav_fallback();
}

/* SEO (titles, meta descriptions, canonical, Open Graph/Twitter, schema,
   sitemap, local business info) is handled by the Rank Math SEO plugin —
   see each Page's Rank Math metabox for its title/description, and
   Rank Math → Titles & Meta → Local SEO for the business profile. */

/* ------------------------------------------------------------------ *
 *  ACF: options page + local field groups (null-safe everywhere).
 * ------------------------------------------------------------------ */
require_once get_template_directory() . '/inc/acf.php';

/* ------------------------------------------------------------------ *
 *  Shared partials.
 * ------------------------------------------------------------------ */

/** Contact card used in the deep-blue contact bands. */
function tuula_contact_card( $show_address = true ) {
	?>
	<div class="contact-card">
		<a href="tel:<?php echo esc_attr( tuula_opt( 'phone_tel' ) ); ?>"><?php echo esc_html( tuula_opt( 'phone_display' ) ); ?></a>
		<a href="mailto:<?php echo esc_attr( tuula_opt( 'email' ) ); ?>"><?php echo esc_html( tuula_opt( 'email' ) ); ?></a>
		<?php if ( $show_address ) : ?>
			<span><?php echo esc_html( tuula_opt( 'address_line_1' ) ); ?></span>
			<span><?php echo esc_html( tuula_opt( 'address_line_2' ) ); ?></span>
		<?php endif; ?>
		<a class="button button--primary" href="<?php echo esc_url( tuula_page_url( 'apply' ) . '#calculator' ); ?>"><?php esc_html_e( 'Calculate and apply', 'tuula' ); ?></a>
	</div>
	<?php
}

/** The six real loan products (codes: BUSINESS, SCHOOL_FEES, LOGBOOK, ASSET, EMERGENCY, PERSONAL). */
function tuula_products_defaults() {
	$apply = tuula_page_url( 'apply' );
	$services = tuula_page_url( 'services' );
	return array(
		'business' => array(
			'icon'   => 'B',
			'title'  => __( 'Business and corporate loans', 'tuula' ),
			'copy'   => __( 'Capital support for companies, institutions and growing SMEs that need working capital, project finance, refinancing or cash-flow support.', 'tuula' ),
			'points' => array( __( 'Business expansion', 'tuula' ), __( 'Inventory and operations', 'tuula' ), __( 'Institutional finance', 'tuula' ) ),
			'cta'    => __( 'Apply for business finance', 'tuula' ),
			'url'    => $apply . '?loanType=Business+or+corporate+loan&amount=25000000&term=24&rate=16#calculator',
			'anchor' => 'business-loans',
		),
		'school_fees' => array(
			'icon'   => 'S',
			'title'  => __( 'School fees loans', 'tuula' ),
			'copy'   => __( 'Short-term education finance for tuition, hostel requirements, scholastic materials and related student needs.', 'tuula' ),
			'points' => array( __( 'Primary and secondary school', 'tuula' ), __( 'University and tertiary needs', 'tuula' ), __( 'Parent and guardian support', 'tuula' ) ),
			'cta'    => __( 'Request school fees support', 'tuula' ),
			'url'    => $apply . '?loanType=School+fees+loan&amount=2000000&term=6&rate=18#calculator',
			'anchor' => 'school-fees-loans',
		),
		'logbook' => array(
			'icon'   => 'L',
			'title'  => __( 'Logbook loans', 'tuula' ),
			'copy'   => __( 'Cash against a motor vehicle logbook registered in your name, with flexible review and the ability to keep using your vehicle during the loan period.', 'tuula' ),
			'points' => array( __( 'New or old cars', 'tuula' ), __( 'Private and business vehicles', 'tuula' ), __( 'Fast document review', 'tuula' ) ),
			'cta'    => __( 'Start a logbook loan request', 'tuula' ),
			'url'    => $apply . '?loanType=Logbook+loan&amount=7000000&term=12&rate=18#calculator',
			'anchor' => 'logbook-loans',
		),
		'asset' => array(
			'icon'   => 'A',
			'title'  => __( 'Asset financing', 'tuula' ),
			'copy'   => __( 'Finance for equipment, machinery, production tools, agricultural assets, medical equipment and other income-generating assets.', 'tuula' ),
			'points' => array( __( 'Equipment purchase', 'tuula' ), __( 'Agricultural assets', 'tuula' ), __( 'Medical and production tools', 'tuula' ) ),
			'cta'    => __( 'Finance an asset', 'tuula' ),
			'url'    => $apply . '?loanType=Asset+financing&amount=12000000&term=18&rate=17#calculator',
			'anchor' => 'asset-finance',
		),
		'emergency' => array(
			'icon'   => 'I',
			'title'  => __( 'Instant and emergency loans', 'tuula' ),
			'copy'   => __( 'Short-term support for sudden financial shocks, urgent bills, household gaps, business interruptions and time-sensitive needs.', 'tuula' ),
			'points' => array( __( 'Emergency cash needs', 'tuula' ), __( 'Mobile support', 'tuula' ), __( 'Simple application steps', 'tuula' ) ),
			'cta'    => __( 'Get urgent help', 'tuula' ),
			'url'    => $apply . '?loanType=Emergency+loan&amount=1500000&term=6&rate=18#calculator',
			'anchor' => 'instant-loans',
			'accent' => true,
		),
		'personal' => array(
			'icon'   => 'P',
			'title'  => __( 'Personal loans', 'tuula' ),
			'copy'   => __( 'Flexible personal credit for planned and unplanned expenses, from household improvements to short-term income gaps.', 'tuula' ),
			'points' => array( __( 'Home needs', 'tuula' ), __( 'Family expenses', 'tuula' ), __( 'Short-term support', 'tuula' ) ),
			'cta'    => __( 'Apply for a personal loan', 'tuula' ),
			'url'    => $apply . '?loanType=Personal+loan&amount=3000000&term=12&rate=18#calculator',
			'anchor' => 'personal-loans',
		),
	);
}

/**
 * Loan products: ACF `loan_products` repeater on the Services page when rows
 * exist, otherwise the approved prototype defaults. Blank sub-fields fall
 * back per-row by position so a partially filled row still renders complete.
 */
function tuula_products() {
	$defaults      = tuula_products_defaults();
	$services_page = get_page_by_path( 'services' );
	$rows          = $services_page instanceof WP_Post
		? tuula_field( 'loan_products', array(), $services_page->ID )
		: array();

	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return $defaults;
	}

	$apply_url      = tuula_page_url( 'apply' );
	$fallback_rows  = array_values( $defaults );
	$products       = array();

	foreach ( $rows as $i => $row ) {
		$fallback = $fallback_rows[ $i ] ?? array();
		$title    = ! empty( $row['title'] ) ? $row['title'] : ( $fallback['title'] ?? '' );

		$points = array();
		if ( ! empty( $row['bullet_points'] ) ) {
			$points = array_values( array_filter( array_map( 'trim', explode( "\n", (string) $row['bullet_points'] ) ) ) );
		}
		if ( empty( $points ) && ! empty( $fallback['points'] ) ) {
			$points = $fallback['points'];
		}

		$icon = ! empty( $row['icon_letter'] ) ? $row['icon_letter'] : ( $fallback['icon'] ?? strtoupper( mb_substr( wp_strip_all_tags( $title ), 0, 1 ) ) );

		$products[] = array(
			'icon'   => $icon,
			'title'  => $title,
			'copy'   => ! empty( $row['description'] ) ? $row['description'] : ( $fallback['copy'] ?? '' ),
			'points' => $points,
			'cta'    => ! empty( $row['cta_label'] ) ? $row['cta_label'] : ( $fallback['cta'] ?? __( 'Apply now', 'tuula' ) ),
			'url'    => ! empty( $row['apply_link'] ) ? $row['apply_link'] : ( $fallback['url'] ?? $apply_url . '#calculator' ),
			'anchor' => ! empty( $row['anchor_id'] ) ? sanitize_title( $row['anchor_id'] ) : ( $fallback['anchor'] ?? sanitize_title( $title ) ),
			'accent' => ! empty( $row['highlight'] ),
		);
	}

	return $products;
}

/** Small check icon used in the tv2 service-card bullet lists. */
function tuula_svc_check_svg() {
	return '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
}

/**
 * Render a product card.
 *
 * @param array  $product     One product from tuula_products().
 * @param bool   $show_points Whether to print the bullet-point list.
 * @param string $variant     'legacy' (original .product-card markup) or
 *                            'tv2' (v2 design-system card, used by the
 *                            redesigned Services page).
 */
function tuula_product_card( $product, $show_points = true, $variant = 'legacy' ) {
	if ( 'tv2' === $variant ) {
		$check_svg = tuula_svc_check_svg();
		$classes   = 'tv2-svc-card' . ( ! empty( $product['accent'] ) ? ' tv2-svc-card--accent' : '' );
		?>
		<article class="<?php echo esc_attr( $classes ); ?>" id="<?php echo esc_attr( $product['anchor'] ); ?>">
			<div class="tv2-svc-card__top">
				<span class="tv2-svc-card__icon" aria-hidden="true"><?php echo esc_html( $product['icon'] ); ?></span>
				<?php if ( ! empty( $product['accent'] ) ) : ?>
					<span class="tv2-badge"><?php esc_html_e( 'Most requested', 'tuula' ); ?></span>
				<?php endif; ?>
			</div>
			<h3><?php echo esc_html( $product['title'] ); ?></h3>
			<p><?php echo esc_html( $product['copy'] ); ?></p>
			<?php if ( $show_points && ! empty( $product['points'] ) ) : ?>
				<ul class="tv2-svc-card__points">
					<?php foreach ( $product['points'] as $point ) : ?>
						<li><?php echo $check_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $point ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<a class="tv2-link" href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['cta'] ); ?> →</a>
		</article>
		<?php
		return;
	}

	$classes = 'product-card' . ( ! empty( $product['accent'] ) ? ' product-card--accent' : '' );
	?>
	<article class="<?php echo esc_attr( $classes ); ?>" id="<?php echo esc_attr( $product['anchor'] ); ?>">
		<span class="product-card__icon"><?php echo esc_html( $product['icon'] ); ?></span>
		<h3><?php echo esc_html( $product['title'] ); ?></h3>
		<p><?php echo esc_html( $product['copy'] ); ?></p>
		<?php if ( $show_points && ! empty( $product['points'] ) ) : ?>
			<ul>
				<?php foreach ( $product['points'] as $point ) : ?>
					<li><?php echo esc_html( $point ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<a href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['cta'] ); ?></a>
	</article>
	<?php
}
