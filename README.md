<p align="left">
    <img alt="logo" src="logo.svg" width="40%">
</p>

# Squidge

Is **FREE** WordpPress Plugin built for developers in mind to compress and convert images using `jpegoptim`,
`optipng`, `cwebp`, and `libavif`. It's **extremley** simple to use and is designed to increase PSI and boost rankings.

[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/ainsleyclark/wp-squidge/blob/master/LICENSE)
[![GNU General Public License 3.0](https://img.shields.io/github/license/ainsleyclark/wp-squidge.svg)](https://www.gnu.org/licenses/gpl-3.0.en.html)

## Why?

Image compression in WordPress can be costly, confusing and sometimes just simply don't work. We have aimed to simplify
the process by requiring the developer to install the required packages.


## What does Squidge do?

- Compresses JPG images using `jpegoptim`.
- Compresses PNG images using `optipng`.
- Converts JPG and PNG images to `.webp` files using `cwebp` with the appended extension  e.g. `image.jpg.webp`.
- Converts JPG and PNG images to `.avif` files using `libavif` with the appended extension  e.g. `image.jpg.avif`.

## Installation

1. Upload the `wp-squidge` plugin to your `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Check the Settings tab under `Settings | Squidge Options` to ensure the libraries are installed, if they aren't,
run the commands listed dependent on your operating system.
4. Check the individual optimisation tabs and adjust settings accordingly.
5. Done!

## Render Images

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

## Screenshots

### Plugin settings page

![Squidge Settings Page](https://github.com/ainsleyclark/wp-squidge/blob/master/assets/images/screenshot-home.png)

### Example compression tab

![Squidge Example Compression Tab](https://github.com/ainsleyclark/wp-squidge/blob/master/assets/images/screenshot-tab.png)

## FAQs

**Does the plugin replace existing images?**

Yes

**What are the supported operating systems?**

Windows, Linux, & Mac OSX.

**How are JPGs optimized?**

```bash
jpegoptim --strip-all --overwrite --max={{ quality }} input-file.jpg
```

**How are PNGs optimized?**

```bash
optipng -clobber -strip all -o {{ optimization }} input-file.jpg
````

**How are images converted to webp files?**

```bash
cwebp -q {{ quality }} input-file.jpg -o input-file.jpg.webp
```

**How are images converted to avif files?**

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
