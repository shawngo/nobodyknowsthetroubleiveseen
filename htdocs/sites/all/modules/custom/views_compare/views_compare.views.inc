<?php

/**
 * Implementation of hook_views_handlers().
 *
 * @return array
 */
function views_compare_views_handlers() {
  return array(
  'info' => array(
    'path' => drupal_get_path('module', 'views_compare') .'/views',
    ),
  'handlers' => array(
    'views_compare_handler_field_compare' => array(
     'parent' => 'views_handler_field',
     ),        
    ),
  );
}


/**
 * Implementation of hook_views_data().
 *
 * @return array
 */
function views_compare_views_data() {
  $data['views_compare']['table']['group'] = t('Views Compare');
  $data['views_compare']['table']['join'] = array(
    '#global' => array(),
  );
  
  $data['views_compare']['compare'] = array(
    'title' => t('Compare'),
    'help' => t('Display compare checkboxes.'),
    'field' => array(
      'handler' => 'views_compare_handler_field_compare',
      'click sortable' => FALSE,
      'notafield' => TRUE,
    ),
  );
  
  return $data;
}