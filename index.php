<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require('../../config.php');
require('lib.php');

$search = optional_param('search', '', PARAM_CLEAN);
$removecontact  = optional_param('removecontact',  0, PARAM_INT);
$blockcontact   = optional_param('blockcontact',   0, PARAM_INT);
$unblockcontact = optional_param('unblockcontact', 0, PARAM_INT);
$addcontact     = optional_param('addcontact',     0, PARAM_INT);

require_login();

if ($removecontact and confirm_sesskey()) {
    add_to_log(SITEID, 'message', 'remove contact', 'index.php?user1='.$removecontact.'&amp;user2='.$USER->id, $removecontact);
    message_remove_contact($removecontact);
}
if ($blockcontact and confirm_sesskey()) {
    add_to_log(SITEID, 'message', 'block contact', 'index.php?user1='.$blockcontact.'&amp;user2='.$USER->id, $blockcontact);
    message_block_contact($blockcontact);
}
if ($unblockcontact and confirm_sesskey()) {
    add_to_log(SITEID, 'message', 'unblock contact', 'index.php?user1='.$unblockcontact.'&amp;user2='.$USER->id, $unblockcontact);
    message_unblock_contact($unblockcontact);
}
if ($addcontact and confirm_sesskey()) {
    add_to_log(SITEID, 'message', 'add contact', 'index.php?user1='.$addcontact.'&amp;user2='.$USER->id, $addcontact);
    message_add_contact($addcontact);
    redirect($CFG->wwwroot . '/local/ualmessages/contacts.php?id='.$addcontact);
}

$context = context_user::instance($USER->id);

#require_capability('local/global_messaging:send', $context);

$plugin_name = get_string('pluginname', 'local_ualmessages');
$str_title = get_string('yourmessages', 'local_ualmessages');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/index.php');
$PAGE->set_title($plugin_name);
$PAGE->set_heading($str_title);
$PAGE->navbar->add($str_title);
#$PAGE->requires->js_init_call('M.local_ualmessages.init');

$renderer = $PAGE->get_renderer('local_ualmessages');


echo $OUTPUT->header();

echo $renderer->print_ual_messages_page($search);

echo $OUTPUT->footer();
