=== Enfold Ticker ===
Contributors: twinpictures
Tags: enfold, ticker, news ticker, scrolling text, layout builder, advanced layout builder
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPL-2.0
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://twinpictures.de

Adds a Ticker element to the Enfold Advanced Layout Builder.

== Description ==

**enfold-ticker** extends the [Enfold](https://kriesi.at/themes/enfold/) theme Advanced Layout Builder (ALB) with a custom **Ticker** element. Site editors can add a horizontal, continuously scrolling news-style ticker to any layout.

The ticker uses CSS animation (no jQuery by default) and scrolls text across the available width, with a seamless loop. Scroll duration is configurable in seconds, with optional right-to-left or left-to-right direction, font size, and full translation support including bundled German (de_DE).

**Features**

* Native ALB shortcode — appears under Content Elements like other Enfold modules
* Configurable text content, font size, scroll duration (5–300 seconds), and direction
* Seamless loop; respects `prefers-reduced-motion`
* Loads styles only when the shortcode is present on the page
* Text domain: `enfold-ticker` — `.pot` and German `.po` / `.mo` included

**Requirements**

* WordPress 6.0 or higher
* PHP 7.4 or higher
* The [Enfold](https://kriesi.at/themes/enfold/) parent theme (active)

== Installation ==

1. Upload the `enfold-ticker` folder to `/wp-content/plugins/`, or install the zip from the Plugins screen.
2. Activate the plugin under **Plugins → Installed Plugins**.
3. Edit a page with the Enfold Layout Builder.
4. In **Add Elements → Content Elements**, choose **Ticker** and place it in your layout.
5. Set content, font size, scroll duration, and direction in the element options.
6. Save and view the page on the front end.

== Frequently Asked Questions ==

= Does this work without the Enfold theme? =

No. The plugin registers an Avia/ALB element; Enfold (with its builder) is required.

= Can I change colours or background in the element options? =

Not in the current version. You can style `.enfold-ticker` and related classes in your child theme or Customizer CSS.

= Why does the animation stop for some users? =

The stylesheet respects the `prefers-reduced-motion` media query. Users who have reduced motion enabled in the OS or browser will see a non-animated display.

= How do I customize the element icon in the ALB? =

The plugin picks an existing image from the theme’s Avia `images` folder. You can override the URL with the `enfold_ticker_alb_icon_url` filter (see the main plugin file).

== Screenshots ==

1. Ticker in the Enfold ALB element list (Content Elements)
2. Ticker options: content, font size, scroll duration, direction
3. Ticker on the front end in a color section

== Changelog ==

= 0.1.0 =
* Release 0.1.0. README and metadata alignment; ALB icon resolution from theme images; full-width and marquee behaviour updates.

= 0.0.1 =
* Initial public structure.

== Upgrade Notice ==

= 0.1.0 =
Maintenance release. Update the plugin; clear caches if you use a page cache.
