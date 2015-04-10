# [Wheaton Map Theme](http://wheatoncollege.eduo/)

The Wheaton Map theme is built using Roots. Roots is a WordPress starter theme based on [HTML5 Boilerplate](http://html5boilerplate.com/) & [Bootstrap](http://getbootstrap.com/) that will help you make better themes.

* Source: [https://github.com/roots/roots](https://github.com/roots/roots)

## Theme Requirements
* [Advanced Custom Fields](http://www.advancedcustomfields.com/)
## Installation

Clone the git repo and then rename the directory to the name of your theme or website. [Install Grunt](http://gruntjs.com/getting-started), and then install the dependencies for Roots contained in `package.json` by running the following from the Roots theme directory:

```
npm install
```

Reference the [theme activation](http://roots.io/roots-101/#theme-activation) documentation to understand everything that happens once you activate Roots.

## Theme Development

After you've installed Grunt and ran `npm install` from the theme root, use `grunt watch` to watch for updates to your LESS and JS files and Grunt will automatically re-build as you write your code.

## Configuration

Edit `lib/config.php` to enable or disable support for various theme functions and to define constants that are used throughout the theme.

Edit `lib/init.php` to setup custom navigation menus and post thumbnail sizes.

## Documentation

### Map Locations

Map locations are implemented as a custom post type, with a mix of custom fields and normal Wordpress fields to define content. The Locations post type is registered automatically by the theme. You may have to import the custom fields for locations to work properly. The code to generate the custom fields is located in lib/fields.php and included in lib/custom.php. Custom fields should automatically register themselves.

### Location Content
* Wordpress fields
	* Title - Building Name
	* Categories - Used to support map filtering in categories such as Athletic, Dining, etc.
	* Tags - Reserved for future use
	* Featured Image - Used for the hero image on the building description page. Must be landscape orientation, 1600x1200 recommended.
* Custom Fields
	* Description - About a paragraph of lightly-formatted text about the building
	* Hours (optional) - A repeater field with a maximum of one entry. Hours for each day of the week.
  * Quick Facts (Optional) - A repeater field for tidbits of factual information ("Built in 1842").
	* Features - A text list of amenities and services offered in the building. 
	* Directory (Optional) - A repeater field for a list of relevant department or organizational links (Admissions, Swim Team). Each directory entry has a label ("Name") and a URL ("Link")
	* Contact Information (Optional) - A repeater field for one or more sets of phone numbers, e-mail addresses, etc. Each repeater contains a "Type" (Phone or Email), a label ("Name"), and a value for the actual phone number or e-mail address.
	* Photo Gallery (Optional) - A gallery of photos of the building and related activities. Photos are pulled in through the normal Wordpress Media Library and upload system. Landscape highly recommended, at least 1600x1200 each. 
	* Coordinates - The actual map coordinates for the location

### [Roots Docs](http://roots.io/docs/)

* [Roots 101](http://roots.io/roots-101/) — A guide to installing Roots, the files and theme organization
* [Theme Wrapper](http://roots.io/an-introduction-to-the-roots-theme-wrapper/) — Learn all about the theme wrapper
* [Build Script](http://roots.io/using-grunt-for-wordpress-theme-development/) — A look into the Roots build script powered by Grunt
* [Roots Sidebar](http://roots.io/the-roots-sidebar/) — Understand how to display or hide the sidebar in Roots
