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

/**
 * Message page for ual messages
 */

require('../../config.php');
require('lib.php');

$user_to_id = optional_param('id', 0, PARAM_INT);

require_login();

$context = context_user::instance($USER->id);

$strtitle = get_string('pluginname', 'local_ualmessages');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/send.php');
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);
$PAGE->navbar->add($strtitle);
#$PAGE->requires->js_init_call('M.local_messaging.init');

$renderer = $PAGE->get_renderer('local_ualmessages');

echo $OUTPUT->header();


if($user_to_id==0)
{
    // need to redirect to contacts page to select contact
    echo $renderer->print_create_message_contact_page(0,0,'');
} else {
    echo $renderer->print_send_message_page($user_to_id);    
}

echo $OUTPUT->footer();
