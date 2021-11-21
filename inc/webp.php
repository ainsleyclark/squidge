<?php

/**
 * WebP
 *
 * Service for converting and deleting webp files using
 * the cwebp library. This service extends WP_Squidge
 * to implement the installed and convert methods.
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace WPSquidge\Includes;

use WP_Query;

class WP_Squidge_WebP extends WP_Squidge_Service
{
    /**
     * The command name to run.
     */
    const CMD_NAME = "cwebp";

    /**
     * The extension to save.
     */
    const EXTENSION = ".webp";

    /**
     * The quality of the webp file.
     *
     * @var int
     */
    public $quality = 80;

    /**
     * Sets up actions.
     */
    public function __construct()
    {
        $this->quality = carbon_get_theme_option('wp_squidge_webp_quality');
        parent::__construct(self::CMD_NAME);
        add_action('delete_attachment', [$this, 'delete']);
    }

    /**
     * Converts all image sizes if they are jpg or png
     * to webp with the given file extension.
     *
     * @param array $images
     * @return void
     */
    public function convert(int $id)
    {
        if (!$this->installed()) {
            error_log("WP Squidge - cwebp is not installed");
            return;
        }


        error_log($id);

        //        foreach ($images as $image) {
        //            exec("cwebp -q " . $this->quality . " " . $image['path'] . " -o " . $image['path'] . self::EXTENSION);
        //        }
    }

    /**
     * Deletes all webp images associated with the
     * image (if the file exists).
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $images = get_attached_file($id); // Gets path to attachment

        foreach ($images as $image) {
            if (file_exists($image['path'] . self::EXTENSION)) {
                unlink($image['path']);
            }
        }
    }

    /**
     * Returns an array of attachment data.
     *
     * @date    05/01/2015
     * @param int|WP_Post The attachment ID or object.
     * @return  array|false
     * @since   5.1.5
     *
     */
    protected function get_attachment($attachment)
    {
        // Get the attachment post object.
        $attachment = get_post($attachment);
        if (!$attachment) {
            return false;
        }
        if ($attachment->post_type !== 'attachment') {
            return false;
        }
    }
}


/**
 * Returns an array of attachment data.
 *
 * @date    05/01/2015
 * @param int|WP_Post The attachment ID or object.
 * @return    array|false
 * @since    5.1.5
 *
 */
function wp_squidge_get_attachment($attachment)
{
    // Get the attachment post object.
    $attachment = get_post($attachment);
    if (!$attachment) {
        return false;
    }
    if ($attachment->post_type !== 'attachment') {
        return false;
    }

    // Load various attachment details.
    $meta = wp_get_attachment_metadata($attachment->ID);
    $attached_file = get_attached_file($attachment->ID);
    if (strpos($attachment->post_mime_type, '/') !== false) {
        list($type, $subtype) = explode('/', $attachment->post_mime_type);
    } else {
        list($type, $subtype) = array($attachment->post_mime_type, '');
    }

    // Generate response.
    $response = array(
        'ID'          => $attachment->ID,
        'title'       => $attachment->post_title,
        'filepath'    => get_attached_file($attachment->ID),
        'filename'    => wp_basename($attached_file),
        'filesize'    => 0,
        'url'         => wp_get_attachment_url($attachment->ID),
        'author'      => $attachment->post_author,
        'description' => $attachment->post_content,
        'caption'     => $attachment->post_excerpt,
        'name'        => $attachment->post_name,
        'status'      => $attachment->post_status,
        'uploaded_to' => $attachment->post_parent,
        'date'        => $attachment->post_date_gmt,
        'mime_type'   => $attachment->post_mime_type,
        'type'        => $type,
        'subtype'     => $subtype,
        'icon'        => wp_mime_type_icon($attachment->ID)
    );

    // Append filesize data.
    if (isset($meta['filesize'])) {
        $response['filesize'] = $meta['filesize'];
    } elseif (file_exists($attached_file)) {
        $response['filesize'] = filesize($attached_file);
    }

    // Restrict the loading of image "sizes".
    $sizes_id = 0;

    if ($type === 'image') {
        $sizes_id = $attachment->ID;
        $src = wp_get_attachment_image_src($attachment->ID, 'full');
        if ($src) {
            $response['url'] = $src[0];
            $response['width'] = $src[1];
            $response['height'] = $src[2];
        }
    }

    // Load array of image sizes.
    if( $sizes_id ) {
        $sizes = get_intermediate_image_sizes();
        $sizes_data = array();
        foreach( $sizes as $size ) {
            $src = wp_get_attachment_image_src( $sizes_id, $size );

            //print_r(image_get_intermediate_size($attachment->ID, $size));

           // print_r(wp_upload_dir());

            // https://stackoverflow.com/questions/36700286/is-there-any-away-to-get-absolute-path-of-product-image-featured-image-in-wordpr

            if ( $src ) {
                $sizes_data[ $size ] = $src[0];
                $sizes_data[ $size . '-width' ] = $src[1];
                $sizes_data[ $size . '-height' ] = $src[2];
            }
        }
        $response['sizes'] = $sizes_data;
    }


    return $response;
}

add_action('init', function () {
    $query_images_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
    );

    $query_images = new WP_Query($query_images_args);

    $images = array();
    foreach ($query_images->posts as $image) {



        echo '<pre>';
        print_r(wp_squidge_get_attachment($image->ID));
    }

});
