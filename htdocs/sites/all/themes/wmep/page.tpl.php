<?php
// $Id: page.tpl.php,v 1.26 2009/11/05 13:54:57 johnalbin Exp $

/**
* @file
* Theme implementation to display a single Drupal page.
*
* Available variables:
*
* General utility variables:
* - $base_path: The base URL path of the Drupal installation. At the very
*   least, this will always default to /.
* - $css: An array of CSS files for the current page.
* - $directory: The directory the template is located in, e.g. modules/system
*   or themes/garland.
* - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
* - $logged_in: TRUE if the user is registered and signed in.
* - $is_admin: TRUE if the user has permission to access administration pages.
*
* Page metadata:
* - $language: (object) The language the site is being displayed in.
*   $language->language contains its textual representation.
*   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
* - $head_title: A modified version of the page title, for use in the TITLE tag.
* - $head: Markup for the HEAD section (including meta tags, keyword tags, and
*   so on).
* - $styles: Style tags necessary to import all CSS files for the page.
* - $scripts: Script tags necessary to load the JavaScript files and settings
*   for the page.
* - $classes: String of classes that can be used to style contextually through
*   CSS. It should be placed within the <body> tag. When selecting through CSS
*   it's recommended that you use the body tag, e.g., "body.front". It can be
*   manipulated through the variable $classes_array from preprocess functions.
*   The default values can be one or more of the following:
*   - front: Page is the home page.
*   - not-front: Page is not the home page.
*   - logged-in: The current viewer is logged in.
*   - not-logged-in: The current viewer is not logged in.
*   - node-type-[node type]: When viewing a single node, the type of that node.
*     For example, if the node is a "Blog entry" it would result in "node-type-blog".
*     Note that the machine name will often be in a short form of the human readable label.
*   The following only apply with the default 'sidebar_first' and 'sidebar_second' block regions:
*     - two-sidebars: When both sidebars have content.
*     - no-sidebars: When no sidebar content exists.
*     - one-sidebar and sidebar-first or sidebar-second: A combination of the
*       two classes when only one of the two sidebars have content.
* - $node: Full node object. Contains data that may not be safe. This is only
*   available if the current page is on the node's primary url.
*
* Site identity:
* - $front_page: The URL of the front page. Use this instead of $base_path,
*   when linking to the front page. This includes the language domain or prefix.
* - $logo: The path to the logo image, as defined in theme configuration.
* - $site_name: The name of the site, empty when display has been disabled
*   in theme settings.
* - $site_slogan: The slogan of the site, empty when display has been disabled
*   in theme settings.
* - $mission: The text of the site mission, empty when display has been disabled
*   in theme settings.
*
* Navigation:
* - $search_box: HTML to display the search box, empty if search has been disabled.
* - $primary_links (array): An array containing the Primary menu links for the
*   site, if they have been configured.
* - $secondary_links (array): An array containing the Secondary menu links for
*   the site, if they have been configured.
* - $breadcrumb: The breadcrumb trail for the current page.
*
* Page content (in order of occurrence in the default page.tpl.php):
* - $title: The page title, for use in the actual HTML content.
* - $messages: HTML for status and error messages. Should be displayed prominently.
* - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the
*   view and edit tabs when displaying a node).
* - $help: Dynamic help text, mostly for admin pages.
* - $content: The main content of the current page.
* - $feed_icons: A string of all feed icons for the current page.
*
* Footer/closing data:
* - $footer_message: The footer message as defined in the admin settings.
* - $closure: Final closing markup from any modules that have altered the page.
*   This variable should always be output last, after all other dynamic content.
*
* Helper variables:
* - $classes_array: Array of html class attribute values. It is flattened
*   into a string within the variable $classes.
*
* Regions:
* - $content_top: Items to appear above the main content of the current page.
* - $content_bottom: Items to appear below the main content of the current page.
* - $navigation: Items for the navigation bar.
* - $sidebar: Items for the main sidebar.
* - $sidebar_inner: Items for the inner sidebar.
* - $header: Items for the header region.
* - $footer: Items for the footer region.
* - $page_closure: Items to appear below the footer.
*
* The following variables are deprecated and will be removed in Drupal 7:
* - $body_classes: This variable has been renamed $classes in Drupal 7.
*
* @see template_preprocess()
* @see template_preprocess_page()
* @see zen_preprocess()
* @see zen_process()
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
<title><?php print $head_title; ?></title>
<?php print $head; ?>
<?php print $styles; ?>
<?php print $scripts; ?>
<?php if ($node->nid == "1536") { ?>
<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/wmep/css/ngm.css" /> 
<script type="text/javascript" src="/sites/all/themes/wmep/js/ngm-scripts.js"></script> 
<?php } ?>

</head>
<body class="<?php print $classes; ?>">

<div id="container">
	<div id="utility">
<?php if ($site_slogan): ?>
		<h3 id="wmep-name"><?php print $site_slogan; ?></h3>
<?php endif; ?>
<?php if ($secondary_links): ?>
		<div id="utilitylinks">
<?php print theme('links', $secondary_links); ?>
		</div>
<?php endif; ?>
<?php if ($search_box): ?>
		<div id="search-box"><?php print $search_box; ?></div>
<?php endif; ?>
	</div>
	<div id="container2">
		<div id="header">
<?php if ($logo): ?>
			<div id="logo"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" /></a></div>
<?php endif; ?>
<?php if ($navigation) { ?>
			<div id="nav">
<?php print $navigation; ?>
			</div>
<?php } ?>
		</div>
	
		<div id="heading">
<?php if ($title): ?>
<?php if ($node->type == "poll") { ?>
			<h2 class="title"><strong>Poll</strong> Detail</h2>
<?php } elseif ($node->type == "wmep_event") { ?>
			<h2 class="title"><strong>WMEP</strong> Events</h2>
<?php } elseif ($node->type == "partner_event") { ?>
			<h2 class="title"><strong>Partner</strong> Events</h2>
<?php } elseif ($node->type == "news") { ?>
			<h2 class="title"><strong>News</strong></h2>
<?php } elseif ($node->type == "client_releases") { ?>
			<h2 class="title"><strong>Client Releases</strong></h2>
<?php } else { ?>
			<h1 class="title"><?php wmep_strip_strong($title); ?></h1>
<?php } ?>
<?php endif; ?>
<?php print $breadcrumb; ?>
		</div>

		<div id="sidebar">
<?php if ($sidenav): ?>
			<div id="sidenav">
<?php print $sidenav; ?>
			</div>
<?php endif; ?>
<?php if ($sidebar): ?>
  <?php print $sidebar; ?>
<?php endif; ?>

		</div>
	
		<div id="main">
<?php print $highlight; ?>
<?php print $messages; ?>
<?php print $help; ?>
<?php if ($tabs): ?>
			<div class="tabs"><?php print $tabs; ?></div>
<?php endif; ?>
<?php print $sidebar_second; ?>

<?php print $content; ?>

<?php print $content_bottom; ?>
		</div>
	</div>
</div>
<div id="footer">
	<div id="footer-content">
		<h5>Wisconsin Manufacturing Extension Partnership</h5>
		<p>2601 Crossroads Drive | Suite 145 | Madison, WI 53718</p>
		<p><strong>Experience.</strong> Results. | Contact us at 877-800-2085</p>
	</div>
	<div id="footer-sitemap">
<?php if ($footer_links): ?>
		<div><?php print $footer_links; ?></div>
<?php endif; ?>
		<p>Copyright &copy; <?php print date('Y'); ?> WMEP</p>
		<p><a href="http://www.topfloortech.com/">Website Design</a> by Top Floor Technologies</p>
	</div>
</div>
<?php print $page_closure; ?>
<?php print $closure; ?>
<script type="text/javascript" src="/highlighter_tracking.js"></script>

</body>
</html>
