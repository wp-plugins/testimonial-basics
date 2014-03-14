=== Testimonial Basics ===
Contributors: kevinhaig
Donate link: http://kevinsspace.ca/testimonial-basics/
Tags: testimonial,testimonials,praise,user comments,widgets,translation ready
Requires at least: 3.6
Tested up to: 3.8
Stable tag: 4.0.5
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Manage testimonials for your WordPress site.

== Description ==

Testimonial Basics is a full featured testimonial management plugin. 

* setup input forms in content or widget areas
* show testimonials in content or widget areas
* group testimonials for separate display
* use 5 star rating system
* use sliders and excerpts
* optionally use schema/google snippet markup
* black and white or color captcha built in
* customize text color and background color
* use one of nine web friendly fonts
* include gravatars
* easily edit and approve testimonials in the admin panel
* pagination available in 3, 5, or 10 testimonials per page
* help available in admin panels
* translations : French, Dutch, German, Spanish

== Installation ==

1. Upload Testimonial Basics to the plugin directory 
   (wp-content/plugins/testimonial-basics) of your wordpress setup. 
2. Ensure all sub directories are maintained. 
3. Activate the theme through the Wordpress Admin panel under "Plugins".

== Frequently Asked Questions ==

= Page load speeds are slow =

If your page load speed is slow it will likely be because you are using Gravatars and you are not using a cache plugin. It is recommended that you use a cache plugin for any site, whether or not you are using Gravatars for Testimonial Basics. I use WP Super Cache.

= My testimonial is not showing? =

Ensure it is approved.

= I just approved a testimonial and it is not showing? =

If you have a cache plugin installed such as WP Super Cache, the page you use to display your testimonials may be cached. Simply edit the page and update it or wait and the cached files will eventually be deleted and refreshed.

= When I input a color number in the cell the color won't change? =

Hit the enter key.

= Why can't users upload photos? =

Users are not allowed to upload photos because it is a security issue. Use of gravatars is highly recommended. Administrators have the ability to add images in the Edit Testimonials admin panel.

== Screenshots ==

1. Formatted Display Example

2. Input Page Example

3. Edit Testimonials Admin Panel

4. Options Panel

5. Testimonials Example Page

== Changelog ==

= 4.0.5 =
* forgot to include function to display the input form in code, was in another 
  working copy

= 4.0.4 =
* fixed bug where wpautop was adding line breaks to rating html causing it to break
* added function to display the input form in code

= 4.0.3 =
* added option to use javascript alert message that testimonial was submitted
* added German translation, Thankyou Frank!

= 4.0.2 =
* fixed bug for loading excerpt script when only the widget one is checked
* changed rotator and excerpt scripts to load in the footer
* modified slider jquery for IE9&10 compatibility and independant speed variables
* removed padding from katb_error
* updated katb_list_testimonials() , initialized critical arrays for
  repeated use
  
= 4.0.1 =
* bug fix - Testimonials were not being added to the database in Windows Servers
* improvement - Spanish Translation added
* bug fix - css in rateit.css, all widget testimonials were showing 5 stars

= 4.0 =
* bug fix - changed $pend-count to $total in katb_add_unapproved_count()
* bug fix - removed action="#" from input forms and pagination form

= 3.32.9 =
* bug fix - fixed custom font css for the widget and widget popup display
* improvement moved ... in excerpt to before close tags
* improvement - set metabox styling in popup
* bug fix - fixed popup to show title if use schema selected
* bug fix - syntax error in rating input html content form
* bug fix - fixed itallic setting for basic widget display
* bug fix - fixed custom formatting to include rotator divs in widget
* improvement - added option for auto approval

= 3.31.8 =
* bug fix - fixed the custom text color option on the widget display author strip
* bug fix - fixed the divide by zero error, when schema is selected and there are no ratings
* Testimonial aggregate display will not be shown (including meta) unless there are 2 or more ratings 
  and the average rating is greater than 0.
* bug fix, input forms were sometimes submitting nothing for rating
  solved by switching from select input box to HTML5 range input

= 3.30.7 =
* Added optional 5 star rating system
* Added optional schema mark up
* Improved edit testimonials view panel
* Changed Options panel to tabbed for better organization
* Set up photo upload button in admin Edit Testimonials panel
* Added minimum height option to slider
* Added option to use gravatar substitute
* Changed slide hover icon to a pause icon
* Updated slider options to include fade, slide-left, and slide-right, and time
* Added font size option for input forms and display
* bug fix, formatting in the widget popup was not working for paragraphs.
* bug fix, excerpt filter was not leaving &lt;br /&gt; in, and when I put it in I had to fix the open &lt;br problem
* Fixed testimonials with no html. Line feeds were not being carried through to display. Did this by adding wpautop() to text elements.
* Changed color captcha art
* Added photo url and rating to database
* Increased Group name to 100 characters
* Added bubble count for unapproved testimonials
* Added option to size gravatars
* Modified slider for inside wrapper rotation
* Added optional Title to displays
* Added meta location option to top or bottom
* Code optimization

