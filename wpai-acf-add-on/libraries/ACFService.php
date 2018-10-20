<?php

namespace wpai_acf_add_on\acf;

use wpai_acf_add_on\acf\fields\Field;

/**
 * Class ACFService
 * @package wpai_acf_add_on\acf
 */
final class ACFService{

    /**
     * @param $version
     * @return bool
     */
    public static function isACFNewerThan($version) {
        global $acf;
        return version_compare($acf->settings['version'], $version) >= 0;
    }

    /**
     *
     * Set ACF field value
     *
     * @param \wpai_acf_add_on\acf\fields\Field $field
     * @param $pid
     * @param $name
     * @param $value
     */
    public static function update_post_meta(Field $field, $pid, $name, $value) {

        $cf_value = apply_filters('pmxi_acf_custom_field', $value, $pid, $name);

        switch ($field->getImportType()) {
            case 'import_users':
                update_user_meta($pid, $name, $cf_value);
                break;
            case 'taxonomies':
                $option = $field->getTaxonomyType() . '_' . $pid . '_' . $name;
                if (strpos($cf_value, 'field_') === 0 && strpos($name, '_') === 0) {
                    $option = '_' . $field->getTaxonomyType() . '_' . $pid . $name;
                }
                update_option($option, $cf_value);
                update_term_meta($pid, $name, $value);
                break;
            default:
                update_post_meta($pid, $name, $cf_value);
                break;
        }
    }

    /**
     *
     * Get ACF field value
     *
     * @param Field $field
     * @param $pid
     * @param $name
     * @return mixed
     */
    public static function get_post_meta(Field $field, $pid, $name) {
        switch ($field->getImportType()) {
            case 'import_users':
                $value = get_user_meta($pid, $name, TRUE);
                break;
            case 'taxonomies':
                $value = get_option($field->getTaxonomyType() . '_' . $pid . '_' . $name);
                break;
            default:
                $value = get_post_meta($pid, $name, TRUE);
                break;
        }
        return $value;
    }

    /**
     *
     * Assign taxonomy terms with particular post
     *
     * @param $pid
     * @param $assign_taxes
     * @param $tx_name
     * @param bool $logger
     */
    public static function associate_terms($pid, $assign_taxes, $tx_name, $logger = FALSE) {

        global $wpdb;

        wp_cache_flush();
        $terms = wp_get_object_terms( $pid, $tx_name );
        $term_ids = array();

        $assign_taxes = (is_array($assign_taxes)) ? array_filter($assign_taxes) : false;

        if ( ! empty($terms) ){
            if ( ! is_wp_error( $terms ) ) {
                foreach ($terms as $term_info) {
                    $term_ids[] = $term_info->term_taxonomy_id;
                    $wpdb->query(  $wpdb->prepare("UPDATE {$wpdb->term_taxonomy} SET count = count - 1 WHERE term_taxonomy_id = %d AND count > 0", $term_info->term_taxonomy_id) );
                }
                $in_tt_ids = "'" . implode( "', '", $term_ids ) . "'";
                $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->term_relationships} WHERE object_id = %d AND term_taxonomy_id IN ($in_tt_ids)", $pid ) );
            }
        }

        if (empty($assign_taxes)) return;

        $values = array();
        $term_order = 0;
        foreach ( $assign_taxes as $tt )
        {
            do_action('wp_all_import_associate_term', $pid, $tt, $tx_name);
            $values[] = $wpdb->prepare( "(%d, %d, %d)", $pid, $tt, ++$term_order);
            $wpdb->query( "UPDATE {$wpdb->term_taxonomy} SET count = count + 1 WHERE term_taxonomy_id = $tt" );
        }

        if ( $values ){
            if ( false === $wpdb->query( "INSERT INTO {$wpdb->term_relationships} (object_id, term_taxonomy_id, term_order) VALUES " . join( ',', $values ) . " ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)" ) ){
                $logger and call_user_func($logger, __('<b>ERROR</b> Could not insert term relationship into the database', 'wp_all_import_plugin') . ': '. $wpdb->last_error);
            }
        }

