# CPT Person
__Provides a standardized Custom Post Type 'Person' plus metadata registered through ACF or CMB2__

## Development
* Clone repo
* Run `composer install --prefer-dist`
* DO NOT commit `lib/*` to git for now!

## Changelog
* __@todo__
	* Evaluate Pods support
	* Evaluate meta-keys
* __0.1.0__ (2015-02-26)
	* Moved code to `WPStore\CPT` namespace
	* Use Composer PSR-4 autoloader (for now)
	* Testing [TGM-Plugin-Activation](https://github.com/thomasgriffin/TGM-Plugin-Activation) library to require ACF or CMB2
* __0.0.3__
	* Activation: Check for `person` cpt to prevent conflicts
* __0.0.2__
	* ADDED support for [CMB2](https://wordpress.org/plugins/cmb2/)
	* FIXED support for [ACF](https://wordpress.org/plugins/advanced-custom-fields/)
* __0.0.1__
	* Running prototype
	* Register CPT `person`
