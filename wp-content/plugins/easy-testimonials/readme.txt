=== Easy Testimonials ===
Contributors: richardgabriel, ghuger
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=V7HR8DP4EJSYN
Tags: testimonials, testimonial widget, testimonial feed, random testimonials
Requires at least: 3.1
Tested up to: 4.6.1
Stable tag: 2.0.14
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easy Testimonials is a simple-to-use plugin for adding Testimonials to your WordPress Theme, using a shortcode or a widget.

== Description ==

Easy Testimonials is an easy-to-use plugin that allows users to add Testimonials to the sidebar, as a widget, or to embed testimonials into a Page or Post using the shortcode.  Easy Testimonials also allows you to insert a list of all Testimonials or output a Random Testimonial. Easy Testimonials allows you to include an image with each testimonial - this is a great feature for adding a photo of the testimonial author.  Easy Testimonials uses schema.org compliant markup so that your testimonials appear correctly in search results!

= Easy Testimonials is a great plugin for: =
* Adding Random Testimonials to Your Sidebar
* Adding Random Testimonials to Your Page
* Outputting a List of Testimonials
* Outputting a Fading or Sliding Testimonial Widget
* Able To Use Multiple Testimonial Themes on the Same Page!
* Responsive Themes!
* Displaying an Image with a Testimonial
* Displaying a Testimonial with a Rating
* Displaying Testimonials using Schema.org compliant markup
* Options Allow You to Link Your Testimonials to a Page, Such As a Product Page
* Testimonial Categories Allow You To Easily Organize Testimonials!
* Easy-to-use interface allows you to manage, edit, create, and delete Testimonials with no new knowledge!

= Pro Features include: =
* Collect Testimonials: Front-End Testimonial Form Allows Customers to Submit Testimonials on your Website!
* Multiple Testimonial Forms: use multiple forms to send to specific Testimonial Categories!
* Testimonial Form Spam Prevention: support for Really Simple Captcha and ReCaptcha included!
* Designer Themes: 75+ professionally designed themes for front end display!
* Advanced Transitions: including scrolling, flipping, and tiling!
* Custom Typography Settings: perfectly blend your testimonials into your website with a huge selection of fonts, colors, and sizes, including Google fonts!

Easy Testimonials allows you to set the URL of the View More Link, to display the Testimonial Image, control meta field display, and more!  Controlling the URL of the Testimonials view more link enables you to direct visitors to the product info page that the testimonial is about.  Showing an Image next to a Testimonial is a great tool for social proofing!

Easy Testimonials allows display of custom excerpted Testimonials.  Display custom excerpts in your widgets that draw your visitors into your Testimonial archive!

Collecting Testimonials can be a tedious job - fortunately, in the Pro version of Easy Testimonials, adding a form to your website for users to submit Testimonials is a breeze!  Users can even upload an image with their Testimonial!  Easy Testimonials integrates with Really Simple Captcha and ReCaptcha to prevent spam testimonial submissions.

Easy Testimonials is the easiest way to start adding your customer testimonials, right now!  Click the Download button now to get started.  Easy Testimonials will inherit the styling from your Theme - just install and get to work adding your testimonials!

= Premium Support =

