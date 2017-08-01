=== WooCommerce Conversion Tracking ===
Contributors: tareq1988
Tags: ecommerce, e-commerce, commerce, woocommerce, tracking, facebook, google, adwords, tracking-pixel
Donate link: https://tareq.co/donate/
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds various conversion tracking codes to cart, checkout, registration success and product page on WooCommerce

== Description ==

When you are integrating any advertising campaigns, they provide various tracking codes (mainly JavaScript) to insert them various pages of your site so that it can track how the conversion is happening.

This plugin inserts those codes on WooCommerce cart page, checkout success page and after user registration. So you can track who are adding your products to cart, who are buying them and who are registering to your site.

= Contribute =
[Github](https://github.com/tareq1988/woocommerce-conversion-tracking)

= Author =
[Tareq Hasan](https://tareq.co)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

= Minimum Requirements =

* WooCommerce 2.1.0
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

== Frequently Asked Questions ==

= Does it work with WooCommerce 2.x and 3.x? =

Yes, the plugin works both with the latest v3.x and the older 2.x versions.

= How conversions are tracked? =

We have three different ways of tracking a conversion. The most used one is when a order has been made.

We put the JavaScript scripts provided by you in the page and it fires a conversion event to that scripts site.


== Screenshots ==

1. Settings Panel
2. Tracking code on single product.

== Changelog ==

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