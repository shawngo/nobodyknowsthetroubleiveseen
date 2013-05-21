<?php
// $Id: admin.system.inc,v 1.2 2010/02/02 16:57:55 justphp Exp $
/**
 * @file
 */

/**
 * Displays the module intro page in the admin settings page
 */
function constant_contact_intro()
{
	$info_filename = drupal_get_path('module','constant_contact').'/'.'constant_contact' .'.info';
	$module = drupal_parse_info_file($info_filename);
	
	// not sure translation will work here :(
	$html = '<p>This is version '.$module['version'].' of the Constant Contact module for Drupal.</p>';
	$html.='<p>If you do not have a constant contact account <a target="_blank" href="@cc">Signup for a free 60-day trial</a>.</p>';
	$html.='<p>Instructions for setting up the module can be found <a href="@instructions">here</a>.</p>';
	$html.='<p>If you find any problems or need help see <a href="@help">here</a>.</p>';
	$html.='<br /><p>The drupal module is provided by <a target="_blank" href="@me">James Benson</a>.
	<br />If you find the module useful please consider <a target="_blank" href="@donate">donating</a> a few dollars towards future development costs.</p>';
	
	$params = array(
		'@instructions' => url('admin/help/constant_contact'),
		'@help' => 'http://drupal.org/project/issues/constant_contact?categories=All',
		'@donate' => 'http://integrationservic.es/donate.php',
		'@me' => 'http://justphp.co.uk',
	  	'@cc' => CC_TRIAL_URL,
	);
	return t($html, $params);
}


/**
 * Displays the module settings page in the admin
 */
