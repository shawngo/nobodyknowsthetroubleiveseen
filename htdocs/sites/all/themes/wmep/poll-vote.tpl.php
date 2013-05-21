<?php
// $Id: poll-vote.tpl.php,v 1.2 2007/08/07 08:39:35 goba Exp $

/**
 * @file poll-vote.tpl.php
 * Voting form for a poll.
 *
 * - $choice: The radio buttons for the choices in the poll.
 * - $title: The title of the poll.
 * - $block: True if this is being displayed as a block.
 * - $vote: The vote button
 * - $rest: Anything else in the form that may have been added via
 *   form_alter hooks.
 *
 * @see template_preprocess_poll_vote()
 */
?>
<?php if ($block): ?>
	<p class="question"><?php print $title; ?></p>
<?php endif; ?>
<?php print $choice; ?>
<?php print $vote; ?>
<?php // This is the 'rest' of the form, in case items have been added. ?>
<?php print $rest ?>
