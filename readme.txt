=== CF7 Honeypot Lite ===
Contributors: weboksolutions
Tags: contact-form-7, honeypot, anti-spam, spam-protection
Requires at least: 6.2
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight honeypot spam protection for Contact Form 7. Zero config — just add [honeypot] to your form.

== Description ==

CF7 Honeypot Lite adds a simple, effective honeypot field to your Contact Form 7 forms. It catches spam bots by adding a hidden field that real users never see — but bots fill it in automatically, revealing themselves as spam.

**Why this plugin?**

* **Zero configuration** — no settings page, no database writes. Just add the tag and go.
* **Lightweight** — under 10KB total. No bloat, no upsells, no bundled features you don't need.
* **Silent success** — bots see a fake "message sent" response, so they never learn to adapt.
* **Drop-in replacement** — uses the same `[honeypot]` tag as other CF7 honeypot plugins. Switch without editing your forms.
* **Works great alongside Turnstile/reCAPTCHA** — honeypots catch dumb bots, CAPTCHAs catch smart ones.

**How it works:**

1. Add `[honeypot your-field-name]` anywhere in your CF7 form template.
2. The plugin renders a hidden text input that's invisible to humans.
3. Spam bots auto-fill every field they find, including the honeypot.
4. If the honeypot has a value on submission, the form is silently rejected.

== Installation ==

1. Upload the `cf7-honeypot-lite` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu.
3. Edit any Contact Form 7 form and click the **honeypot** button in the toolbar, or manually add `[honeypot your-field-name]` to your form template.

That's it. No settings to configure.

== Frequently Asked Questions ==

= Do I need to configure anything? =

No. Just add the `[honeypot]` tag to your form and the plugin handles everything else.

= Can I use this with Cloudflare Turnstile or reCAPTCHA? =

Absolutely. Honeypots and CAPTCHAs complement each other — honeypots catch simple bots that fill every field, while CAPTCHAs catch more sophisticated ones.

= What happens when a bot is caught? =

The bot sees a fake success message ("Your message has been sent"), so it thinks the submission went through. No email is actually sent.

= Can I switch from the "CF7 Apps" honeypot plugin? =

Yes. CF7 Honeypot Lite uses the same `[honeypot]` form tag, so you can deactivate the old plugin and activate this one — no form changes needed.

= Will this slow down my site? =

No. The plugin adds one tiny CSS file (under 1KB) and a few lines of PHP. There are no JavaScript files, no external requests, and no database queries.

== Changelog ==

= 1.0.0 =
* Initial release.
* Honeypot form tag for Contact Form 7.
* Silent success response for caught bots.
* Tag generator button in CF7 form editor.