        wp_cache_delete( $pid, $tx_name . '_relationships' );
    }

    /**
     * @param Field $field
     * @param $img_url
     * @param $pid
     * @param $logger
     * @param bool $search_in_gallery
     * @return bool|int|\WP_Error
     */
    public static function import_image(Field $field, $img_url, $pid, $logger, $search_in_gallery = FALSE) {

        // search image attachment by ID
        if ($search_in_gallery and is_numeric($img_url)) {
            if (wp_get_attachment_url($img_url)) {
                return $img_url;
            }
        }

        $importData  = $field->getImportData();
        $parsingData = $field->getParsingData();

        $uploads = wp_upload_dir();

        $uploads = apply_filters('wp_all_import_images_uploads_dir', $uploads, $importData['articleData'], $parsingData['xml'], $importData['import']->id);

        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $url = trim($img_url);
        $bn = wp_all_import_sanitize_filename(urldecode(basename($url)));

        $img_ext = pmxi_getExtensionFromStr($url);
        $default_extension = pmxi_getExtension($bn);

        if ($img_ext == "") {
            $img_ext = pmxi_get_remote_image_ext($url);
        }

        // generate local file name
        $image_name = apply_filters("wp_all_import_image_filename", urldecode(sanitize_file_name((($img_ext) ? str_replace("." . $default_extension, "", $bn) : $bn))) . (("" != $img_ext) ? '.' . $img_ext : ''));

        // if wizard store image data to custom field
        $create_image = FALSE;
        $download_image = TRUE;
        $attachment = FALSE;

        $image_filename = $image_name;
        $image_filepath = $uploads['path'] . '/' . $image_filename;

        if ($search_in_gallery) {

            // trying to find existing image in hash table
            if (class_exists('PMXI_Image_List')){
                $imageList = new \PMXI_Image_List();
                $args = array(
                    'hash' => md5($img_url)
                );
                foreach($imageList->getBy($args)->convertRecords() as $imageRecord) {
                    if ( ! $imageRecord->isEmpty() ) {
                        $attachment = get_post($imageRecord->attachment_id);
                    }
                    if ($attachment){
                        $logger and call_user_func($logger, sprintf(__('Existing image was found by URL `%s` hash `%s`...', 'wp_all_import_plugin'), $img_url, md5($img_url)));
                        break;
                    }
                }
            }
            if (empty($attachment)) {
                $attachment = wp_all_import_get_image_from_gallery($image_name, $uploads['path']);
            }

            if (empty($attachment)) {
                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Image %s not found in media gallery.', 'wp_all_import_acf_add_on'), trim($image_name)));
            }
            else {
                $logger and call_user_func($logger, sprintf(__('- Using existing image `%s`...', 'wp_all_import_acf_add_on'), trim($image_name)));
                return $attachment->ID;
            }
        }

        if ($download_image) {

            $image_filename = wp_unique_filename($uploads['path'], $image_name);
            $image_filepath = $uploads['path'] . '/' . $image_filename;

            $logger and call_user_func($logger, sprintf(__('- Downloading image from `%s`', 'wp_all_import_plugin'), $url));

            $request = get_file_curl($url, $image_filepath);

            if ((is_wp_error($request) or $request === FALSE) and !@file_put_contents($image_filepath, @file_get_contents($url))) {
                @unlink($image_filepath); // delete file since failed upload may result in empty file created
            }
            else{
                if( preg_match('%\W(svg)$%i', \PMAI_Compatibility::basename($image_filepath)) or $image_info = apply_filters('pmxi_getimagesize', @getimagesize($image_filepath), $image_filepath) and in_array($image_info[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
                    $create_image = true;
                    $logger and call_user_func($logger, sprintf(__('- Image `%s` has been successfully downloaded', 'wp_all_import_plugin'), $url));
                }
                else
                {
                    $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as featured one', 'wp_all_import_plugin'), $url));
                }
            }

            if (!$create_image) {

                $url = str_replace(" ", "%20", trim(pmxi_convert_encoding($img_url)));

                $request = get_file_curl($url, $image_filepath);

                if ((is_wp_error($request) or $request === FALSE) and !@file_put_contents($image_filepath, @file_get_contents($url))) {
                    $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s cannot be saved locally as %s', 'wp_all_import_acf_add_on'), $url, $image_filepath));
                    @unlink($image_filepath); // delete file since failed upload may result in empty file created
                }
                else{
                    if( preg_match('%\W(svg)$%i', \PMAI_Compatibility::basename($image_filepath)) or $image_info = apply_filters('pmxi_getimagesize', @getimagesize($image_filepath), $image_filepath) and in_array($image_info[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
                        $create_image = true;
                        $logger and call_user_func($logger, sprintf(__('- Image `%s` has been successfully downloaded', 'wp_all_import_plugin'), $url));
                    } else {
                        $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as featured one', 'wp_all_import_plugin'), $url));
                        @unlink($image_filepath);
                    }
                }
            }
        }

        if ($create_image) {

            $file_mime_type = '';

            if ( ! empty($image_info) )
            {
                $file_mime_type = image_type_to_mime_type($image_info[2]);
            }
            $file_mime_type = apply_filters('wp_all_import_image_mime_type', $file_mime_type, $image_filepath);

            $attachment = array(
                'post_mime_type' => $file_mime_type,
                'guid' => $uploads['url'] . '/' . $image_filename,
                'post_title' => $image_filename,
                'post_content' => '',
                'post_author' => $importData['articleData']['post_author'],
            );
            if (($image_meta = wp_read_image_metadata($image_filepath))) {
                if (trim($image_meta['title']) && !is_numeric(sanitize_title($image_meta['title']))) {
                    $attachment['post_title'] = $image_meta['title'];
                }
                if (trim($image_meta['caption'])) {
                    $attachment['post_content'] = $image_meta['caption'];
                }
            }

            $attid = wp_insert_attachment($attachment, $image_filepath, $pid);

            if (is_wp_error($attid)) {
                $logger and call_user_func($logger, __('- <b>WARNING</b>', 'wp_all_import_acf_add_on') . ': ' . $attid->get_error_message());
            }
            else {

                wp_update_attachment_metadata($attid, wp_generate_attachment_metadata($attid, $image_filepath));

                if (class_exists('PMXI_Image_Record')){
                    $imageRecord = new \PMXI_Image_Record();
                    $imageRecord->isEmpty() and $imageRecord->set(array(
                        'attachment_id' => $attid,
                        'hash' => md5($img_url)
                    ))->insert();
                }

                do_action('pmxi_gallery_image', $pid, $attid, $image_filepath);

                return $attid;
            }
        }

        return FALSE;
    }

    /**
     * @param Field $field
     * @param $atch_url
     * @param $pid
     * @param $logger
     * @param bool $fast
     * @param bool $search_in_gallery
     * @return bool|int|\WP_Error
     */
    public static function import_file(Field $field, $atch_url, $pid, $logger, $fast = FALSE, $search_in_gallery = FALSE) {

        // search file attachment by ID
        if ($search_in_gallery and is_numeric($atch_url)) {
            if (wp_get_attachment_url($atch_url)) {
                return $atch_url;
            }
        }

        $importData  = $field->getImportData();
        $parsingData = $field->getParsingData();

        global $wpdb;

        $uploads = wp_upload_dir();

        $uploads = apply_filters('wp_all_import_images_uploads_dir', $uploads, $importData['articleData'], $parsingData['xml'], $importData['import']->id);

        $file_name = sanitize_file_name(basename(parse_url(trim($atch_url), PHP_URL_PATH)));
        $wpai_uploads = \PMXI_Plugin::FILES_DIRECTORY . DIRECTORY_SEPARATOR;

        if (!preg_match('%^https?://%i', $atch_url)) {
            $file_path = $wpai_uploads . $atch_url;
        }
        else {
            $file_path = $uploads['path'] . '/' . $file_name;
        }
        $attachment_filename = wp_unique_filename($uploads['path'], $file_name);
        $attachment_filepath = $uploads['path'] . '/' . sanitize_file_name($attachment_filename);
        $download_file = TRUE;
        $create_file = FALSE;

        if ($search_in_gallery) {

            $attachment = wp_all_import_get_image_from_gallery($file_name, $uploads['path'], 'files');

            if ( $attachment ){
                return $attachment->ID;
            }

            if (@file_exists($file_path)) {
                if (!$wp_filetype = wp_check_filetype(basename($file_name), NULL)) {
                    $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as ACF image', 'wp_all_import_acf_add_on'), $file_path));
                }
                else {
                    $download_file = FALSE;
                    $create_file = TRUE;
                }
            }
        }

        if ($download_file) {
            if (!get_file_curl(trim($atch_url), $attachment_filepath) and !@file_put_contents($attachment_filepath, @file_get_contents(trim($atch_url)))) {
                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Attachment file %s cannot be saved locally as %s', 'wp_all_import_acf_add_on'), trim($atch_url), $attachment_filepath));
                unlink($attachment_filepath); // delete file since failed upload may result in empty file created
            }
            elseif (!$wp_filetype = wp_check_filetype(basename($attachment_filename), NULL)) {
                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Can\'t detect attachment file type %s', 'wp_all_import_acf_add_on'), trim($atch_url)));
            }
            else {
                $create_file = TRUE;
            }
        }

        if ($create_file) {
            $attachment_data = array(
                'guid' => $uploads['baseurl'] . '/' . _wp_relative_upload_path($attachment_filepath),
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($attachment_filepath)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment_data, $attachment_filepath);

            if (is_wp_error($attach_id)) {
                $logger and call_user_func($logger, __('- <b>WARNING</b>', 'wp_all_import_acf_add_on') . ': ' . $pid->get_error_message());
            }
            else {
                // you must first include the image.php file
                // for the function wp_generate_attachment_metadata() to work
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                do_action('pmxi_attachment_uploaded', $pid, $attach_id, $attachment_filepath);
                wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $attachment_filepath));
                return $attach_id;
            }
        }
        return FALSE;
    }
}