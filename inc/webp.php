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
    public function convert(array $images)
    {
        if (!$this->installed()) {
            error_log("WP Squidge - cwebp is not installed");
            return;
        }
        foreach ($images as $image) {
            exec("cwebp -q " . $this->quality . " " . $image['path'] . " -o " . $image['path'] . self::EXTENSION);
        }
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
     * @since   5.1.5
     *
     * @param   int|WP_Post The attachment ID or object.
     * @return  array|false
     */
    protected function get_attachment($attachment)
    {
        // Get the attachment post object.
        $attachment = get_post( $attachment );
        if ( ! $attachment ) {
            return false;
        }
        if ( $attachment->post_type !== 'attachment' ) {
            return false;
        }

        // Generate response.
        $response = array(
            'ID'          => $attachment->ID,
            'id'          => $attachment->ID,
            'title'       => $attachment->post_title,
            'filename'    => wp_basename( $attached_file ),
            'filesize'    => 0,
            'url'         => wp_get_attachment_url( $attachment->ID ),
            'link'        => get_attachment_link( $attachment->ID ),
            'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'author'      => $attachment->post_author,
            'description' => $attachment->post_content,
            'caption'     => $attachment->post_excerpt,
            'name'        => $attachment->post_name,
            'status'      => $attachment->post_status,
            'uploaded_to' => $attachment->post_parent,
            'date'        => $attachment->post_date_gmt,
            'modified'    => $attachment->post_modified_gmt,
            'menu_order'  => $attachment->menu_order,
            'mime_type'   => $attachment->post_mime_type,
            'type'        => $type,
            'subtype'     => $subtype,
            'icon'        => wp_mime_type_icon( $attachment->ID ),
        );

        $sizes      = get_intermediate_image_sizes();
        $sizes_data = array();
        foreach ( $sizes as $size ) {
            $src = wp_get_attachment_image_src( $sizes_id, $size );
            if ( $src ) {
                $sizes_data[ $size ]             = $src[0];
                $sizes_data[ $size . '-width' ]  = $src[1];
                $sizes_data[ $size . '-height' ] = $src[2];
            }
        }
        $response['sizes'] = $sizes_data;
    }
}