<?php

namespace wpai_acf_add_on\acf\fields;

use wpai_acf_add_on\acf\ACFService;

/**
 * Class FieldPostObject
 * @package wpai_acf_add_on\acf\fields
 */
class FieldPostObject extends Field {

    /**
     *  Field type key
     */
    public $type = 'post_object';

    /**
     *
     * Parse field data
     *
     * @param $xpath
     * @param $parsingData
     * @param array $args
     */
    public function parse($xpath, $parsingData, $args = array()) {
        parent::parse($xpath, $parsingData, $args);
        $values = $this->getByXPath($xpath);
        $this->setOption('values', $values);
    }

    /**
     * @param $importData
     * @param array $args
     * @return void
     */
    public function import($importData, $args = array()) {
        parent::import($importData, $args);
        ACFService::update_post_meta($this, $this->getPostID(), $this->getFieldName(), $this->getFieldValue());
    }

    /**
     * @return false|int|mixed|string
     */
    public function getFieldValue() {
        global $wpdb;
        $post_ids = array();
        $entries = explode(",", parent::getFieldValue());
        if (!empty($entries) and is_array($entries)) {
            foreach ($entries as $ev) {
                $relation = false;
                if (ctype_digit($ev)) {
                    $relation = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID = %s", $ev));
                }
                if (empty($relation))
                {
                    if (empty($field['post_type'])){
                        $sql = "SELECT * FROM {$wpdb->posts} WHERE post_type != %s AND ( post_title = %s OR post_name = %s )";
                        $relation = $wpdb->get_row($wpdb->prepare($sql, 'revision', $ev, sanitize_title_for_query($ev)));
                    }
                    else{
                        $sql = "SELECT * FROM {$wpdb->posts} WHERE post_type IN ('%s') AND ( post_title = %s OR post_name = %s )";
                        $relation = $wpdb->get_row($wpdb->prepare($sql, implode("','", $field['post_type']), $ev, sanitize_title_for_query($ev)));
                    }
                }
                if ($relation) {
                    $post_ids[] = (string) $relation->ID;
                }
            }
        }
        if (!empty($post_ids)) {
            $parsedData = $this->getParsedData();
            return empty($parsedData['multiple']) ? array_shift($post_ids) : $post_ids;
        }
        return '';
    }
}