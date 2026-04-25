# enfold-ticker

A WordPress plugin that adds a **Ticker** element to the [Enfold theme](https://kriesi.at/themes/enfold/) Advanced Layout Builder (ALB).

## Description

enfold-ticker extends the Enfold ALB with a custom Ticker component. Once installed, admins and editors can drop a news-style scrolling ticker into any page or layout built with the Enfold builder. The ticker scrolls text horizontally across the full width of its container in a seamless, continuous loop.

## Features

- Native ALB element — integrates directly into the Enfold Advanced Layout Builder
- Seamless horizontal scroll loop (left to right, full container width)
- Configurable **content**, **font size**, and **scroll speed**
- Lightweight CSS-based animation
- Translation-ready — ships with English and German (de_DE)

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- [Enfold theme](https://kriesi.at/themes/enfold/) (required — plugin extends the Enfold ALB)

## Installation

1. Upload the `enfold-ticker` folder to `/wp-content/plugins/`
2. Activate the plugin through **Plugins → Installed Plugins** in the WordPress admin
3. Open any page or post in the Enfold Layout Builder
4. Find the **Ticker** element in the ALB element list and drag it into your layout
5. Configure content, font size, and speed in the element options panel
6. Save and preview the page

## ALB Element Options

| Option | Description |
|---|---|
| Content | The text displayed in the scrolling ticker |
| Font Size | Size of the ticker text |
| Speed | How fast the ticker scrolls (slow / medium / fast) |
| Scroll Direction | Direction of scroll — Right to Left (default) or Left to Right |

## Translations

The plugin is fully translation-ready using WordPress `.po` / `.mo` files.

Bundled translations:
- **English** (default)
- **German** — `de_DE`

To add a new language, copy `languages/enfold-ticker.pot` and translate using [Poedit](https://poedit.net/) or a compatible tool.

## License

GPL-2.0 — see [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## Author

[Twinpictures](https://twinpictures.de)

## Changelog

### 0.0.1
- Initial release
