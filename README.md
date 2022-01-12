<p align="left">
    <img alt="logo" src="https://github.com/ainsleyclark/squidge/blob/master/assets/icon.svg" width="40%">
</p>

# Squidge

is a **FREE** WordPress plugin, built with developers in mind, for the compression and conversion of images using `jpegoptim`,
`optipng`, `cwebp`, and `libavif`. It’s **extremely** simple to use and is designed to increase PSI and boost rankings.

[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![GNU General Public License 3.0](https://img.shields.io/github/license/ainsleyclark/squidge.svg)](https://www.gnu.org/licenses/gpl-3.0.en.html)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate?hosted_button_id=PQG5A34KWUXRJ)

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

## Installation

1. Go to the [releases](https://github.com/ainsleyclark/squidge/releases) section and download the plugin.
2. Upload the `squidge` plugin to your `/wp-content/plugins/` directory.
3. Activate the plugin through the "Plugins" menu in WordPress.
4. Check the Settings tab under `Settings | Squidge Options` to ensure the libraries are installed, if they aren't,
run the commands listed dependent on your operating system.
5. Check the individual optimisation tabs and adjust settings accordingly.
6. Done!

## Render Images

To render images in templates, you can either set up nginx or apache rules to serve images dynamically or used the
`squidge_image` helper function. This dynamically checks if an `.avif` or `.webp` file is available on the file system
and returns the output.

### Function
```php
/**
 * Returns a <picture> element with source media for the standard file passed
 * (such as a JPG), the .avif file, the .webp file (if to exist on the file system).
 *
 * Appropriate <source> elements for image sizes with max widths.
 * Finally, the main be outputted with alt and title text.
 *
 * - If lazy is true, the data-src or data-srcset will be appended.
 * - If a class is set, the class will be outputted on the <picture> element.
 *
 * @param $image_id
 * @param string $class
 * @param false $lazy
 * @return string
 */
function squidge_image($image_id, $class = '', $lazy = false)
```

### Output
```html
<picture class="picture">
	<!-- Loads if AVIF is supported and the window is smaller than 400px wide -->
	<source media="(max-width: 400px)" srcset="/sample-image.jpg.avif" type="image/avif">
	<source media="(max-width: 400px)" srcset="/sample-image.jpg.webp" type="image/webp">
	<source media="(max-width: 400px)" srcset="/sample-image.jpg">
	<!-- AVIF & Wep Initial Sizes -->
	<source srcset="/sample-image.jpg.avif" type="image/avif">
	<source srcset="/sample-image.jpg.webp" type="image/webp">
	<!-- Default -->
	<img src="/sample-image.jpg" alt="Alt text" title="Sample JPG">
</picture>
```

## Screenshots

### Plugin settings page

![Squidge Settings Page](https://github.com/ainsleyclark/squidge/blob/master/assets/screenshot-1.png)

### Example compression tab

![Squidge Example Compression Tab](https://github.com/ainsleyclark/squidge/blob/master/assets/screenshot-2.png)

## FAQs

### Does the plugin replace existing images?

Yes

### What are the supported operating systems?

Windows, Linux, & Mac OSX.

### How are JPGs optimized?

```bash
jpegoptim --strip-all --overwrite --max={{ quality }} input-file.jpg
```

### How are PNGs optimized?

```bash
optipng -clobber -strip all -o {{ optimization }} input-file.jpg
````

### How are images converted to webp files?

```bash
cwebp -q {{ quality }} input-file.jpg -o input-file.jpg.webp
```

### How are images converted to avif files?

```bash
avifenc --min 0 --max 63 --speed 6 -a end-usage=q -a cq-level=18 -a tune=ssim input-file.jpg input-file.jpg.avif
```

## CLI

Squidge includes a built in `WP CLI` to help convert and compress images, you can see the commands below.

```bash
wp squidge
```

```bash
usage: wp squidge health
   or: wp squidge run
   or: wp squidge version
```

### Version

Outputs the current version number of Squidge.

```bash
wp squidge version
```

### Health

Checks the correct libraries are installed.

```bash
wp squidge health
```

### Run

Compresses and converts all images. This command will obtain images from the WP media library, compress them if they are
JPG/PNG's and convert them to the `.webp` and `.avif` file formats.

By default all optimisation methods are ran, but you can disable them using the arguments below.

**Simple example:**

```bash
wp squidge run
```

**With example arguments**

```bash
wp squidge run --jpeg=false --quality=80 --optimization=o3
```

#### Arguments

| Argument          | Default Value            | Accepted Values          | Description       |
| ----------------- | ------------------------ | ------------------------ | ----------------- |
| jpg               | `true`                   | `true`/`false`           | If JPG compression should run.
| png               | `true`                   | `true`/`false`           | If PNG compression should run.
| webp              | `true`                   | `true`/`false`           | If WebP conversion should run.
| avif              | `true`                   | `true`/`false`           | If AVIF conversion should run.
| quality           | `80`                     | `0` to `100`             | Compression quality of the images.
| optimization      | `02`                     | `o1` to `o7`             | Optimisation of PNG images.

## Road Map

- Add `SVGO` to optimise SVG images.
- More arguments passed to each service.
- Update meta data when images are converted or compressed.
- Output compression info in the Media Library.
- Create unit tests.
