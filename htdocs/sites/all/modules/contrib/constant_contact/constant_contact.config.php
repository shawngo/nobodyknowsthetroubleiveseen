<?php
// $Id: constant_contact.config.php,v 1.7 2010/02/02 16:57:55 justphp Exp $
/**
 * @file
 */

/**
 * Define default settings for the module
 * These are here purely for convience
 * They can all be overridden on the settings page
 */

// method to use for the register page, can be either checkbox or lists
define('CC_REGISTER_PAGE_METHOD', 'none');

// determines if we show the contact list selection in the form block
define('CC_BLOCK_SHOW_LIST_SELECTION', 1);

// determines if we should opt-in users by default (register page)
define('CC_DEFAULT_OPT_IN', 1);

// determines if we should synce unsubscribed users with constant contact
define('CC_SYNC_UNSUBSCRIBED_USERS', 0);

// the title of the signup checkbox box
define('CC_SIGNUP_TITLE', 'Subscribe to the Newsletter');

// the description of the signup checkbox box
define('CC_SIGNUP_DESCRIPTION', 'Select your areas of interest / would you like to receive the newsletter?');

// The URL for the Constant Contact 60-day trial
define('CC_TRIAL_URL', 'http://bit.ly/cctrial');

// The format for the list selection form element, checkbox or select
define('CC_LIST_SELECTION_FORMAT', 'select');

?>