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
 * renderer for ual messages local plugin
 */


class local_ualmessages_renderer extends plugin_renderer_base {
    
    // your message / recent conversations page
    public function print_ual_messages_page() {        
               
        global $USER, $CFG;
        
        $content = html_writer::start_tag('div', array('class'=>'content messages'));
        $content .= html_writer::start_tag('h1');
        $content .= get_string('yourmessages', 'local_ualmessages');
        $content .= html_writer::end_tag('h1');
        
        $content .= html_writer::start_tag('div', array('class'=>'in-page-controls'));
        $content .= html_writer::start_tag('p', array('class'=>'settings'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/message/edit.php?id='.$USER->id));
        $content .= get_string('settings', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('div');

        // tabs
        $content .= html_writer::start_tag('ul', array('class'=>'tabs'));
        $content .= html_writer::start_tag('li', array('class'=>'active'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/'));
        $content .= get_string('recentconversations', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li');
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/contacts.php'));
        $content .= get_string('contacts', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li', array('class'=>'compose'));
        $content .= html_writer::start_tag('a', array('href'=>'#'));
        $content .= get_string('composeanewmessage', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::end_tag('ul');      
        
        // filter
        $content .= html_writer::start_tag('div', array('class'=>'filter'));
        $content .= html_writer::start_tag('p');
        $content .= html_writer::start_tag('label');
        $content .= get_string('searchmessages', 'local_ualmessages');
        $content .= html_writer::end_tag('label');
        $content .= html_writer::start_tag('input', array('name'=>'', 'value'=>get_string('enterasearchterm', 'local_ualmessages'),'class'=>'text'));
        $content .= html_writer::start_tag('input', array('type'=>'submit','name'=>'','value'=>get_string('search', 'local_ualmessages'),'class'=>'submit'));
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('div');
               
        // inbox
        $content .= html_writer::start_tag('div', array('class'=>'inbox'));
        $content .= html_writer::start_tag('ul');
            
        // get unread messages
        $unread_messages = get_messages_unread($USER, 50);
        
        if($unread_messages) {
            $content .= $unread_messages;
        }
        
        // get read messages
        $read_messages = get_messages_read($USER, 50);
        
        if($read_messages) {
            $content .= $read_messages;
        }
        
        
        $content .= html_writer::end_tag('div');
        
        
        
/* TEMP
<div class="pagination">
  <p>Page 2 of 14</p>
  <ul>
    <li><a href="">1</a></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href="">4</a></li>
    <li><a href="">&hellip;</a></li>
    <li><a href="">14</a></li>
    <li class="next"><a href="">Next<span></span></a></li>
    <li class="last"><a href="">Last<span></span></a></li>                
  </ul>
  <div class="clearfix"></div>                       
</div>
TEMP */
        $content .= html_writer::end_tag('div');
          
        return $content;
    }

    // view message
    public function print_message_view_page($message_id) {

        global $USER, $CFG;
        
        $content = html_writer::start_tag('div', array('class'=>'content messages'));
        $content .= html_writer::start_tag('h1');
        $content .= get_string('yourmessages', 'local_ualmessages');
        $content .= html_writer::end_tag('h1');
        
        $content .= html_writer::start_tag('div', array('class'=>'in-page-controls'));
        $content .= html_writer::start_tag('p', array('class'=>'settings'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/message/edit.php?id='.$USER->id));
        $content .= get_string('settings', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('div');

        // tabs
        $content .= html_writer::start_tag('ul', array('class'=>'tabs'));
        $content .= html_writer::start_tag('li', array('class'=>'active'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/'));
        $content .= get_string('recentconversations', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li');
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/contacts.php'));
        $content .= get_string('contacts', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li', array('class'=>'compose'));
        $content .= html_writer::start_tag('a', array('href'=>'#'));
        $content .= get_string('composeanewmessage', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::end_tag('ul');      
        
        // filter
        $content .= html_writer::start_tag('div', array('class'=>'filter'));
        $content .= html_writer::end_tag('div');
        
        // get message details
        $content .= get_recent_conversation($message_id);        
        
        $content .= html_writer::end_tag('div');
        
        return $content;
    }

    
    // choose contact to message
    public function print_message_contact_page($viewing, $page) {
        
        global $USER, $CFG, $PAGE, $OUTPUT;
        
        $content = html_writer::start_tag('div', array('class'=>'content messages'));
        $content .= html_writer::start_tag('h1');
        $content .= get_string('yourmessages', 'local_ualmessages');
        $content .= html_writer::end_tag('h1');
        
        $content .= html_writer::start_tag('div', array('class'=>'in-page-controls'));
        $content .= html_writer::start_tag('p', array('class'=>'settings'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/message/edit.php?id='.$USER->id));
        $content .= get_string('settings', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('div');

        // tabs
        $content .= html_writer::start_tag('ul', array('class'=>'tabs'));
        $content .= html_writer::start_tag('li');
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/'));
        $content .= get_string('recentconversations', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li', array('class'=>'active'));
        $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/contacts.php'));
        $content .= get_string('contacts', 'local_ualmessages');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::start_tag('li', array('class'=>'compose'));
        $content .= html_writer::start_tag('a', array('href'=>'#'));
        $content .= get_string('composeanewmessage', 'local_ualmessages');
        $content .= html_writer::start_tag('span');
        $content .= html_writer::start_tag('i');
        $content .= html_writer::end_tag('i');
        $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('a');
        $content .= html_writer::end_tag('li');
        $content .= html_writer::end_tag('ul');      
        
        // filter
        $content .= html_writer::start_tag('div', array('class'=>'filter'));
        $content .= html_writer::start_tag('form', array('id' => 'contactsfilter','method' => 'get','action' => ''));
        $content .= html_writer::start_tag('p');
        $content .= html_writer::start_tag('label');
        $content .= get_string('searchcontacts', 'local_ualmessages');
        $content .= html_writer::end_tag('label');
        $content .= html_writer::start_tag('input', array('name'=>'', 'value'=>get_string('searchcontacts', 'local_ualmessages'),'class'=>'text'));
        $content .= html_writer::start_tag('input', array('type'=>'submit','name'=>'searchcontacts','value'=>get_string('search', 'local_ualmessages'),'class'=>'submit'));
        $content .= html_writer::end_tag('p');
        
        // get user enrolled courses
        $courses = enrol_get_users_courses($USER->id, true);
        $coursecontexts = message_get_course_contexts($courses);
        
        if (!empty($courses)) {
            $courses_options = array();
    
            foreach($courses as $course) {
                if (has_capability('moodle/course:viewparticipants', $coursecontexts[$course->id])) {
                    //Not using short_text() as we want the end of the course name. Not the beginning.
                    $shortname = format_string($course->shortname, true, array('context' => $coursecontexts[$course->id]));
                    if (textlib::strlen($shortname) > MESSAGE_MAX_COURSE_NAME_LENGTH) {
                        $courses_options[MESSAGE_VIEW_COURSE.$course->id] = '...'.textlib::substr($shortname, -MESSAGE_MAX_COURSE_NAME_LENGTH);
                    } else {
                        $courses_options[MESSAGE_VIEW_COURSE.$course->id] = $shortname;
                    }
                }
            }

            if (!empty($courses_options)) {
                $options[] = get_string('choosecourse','local_ualmessages');
                $options[] = array(get_string('courses') => $courses_options);
            }
        }
        
        $content .= html_writer::start_tag('p');
        $content .= html_writer::start_tag('label');
        $content .= get_string('filterbycourse', 'local_ualmessages');
        $content .= html_writer::end_tag('label');
        $content .= html_writer::select($options, 'viewing', $viewing, false, array('id' => 'viewing','onchange' => 'this.form.submit()'));
        $content .= html_writer::end_tag('p');
        $content .= html_writer::end_tag('form');
        $content .= html_writer::end_tag('div');
                       
        // inbox
        $content .= html_writer::start_tag('div', array('class'=>'inbox'));
        $content .= html_writer::start_tag('ul');
        
        // get course participant contacts - using the filter
        $course_id = intval(substr($viewing, 7));
        if(!empty($course_id)) {
            
            $countparticipants = count_enrolled_users($coursecontexts[$course_id]);
            $participants = get_enrolled_users($coursecontexts[$course_id], '', 0, 'u.*', '', $page*MESSAGE_CONTACTS_PER_PAGE, MESSAGE_CONTACTS_PER_PAGE);
            
            $pagingbar = new paging_bar($countparticipants, $page, MESSAGE_CONTACTS_PER_PAGE, $PAGE->url, 'page');
            $content .= $OUTPUT->render($pagingbar);
            
            $content .= html_writer::start_tag('table', array('id' => 'message_participants', 'class' => 'boxaligncenter', 'cellspacing' => '2', 'cellpadding' => '0', 'border' => '0'));
            
            $iscontact = true;
            $isblocked = false;
            foreach ($participants as $participant) {
                if ($participant->id != $USER->id) {
                    $participant->messagecount = 0;
                    
                    $fullname  = fullname($participant);
                    $fullnamelink  = $fullname;
                
                    $linkclass = '';
                    if (!empty($selecteduser) && $participant->id == $selecteduser->id) {
                        $linkclass = 'messageselecteduser';
                    }
                    
                    if ($participant->messagecount > 0 ){
                        $fullnamelink = '<strong>'.$fullnamelink.' ('.$participant->messagecount.')</strong>';
                    }
                
                    $strcontact = $strblock = $strhistory = null;
                    $strcontact = message_get_contact_add_remove_link($iscontact, $isblocked, $participant);
                    $strblock   = message_get_contact_block_link($iscontact, $isblocked, $participant);
                    $strhistory = message_history_link($USER->id, $participant->id, true, '', '', 'icon');
                
                    $content .= html_writer::start_tag('tr');
                    $content .= html_writer::start_tag('td', array('class' => 'pix'));
                    $content .= $OUTPUT->user_picture($participant, array('size' => 20, 'courseid' => SITEID));
                    $content .= html_writer::end_tag('td');
                
                    $content .= html_writer::start_tag('td', array('class' => 'contact'));
                
                    $popupoptions = array(
                            'height' => MESSAGE_DISCUSSION_HEIGHT,
                            'width' => MESSAGE_DISCUSSION_WIDTH,
                            'menubar' => false,
                            'location' => false,
                            'status' => true,
                            'scrollbars' => true,
                            'resizable' => true);
                
                    $link = $action = null;
                    if (!empty($selectcontacturl)) {
                        $link = new moodle_url($selectcontacturl.'&user2='.$participant->id);
                    } else {
                        //can $selectcontacturl be removed and maybe the be removed and hardcoded?
                        $link = new moodle_url("/local/ualmessages/send.php?id=$participant->id");
                        $action = new popup_action('click', $link, "message_$participant->id", $popupoptions);
                    }
                    $content .= $OUTPUT->action_link($link, $fullnamelink, $action, array('class' => $linkclass,'title' => get_string('sendmessageto', 'message', $fullname)));
                
                    $content .= html_writer::end_tag('td');
                
                    $content .= html_writer::tag('td', '&nbsp;'.$strcontact.$strblock.'&nbsp;'.$strhistory, array('class' => 'link'));
                
                    $content .= html_writer::end_tag('tr');
                }
            }
        } else {   // get all contacts
            
            // find contacts
            $countunreadtotal = message_count_unread_messages($USER);
            $blockedusers = message_get_blocked_users($USER, '');
            list($onlinecontacts, $offlinecontacts, $strangers) = message_get_contacts($USER, '');
            
            $content .= html_writer::start_tag('div', array('class' => 'contactselector mdl-align'));
            
            $countonlinecontacts  = count($onlinecontacts);
            $countofflinecontacts = count($offlinecontacts);
            $countstrangers       = count($strangers);
            $isuserblocked = null;
        
            if ($countonlinecontacts + $countofflinecontacts == 0) {
                $content .= html_writer::tag('div', get_string('contactlistempty', 'message'), array('class' => 'heading'));
            }
        
            $content .= html_writer::start_tag('table', array('id' => 'message_contacts', 'class' => 'boxaligncenter'));
        
        
            if($countonlinecontacts) {
                        
                if (empty($titletodisplay)) {
                    message_print_heading(get_string('onlinecontacts', 'message', $countonlinecontacts));
                }
        
                $isuserblocked = false;
                $isusercontact = true;
                foreach ($onlinecontacts as $contact) {
                    if ($contact->messagecount >= 0) {
                        $content .= $this->get_contacts($contact, $isusercontact, $isuserblocked);
                    }
                }
            }
        
            if ($countofflinecontacts) {
                        
                if (empty($titletodisplay)) {
                    message_print_heading(get_string('offlinecontacts', 'message', $countofflinecontacts));
                }
        
                $isuserblocked = false;
                $isusercontact = true;
                foreach ($offlinecontacts as $contact) {
                    if ($contact->messagecount >= 0) {
                        $content .= $this->get_contacts($contact, $isusercontact, $isuserblocked);
                    }
                }
        
            }
            
            if ($countstrangers) {
                message_print_heading(get_string('incomingcontacts', 'message', $countstrangers));
        
                $isuserblocked = false;
                $isusercontact = false;
                foreach ($strangers as $stranger) {
                    if ($stranger->messagecount >= 0) {
                        $content .= $this->get_contacts($stranger, $isusercontact, $isuserblocked);
                    }
                }
            }
            
            $content .= html_writer::end_tag('table');
        
            if ($countstrangers && ($countonlinecontacts + $countofflinecontacts == 0)) {  // Extra help
                $content .= html_writer::tag('div','('.get_string('addsomecontactsincoming', 'message').')',array('class' => 'note'));
            }

            $content .= html_writer::end_tag('div');
        }

        $content .= html_writer::end_tag('table');
    
        $content .= html_writer::end_tag('div');
        
        $content .= html_writer::end_tag('div');
          
        return $content;
    }
    
    
    private function get_contacts($contact, $incontactlist, $isblocked) {
        
        global $OUTPUT, $USER;
        
        $this_contact="";
        
        $fullname  = fullname($contact);
        $fullnamelink  = $fullname;
    
        $linkclass = '';
        if (!empty($selecteduser) && $contact->id == $selecteduser->id) {
            $linkclass = 'messageselecteduser';
        }
    
        /// are there any unread messages for this contact?
        if ($contact->messagecount > 0 ){
            $fullnamelink = '<strong>'.$fullnamelink.' ('.$contact->messagecount.')</strong>';
        }
    
        $strcontact = $strblock = $strhistory = null;
    
        $strcontact = message_get_contact_add_remove_link($incontactlist, $isblocked, $contact);
        $strblock   = message_get_contact_block_link($incontactlist, $isblocked, $contact);
        $strhistory = message_history_link($USER->id, $contact->id, true, '', '', 'icon');
    
        $this_contact.= html_writer::start_tag('tr');
        $this_contact.= html_writer::start_tag('td', array('class' => 'pix'));
        $this_contact.= $OUTPUT->user_picture($contact, array('size' => 20, 'courseid' => SITEID));
        $this_contact.= html_writer::end_tag('td');
    
        $this_contact.= html_writer::start_tag('td', array('class' => 'contact'));
    
        $popupoptions = array(
                'height' => MESSAGE_DISCUSSION_HEIGHT,
                'width' => MESSAGE_DISCUSSION_WIDTH,
                'menubar' => false,
                'location' => false,
                'status' => true,
                'scrollbars' => true,
                'resizable' => true);
    
        $link = $action = null;
        if (!empty($selectcontacturl)) {
            $link = new moodle_url($selectcontacturl.'&user2='.$contact->id);
        } else {
            $link = new moodle_url("/message/index.php?id=$contact->id");
            $action = new popup_action('click', $link, "message_$contact->id", $popupoptions);
        }
        $this_contact.= $OUTPUT->action_link($link, $fullnamelink, $action, array('class' => $linkclass,'title' => get_string('sendmessageto', 'message', $fullname)));
    
        $this_contact.= html_writer::end_tag('td');
    
        $this_contact.= html_writer::tag('td', '&nbsp;'.$strcontact.$strblock.'&nbsp;'.$strhistory, array('class' => 'link'));
    
        $this_contact.= html_writer::end_tag('tr');
        
        return $this_contact;
    }
    
    
    // create new message
    public function print_create_message_page() {
        
        $content = '';
        
        echo $content;
    }
}

