<?php
// $Id:$

/**
 * @file
 * Administrative page callbacks for the wnr module.
 */

/**
 * Implementation of hook_admin_settings() for configuring the module
 */
function webform_node_request_admin_settings_form(&$form_state) {
  $form = array();
  $form['webform_node_request']['webform_node_request_form'] = array(
    '#type' => 'textfield',
    '#title' => t('Enter the form path'),
    '#default_value' => variable_get('webform_node_request_form_nid', 'node/1'),
    '#description' => t('Form path example: node/1')
  );
  $form['webform_node_request']['webform_node_request_other'] = array(
    '#type' => 'textarea',
    '#title' => t('Enter an alternate contact method'),
    '#default_value' => variable_get('webform_node_request_other', ''),
    '#description' => t('This information will appear -- todo --.')
  );
  
  return system_settings_form($form);
}

