# Web Ok Honeypot Lite for CF7

### Lightweight spam protection for Contact Form 7

Adds a hidden honeypot field to CF7 forms that catches spam bots without CAPTCHA friction. Zero configuration — just drop `[honeypot]` into your form template. Bots that fill the field are silently rejected with a fake success response so they never learn to adapt.

---

## Features

- **Zero configuration** — no settings page, no database writes. Add the tag and go.
- **Lightweight** — under 10KB total. No bloat, no upsells, no bundled features you don't need.
- **Silent success** — bots see a fake "message sent" response, so they never learn to adapt.
- **Drop-in replacement** — uses the same `[honeypot]` tag as other CF7 honeypot plugins. Switch without editing your forms.
- **Works great alongside Turnstile / reCAPTCHA** — honeypots catch dumb bots, CAPTCHAs catch smart ones.

## Requirements

- WordPress 6.2+
- PHP 7.4+
- Contact Form 7 (any recent version)

## Installation

1. Upload the `web-ok-honeypot-lite-for-cf7` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu.
3. Edit any CF7 form and click the **honeypot** button in the toolbar, or manually add `[honeypot your-field-name]` to your form template.

That's it. No settings to configure.

## How It Works

1. Add `[honeypot your-field-name]` anywhere in your CF7 form template.
2. The plugin renders a hidden text input invisible to human users (positioned offscreen via CSS — not `display:none`, which smarter bots can detect).
3. Spam bots auto-fill every field they find, including the honeypot.
4. If the honeypot has a value on submission, the form is silently rejected and the bot receives a fake success message.

## Usage

**Via the CF7 editor toolbar:**
Click the **honeypot** button above the form template textarea — it opens a tag generator dialog to name your field and insert the tag.

**Manually:**

```
[honeypot honeypot-field]
```

## FAQ

**Do I need to configure anything?**
No. Just add the `[honeypot]` tag to your form and the plugin handles everything else.

**Can I use this alongside Cloudflare Turnstile or reCAPTCHA?**
Absolutely. They complement each other — honeypots catch simple bots, CAPTCHAs catch more sophisticated ones.

**What happens when a bot is caught?**
The bot receives a fake success message and no email is sent.

**Can I switch from another CF7 honeypot plugin?**
Yes. Web Ok Honeypot Lite uses the same `[honeypot]` tag, so you can swap plugins without editing your forms.

**Will this slow down my site?**
No. One small CSS file, a few lines of PHP, no JavaScript, no external requests, no database queries.

## License

[GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html)

## Author

[Web Ok Solutions Inc.](https://webok.ca/)
