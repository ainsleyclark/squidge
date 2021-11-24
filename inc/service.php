<?php

/**
 * Service
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace WPSquidge\Includes;

/**
 * Jpeg Mime Type
 */
const JPEG_MIME = 'image/jpeg';

/**
 * PNG Mime Type
 */
const PNG_MIME = 'image/png';

/**
 * SVG Mime Type
 */
const SVG_MIME = 'image/svg+xml';

/**
 *
 */
abstract class WP_Squidge_Service
{
    /**
     * The command name to run
     *
     * @var string
     */
    protected string $cmd_name = '';

    /**
     * @var string
     */
    protected string $extension = '';


    /**
     * @param string $cmd_name
     * @param string $extension
     * @param false $should_delete
     */
    public function __construct(string $cmd_name, string $extension, $should_delete = false)
    {
        $this->cmd_name = $cmd_name;
        $this->extension = $extension;
        add_filter("wp_generate_attachment_metadata", [$this, 'process'], 100, 1);
        if ($should_delete) {
            add_filter('delete_attachment', [$this, 'delete'], 100, 1);
        }
    }

    /**
     * Converts or compresses an image.
     *
     * @return mixed
     */
    public abstract function convert($filepath);

    /**
     *
     */
    public function process($attachment)
    {
        // Return if the cwebp library is not installed.
        if (!$this->installed()) {
            error_log("WP Squidge - cwebp is not installed.");
            return $attachment;
        }

        // Check if the file key exists.
        if (!isset($attachment['file'])) {
            error_log("WP Squidge - file attachment is not set.");
            return $attachment;
        }

        // Obtain the file and check if it exists.
        $mainFile = $this->get_file_path($attachment['file']);
        if (!$mainFile) {
            error_log("WP Squidge - file does not exist");
            return $attachment;
        }

        $mime = $this->get_mime_type($mainFile);
        if (!$this->is_jpeg_or_png($mime)) {
            return $attachment; // Mime cannot be converted, return.
        }

        // Convert main image.
        $this->convert($mainFile);

        // Loop over the sizes and convert them.
        foreach ($attachment['sizes'] as $size) {
            if (!isset($size['file'])) {
                continue;
            }
            $path = $this->get_file_path($size['file']);
            if (!$path) {
                continue;
            }
            $this->convert($path);
        }

        return $attachment;
    }

    /**
     * Deletes all webp images associated with the
     * image (if the file exists).
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $sizes = get_intermediate_image_sizes();

        error_log(json_encode($sizes));

        foreach ($sizes as $size) {
            $src = wp_get_attachment_image_src($id, $size);
            $path = $this->get_file_path($src[0] . $this->extension);
            if (!$path) {
                continue;
            }
            unlink($path);
        }

        return $id;
    }

    /**
     * Checks if a command exists.
     *
     * @return bool
     */
    public function installed(): bool
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg($this->cmd_name)));
        return !empty($return);
    }

    /**
     * Determines if a mime type is jpeg or png.
     *
     * @param string $mime
     * @return bool
     */
    private function is_jpeg_or_png(string $mime): bool
    {
        return ($mime === JPEG_MIME || $mime === PNG_MIME);
    }

    /**
     * Obtains the absolute filepath including the
     * upload directory.
     * If the file does not exist on the file system, the
     * function will return false.
     *
     * @param $path
     * @return string
     */
    private function get_file_path($path)
    {
        $file = wp_get_upload_dir()['path'] . DIRECTORY_SEPARATOR . basename($path);
        error_log("File" . $file);
        if (file_exists($file)) {
            return $file;
        }
        return false;
    }

    /**
     * Returns the mimetype of a file passed.
     *
     * @param $file
     * @return false|string
     */
    private function get_mime_type($file)
    {
        return mime_content_type($file);
    }
}
//
//use WP_Query;
//
//add_action('init', function () {
//
//    $query_images_args = array(
//        'post_type'      => 'attachment',
//        'post_mime_type' => 'image',
//        'post_status'    => 'inherit',
//        'posts_per_page' => 5,
//    );
//
//    $query_images = new WP_Query($query_images_args);
//
//    $images = array();
//    foreach ($query_images->posts as $image) {
//
//        $webp = new WP_Squidge_WebP();
//       //print_r($webp->)
//
//        echo '<pre>';
//        print_r( $webp->get_attachment($image->ID));
//    }
//
//});