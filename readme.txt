=== Magic Action Box ===
Contributors: prosulum, pogidude
Developer: Prosulum
Tags: opt in, call to action, aweber, email, email marketing, form, mailing list, marketing, newsletter, webform, mailchimp, constant contact
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 2.12

Magic Action Box let's you display professional looking opt-in forms and feature boxes in your WordPress site.

== Description ==

Magic Action Box is an easy to use but powerful lead generation plugin that lets you create a focused and high converting feature box in minutes. It let's you display professional looking opt-in forms and feature boxes in your WordPress site.

Magic Action Box also integrates with Gravity Forms to build complex, powerful and beautiful contact forms in just minutes.

Some features:

* Easily add an action box before or after a blog post or page
* Easily add opt in forms - with stunning designs - to your sidebar
* Create Email Opt In Forms
* Integrates with Gravity Forms
* Make your own action box styles
* Or, pick a style from one of the pre-configured designs

[See more features in Pro version](http://www.magicactionbox.com/?pk_campaign=LITE&pk_kwd=pluginPage1)

Some features available in Pro version:

* Create Contact Form Boxes
* Create Sales Boxes
* Create Share Boxes
* Create Custom CSS3 Buttons
* Display random action boxes
* Show video (not just images) with your action boxes
* More pre-designed styles
* Shortcodes and template tag
* Sidebar Widget
* VIP Support
* [And more...](http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=pluginPage2)

[View changelog](http://www.magicactionbox.com/features/?pk_campaign=LITE&pk_kwd=pluginPage2)


== Installation ==

1. Download the zip-archive and extract it into your computer.
2. Upload the magic-action-box folder to the /wp-content/plugins/ directory in your web site.
3. Activate the plugin through the 'Plugins' menu in your WordPress administration page.


== Frequently Asked Questions ==

= My autoresponder is not on the list. Can I use it with the plugin? =

Yes you can. As long as your autoresponder lets you create html forms that you can copy and paste, then you are all good. Watch this [video tutorial](http://www.magicactionbox.com/how-use-magic-action-box-with-any-email-marketing-service/?pk_campaign=LITE&pk_kwd=faq) to learn more.

= Can I place an action box on my website's sidebar? =

Yes. In the WordPress Dashboard, go to the Widgets page and lookg for the Magic Action Box Widget (available only in Pro).
=======
2. Upload the magic-action-box-lite folder to the /wp-content/plugins/ directory in your web site.
3. Activate the plugin through the 'Plugins' menu in your WordPress administration page.

== Frequently Asked Questions ==

= My autoresponder is not on the list. Can I use it with the plugin? =
Yes you can. As long as your autoresponder lets you create html forms that you can copy and paste, then you are all good. Watch this [video tutorial](http://www.magicactionbox.com/how-use-magic-action-box-with-any-email-marketing-service/) to learn more.

= Shortcode and Template Tag (available in Pro) =

You may use the *[magicactionbox id="ACTION BOX ID"]* shortcode in your blog posts or the `mab_get_actionbox( ACTION_BOX_ID )` template tag in your theme template.

= Can I place an action box on my website's sidebar? =

Yes. In the WordPress Dashboard, go to the Widgets page and lookg for the Magic Action Box Widget.

= My action box doesn't seem to have any styles to it. What's wrong? =

Make sure that your uploads directory wp-content/uploads/ is writeable (it usually is). Then save your action box or custom style again to allow the plugin to generate the required css code.

= My action box has a lot of empty spaces and line breaks in it. = 

Go to Magic Action Box Settings -> Main Settings and check the Minify HTML Output checkbox.

= My action box styles are gone. What did your update do? =

If you just upgrade from any version below 2.8, then this is expected due to the big improvements in the code. We're sorry for the scare but don't worry, just follow the steps [in this guide](http://www.magicactionbox.com/fixing-action-box-styles-v2-8-upgrade/?pk_campaign=LITE&pk_kwd=faq) and you should get back your converting users in no time.

= I just recently updated the plugin and the action box looks weird. =

Try clearing the plugin cache using the *Clear Cache* button found in WP Admin -> Magic Action Box Settings -> Main Settings

= The action box is showing up after some other social sharing icons placed by another plugin. But I want it to show up right after the blog post =

Try checking the *Reorder post content filter priorities* checkbox found in WP Admin -> Magic Action Box Settings -> Main Settings. Please understand that this may not solve the problem and may conflict with other plugins too. Just uncheck it if it does.


== Screenshots ==

1. Main Settings Screen
2. Button Designs Screen
3. Sample Action Box
4. Select Action Box Type
5. Action Box Settings Screen

== Changelog ==
= 2.12 =
* Added Gravity Forms add-on
* Improved custom style generator
* Improved the category tab in main settings to also display parent categories.
* Minor fixes

= 2.11 = 
* [fix] fixed action box style dropdown select box reverting to User Styles after save when selecting None as style.
* [fix] fixed style creator not putting out border-radius css
* [fix] fixed php notices
* [fix] fixed php error if the page content type is not allowed by MAB but MAB still tries to set action box.
* made paths to functions file in addons use absolute paths
* added more classes to generated button css code
* [fix] updated linear-gradient in button css code to use new W3c implementation

= 2.10 =
* Added Random Box type to display a random action box from a specified set of action boxes
* Added feature to display video beside selected action boxes

= 2.9.10 = 
* Fixes
* made css more specific in button css code
* custom buttons now working for Opt In box type
* added [mab_button] shortcode

= 2.9.5 =
* Fixed css generator where it wasn't putting out the property for submit buttons on hover
* Fixed paging issue when on page with custom query
* added mab_allowed_post_types filter for making it possible to show action boxes on other post types

= 2.9.4 =
* Added new action box type - Contact Form 7 box
* Added a number of action and filter hooks for extending the plugin :)
* Added options for setting the input field labels of integrated mailing list providers

= 2.9.3 =
* Replaced the hook used to call the main action box from template_redirect to wp hook.

= 2.9.2 =
* Improved Custom Style editor generated stylesheets due to label color being overridden.

= 2.9.1 =
* Fixed Custom Style editor stylesheets
* Updated default action box css

= 2.9 =
* Added new action box styles
* Reorganized plugin assets so they're all registered at magic-action-box.php
* Added specialized classes MAB_ActionBox, MAB_Template, MAB_Widget classes to make things more OOP.
* Reorganized methods and classes to fit the new architecture and use the new classes.
* Updated view templates to use MAB_ActionBox class.
* Updated mab_get_actionbox() function to work with new MAB_ActionBox class.
* Added mab_template_output, mab_get_template-{$type} and mab_get_template action hooks for outputting action box html in MAB_Template::getTemplate()
* Added MAB_Utils and deprecated ProsulumMabCommon class and placed in deprecated-classes.php file.
* Default value for selected action box in posts/pages now set to "Default". Previously it was set to "Disabled".
* Added option to enable/disable minifying of html output.
* Added Magic Action Box Widget.
* Improved HTML parser to allow <select> and <button> tags, and recognize attribute values surrounded by single quotes.
* Updated action url of generated mailchimp form
* Added margin: 0 auto to .mab-wrap default style. added actionbox-helper.js
* Added Duplicate Action Box function
* Replaced textarea for action box main content and secondary content with WYSIWYG editor via wp_editor()
* Changed a lot of CSS for the preconfigured designs
* Added wrapping <div> around the submit button

= 2.8.6 =
* Fixed admin notices not having a "hide notice" link.
* Added new admin page - Support.

= 2.8.5.1 =
* Minor fixes

= 2.8.5 =
* Added integrated support for Wysija Newsletters plugin

= 2.8.4 =
* Added new setting field for salesbox action box type for specifying additional attributes for the main button

= 2.8.3 =
* Fixed bug where multiple custom stylesheets were not all loading

= 2.8.2 =
* Added feature to set a default action boxe for ALL posts/pages

= 2.8.1 =
* Disabled tracking on AddThis social sharing as it was adding ugly tracking hashtags to the share link.

= 2.8 =
* Made action box styles global
* Added Share Box action box type
* Renamed Design Settings menu to Styles & Buttons
* Fixed PHP notices
* Fixed action box styling issues on preconfigured styles
* Added id parameter to shortcode
* Added mab_get_actionbox() template tag function

= 2.7.2 =
* Fixed style not working for Sales Box type

= 2.7.1 =
* Fixed PHP notices

= 2.7 =
* Added new style "Purity"
* Added new style "Purity Alternate"
* Added new style "Lead"
* Added new style "The Grey"
* Added autoupdate functionality"

= 2.6.2 =
* Improved UI copy on Opt-In box settings screen.

= 2.6.1 =
* Fixed styling issue where all visited links on the page are overriden by the plugin's stylesheet.

= 2.6 =
* Fixed stylesheet not loading when selecting User Settings

= 2.5 =
* Added option to reorder the priority of wpautop() and wptexturize() on the_content filter. This is to force the action box to be displayed first.
* Fixed Aweber thank you page not working

= 2.4 =
* Fixed issue with previous styles not being the right one.
* Added function to clear cache
* Added nag message to clear cache.

= 2.3 =
* Added Crosswalk style.
* Added 10 preconfigured CSS3 buttons
* Styling fixes

= 2.2 =
* Added [magicactionbox] shortcode and mab_get_actionbox() function
* Thumbnail previews for styles.
* Moved individual action box assets to be under each own directory.
* Override Preconfigured styles with own CSS through Custom CSS box.

= 2.1 =
* Modified action box styles to be more resilient.
* Added Last Light style and Clean style.

= 2.0 =
* Added Sales Box type
* Added Button creator functionality

= 1.3.1 =
* BUG/FIX fixed conflict on wp media upload/insert on post and page edit screen with plugin.
* Fixed styling issues with some of the preconfigured designs.
* Added screen to select Action Box type.

= 1.3 =
* Created additional action box styles

= 1.2 =
* Fixed settings not being initialized on first install

= 1.1 =
* Original Version.

== Upgrade Notice ==
= 2.10 =
Feature updates

= 2.9.3 =
Minor update

= 2.9.1 =
Styling fixes

= 2.9 =
Major update. See Changelog

= 2.8.5.1 =
Minor fixes

= 2.8.4 =
Just upgrade :)

= 2.8.3 =
Fixed bug where multiple custom stylesheets were not all loading

= 2.8.2 =
Added global action boxes

= 2.8.1 =
Removed tracking from AddThis social sharing

= 2.8 =
Lots of improvements

= 2.7.2 =
Fixed style not working for Sales Box type

= 2.7.1 =
Fix PHP notices

= 2.7 =
This version now has autoupdate functionality

= 2.6 =
This version fixes the issue where stylesheet is not loading when User Settings in the style setting is selected.

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.