The GoldPlugins team does not provide direct support for Easy Testimonials on the WordPress.org forums. One on one email support is available to people who have purchased Easy Testimonials Pro only. Easy Testimonials Pro also includes tons of extra themes and advanced features including a Testimonial Collection Form, so you should [upgrade today!](https://goldplugins.com/our-plugins/easy-testimonials-details/upgrade-to-easy-testimonials-pro/ "Upgrade to Easy Testimonials Pro")

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the contents of `/easy_testimonials/` to the `/wp-content/plugins/` directory
2. Activate Easy Testimonials through the 'Plugins' menu in WordPress
3. Visit [here](https://goldplugins.com/documentation/easy-testimonials-documentation/easy-testimonials-installation-and-usage-instructions/ "Easy Testimonials Pro Documentation") for information on how to configure and use the plugin.

== Frequently Asked Questions ==

= Help!  I need more information! =

OK!  We have a great page with some helpful information [here](https://goldplugins.com/documentation/easy-testimonials-documentation/ "Easy Testimonials Pro Documentation").

= I Updated, and my formatting changed! =

Yikes!  Before 1.7.2, we were not respecting the content filter when outputting testimonials.  So, you may have to update the CSS of paragraph tags inside .testimonial_body.  For more information, contact us via our website or support forum.

= Hey!  How do I allow my visitors to submit testimonials? =

Great question!  With the Pro version of the plugin, you can do this with our front end form that is output with a shortcode!  Testimonials will show up as pending on the Dashboard, for admin moderation.  Visit [here](https://goldplugins.com/our-plugins/easy-testimonials-details/ "Easy Testimonials Pro") to purchase the Pro version.

= Urk! When I Activate Easy Testimonials, I start having trouble with my Cycle2 powered JavaScript! =

Oh no!  Check the box that is labeled "Disable Cycle2 Output".  This will cease including our JavaScript.

= Yo!  Your plugin is great - I would really like to change the size of the images that are output.  How do I do it? =

Another good question!  With the Pro version of the plugin, you can do this by controlling the Testimonial Image Size drop down menu on the Settings screen.  Depending on your website, using bigger images may require CSS changes to be made.  Visit [here](https://goldplugins.com/our-plugins/easy-testimonials-details/ "Easy Testimonials Pro") to purchase the Pro version.

= Eek!  I love everything about this plugin... but, I don't know how to use it inside my Template Files!  What do I do? =

Don't worry!  WordPress has a great function, ```do_shortcode()```, that will allow you to use our shortcodes inside your theme files.  For example, to output a Random Testimonial in a Theme file, you would do this: ```<?php echo do_shortcode('[random_testimonial count="1"'); ?>```

= Arg!  When using the testimonial Cycle widget, I get weird overlapping text.  What gives? =

You need to update your CSS.  Try something like ```blockquote.easy_testimonial{ background-color: white; }```

= Ack!  This Testimonials Plugin is too easy to use! Will you make it more complicated? =

Never!  Easy is in our name!  If by complicated you mean new and easy to use features, there are definitely some on the horizon!

= Yikes!  I'm getting a ton of spam! =

Never fear, Captcha support is here!  Go install and activate the plugin Really Simple Captcha.  Once done, make sure you have the "Enable Captcha on Submission Form" box checked on your settings, and you should be good to go!

= Help!  I'm having issues getting the Slider to work on my site! =

Never fear, the "Use Cycle Fix" option is here!  Try checking this option and fully refreshing the page (to make sure any and all caches have cleared) -- hopefully everything is working now!

= Blech!  Some of my testimonials are too tall and the text is cut off by the bottom of the slider!  What gives?! =

Ok!  We have the solution to adjust the height to display all of your testimonial!  Use the attribute ```container='1'``` in your shortcode and the javascript will adjust the height to match the content on each transition.

= Hiyo!  My customers are submitting testimonials but no images are showing up.  What gives? =

As a security precaution, our plugin only allows users to upload images of the following file types: PNG, JPG, or GIF.  If they attempt to upload a different file type, or choose not to upload an image, then no image will be attached to the Testimonial.

= What's Going On?!  When I use the [testimonials] shortcode, I'm not seeing anything that looks right! =

Sometimes, your theme or other plugins have shortcodes in the same namespace as ours.  In case you suspect this is happening, use the Shortcode Options on the Basic Settings screen to change our shortcodes -- typically adding easy_ to our shortcodes will fix the problem!

= Hey! How do I change the Width of my Testimonials?! =

Easy!  Just add the attribute width=500px or width=33% (be sure to use the full value, ie 500px, or 33% - otherwise it won't work!)  If not set, Testimonials will size to their container.

== Screenshots ==

1. This is the Add New Testimonial Page.
2. This is the List of Testimonials - from here you can Edit or Delete a Testimonial.
3. This is the Basic Settings Page.
4. This is the Display Options Settings Page.
5. This is the Themes Selection Page.
6. This is the Submission Form Settings Page.
7. This is the Shortcode Generator.
8. This is the Import & Export Testimonials Page.
9. This is the Help & Instructions Page.
10. This is the Random Testimonial Widget.
11. This is the Testimonial Cycle Widget.
12. This is the Testimonial List Widget.
13. This is the Single Testimonial Widget.
14. This is the Testimonial Grid Widget.

== Changelog ==
= 2.0.14 =
* Minor compatibility updates.
* Importer / Exporter updates.

* [View Changelog](https://goldplugins.com/documentation/easy-testimonials-documentation/easy-testimonials-changelog/ "View Changelog")

== Upgrade Notice ==

**2.0.14** Important Update Available!