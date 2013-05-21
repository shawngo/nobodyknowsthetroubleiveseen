<?php
// $Id: editview_plugin_style_node_add.inc,v 1.1 2009/02/17 00:39:02 agileware Exp $

/**
 * @file
 * Style plug-in file.
 *
 * This is kept in a separate file and included only when needed to prevent
 * missing class errors.
 */

/**
 * @addtogroup editview
 * @{
 */

/**
 * Style plugin to add new node form.
 *
 * Fields which are added to the view will be shown.
 */
class editview_plugin_style_node_add extends views_plugin_style {
  /**
   * Implementation of option_definition().
   */
  function option_definition() {
    $options = parent::option_definition();
    $options['editview_node_type'] = array();
    $options['editview_node_position'] = array('default' => EDITVIEW_ABOVE);
    return $options;
  }

  /**
   * Implementation of options_form().
   */
  function options_form(&$form, &$form_state) {
    $form['editview_node_type'] = array(
      '#type' => 'select',
      '#title' => t('Node type'),
      '#default_value' => $this->options['editview_node_type'],
      '#options' => node_get_types('names'),
      '#description' => t('Select a node type for the new node form.'),
      '#required' => TRUE,
    );
    $form['editview_node_position'] = array(
      '#type' => 'radios',
      '#title' => t('New node position'),
      '#default_value' => $this->options['editview_node_position'],
      '#options' => array(t('Above'), t('Below')),
      '#description' => t('Specify whether a new node form should be above or below existing records.'),
    );
    parent::options_form($form, $form_state);
  }

  /**
   * Implementation of uses_row_plugin().
   *
   * We want to hard-code the row plug-in, so we return TRUE here instead of
   * specifying that we use a row plug-in in our style definition.
   */
  function uses_row_plugin() {
    return TRUE;
  }

  /**
   * Implementation of render().
   *
   * Render the view with a new node form.
   */
  function render() {
    // Create empty node.
    $node = new stdClass();
    // Add empty view fields (needed for grouped views).
    foreach ($this->view->field as $field) {
      foreach ($field->aliases as $alias) {
        $node->$alias = NULL;
      }
      $alias = $field->field_alias;
      $node->$alias = NULL;
    }
    $node->nid = 'new';
    if ($this->options['grouping'] == 'type' && !empty($this->view->result)) {
      // If grouping by node type, add an empty node for each type.
      foreach ($this->view->result as $row) {
        $types[$row->node_type] = NULL;
      }
      foreach (array_keys($types) as $type) {
        $node->node_type = $type;
        if (empty($this->options['editview_node_position'])) {
          array_unshift($this->view->result, $node);
        }
        else {
          array_push($this->view->result, $node);
        }
      }
    }
    else {
      // Otherwise, add one empty node.
      if (empty($this->options['editview_node_position'])) {
        array_unshift($this->view->result, $node);
      }
      else {
        array_push($this->view->result, $node);
      }
    }
    // Initialize the Editview row plug-in.
    $this->row_plugin = views_get_plugin('row', 'editview');
    $this->row_plugin->init($this->view, $this->display);
    return parent::render();
  }
}

/**
 * @} End of "addtogroup editview".
 */
