# enfold-ticker — Claude Code Project Memory

## Plugin Overview

**enfold-ticker** adds a custom Ticker element to the [Enfold theme](https://kriesi.at/themes/enfold/) Advanced Layout Builder (ALB). It renders a seamless, horizontally scrolling news ticker on the frontend.

## Plugin Identity

| Field | Value |
|---|---|
| Plugin Name | enfold-ticker |
| Text Domain | `enfold-ticker` |
| Author | Twinpictures |
| Version | 0.1.0 |
| License | GPL-2.0 |
| Min WordPress | 6.0 |
| Min PHP | 7.4 |

## Functional Requirements

### ALB Component Options
- **Content** — the ticker text displayed to visitors
- **Font Size** — controls the text size of the ticker
- **Scroll duration** — integer (seconds, 5–300) for one full loop; lower = faster
- **Scroll Direction** — `rtl` (default) or `ltr`

### Ticker Behavior
- Scroll direction is configurable; **RTL is the default** (text enters from the right, exits at the left — standard news ticker behaviour)
- LTR option: text enters from the left, exits at the right edge
- Seamless loop: text that scrolls off one edge reappears from the opposite edge
- Width: 100% of the parent wrapper element
- Implemented with CSS animation (no jQuery dependency if avoidable)

### Users
- **Backend:** site admins and editors configure the component in the Enfold ALB
- **Frontend:** scrolling ticker is displayed to public visitors

## Internationalization

- All code and inline comments are in **English**
- Plugin uses WordPress i18n standard (`.po` / `.mo` files)
- Translation files live in `languages/`
- **German (de_DE)** translation is bundled with the plugin
- Use `__()`, `_e()`, `esc_html__()` etc. with text domain `enfold-ticker`

## File Structure (target)

```
enfold-ticker/
├── enfold-ticker.php          # Main plugin file, plugin header, bootstrap, avia_load_shortcodes
├── shortcodes/
│   └── avia-ticker.php         # aviaShortcodeTemplate class (loaded by Enfold)
├── assets/
│   ├── css/
│   │   └── enfold-ticker.css  # Frontend ticker styles + animation
│   └── js/
│       └── enfold-ticker.js   # Optional JS (only if CSS alone is insufficient)
├── languages/
│   ├── enfold-ticker-de_DE.po
│   └── enfold-ticker-de_DE.mo
├── README.md
└── CLAUDE.md
```

## Key Technical Decisions

- Register the ALB element by adding the `shortcodes/` directory to Enfold’s `avia_load_shortcodes` filter and extending `aviaShortcodeTemplate` (Enfold’s discovery path is required; `avia_builder_init` alone is not sufficient)
- Enqueue CSS only on pages where the shortcode is present (use `wp_enqueue_style` conditionally or via shortcode render method)
- CSS animation preferred over JS marquee for performance and accessibility
- Scroll duration (seconds) maps to a CSS `animation-duration` value
- ALB tab for the element uses Enfold’s `__( 'Content Elements', 'avia_framework' )` so it groups with the default Content Elements, not a separate tab

## Conventions

- PSR-2 coding style for PHP
- WordPress Coding Standards for hooks, filters, escaping, and sanitization
- All output is escaped (`esc_html`, `esc_attr`, `wp_kses_post` as appropriate)
- No direct database queries; use WordPress options API if settings storage is needed
- Prefix all functions, classes, and hooks with `enfold_ticker_` or `EnfoldTicker`
