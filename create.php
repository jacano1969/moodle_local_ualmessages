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
$message = '';
$user_from_id = 0;
$user_to_id = 0;

if(isset($_POST['message'])) {
    $message = $_POST['message'];
    $user_from_id = $_POST['userfromid'];
    $user_to_id = $_POST['usertoid'];
}

require_login();

$context = context_user::instance($USER->id);

$strtitle = get_string('pluginname', 'local_ualmessages');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/index.php');
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);
$PAGE->navbar->add($strtitle);

$js_include = new moodle_url($CFG->httpswwwroot."/local/ualmessages/script/jquery-1.8.1.min.js");
$PAGE->requires->js($js_include, true);
$js_include = new moodle_url($CFG->httpswwwroot."/local/ualmessages/script/contactsearch.js");
$PAGE->requires->js($js_include, true);

$renderer = $PAGE->get_renderer('local_ualmessages');

if($message!=''){
    // get user from
    $msg_from_user = $DB->get_record('user', array('id'=>$user_from_id));   

    // get user to
    $msg_to_user = $DB->get_record('user', array('id'=>$user_to_id));
    
    $messageid = message_post_message($msg_from_user, $msg_to_user, $message, '');
    if (!empty($messageid)) {
        //including the id of the user sending the message in the logged URL so the URL works for admins
        //note message ID may be misleading as the message may potentially get a different ID when moved from message to message_read
        add_to_log(SITEID, 'message', 'write', 'index.php?user='.$user_from_id.'&id='.$user_to_id.'&history=1#m'.$messageid, $user_from_id);
        redirect($CFG->wwwroot . '/local/ualmessages/view.php?user1='.$user_to_id.'&user2='.$user_from_id);
    }
} else {
    
    echo $OUTPUT->header();
    
    if($user_to_id==0)
    {
        // need to redirect to contacts page to select contact
        echo $renderer->print_create_message_contact_page($viewing, $page, $search);
    } else {
        echo $renderer->print_create_message_page($user_to_id);    
    }
    
    echo $OUTPUT->footer();
}


