=== Enfold Ticker ===
Contributors: twinpictures
Tags: enfold, ticker, news ticker, scrolling text, layout builder
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 0.0.1
License: GPL-2.0
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a Ticker element to the Enfold Advanced Layout Builder.

== Description ==

enfold-ticker extends the Enfold theme Advanced Layout Builder (ALB) with a custom Ticker component. Once installed, admins and editors can drop a scrolling news ticker into any page or layout built with the Enfold builder.

The ticker scrolls text horizontally across the full width of its container in a seamless, continuous loop powered by CSS animation — no jQuery required.

**Features**

* Native ALB element — integrates directly into the Enfold Advanced Layout Builder
* Configurable content, font size, scroll speed, and scroll direction
* Seamless horizontal scroll loop (right to left by default, left to right optional)
* Lightweight CSS animation — no extra JavaScript
* Respects the `prefers-reduced-motion` accessibility media query
* Translation-ready — ships with English and German (de_DE)

**Requirements**

* [Enfold theme](https://kriesi.at/themes/enfold/) must be installed and active

== Installation ==

1. Upload the `enfold-ticker` folder to `/wp-content/plugins/`
2. Activate the plugin through **Plugins → Installed Plugins** in the WordPress admin
3. Open any page or post in the Enfold Layout Builder
4. Find the **Ticker** element in the ALB element list and drag it into your layout
5. Configure content, font size, speed, and scroll direction in the element options panel
6. Save and preview the page

== Frequently Asked Questions ==

= Does this work without the Enfold theme? =

No. This plugin extends the Enfold Advanced Layout Builder and requires the Enfold theme to be installed and active.

= Can I change the ticker text colour and background? =

Not through the ALB panel in this version. You can target `.enfold-ticker` and `.enfold-ticker-content` with custom CSS in your theme or via the WordPress Customizer.

= Why does the ticker stop when a user has reduced motion enabled? =

The plugin respects the `prefers-reduced-motion` accessibility media query. Users who have requested reduced motion in their OS settings will see the ticker paused. This is intentional.

== Screenshots ==

1. Ticker element in the Enfold ALB element picker
2. Ticker element options panel — content, font size, speed, and direction
3. Rendered ticker on the frontend

== Changelog ==

= 0.0.1 =
* Initial release

== Upgrade Notice ==

= 0.0.1 =
Initial release.
