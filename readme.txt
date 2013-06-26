=== Testimonial Basics ===
Contributors: kevinhaig
Donate link: http://www.kevinsspace.ca/testimonial-basics/
Tags: testimonial,testimonials,praise,user comments,widgets,translation ready
Requires at least: 3.3
Tested up to: 3.6
Stable tag: 3.12.2
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Testimonial Basics is a great plugin for managing testimonials for your site. It is 
simple to use and comes with detailed user documentation.

== Description ==

Testimonial Basics facilitates easy management of customer testimonials. The user can set 
up an input form in a page or in a widget, and display all or selected testimonials in a 
page or a widget. The plug in is very easy to use and modify:

    1) Testimonials are saved in a database table integrated into WordPress.
    
    2) Users access their testimonials through an Administration Panel where 
       it is very easy to add new testimonials, or modify existing ones.
       - New : The administration panel is now paged
       - New : Images can now be loaded through the admin panel.
       
    3) Testimonials are displayed in a pages content

       a) The user can display all testimonials or a selected number.
       b) The user can group testimonials for display on separate pages.
       c) Testimonials can be displayed by most recent date, or by a 
          user selected order.
       d) A single selected testimonial can be displayed, or a single 
          testimonial can be randomly displayed every time the page 
          is loaded.
       e) A new shortcode allows you to display multiple testimonials 
          randomly selected from a group or from all testimonials.
       f) Display excerpts of testimonials and when the user clicks 
          a ...more link, the full testimonial is diaplayed in a pop 
          up window.
       g) New-Testimonials can now be presented in an optional 5 or 10 
          per page format.

    4) Display Widgets
    
       a) A single selected or single random testimonial can be 
          displayed.
       b) A multiple display widget allows you to display multiple 
          testimonials in a widget, by group, date, order or randomly.
       c) Display excerpts of testimonials and when the user clicks 
          a ...more link, the full testimonial is diaplayed in a 
          pop-up window.

    5) A visitor input form is easily set up in the content of a page, 
       allowing visitors to submit testimonials.

    6) A visitor input form is also available in widget form.
    
    7) The user can include a captcha on input forms to reduce spam.
       New: A color option is now available for wider compatibility.
    
    8) The user can use a display native to the theme or select a 
       customizable display option.
    
    9) There is a full set of option features
    
       a) Including the Website link is an option.
       b) Including the Date is an option. New-Dates are now 
          displayed in the default WordPress format.
       c) Including the Location is an option.
       d) Including italic style is an option.
       e) Including Gravatars is an option.
       f) User can select a customizable display.
       g) Select one of nine fonts from a drop down list.
       h) Select text colors using a color picker.
       i) Select background colors using a color picker.
       j) Visitor input form options to include a title, email note, 
          and display the html allowed strip (new).
       k) Include a contact email as an option
       l) Admin or Editor user level can edit testimonials
       m) Using excerpts and excerpt lengths are separately set 
          for widgets and the main area testimonial displays
    
    10) There is a function that lets you display testimonials within 
        template code.
    
    11) HTML tags allowed : a p br i em strong q h1-h6
    
    12) Detailed documentation now available at the plugin site

== Installation ==

1. Upload Testimonial Basics to the plugin directory (wp-content/plugins/testimonial-basics) of your 
wordpress setup. 
2. Ensure all sub directories are maintained. 
3. Activate the theme through the Wordpress Admin panel under "Plugins".

== Frequently Asked Questions ==

= Page load speeds are slow =

If your page load speed is slow it will likely be because you are using Gravatars 
and you are not using a cache plugin. It is recommended that you use a cache plugin 
for any site, whether or not you are using Gravatars for Testimonial Basics. I use 
WP Super Cache.

= My testimonial is not showing? =

Ensure it is approved.

= I just approved a testimonial and it is nor showing? =

If you have a cache plugin installed such as WP Super Cache, the page you use to 
display your testimonials may be cached. Simply edit the page and update it or wait 
and the cached files will eventually be deleted and refreshed.

= When I input a color number in the cell the color won't change? =

Hit the enter key.

== Screenshots ==

1. Plugin Options Admin Panel

2. Edit Testimonials Admin Panel

3. Visitor Input Form Options

3. Testimonials Display Options

== Changelog ==
= 3.12.2 =
* svn problem
= 3.12.1 =
* added a color option for captcha
* added link tag to allowed html for user submissions
* updated html allowed on admin page to wp_kses_post, giving full access to post html tags
* added strict image formatting
* added pagination to edit testimonials admin panel
* added pagination option for displaying all or grouped testimonials by date or order
* changed date display format to the default selected in the Settings => General Tab
* updated output data validation
* Minor bug fixes and code clean-up
* added Dutch translation
* modified code to allow gravatars in excerpt pop-ups
* testimonials in the admin edit panel are now displayed most recent first


= 3.0.0 =
* added multiple testimonial widget
* added random shortcode for main area displays
* added excerpt for widgets, main area and function testimonials displays
* added email for contact about submitted testimonials
* set up captcha text input to be fully selected on click
* changed coding of the main area input form to a shortcode format to minimize 
  potential plugin conflicts and duplicate entry issues
* modified captcha coding letter selection, and variable names to minimize potential conflicts
* added option to allow WordPress editor levels to edit testimonials
* html tags allowed p,br,i,em,strong,q,h1-h6
* html strip now displayed as an option
* Fixed \ problem in emails
* Corrected blogBox references in validate function
* Table encoding issue resolved with a table set up modification for new installs 
  and a blog post on updating existing tables.
* When using order to display testimonials they are now displayed in ascending order.
* incorporated new color picker with fallback to color wheel for older versions of WordPress

= 2.10.6 =
* fixed bug for uploading testimonials
* fixed bug for loading gravatar logo

= 2.8.4,2.8.5 =
* allowed paragraph and line break tags in in comments
* added default font to custom styling
* added option for italic style both in basic and in custom styling
* added groups so users can group testimonials and display them in separate pages.
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

= 2.10.6 =

* gravatar logo was not loading properly
* Testimonial was not updating in the database for Windows server setups
* These two issues should now be fixed
* Thanks for the feed back, it lets me fix the problems.

= 2.8.4, 2.8.5 = Release
* please ensure your database is backed up before you upgrade
* your database will be updated adding a Group column and a E-mail column
* there should be no problem with the database but back-up to be safe
* advanced function in code users must adjust the parameters in the function call
* detailed documentation must now be obtained from the plugin site

= 2.0.0 = Release
* when you install this update you will start with the basic display format
* go to the new options panel to get the formatted display back
* this is a major upgrade to the initial version
* a number of bugs were fixed
* a complete new options section has been added

= 1.0.7 =
* Initial Release