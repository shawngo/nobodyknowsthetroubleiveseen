<?php
// $Id: webform-form.tpl.php,v 1.1.2.4 2009/01/11 23:09:35 quicksketch Exp $

/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 */
?>
<style type="text/css">
  #main .labels-inline label {width: 165px;}
  #main .labels-inline .form-item .form-item 
, #main .labels-inline .form-item select { padding-left: 10px; display: inline; margin:0; }

  #main .form-item {padding-left: 175px;}
  #main .form-radios .form-item {padding-left: 90px;}
  #main .short-labels-inline div.form-item {padding-left: 135px;}

  #main .long-labels-inline label {width: 220px;}
  #main .long-labels-inline div.form-item {height: 40px;padding-left: 235px;}
  #main .long-labels-inline div.form-item .form-item 
, #main .long-labels-inline div.form-item .form-radios { padding-left: 0px; }
  #main .long-labels-inline div.form-item .form-radios .form-item {display: inline;float: left;padding-right: 20px;}

  #main fieldset.nested-short-labels-inline label { width: 100px; }
  #main fieldset.nested-short-labels-inline div.form-item { padding-left: 110px;}
  #main fieldset.nested-long-labels-inline label { width: 220px;}
  #main fieldset.nested-long-labels-inline div.form-item {padding-left: 230px;}

  #main fieldset.nested-long-labels-block label { width: auto; position: relative; text-align: left; margin-bottom: 0; }
  #main fieldset.nested-long-labels-block div.form-item { padding-left: 0px; height: auto; clear: both; display: block;}
  #main fieldset.nested-long-labels-block div.form-item .form-radios .form-item {display: inline; float: none; padding-right: 20px;}
  #main fieldset.nested-long-labels-block div.form-item .form-radios {margin: 0;}

  #main .long-labels-block label { width: auto; position: relative; text-align: left; margin-bottom: 0; }
  #main .long-labels-block div.form-item { padding-left: 0px; height: auto; clear: both; display: block;}
  #main .long-labels-block div.form-item .form-radios .form-item 
, #main .long-labels-block div.form-item .form-checkboxes .form-item { display: inline; float: none; padding-right: 20px; }
  #main .long-labels-block div.form-item .form-radios {margin: 0;}

/* specificalities */
#webform-component-energy--environmental-information--what-do-you-estimate-as-your-top-five-energy-consuming-activities-or-equipment-areas {
height: 180px;
}
</style>
<?php
//dpm($form);

  // If editing or viewing submissions, display the navigation at the top.
  if (isset($form['submission_info']) || isset($form['navigation'])) {
    print drupal_render($form['navigation']);
    print drupal_render($form['submission_info']);
  }

  if (!empty($form['actions']['next'])) {
    //wmep_fieldset_labels_on_left_table( $form['submitted']['company_information'], TRUE, 50 );
    wmep_fieldset_subfieldsets_to_table( $form['submitted']['tracking__progress'], array('', 'No Program', 'Some Tracking', 'Audit Process', 'Full Program', 'NA'));
    $form['submitted']['company_information']['#attributes']['class'] .= ' labels-inline';
    $form['submitted']['product__process_information']['#attributes']['class'] .= ' labels-break';
    $form['submitted']['energy__environmental_information']['water']['#attributes']['class'] .= ' labels-break';

    // just adding classes for display
    $form['submitted']['contact_information']['#attributes']['class'] .= ' short-labels-inline';
    $form['submitted']['product__process_information']['#attributes']['class'] .= ' long-labels-inline';
    $form['submitted']['energy__environmental_information']['#attributes']['class'] .= ' long-labels-inline';
    $form['submitted']['energy__environmental_information']['other_fuels']['#attributes']['class'] .= ' nested-short-labels-inline';

    $form['submitted']['energy__environmental_information']['waste']['#attributes']['class'] .= ' nested-long-labels-block';

    $form['submitted']['transportation_information']['#attributes']['class'] .= ' long-labels-block';
    $form['submitted']['senior_executivelabor_essay']['#attributes']['class'] .= ' long-labels-block';
  }

/** PRINT PAGE **/
/* */
  if (!empty($form['actions']['previous'])) {
    $components = $form['#parameters'][2]->webform['components'];
    foreach ($components as $component) {
      $cfields[$component['form_key']] = $component;
    }
//dpm($cfields);
    wmep_println(NULL,NULL,$cfields);
    $s_vals = $form['#parameters'][1]['storage']['submitted'];

    array_walk_recursive($s_vals, 'wmep_println');

    echo '<p><input type="button" id="print-webform-results" value="Click To Print Results" onclick="window.print();" /></p>';


  }
// */

//  drupal_render($form['#parameters'][1]['storage']['submitted']['company_information']);
//  dpm($form);

  // Print out the main part of the form.
  // Feel free to break this up and move the pieces within the array.
  print drupal_render($form['submitted']);


  // Always print out the entire $form. This renders the remaining pieces of the
  // form that haven't yet been rendered above.
  print drupal_render($form);

  // Print out the navigation again at the bottom.
  if (isset($form['submission_info']) || isset($form['navigation'])) {
    unset($form['navigation']['#printed']);
    print drupal_render($form['navigation']);
  }


function wmep_println($item, $key, $fields = NULL) {
  static $cfields; 
  if ($fields != NULL) {
    $cfields = $fields;
    return;
  }
  $item = check_plain($item);
  if ($key != 'pagebreak' && $item != '') {
    echo '<p><strong>'. $cfields[$key]['name'] .'</strong>: '. $item .'</p>';
  }
}
