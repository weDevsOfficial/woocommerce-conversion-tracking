=== WooCommerce Conversion Tracking ===
Contributors: tareq1988
Tags: ecommerce, e-commerce, commerce, woocommerce, tracking, facebook, google, adwords, tracking-pixel
Donate link: https://tareq.co/donate/
Requires at least: 4.0
Tested up to: 4.9.4
Stable tag: 2.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds various conversion tracking codes to cart, checkout, registration success and product page on WooCommerce

== Description ==

When you are integrating any advertising campaigns, they provide various tracking codes (mainly JavaScript) to insert them various pages of your site so that it can track how the conversion is happening.

This plugin inserts those codes on WooCommerce cart page, checkout success page and after user registration. So you can track who are adding your products to cart, who are buying them and who are registering to your site.

= Supported Integrations =

 * [Facebook](https://wedevs.com/docs/woocommerce-conversion-tracking/facebook/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=facebook)
 * [Twitter](https://wedevs.com/docs/woocommerce-conversion-tracking/twitter/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=twitter)
 * [Google Adwords](https://wedevs.com/docs/woocommerce-conversion-tracking/google-adwords/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=google_adwords)
 * [Custom Tracking](https://wedevs.com/docs/woocommerce-conversion-tracking/custom/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=custom)

= Pro Features =

 * More Facebook Events
 * Multiple Facebook Pixels
 * [Facebook Product Catalog](https://wedevs.com/docs/woocommerce-conversion-tracking/facebook/facebook-product-catalog/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=product_catalog)
 * [Perfect Audience](https://wedevs.com/docs/woocommerce-conversion-tracking/perfect-audience/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=perfect_audience)
 * More Twitter and Google Adwords Events

[**Get Pro Version**](https://wedevs.com/woocommerce-conversion-tracking/pricing/?utm_source=wporg&utm_medium=Readme&utm_campaign=wcct-lite&utm_content=pricing)

= Videos =
[youtube http://www.youtube.com/watch?v=PZN883xb51c]
[youtube http://www.youtube.com/watch?v=6QMWzM9decU]

[**All Videos**](https://www.youtube.com/watch?v=b3BHJwQ7Q70&list=PLJorZsV2RVv_7zV2I1_X_xJODZklXHQtS)

= Contribute =
[Github](https://github.com/tareq1988/woocommerce-conversion-tracking)

= Author =
[Tareq Hasan](https://tareq.co)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

= Minimum Requirements =

* WooCommerce 3.0
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Tracking Conversions =

If you need to track successful purchases, go to the settings and in the **Tags for Successful Order** box, place the JavaScript code you received from the services (e.g. Facebook, Twitter, AdWords) you want to use.

In the JavaScript snippet, there are places where you can use `order_number`, `order_total`, `order_subtotal`, `currency`, etc.

The plugin provides the following codes: <code>{customer_id}</code>, <code>{customer_email}</code>, <code>{customer_first_name}</code>, <code>{customer_last_name}</code>, <code>{order_number}</code>, <code>{order_total}</code>, <code>{order_subtotal}</code>, <code>{currency}</code>, <code>{payment_method}</code>.

Replace the script tag values with the suitable codes the plugin provides and finally insert the snippet in the boxes.

== Frequently Asked Questions ==

= Does it work with WooCommerce 2.x and 3.x? =

Yes, the plugin works both with the latest v3.x and the older 2.x versions.

= How conversions are tracked? =

We have three different ways of tracking a conversion. The most used one is when a order has been made.

We put the JavaScript scripts provided by you in the page and it fires a conversion event to that scripts site.


== Screenshots ==

1. Settings Panel
2. Facebook Pixel Setup
3. Google Adwords Conversion Tracking Settings
4. Twitter Purchase Tracking Setup
5. Custom Codes

== Changelog ==

= Version 2.0 (22-February-2018) =

 * Major version released
 * Individual gateway integrations
 * More streamlined and user friendly UI


= Version 1.2.5 (28-December-2017) =

 * Added plugin action links for Docs and Settings.
 * Added a survey for next version features.
 * Updated WooCommerce compatibility version tags.

= 1.2.4 - 01-Aug-2017 =

 * [fix] The tracker option won't go away. Sorry!

= 1.2.3 - 31-July-2017 =

 * [improvement] WooCommerce v3.0 compatibility
 * [new] Added new shortcodes: `{customer_id}`, `{customer_email}`, `{customer_first_name}`, `{customer_last_name}`, `{payment_method}`
 * [new] Added weDevs Insights class

= 1.2.2 - 10-Feb-2017 =

* Updated with plugin slug as the textdomain
* Integration class PHP compatibility

= 1.2.1 - 9-June-2016 =

* [fix] Fatal error on thank you page when without parameters

= 1.2 - 10-April-2016 =

* [new] Order number variable `{order_number}` added on checkout page

= 1.1 - 08-Jan-2016 =

* [new] Dynamic values on product and checkout script

= 1.0 - 08/07/2015 =

* [fix] Removed product specific codes from product single page, should show only on checkout. My bad!

= 0.3 - 31/05/2015 =

* [fix] Product specific code only loads on product page itself, not checkout

= 0.2 - 30/05/2015 =

* Renamed position option "In Footer" to "Inside Body Tag", may be was confusing to users.

= 0.1.1 - 06/04/2014 =

* Added position parameter for display position control

= 0.1 - 27/03/2014 =

* Initial release

== Upgrade Notice ==

N/A