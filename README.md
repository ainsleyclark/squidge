<p align="lefty">
    <img alt="logo" src="logo.svg" width="40%">
</p>

# Squidge
Is **FREE** WordpPress Plugin built for developers in mind to compress and convert images using cwebp, jpegoptim, optipng and libavif.
It's **extremley** simple to use and is designed to increase PSI and boost rankings.

[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/ainsleyclark/wp-squidge/blob/master/LICENSE)
[![GNU General Public License 3.0](https://img.shields.io/github/license/ainsleyclark/wp-squidge.svg)](https://www.gnu.org/licenses/gpl-3.0.en.html)

## Description



## Usage

## CLI

Squidge includes a built in `WP CLI` to help convert and compress images, you can see the commands below.

```bash
wp squidge

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
Compresses and converts all images. This  command will obtain images from the WP media library, compress them if they are JPG/PNG's and convert
them to the `.webp` and `.avif` file formats.

```bash
 wp squidge health
```

## Road Map
