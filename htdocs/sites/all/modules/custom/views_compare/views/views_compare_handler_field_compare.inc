<?php
// $Id$

/**
 * @file
 * Contains the 'compare' compare field handler.
 */

/**
 * Display the simpler Compare Item form like the catalog.
 */
class views_compare_handler_field_compare extends views_handler_field {
  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function element_type() {
    if (isset($this->definition['element type'])) {
      return $this->definition['element type'];
    }
    return 'div';
  }

  function render($values) {

//    drupal_add_js(drupal_get_path('module', 'views_compare') . '/js/jquery.simpletip.js');
    
    drupal_add_js(drupal_get_path('module', 'views_compare') . '/js/jquery.livequery.js');
    drupal_add_js(drupal_get_path('module', 'views_compare') . '/js/views_compare.js');
    /*
      stdClass Object
      (
          [nid] => 1126
          [node_title] => Accessory Table
          [node_type] => product
      )
   */
  return drupal_get_form('views_compare_form_'. $values->nid, $values->nid);

//    $product = node_load($values->{$this->aliases['nid']});
//    if (uc_product_is_product($product)) {
//      return drupal_get_form('views_compare_form', $product);
//      //. $values->{$this->aliases['nid']}
//    }
  }
/*
  function query() {
    $this->field_alias = 'views_compare_compare_'. $this->position;
    
    $value = db_escape_string($this->options['value']);
    $this->query->add_field('', "'$value'", $this->field_alias);
  }
  
  function option_definition() {
    $options = parent::option_definition();
    $options['value'] = array('default' => '');
    $options['format'] = array('default' => FILTER_FORMAT_DEFAULT);
    return $options;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['value'] = array(
      '#type' => 'textarea',
      '#title' => t('Value'),
      '#default_value' => $this->options['value'],
      '#rows' => 5,
    );
    $form['format'] = filter_form($this->options['format'], NULL, array('options', 'format'));
  }

  function render($values) {
    $value = $values->{$this->field_alias};
    return check_markup($value, $this->options['format'], FALSE);
  }
*/

}
