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
