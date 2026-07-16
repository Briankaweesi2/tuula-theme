<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.bunny.net">
	<script>
	/* Anti-flash: apply the saved (or OS-preferred) theme before first paint. */
	( function () {
		var theme = null;
		try {
			var saved = localStorage.getItem( 'tuula-theme' );
			if ( saved === 'light' || saved === 'dark' ) {
				theme = saved;
			}
		} catch ( e ) {}
		if ( ! theme ) {
			theme = ( window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) ? 'dark' : 'light';
		}
		document.documentElement.setAttribute( 'data-theme', theme );
	} )();
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'tuula' ); ?></a>

<header class="tv2-header" data-header>
	<div class="tv2-header__inner">
		<a class="tv2-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="tv2-logo" role="img" aria-label="<?php esc_attr_e( 'Tuula Credit', 'tuula' ); ?>"></span>
		</a>

		<nav class="tv2-nav" id="site-nav" data-nav aria-label="<?php esc_attr_e( 'Primary', 'tuula' ); ?>">
			<?php tuula_primary_nav(); ?>
		</nav>

		<div class="tv2-header__right">
			<div class="tv2-header__actions">
				<button class="tv2-theme-toggle" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Toggle dark or light theme', 'tuula' ); ?>">
					<span class="tv2-icon-sun" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" stroke-linecap="round"></path></svg>
					</span>
					<span class="tv2-icon-moon" aria-hidden="true">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.5A8.5 8.5 0 1111.5 3 7 7 0 0021 12.5z"></path></svg>
					</span>
				</button>
				<a class="tv2-header__cta" href="<?php echo esc_url( tuula_page_url( 'apply' ) . '#calculator' ); ?>"><?php esc_html_e( 'Apply →', 'tuula' ); ?></a>
			</div>

			<button class="tv2-nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
				<span></span>
				<span></span>
				<span></span>
				<span class="sr-only"><?php esc_html_e( 'Menu', 'tuula' ); ?></span>
			</button>
		</div>
	</div>
</header>
