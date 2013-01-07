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
$page = optional_param('page', 0, PARAM_INT);
$search = optional_param('search', '', PARAM_CLEAN);


require_login();

$context = context_user::instance($USER->id);

$strtitle = get_string('pluginname', 'local_ualmessages');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/contacts.php');
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);
$PAGE->navbar->add($strtitle);
#$PAGE->requires->js_init_call('M.local_messaging.init');

$js_include = new moodle_url($CFG->httpswwwroot."/local/ualmessages/script/jquery-1.8.1.min.js");
$PAGE->requires->js($js_include, true);
$js_include = new moodle_url($CFG->httpswwwroot."/local/ualmessages/script/viewpaging.js");
$PAGE->requires->js($js_include, true);

$renderer = $PAGE->get_renderer('local_ualmessages');

echo $OUTPUT->header();

echo $renderer->print_message_contact_page($viewing, $page, $search);

echo $OUTPUT->footer();
