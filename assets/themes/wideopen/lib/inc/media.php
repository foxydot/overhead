<?php
/**
 * Add new image sizes
 */
add_image_size('mini-thumbnail', 75, 75, FALSE);
add_image_size('medlg', 500, 500, FALSE);
add_image_size('facebook', 200, 200, TRUE);
add_image_size('linkedin', 180, 110, TRUE);

/* Display a custom favicon */
add_filter( 'genesis_pre_load_favicon', 'msdlab_favicon_filter' );
function msdlab_favicon_filter( $favicon_url ) {
    return get_stylesheet_directory_uri().'/lib/img/favicon.ico';
}

//add_action('genesis_after_header','msd_post_image');
/**
 * Manipulate the featured image
 */
function msd_post_image() {
    global $post;
    //setup thumbnail image args to be used with genesis_get_image();
    $size = 'post-image'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    );

    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail() && is_page() ) {
        msdlab_page_banner();
    } elseif ( has_post_thumbnail() ){
        print '<section class="header-image">';
        printf( '<a title="%s" href="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
        print '</section>';
    } elseif( is_front_page() ){
        msdlab_page_banner();
    }

}

/**
 * Add new image sizes to the media panel
 */
if(!function_exists('msd_insert_custom_image_sizes')){
function msd_insert_custom_image_sizes( $sizes ) {
	global $_wp_additional_image_sizes;
	if ( empty($_wp_additional_image_sizes) )
		return $sizes;

	foreach ( $_wp_additional_image_sizes as $id => $data ) {
		if ( !isset($sizes[$id]) )
			$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
	}

	return $sizes;
}
}
add_filter( 'image_size_names_choose', 'msd_insert_custom_image_sizes' );