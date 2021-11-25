=== Squidge ===
Contributors: ainsleyclark
Donate link: https://www.paypal.com/donate?hosted_button_id=PQG5A34KWUXRJ
Tags: image, compression, plugin, image compression
Requires at least: 4.5
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Squidge is a FREE WordpPress Plugin built for developers in mind compressing and convert images using jpegoptim,
optipng, cwebp, and libavif. It's extremley simple to use and is designed to increase PSI and boost rankings.

== Description ==

## Why?

Image compression in WordPress can be costly, confusing and sometimes just simply don't work. We have aimed to simplify
the process by requiring the developer to install the required package on the operating system and Squidge does the
hard work for you.

- **IT'S FREE**
- Unlimited file size, no limits.
- Optimised for your site to rank.
- CLI to regenerate all of your media files.
- Helper functions to output images in templates.
- Uses the native `cwebp` and `libavif` libraries.

## What does Squidge do?

Squidge compresses and converts image files when the user has uploaded a file to WordPress.

Compresses JPG images using `jpegoptim`.

Compresses PNG images using `optipng`.

Converts JPG and PNG images to `.webp` files using `cwebp` with the appended extension  e.g. `image.jpg.webp`.

Converts JPG and PNG images to `.avif` files using `libavif` with the appended extension  e.g. `image.jpg.avif`.

== Installation ==

1. Go to the [releases](https://github.com/ainsleyclark/wp-squidge/releases) section and download the plugin.
2. Upload the `wp-squidge` plugin to your `/wp-content/plugins/` directory.
3. Activate the plugin through the "Plugins" menu in WordPress.
4. Check the Settings tab under `Settings | Squidge Options` to ensure the libraries are installed, if they aren't,
run the commands listed dependent on your operating system.
5. Check the individual optimisation tabs and adjust settings accordingly.
6. Done!

== Render Images ==

To render images in templates, you can either set up nginx or apache rules to serve images

```html
<picture>
	<!-- Loads if AVIF is supported -->
	<source srcset="img/image.jpg.avif" type="image/avif">
	<!-- Loads if WebP is supported -->
	<source srcset="img/image.jpg.webp" type="image/webp">
	<!-- Default -->
	<img src="img/image.jpg" alt="Alt Text!">
</picture>
```

== Frequently Asked Questions ==

= Does the plugin replace existing images? =

Yes

= What are the supported operating systems? =

Windows, Linux, & Mac OSX.

== Screenshots ==

1. Plugin settings page
2. Example compression tab

== Changelog ==

= 0.1.0 =
* Initial Release

== Credits ==

Written by [Ainsley Clark](https://github.com/ainsleyclark)
