<?php
// $Id: template.php,v 1.21 2009/08/12 04:25:15 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to wmep_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: wmep_breadcrumb()
 *
 *   where STARTERKIT is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


function wmep_box($title, $content, $region = 'main') {
  if ($title == 'Your search yielded no results')
  {
    $content = '<ul>';
    $content .= '<li>Check if your spelling is correct.</li>';
    $content .= '<li>Remove quotes around phrases to match each word individually: <em>"asset management"</em> will match less than <em>asset management</em>.</li>';
    $content .= '<li>Consider loosening your query with <em>OR</em>: <em>asset management</em> will match less than <em>asset OR management</em>.</li>';
    $content .= '</ul>';
  }
  $output = '<div class="wmep-box"><h2 class="title">'. $title .'</h2><div>'. $content .'</div></div>';
  return $output;
}


/**
 * Implementation of HOOK_theme().
 */
function wmep_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function wmep_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* 
$wmep_view = views_get_view('homepage_banner_view');
$wmep_view->set_display('default');
$wmep_view->execute();
$wmep_view_results = $wmep_view->result;
foreach ($wmep_view_results as $wmep_view_data) {
  $file_data = field_file_load($wmep_view_data->node_data_field_banner_image_field_banner_image_fid);
  dpm(array('wmep_view' => $wmep_view_data, 'file data' => $file_data));
}
// */
function wmep_preprocess_page(&$vars, $hook) {
  if ($vars['is_front'] === TRUE) {

    $wmep_view = views_get_view('homepage_banner_view');
    $wmep_view->set_display('default');
    $wmep_view->execute();
    $wmep_view_results = $wmep_view->result;
    foreach ($wmep_view_results as $wmep_view_data) {
      $data = wmep_theme_hpbanner ($wmep_view_data);
      $vars['hp_banner'. $data['key']] = $data['html'];
      $vars['link'. $data['key']] = $data['link'];
    }


    $b1 = node_load(1635);
    $vars['banner1'] = wmep_theme_banner($b1);

    $b2 = node_load(1636);
    $vars['banner2'] = wmep_theme_banner($b2);

    $b3 = node_load(1637);
    $vars['banner3'] = wmep_theme_banner($b3);
  }
}

