<?php

namespace wpai_acf_add_on\acf\fields;

use wpai_acf_add_on\acf\ACFService;

/**
 * Class FieldRelationship
 * @package wpai_acf_add_on\acf\fields
 */
class FieldRelationship extends Field {

    /**
     *  Field type key
     */
    public $type = 'relationship';

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
        $xpath = is_array($xpath) ? $xpath['value'] : $xpath;
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

        $xpath = $this->getOption('xpath');

        $values = parent::getFieldValue();

        if (!is_array($values)){
            $values = explode($xpath['delim'], $values);
        }

        foreach ($values as $ev) {
            $relation = false;
            if (ctype_digit($ev)) {
                $relation = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID = %s", $ev));
            }
            if (empty($relation)){
                $sql = "SELECT * FROM {$wpdb->posts} WHERE post_type IN ('%s') AND ( post_title = %s OR post_name = %s )";
                $relation = $wpdb->get_row($wpdb->prepare($sql, implode("','", $this->getFieldOption('post_type')), $ev, sanitize_title_for_query($ev)));
            }
            if ($relation) {
                $post_ids[] = (string) $relation->ID;
            }
        }
        return empty($post_ids) ? '' : $post_ids;
    }

}