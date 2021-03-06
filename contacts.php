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

$viewing = optional_param('viewing', 0, PARAM_ALPHANUMEXT);

require_login();

$context = context_user::instance($USER->id);

$strtitle = get_string('pluginname', 'local_ualmessages');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/index.php');
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);
$PAGE->navbar->add($strtitle);
#$PAGE->requires->js_init_call('M.local_messaging.init');

$renderer = $PAGE->get_renderer('local_ualmessages');

echo $OUTPUT->header();

echo $renderer->print_message_contact_page($viewing);

echo $OUTPUT->footer();
