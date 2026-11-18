<?php
/**
 * ACF integration: options page + local field groups.
 * Everything here is optional — the theme renders full prototype content
 * when ACF is absent (see tuula_field()/tuula_opt() in functions.php).
 */

defined( 'ABSPATH' ) || exit;

/* Options page for site-wide contact facts. */
add_action( 'acf/init', function () {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => __( 'Tuula Site Settings', 'tuula' ),
			'menu_title' => __( 'Tuula Settings', 'tuula' ),
			'menu_slug'  => 'tuula-settings',
			'capability' => 'manage_options',
			'redirect'   => false,
		) );
	}

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* ── Site settings (contact facts; defaults = approved prototype values) ── */
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_settings',
		'title'  => 'Tuula Site Settings',
		'fields' => array(
			array( 'key' => 'field_tuula_phone_display', 'name' => 'phone_display', 'label' => 'Phone (display)', 'type' => 'text', 'default_value' => '+256 393 25 64 58' ),
			array( 'key' => 'field_tuula_phone_tel', 'name' => 'phone_tel', 'label' => 'Phone (tel: link, no spaces)', 'type' => 'text', 'default_value' => '+256393256458' ),
			array( 'key' => 'field_tuula_email', 'name' => 'email', 'label' => 'Email address', 'type' => 'email', 'default_value' => 'info@tuulacredit.com' ),
			array( 'key' => 'field_tuula_whatsapp', 'name' => 'whatsapp_url', 'label' => 'WhatsApp link', 'type' => 'url', 'default_value' => 'https://web.whatsapp.com/send?phone=256777030520&text=Hello%2C+how+may+we+help' ),
			array( 'key' => 'field_tuula_addr1', 'name' => 'address_line_1', 'label' => 'Address line 1', 'type' => 'text', 'default_value' => 'Plot 1200 Old Port Bell Road, Kitintale' ),
			array( 'key' => 'field_tuula_addr2', 'name' => 'address_line_2', 'label' => 'Address line 2', 'type' => 'text', 'default_value' => '2nd Floor Hardware World Mall' ),
			array( 'key' => 'field_tuula_facebook', 'name' => 'facebook_url', 'label' => 'Facebook URL', 'type' => 'url', 'default_value' => 'https://www.facebook.com/tuulacredit' ),
			array( 'key' => 'field_tuula_twitter', 'name' => 'twitter_url', 'label' => 'Twitter/X URL', 'type' => 'url', 'default_value' => 'https://twitter.com/TuulaCredit1' ),
			array( 'key' => 'field_tuula_footer_tagline', 'name' => 'footer_tagline', 'label' => 'Footer tagline', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'We help individuals, businesses and institutions build, preserve and manage wealth so they can pursue their financial goals.' ),
		),
		'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'tuula-settings' ) ) ),
	) );

	/* ── Home hero (front page) ── */
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_home_hero',
		'title'  => 'Home Hero',
		'fields' => array(
			array( 'key' => 'field_tuula_hero_eyebrow', 'name' => 'hero_eyebrow', 'label' => 'Hero eyebrow', 'type' => 'text', 'default_value' => 'Tuula Financial Services Limited' ),
			array( 'key' => 'field_tuula_hero_title', 'name' => 'hero_title', 'label' => 'Hero title (H1)', 'type' => 'text', 'default_value' => 'Flexible loans for real life and business in Uganda' ),
			array( 'key' => 'field_tuula_hero_copy', 'name' => 'hero_copy', 'label' => 'Hero copy', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Get practical financing for school fees, emergencies, logbooks, assets, working capital and larger company needs with guidance before you apply.' ),
			array( 'key' => 'field_tuula_hero_cta_primary', 'name' => 'hero_cta_primary', 'label' => 'Primary CTA label', 'type' => 'text', 'default_value' => 'Apply now' ),
			array( 'key' => 'field_tuula_hero_cta_secondary', 'name' => 'hero_cta_secondary', 'label' => 'Secondary CTA label', 'type' => 'text', 'default_value' => 'Explore loan services' ),
		),
		'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
	) );

	/* ── Page hero (eyebrow / H1 / intro) on the five template pages ──
	 * Defaults are intentionally empty: each template falls back to its own
	 * approved prototype copy when a field is left blank (see tuula_field()).
	 */
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_page_hero',
		'title'  => 'Page Hero',
		'fields' => array(
			array( 'key' => 'field_tuula_page_hero_eyebrow', 'name' => 'page_hero_eyebrow', 'label' => 'Hero eyebrow (small label above the title)', 'type' => 'text' ),
			array( 'key' => 'field_tuula_page_hero_title', 'name' => 'page_hero_title', 'label' => 'Hero title (H1)', 'type' => 'text' ),
			array( 'key' => 'field_tuula_page_hero_intro', 'name' => 'page_hero_intro', 'label' => 'Hero intro paragraph', 'type' => 'textarea', 'rows' => 3 ),
		),
		'location' => array(
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-apply.php' ) ),
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-services.php' ) ),
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-process.php' ) ),
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-faqs.php' ) ),
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-contact.php' ) ),
		),
	) );

	/* ── Loan products repeater on the Services page ──
	 * Rows override the six built-in products (Business, School fees,
	 * Logbook, Asset, Emergency, Personal) rendered on Services AND on the
	 * home page grid. Leave the repeater empty to keep the approved
	 * prototype products; blank sub-fields fall back per-row by position.
	 */
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_products',
		'title'  => 'Loan Products',
		'fields' => array(
			array(
				'key'          => 'field_tuula_products',
				'name'         => 'loan_products',
				'label'        => 'Loan products',
				'instructions' => 'Shown on the Services page and the home-page services grid. Leave empty to use the built-in six products.',
				'type'         => 'repeater',
				'layout'       => 'row',
				'button_label' => 'Add loan product',
				'sub_fields'   => array(
					array( 'key' => 'field_tuula_product_icon', 'name' => 'icon_letter', 'label' => 'Icon letter', 'type' => 'text', 'maxlength' => 2 ),
					array( 'key' => 'field_tuula_product_title', 'name' => 'title', 'label' => 'Title', 'type' => 'text' ),
					array( 'key' => 'field_tuula_product_copy', 'name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3 ),
					array( 'key' => 'field_tuula_product_points', 'name' => 'bullet_points', 'label' => 'Bullet points (one per line)', 'type' => 'textarea', 'rows' => 3 ),
					array( 'key' => 'field_tuula_product_cta', 'name' => 'cta_label', 'label' => 'Button label', 'type' => 'text' ),
					array( 'key' => 'field_tuula_product_url', 'name' => 'apply_link', 'label' => 'Button link (optional; defaults to the Apply page)', 'type' => 'url' ),
					array( 'key' => 'field_tuula_product_anchor', 'name' => 'anchor_id', 'label' => 'Anchor ID (optional, for #links)', 'type' => 'text' ),
					array( 'key' => 'field_tuula_product_accent', 'name' => 'highlight', 'label' => 'Highlight this card', 'type' => 'true_false', 'ui' => 1 ),
				),
			),
		),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-services.php' ) ) ),
	) );

	/* ── Process steps (three journeys) on the Process page ── */
	$tuula_step_subfields = function ( $prefix ) {
		return array(
			array( 'key' => 'field_tuula_' . $prefix . '_step_title', 'name' => 'title', 'label' => 'Step title', 'type' => 'text' ),
			array( 'key' => 'field_tuula_' . $prefix . '_step_copy', 'name' => 'description', 'label' => 'Step description', 'type' => 'textarea', 'rows' => 2 ),
		);
	};
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_process',
		'title'  => 'Process Steps',
		'fields' => array(
			array(
				'key'          => 'field_tuula_steps_personal',
				'name'         => 'personal_steps',
				'label'        => 'Personal borrower steps',
				'instructions' => 'Leave empty to keep the built-in four steps.',
				'type'         => 'repeater',
				'layout'       => 'row',
				'button_label' => 'Add step',
				'sub_fields'   => $tuula_step_subfields( 'personal' ),
			),
			array(
				'key'          => 'field_tuula_steps_business',
				'name'         => 'business_steps',
				'label'        => 'Business and SME steps',
				'instructions' => 'Leave empty to keep the built-in four steps.',
				'type'         => 'repeater',
				'layout'       => 'row',
				'button_label' => 'Add step',
				'sub_fields'   => $tuula_step_subfields( 'business' ),
			),
			array(
				'key'          => 'field_tuula_steps_corporate',
				'name'         => 'corporate_steps',
				'label'        => 'Large company steps',
				'instructions' => 'Leave empty to keep the built-in four steps.',
				'type'         => 'repeater',
				'layout'       => 'row',
				'button_label' => 'Add step',
				'sub_fields'   => $tuula_step_subfields( 'corporate' ),
			),
		),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-process.php' ) ) ),
	) );

	/* ── FAQs repeater on the faqs page ──
	 * Field name `faqs` with sub-fields `question`/`answer` intentionally
	 * matches what platform/wordpress/mu-plugins/tuula-headless.php exposes
	 * at /wp-json/tuula/v1/content. Do not rename.
	 */
	acf_add_local_field_group( array(
		'key'    => 'group_tuula_faqs',
		'title'  => 'FAQs',
		'fields' => array(
			array(
				'key'          => 'field_tuula_faqs',
				'name'         => 'faqs',
				'label'        => 'FAQs',
				'type'         => 'repeater',
				'layout'       => 'row',
				'button_label' => 'Add FAQ',
				'sub_fields'   => array(
					array( 'key' => 'field_tuula_faq_q', 'name' => 'question', 'label' => 'Question', 'type' => 'text' ),
					array( 'key' => 'field_tuula_faq_a', 'name' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'rows' => 3 ),
				),
			),
		),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-faqs.php' ) ) ),
	) );
} );
