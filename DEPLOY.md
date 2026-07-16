# Tuula Credit WordPress Theme — Deployment Guide

Theme location: `platform/wordpress/tuula-theme/` (source of truth) — packaged as `platform/wordpress/tuula-theme.zip`, ready to upload.

## What this is

A custom-coded WordPress theme restyled around the layout/structure patterns of a reference
competitor site (used only for structural inspiration — no text, images, or design assets were
copied from it), built entirely on Tuula's own real, previously-approved content, contacts, and
imagery from the static prototype at the repo root (`index.html`, `apply.html`, `services.html`,
`process.html`, `faqs.html`, `contact.html`).

Verified locally (via `_local-preview/`, WordPress on `http://localhost:8882`):
- All 6 pages (Home, Apply, Services, Process, FAQs, Contact) return HTTP 200 with zero PHP
  fatal/parse errors.
- Real contact facts carried over correctly: phone `+256 393 25 64 58` (tel link
  `+256393256458`, exactly as in the approved prototype), email `info@tuulacredit.com`,
  WhatsApp `256777030520`.
- All six loan product categories present on the Services page: Business, School Fees, Logbook,
  Asset financing, Emergency, Personal.
- No leftover placeholder/lorem-ipsum text found in any page.
- Loan calculator JS (`assets/js/app.js`) ported over from the working prototype logic.

## Install on the live site

1. **Back up** the live WordPress files and database before touching anything (per
   `docs/wordpress-handoff.md` and `LAUNCH.md`).
2. Upload `tuula-theme.zip` via **WP Admin → Appearance → Themes → Add New → Upload Theme**, or
   unzip it into `wp-content/themes/tuula-theme/` via cPanel File Manager / SFTP.
