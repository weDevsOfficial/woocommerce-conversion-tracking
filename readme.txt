=== WooCommerce Conversion Tracking ===
Contributors: tareq1988
Tags: ecommerce, e-commerce, commerce, woocommerce, tracking, facebook, google, adwords, tracking-pixel
Donate link: https://tareq.co/donate/
Requires at least: 4.0
Tested up to: 4.5.2
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
[Tareq Hasan](http://tareq.weDevs.com)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

= Minimum Requirements =

* WooCommerce 2.1.0
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

== Frequently Asked Questions ==

Nothing here right now

== Screenshots ==

1. Settings Panel
2. Tracking code on single product.

== Changelog ==

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