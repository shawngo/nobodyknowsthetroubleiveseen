<?php
// $Id: poll-results-block.tpl.php,v 1.2 2007/08/02 20:08:53 dries Exp $
/**
 * @file poll-results-block.tpl.php
 * Display the poll results in a block.
 *
 * Variables available:
 * - $title: The title of the poll.
 * - $results: The results of the poll.
 * - $votes: The total results in the poll.
 * - $links: Links in the poll.
 * - $nid: The nid of the poll
 * - $cancel_form: A form to cancel the user's vote, if allowed.
 * - $raw_links: The raw array of links. Should be run through theme('links')
 *   if used.
 * - $vote: The choice number of the current user's vote.
 *
 * @see template_preprocess_poll_results()
 */
?>

<p class="question"><?php print $title ?></p>
<?php print $results ?>
<p class="total"><?php print t('Total votes: <strong>@votes</strong>', array('@votes' => $votes)); ?></p>
<div class="links"><?php print $links; ?></div>