function constant_contact_settings()
{
	drupal_add_js(drupal_get_path('module', 'constant_contact') . '/constant_contact.js');
	
	$form = array();
	$lists = array();
	
	// if we have an object get the users contact lists
	$cc = constant_contact_create_object();
	
	if(is_object($cc)):
		$_lists = $cc->get_all_lists();
		  
		if($_lists):
		foreach($_lists as $k => $v):
			$lists[$v['id']] = $v['Name'];
		endforeach;
		endif;
	endif;
		
	// account settings
	$form['constant_contact']['account'] = array(
		'#type' => 'fieldset',
		'#title' => t('Account Settings'),
		'#collapsible' => TRUE,
		'#collapsed' => true,
		'#tree' => false,
		'#description' => t('Change your constant contact account settings'),
	);
  
	$form['constant_contact']['account']['cc_username'] = array(
		'#id' => 'cc_username',
		'#type' => 'textfield',
		'#title' => t('Username'),
		'#description' => t("The Constant Contact Account Username"),
		'#default_value' => variable_get('cc_username',''),
		'#size' => 60,
		'#required' => TRUE,
	);

	$form['constant_contact']['account']['cc_password'] = array(
		'#id' => 'cc_password',
		'#type' => 'password',
		'#title' => t('Password'),
		'#description' => t("The Constant Contact Account Password"),
		'#default_value' => variable_get('cc_password',''),
		'#size' => 60,
		'#required' => TRUE,
	);
	
	$form['constant_contact']['account']['cc_auth_res'] = array(
		'#type' => 'markup', 
		'#value' => '<div class="cc_auth_res">&nbsp;</div>'
	);
	
	$form['constant_contact']['account']['cc_path'] = array(
		'#id' => 'cc_path', 
		'#type' => 'hidden', 
		'#value' => drupal_get_path('module', 'constant_contact')
	);
	
	$form['constant_contact']['account']['cc_auth'] = array(
		'#id' => 'cc_auth',
		'#type' => 'submit',
		'#value' => t('Check Account Details'),
	);
	
	// register page settings
	$form['constant_contact']['form'] = array(
		'#type' => 'fieldset',
		'#title' => t('Register Page Settings'),
		'#collapsible' => TRUE,
		'#collapsed' => true,
		'#tree' => false,
		'#description' => t('Customize register page settings'),
	);

	$form['constant_contact']['form']['cc_register_page_method'] = array(
		'#type' => 'radios',
		'#title' => t('Register Page Subscribe Method'),
		'#description' => t('Choose to either display a checkbox and automatically subscribe users to the contact lists you select below or display a contact list selection for the users to choose which lists to subscribe to and choose which lists to exclude below'),
		'#default_value' => variable_get('cc_register_page_method',CC_REGISTER_PAGE_METHOD),
		'#options' => array('none' => 'Disabled', 'checkbox' => 'Checkbox', 'lists' => 'List Selection'),
	);
	
	$form['constant_contact']['form']['cc_list_selection_format'] = array(
		'#type' => 'radios',
		'#title' => t('List Selection Format'),
		'#default_value' => variable_get('cc_list_selection_format',CC_LIST_SELECTION_FORMAT),
		'#options' => array('select' => 'Multi-Select', 'checkbox' => 'Checkboxes'),
		'#description' => t('If you use the "List Selection" method above you can change the format of the list selection to either checkboxes or a multi-select drop down, the default is a multi-select drop down.'),
	);
	
	$form['constant_contact']['form']['cc_default_opt_in'] = array(
		'#type' => 'checkbox',
		'#title' => t('Opt-in users by default?'),
		'#description' => t('This determines if the register page checkbox is checked by default or if using the "List Selection" method the user will have all lists selected by default, uncheck this box if you want users to have to manually subscribe'),
		'#default_value' => variable_get('cc_default_opt_in', CC_DEFAULT_OPT_IN),
	);
	
	if($lists):
		$form['constant_contact']['form']['cc_lists'] = array(
			'#type' => 'select',
			'#title' => t('Contact lists'),
			'#default_value' => variable_get('cc_lists',''),
			'#options' => $lists,
			'#multiple' => true,
			'#size' => 10,
			'#description' => t('If you use the checkbox method you can choose which lists the subscriber will be automatically added or if you use the list selection method choose which lists to hide from the user, this relates to the "Register Page Subscribe Method" option above.'),
		);
	endif;
	
	$form['constant_contact']['form']['cc_signup_title'] = array(
		'#type' => 'textfield',
		'#title' => t('Signup Title Text'),
		'#description' => t("The title text displayed on the register page, if enabled"),
		'#default_value' => variable_get('cc_signup_title',CC_SIGNUP_TITLE),
		'#size' => 60,
	);

	$form['constant_contact']['form']['cc_signup_description'] = array(
		'#type' => 'textfield',
		'#title' => t('Signup Description Text'),
		'#description' => t("The description text displayed on the register page, if enabled"),
		'#default_value' => variable_get('cc_signup_description',CC_SIGNUP_DESCRIPTION),
		'#size' => 60,
	);

	$form['constant_contact']['form']['cc_extra_field_mappings'] = array(
		'#type' => 'textarea',
		'#title' => t('Extra Field Mappings'),
		'#description' => t("Specify the mappings for your extra fields, if these fields are found in your register form they will be sent to constant contact, you should define these in the format FirstName:ActualFieldname and separate with a comma. You will only need to change the second value to match your form fieldnames, this feature works best with the profile module that comes with drupal"),
		'#default_value' => variable_get('cc_extra_field_mappings',''),
		'#rows' => 6, 
	);
	
	// synchronization settings
	$form['constant_contact']['synchronization'] = array(
		'#type' => 'fieldset',
		'#title' => t('Synchronization Settings'),
		'#collapsible' => TRUE,
		'#collapsed' => true,
		'#tree' => false,
		'#description' => t('Customize how the module synchronizes data with Constant Contact'),
	);
	
	$form['constant_contact']['synchronization']['cc_sync_unsubscribed_users'] = array(
		'#type' => 'checkbox',
		'#title' => t('Synchronize unsubscribed users?'),
		'#description'=>t('Checking this means the module will automatically synchronize users who have unsubscribed directly with the constant contact service with those users in your drupal database, this is necessary because people can unsubscribe from your mailing list through the constant contact website. This feature has only been tested with a small amount of users, use this option with extreme caution, if you have a large site consider running the drupal cron jobs more often to ensure it does not overload the server, likewise if you have a small site run the cron jobs less often to avoid checking for users with the API, alternatively disable this feature altogether and always use the Constant Contact website to get the latest subscribers data'),
		'#default_value' => variable_get('cc_sync_unsubscribed_users',CC_SYNC_UNSUBSCRIBED_USERS),
	);
	
	// form block settings
	$form['constant_contact']['block'] = array(
		'#type' => 'fieldset',
		'#title' => t('Form Block Settings'),
		'#collapsible' => TRUE,
		'#collapsed' => true,
		'#tree' => false,
		'#description' => t('Change settings for the custom form that is shown using the block method'),
	);
	
	$form['constant_contact']['block']['cc_block_show_list_selection'] = array(
		'#type' => 'radios',
		'#title' => t('Show List Selection'),
		'#default_value' => variable_get('cc_block_show_list_selection',CC_BLOCK_SHOW_LIST_SELECTION),
		'#options' => array('0' => 'No', '1' => 'Yes'),
		'#description' => t('If you show the list selection you can exclude certain contact lists by selecting them below, if you don\'t show the list selection you can select which contact lists the subscribers are automatically added to.'),
	);
	
	$form['constant_contact']['block']['cc_block_list_selection_format'] = array(
		'#type' => 'radios',
		'#title' => t('List Selection Format'),
		'#default_value' => variable_get('cc_block_list_selection_format',CC_LIST_SELECTION_FORMAT),
		'#options' => array('select' => 'Multi-Select', 'checkbox' => 'Checkboxes'),
		'#description' => t('You can change the format of the list selection to either checkboxes or a multi-select drop down, the default is a multi-select drop down.'),
	);
	
	if($lists):  
		$form['constant_contact']['block']['cc_block_lists'] = array(
			'#type' => 'select',
			'#title' => t('Contact lists'),
			'#default_value' => variable_get('cc_block_lists',''),
			'#options' => $lists,
			'#multiple' => true,
			'#size' => 10,
		);
	endif;
	
	$form['constant_contact']['block']['cc_block_redirect_url'] = array(
		'#type' => 'textfield',
		'#title' => t('Thank You Page'),
		'#description' => t('After a user submits the form you can send them to a URL, enter the full website address here or leave blank for no redirect'),
		'#default_value' => variable_get('cc_block_redirect_url',''),
	);
	
	$extra_fields = array_slice(variable_get('cc_extra_fields', array()), 0, 18);
	$options = ($extra_fields) ? array_combine(array_values($extra_fields),array_values($extra_fields)):array();
	
	$form['constant_contact']['block']['cc_form_block_fields'] = array(
		'#type' => 'checkboxes',
		'#title' => t('Extra Fields'),
		'#description' => t('Select which extra fields you would like to display in the form, these will be sent along to Constant Contact with the subscribers email'),
		'#default_value' => variable_get('cc_form_block_fields', array()),
		'#options' => $options,
	);
	
	$form['#redirect'] = 'admin/settings/constant_contact/intro';
	return system_settings_form($form);
}

/**
 * Submit handler for the module settings page
 */
function constant_contact_settings_submit($form, &$form_state)
{
	cache_clear_all('variables', 'cache');
	drupal_set_message(t('Constant Contact module settings have been saved'));
}