function wmep_theme_hpbanner($data) {
  $file_data = field_file_load($data->node_data_field_banner_image_field_banner_image_fid);
  $image_data = unserialize($data->node_data_field_banner_image_field_banner_image_data);

  $title_data = explode('|', $data->node_data_field_banner_image_field_banner_title_text_value);
  $title = '<strong>'. $title_data[0] .'</strong>';
  if (isset($title_data[1])) {
    $title .= $title_data[1];
  }
  $url = 'node/'. ($data->node_data_field_banner_image_field_banner_success_story_nid ? $data->node_data_field_banner_image_field_banner_success_story_nid : $data->node_data_field_banner_image_field_banner_node_reference_nid);
  $ll_url = 'node/'. $data->node_data_field_banner_image_field_banner_node_reference_nid;

  $link = l($data->node_data_field_banner_image_field_banner_link_text_value, $url);
//  $ss_url = 'node/'. $data->node_data_field_banner_image_field_banner_success_story_nid; // Success Story URL/

  $ss_link = l($image_data['description'], $url);
  $slide_credit_data = explode('|', $ss_link);
  $slide_credit = $slide_credit_data[0];
  if (isset($slide_credit_data[1])) {
    $slide_credit .= '<em>'. $slide_credit_data[1] .'</em>';
  }

  $node = node_load($data->nid);

  return array('key' => $data->node_data_field_banner_sort_order_field_banner_sort_order_value,
               'link' => url($ll_url),
               'html' => 
' <div class="slide-text">
    <h1>'. $title .'</h1>
    <p>'. $node->body .'</p>
    <p class="more">'. $link .'</p>
  </div>
  <div class="slide-credit">'. $slide_credit .'</div>
  <img alt="'. $image_data['alt'] .'" src="/'. $file_data['filepath'] .'" />
');
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function wmep_preprocess_node(&$vars, $hook) {
  // Optionally, run node-type-specific preprocess functions, like
  // wmep_preprocess_node_page() or wmep_preprocess_node_story().
  /*
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
  */
  if ($hook == 'node' && $vars['node']->type == 'success_story' && !empty($vars['node']->field_pages)) {
    // build out tabs
    $field_pages = $vars['node']->field_pages;
    $tabs = array();
    foreach ($field_pages as $fp_key => $fp_val) {
      $page_id = $fp_key + 1;
      $tabs['stories_'. $fp_key] = array (
          'type'    => 'freetext',
          'title'   => t('Page') .' '. $page_id,
          'text' => $fp_val['safe'],
      );
    }

    // theme the tabs
    $quicktabs['style'] = 'Sky';
    $quicktabs['qtid'] = '1';
    $quicktabs['tabs'] = $tabs;
    $vars['tabs'] = theme('quicktabs', $quicktabs);

    // and now for something completely unrelated!
    // turn images into a var because that's how we roll
    $vars['ss_images'] = $vars['node']->field_ss_image;
  }

}

function wmep_theme_banner ($node) {
  if ($node->field_page_reference[0]['nid'] != '') {
    $link = url('node/'. $node->field_page_reference[0]['nid']);
  }
  else {
    $link = $node->field_offsite_link[0]['url'];
  }

  return '<a href="'. $link .'" title="'. $node->field_ad_image[0]['data']['description'] .'">
            <img src="'. $node->field_ad_image[0]['filepath'] .'" alt="'. $node->field_ad_image[0]['data']['alt'] .'" />
          </a>';
}


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function wmep_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function wmep_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
  dsm($vars);
}
// */


/* Allow the adding of <strong> tags to the page titles. */

function wmep_strip_strong($text) {
	$text = str_replace("&lt;strong&gt;", "<strong>", $text);
	$text = str_replace("&lt;/strong&gt;", "</strong>", $text);
	print ($text);
}



/**
 * UTILITY THEMING FUNCTIONS FOR WEBFORMS
 * found here http://1013.fi/cms/theming-drupal-web-forms
 */

/**
 * Replace a form fieldset (group) by a table formatted as:
 * +----------+--------------+--------------+
 * |          | name         | ssn          |
 * +----------+--------------+--------------+
 * | spouse   | [input /]    | [input /]    |
 * +----------+--------------+--------------+
 * | another  | [input /]    | [input /]    |
 * | fieldset |              |              |
 * +----------+--------------+--------------+
 *
 *
 * @param $group - reference to the fieldset
 * @param $header - set table's header cells' content
 */
function wmep_fieldset_subfieldsets_to_table( &$group, $header ) {
	// confirm we get fieldsets, not form elements nor type-less elements behind page brake
	if( empty( $group['#type'] ) || $group['#type'] != 'fieldset' ) {
		return;
	}

	$rows = array();

	foreach( element_children( $group ) as $group_name ) { // for each subfieldset
		$row = array( 'data' => array() );
		$row['data'][0] = array( // header cell's content lives in data
			'data' => $group[$group_name]['#title'],
			'class' => 'label_cell'
		);
		foreach( element_children( $group[$group_name] ) as $form_field_name ) {
			$row['data'][] = wmep_render_titleless( $group[$group_name][$form_field_name] );
		}
		drupal_render($group[$group_name]); //  sub-fieldset rendered it into void
		$rows[] = $row;
	}

	$group['table'] = array(
		'#type' => 'markup',
		'#value' => theme('table', $header, $rows, array('class' => 'subfields-to-table'))
	);
}

// helper function to remove header prior rendering form element
function wmep_render_titleless( $el ) {
	unset( $el['#title'] ); // title already in header, don't repeat in cell
	return drupal_render( $el ); // returns field without label
}

/**
 * Replace a form fieldset (group) by a table formatted as:
 * +----------+--------------+
 * | name     | [input /]    |
 * +----------+--------------+
 * | ssn      | [input /]    |
 * +----------+--------------+
 *
 * @param $group - reference to the fieldset
 * @param $keep_fieldset - whether to keep the fieldset border, or to remove it
 * @param $weight - set group weight - heavier float down on the page
 */
function wmep_fieldset_labels_on_left_table( &$group, $keep_fieldset = false, $weight = 0 ) {
	// dpm($group);
	// confirm we get fieldsets, not form elements nor type-less elements behind page brake
	if( empty( $group['#type'] ) || $group['#type'] != 'fieldset' ) {
		return;
	}

	$rows = array();

	foreach( element_children( $group ) as $form_field_name ) {
		$description = $group[$form_field_name]['#description'];
		$group[$form_field_name]['#description'] = ''; // no duplicate desctiption below title
		// theme_form_element prepares label together with the required star
		$title = theme( 'form_element', $group[$form_field_name], '' );
		$group[$form_field_name]['#description'] = $description;
		$group[$form_field_name]['#title'] = ''; // we don't want the label to repeat
		$row = array(
			'data' => array( // row's cells live in data, option for attributes
				0 => array( // header cell's content lives in data, option for attributes
					// 'data' => $title,
					'data' => $title,
					'class' => 'label_cell'
				),
				1 => drupal_render( $group[$form_field_name] )
			)
		);
		$rows[] = $row;
	}

	$grp = array(
		'#type' => 'markup',
		'#weight' => $weight,
		'#value' => theme('table', array(), $rows)
	);

	// whether we replace the original fieldset or add the
	// reformatted content inside arbitrarily named sub-element
	if( !$keep_fieldset ){
		$group = $grp;	
	} else {
		$group['table'] = $grp;
	}
}
