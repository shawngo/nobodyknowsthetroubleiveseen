<?php
// $Id:$

/**
 * @file
 * Administrative page callbacks for the insitemetrics module.
 */

/**
 * Implementation of hook_admin_settings() for configuring the module
 */
function jobapp_admin_settings_form(&$form_state) {
  $form = array();
  $form['jobapp']['jobapp_application_form'] = array(
    '#type' => 'textfield',
    '#title' => t('Enter the form path'),
    '#default_value' => variable_get('jobapp_application_form', 'node/40'),
    '#description' => t('Form path example: node/1')
  );
  $form['jobapp']['jobapp_apply_other'] = array(
    '#type' => 'textarea',
    '#title' => t('Enter an alternate contact method'),
    '#default_value' => variable_get('jobapp_apply_other', ''),
    '#description' => t('This information will appear above the Apply Now link.')
  );
  
  return system_settings_form($form);
}