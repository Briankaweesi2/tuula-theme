# Tuula Credit — WordPress Theme

Custom-coded WordPress theme for [Tuula Financial Services Limited](https://tuulacredit.com), a Ugandan lender. Built from scratch (no page builder), with ACF-editable content and a dark/light design system.

## Pages
Home, Apply (4-step wizard), Services, Process, FAQs, Contact, About, Privacy Policy, Terms & Conditions.

## Requirements
- WordPress 6.0+
- PHP 7.4+
- [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) (recommended — theme renders correct fallback content without it; ACF just adds WP Admin editing)

## Install
1. Upload this theme's contents to `wp-content/themes/tuula-theme/`, or zip it and use **Appearance → Themes → Add New → Upload Theme**.
2. Activate the theme.
3. See [`DEPLOY.md`](DEPLOY.md) for full setup steps (ACF fields, required pages, permalinks).

## Structure
- `style.css` — theme header + legacy design tokens
- `functions.php` — theme setup, ACF field registration, helpers (`tuula_field()`, `tuula_opt()`, `tuula_products()`)
- `assets/css/theme-v2.css`, `assets/js/theme-v2.js` — the dark/light "tv2" design system used across all pages
- `template-*.php` — page templates
- `inc/acf.php` — ACF field group definitions