3. Activate the theme.
4. **Recommended plugin:** [Advanced Custom Fields (ACF)](https://wordpress.org/plugins/advanced-custom-fields/)
   — install and activate it. All page templates are fully wired to ACF via `get_field()`
   (through the null-safe `tuula_field()`/`tuula_opt()` helpers), with the approved prototype
   copy baked in as fallback defaults — so the site renders complete and correct even if ACF is
   deactivated or a field is left blank; ACF only *adds* the ability to edit content in WP Admin
   without a developer. What is editable, and where:

   - **Tuula Settings (WP Admin → Tuula Settings options page):** phone (display + tel link),
     email, WhatsApp link, office address line 1 and 2, Facebook URL, Twitter/X URL, footer
     tagline. These feed the top bar, footer, contact cards on every page and the Contact page.
   - **Home page (Pages → Home):** hero eyebrow, hero title (H1), hero copy, primary CTA label
     ("Apply now"), secondary CTA label ("Explore loan services").
   - **Apply / Services / Process / FAQs / Contact pages (Pages → each):** "Page Hero" group —
     hero eyebrow, hero title (H1) and hero intro paragraph on each page. Left blank, each page
     keeps its approved default heading.
   - **Services page:** "Loan Products" repeater — icon letter, title, description, bullet
     points (one per line), button label, button link, anchor ID and a highlight toggle per
     product. These cards render on the Services page *and* the home-page services grid. Leave
     the repeater empty to keep the built-in six products (Business, School Fees, Logbook,
     Asset financing, Emergency, Personal).
   - **Process page:** "Process Steps" — three repeaters (Personal borrower steps, Business and
     SME steps, Large company steps), each row a step title + description.
   - **FAQs page:** "FAQs" repeater — question + answer rows (same `faqs` field the
     `tuula-headless.php` mu-plugin exposes at `/wp-json/tuula/v1/content`; do not rename).

   **Free-ACF note:** the free ACF plugin does not include the *repeater* field type, so the
   three repeater groups (Loan Products, Process Steps, FAQs) will not show an editing UI in
   WP Admin on free ACF — those blocks then simply render the built-in approved content (or
   values seeded via WP-CLI). All the single-value fields above (settings, heros, CTAs, footer
   tagline) are fully editable in WP Admin on free ACF. To let the client edit the repeater
   blocks in WP Admin too, install **ACF PRO** (or the free "Secure Custom Fields" fork, which
   includes repeaters) — the theme's templates accept both storage formats, no code changes
   needed.
5. Under **Settings → Reading**, set the "Home" page as the static front page (the theme's
   `front-page.php` is the coded homepage template; it does not depend on which page is assigned,
   but WordPress needs a front page set to route `/` correctly).
6. Assign each custom page template under **Pages**: Apply → `template-apply.php`,
   Services → `template-services.php`, Process → `template-process.php`,
   FAQs → `template-faqs.php`, Contact → `template-contact.php`,
   About → `template-about.php`, Privacy Policy → `template-privacy.php`,
   Terms & Conditions → `template-terms.php`.

   **About / Privacy / Terms pages must be created** — they may not exist on the live site
   yet. Create three published Pages with slugs exactly `about`, `privacy` and `terms`
   (the theme's nav/footer links resolve by these slugs via `tuula_page_url()`), then assign
   the templates above. Via WP Admin (Pages → Add New → set slug in the permalink → pick the
   template under Page Attributes), or via WP-CLI:

   ```
   wp post create --post_type=page --post_title=About --post_status=publish --post_name=about
   wp post create --post_type=page --post_title="Privacy Policy" --post_status=publish --post_name=privacy
   wp post create --post_type=page --post_title="Terms & Conditions" --post_status=publish --post_name=terms
   wp post meta update <about-id>   _wp_page_template template-about.php
   wp post meta update <privacy-id> _wp_page_template template-privacy.php
   wp post meta update <terms-id>   _wp_page_template template-terms.php
   ```

   If a Primary menu is assigned under **Appearance → Menus**, also add the About page to it
   (the theme's built-in nav fallback already includes About, but an assigned menu overrides
   the fallback). Privacy and Terms are linked from the footer only.
7. Set permalinks (**Settings → Permalinks**) to "Post name" for clean URLs.
8. Confirm the existing headless-CMS plugin (`wp-content/mu-plugins/tuula-headless.php`) is still
   in place — this theme does not touch or replace it; it coexists with the Flutter app's content
   API.

## Before going live — confirm with the client (do not skip)

- **Reconfirm phone, email, WhatsApp number, and office address are still current** — these were
  carried over verbatim from the existing approved prototype, but should be reconfirmed as of
  today per the `LAUNCH.md` compliance checklist.
- **Any interest rate, loan limit, or tenure figure shown anywhere on the site is an indicative
  example, not a final approved rate.** Finance must review and approve real figures before
  publishing (`LAUNCH.md` §5, marked `[blocker]`). Search the theme templates for rate/example
  figures before launch and confirm each one.
- **The Privacy Policy (`template-privacy.php`) and Terms & Conditions (`template-terms.php`)
  page copy is generic starting-point boilerplate, not final legal text.** It must be reviewed
  and approved by Tuula's own lawyer before those pages go live. It intentionally does not name
  a specific regulator or licence number — counsel should add the correct regulatory references
  (and confirm whether the old live-site privacy policy at
  `https://tuulacredit.com/tuula-credit-privacy-policy/` should be superseded or redirected).
- Add LocalBusiness/FinancialService JSON-LD schema with the *confirmed* address/phone (a
  placeholder/example version may already be present — verify against real data) — hold this
  until after legal review, per `docs/wordpress-handoff.md`.
- Configure SMTP (e.g. WP Mail SMTP) so any contact-form emails to `info@tuulacredit.com` are
  actually delivered, not silently dropped by default PHP `mail()`.
- WP hardening before launch: strong admin password + 2FA, limit login attempts, keep
  core/plugins updated, a WAF/Cloudflare in front, `DISALLOW_FILE_EDIT` set in `wp-config.php`.

## Local preview (for future iteration)

A disposable local WordPress instance lives at `_local-preview/` (repo root, not part of the
deployable theme). Start it and reach the site at `http://localhost:8882`. This is for previewing
theme changes before repackaging — it is not part of what gets deployed.
