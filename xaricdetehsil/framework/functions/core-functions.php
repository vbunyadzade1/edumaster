<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Find image type
/*-----------------------------------------------------------------------------------*/
function kavkaz_get_image_type($url){

    $data = explode('.', substr(basename($url), -5));
    $type = $data['1'];

    if ($type == 'jpg') {
        $end = '.jpg';
    } elseif ($type == 'png') {
        $end = '.png';
    } elseif ($type == 'gif') {
        $end = '.gif';
    } elseif ($type == 'jpeg') {
        $end = '.jpeg';
    }
    
    if ($end) {
        return $end;
    } else {
        return false;
    }

}

/*-----------------------------------------------------------------------------------*/
# Poster Uploader
/*-----------------------------------------------------------------------------------*/
function kavkaz_video_upload_image($new_thumbnail, $video_id){
    
    if ($new_thumbnail != null && !has_post_thumbnail()) {

        $error = '';
        $ch = curl_init();
        $timeout = 0;
        curl_setopt($ch, CURLOPT_URL, $new_thumbnail);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $image_contents = curl_exec($ch);

        if (curl_error($ch) != null || $image_contents == null) {
            $curl_error = '';
            if (curl_error($ch) != null) {
                $curl_error = '<br /><a href="http://curl.haxx.se/libcurl/c/libcurl-errors.html">Libcurl error</a> ' . curl_errno($ch) . ': <code>' . curl_error($ch) . '</code>';
            }
            $error = new WP_Error(
                'thumbnail_retrieval',
                __(
                    'Error retrieving a thumbnail from the URL <a href="' .
                        $new_thumbnail .
                        '">' .
                        $new_thumbnail .
                        '</a>' .
                        $curl_error .
                        '. If opening that URL in your web browser shows an image, the problem may be related to your web server and might be something your server administrator can solve.'
                )
            );
        }
        curl_close($ch);

        if ($error != null) {
            return $error;
        }

        $end = kavkaz_get_image_type($new_thumbnail);

        $unique_name = get_the_title() . $end;

        $upload = wp_upload_bits($unique_name, null, $image_contents);

        $new_thumbnail = $upload['url'];

        $filename = $upload['file'];

        $wp_filetype = wp_check_filetype(basename($filename), null);
        $attachment = ['post_mime_type' => $wp_filetype['type'], 'post_title' => get_the_title($video_id), 'post_content' => '', 'post_status' => 'inherit'];
        $attach_id = wp_insert_attachment($attachment, $filename, $video_id);

        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
        wp_update_attachment_metadata($attach_id, $attach_data);

        if (!update_post_meta($video_id, '_video_thumbnail', $new_thumbnail)) {
            add_post_meta($video_id, '_video_thumbnail', $new_thumbnail, true);
        }

        if (!update_post_meta($video_id, '_thumbnail_id', $attach_id)) {
            add_post_meta($video_id, '_thumbnail_id', $attach_id, true);
        }

    }
}

?>