= 3.20.6 =
* Optimized pagination code
* Made the website and location input optional
* Set up form label options for both the content input form and the 
  widget input form
* Added testimonial rotator and reduced testimonial display shortcodes to one
* Added testimonial rotator and reduced testimonial display widgets to one
* Added sections to options panel
* Removed <!-- katb_input_form --> filter.
* General bug Fixes and code clean-up

= 3.12.5 =
* no code changes 
* had problems with the svn

= 3.12.1 =
* added a color option for captcha
* added link tag to allowed html for user submissions
* updated html allowed on admin page to wp_kses_post, giving full access 
  to post html tags
* added strict image formatting
* added pagination to edit testimonials admin panel
* added pagination option for displaying all or grouped testimonials 
  by date or order
* changed date display format to the default selected in the 
  Settings => General Tab
* updated output data validation
* Minor bug fixes and code clean-up
* added Dutch translation
* modified code to allow gravatars in excerpt pop-ups
* testimonials in the admin edit panel are now displayed most 
  recent first

= 3.0.0 =
* added multiple testimonial widget
* added random shortcode for main area displays
* added excerpt for widgets, main area and function 
  testimonials displays
* added email for contact about submitted testimonials
* set up captcha text input to be fully selected on click
* changed coding of the main area input form to a shortcode 
  format to minimize potential plugin conflicts and duplicate 
  entry issues
* modified captcha coding letter selection, and variable names 
  to minimize potential conflicts
* added option to allow WordPress editor levels to edit testimonials
* html tags allowed p,br,i,em,strong,q,h1-h6
* html strip now displayed as an option
* Fixed \ problem in emails
* Corrected blogBox references in validate function
* Table encoding issue resolved with a table set up modification 
  for new installs and a blog post on updating existing tables.
* When using order to display testimonials they are now displayed 
  in ascending order.
* incorporated new color picker with fallback to color wheel for older 
  versions of WordPress

= 2.10.6 =
* fixed bug for uploading testimonials
* fixed bug for loading gravatar logo

= 2.8.4,2.8.5 =
* allowed paragraph and line break tags in in comments
* added default font to custom styling
* added option for italic style both in basic and in custom styling
* added groups so users can group testimonials and display them in 
  separate pages.
* added an option to use gravatars if present.
* modified Edit Testimonials Panel to accomodate Groups and e-mail
* removed user documentation from plugin, available at plugin site
* website link now opens a new tab
* optimized css styling
* fixed strip slashes bug in input title and e-mail note

= 2.0.0 =
* added user options for input forms
* added user options for content testimonial display
* added user options for widget testimonial display
* re-coded e-mail validation
* widget display box height adjusts to 12 em max
* increased captcha width
* fixed bugs in e-mail send
* fixed minor bug in activation function
* fixed undefined variable bug in display scripts
* fixed zero and one testimonial display bug
* fixed esc_url() php warning bug
* changed link to plugin page
* fixed type bug on widget testimonial display

= 1.0.7 =
* Initial Release

== Upgrade Notice ==

= 4.0.5 =
* only critival to those using the input form in code function

= 4.0.4 =
* non critical

= 4.0.3 =
* non critical

= 4.0.2 =
* should provide better compatibility with IE

= 4.0.1 =
* please update

= 4.0 =
* This update fixes a couple of minor bugs

= 3.32.9 =
* This is an intermediate upgrade, non-critical

= 3.31.8 =
* This is an intermediate upgrade with three bug fixes and one improvement

= 3.30.7 =
* This is a major upgrade, check your site after the upgrade as you may have to reset your widgets

= 3.20.6 =
* Testimonials are now displayed in the main content area with a 
  single shortcode. You will likely have to make adjustments to 
  your shortcode.
* A single widget is now used to display testimonials in widgetized 
  areas. You will likely have to reset your widgets.
* the <!-- katb_input_form --> tags for the input form are no longer 
  allowed use [katb_input_testimonials] instead

= 2.10.6 =
* gravatar logo was not loading properly
* Testimonial was not updating in the database for Windows 
  server setups
* These two issues should now be fixed
* Thanks for the feed back, it lets me fix the problems.

= 2.8.4, 2.8.5 = Release
* please ensure your database is backed up before you upgrade
* your database will be updated adding a Group column and a 
  E-mail column
* there should be no problem with the database but back-up to 
  be safe
* advanced function in code users must adjust the parameters 
  in the function call
* detailed documentation must now be obtained from the 
  plugin site

= 2.0.0 = Release
* when you install this update you will start with the basic 
  display format
* go to the new options panel to get the formatted display back
* this is a major upgrade to the initial version
* a number of bugs were fixed
* a complete new options section has been added

= 1.0.7 =
* Initial Release