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
    public function print_message_contact_page($viewing) {
        
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
        
        /*$blockedusers = message_get_blocked_users($USER->id, false);
        $countblocked = count($blockedusers);*/
        
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
    
        /*if ($countblocked>0) {
            $str = get_string('blockedusers','message', $countblocked);
            $options[MESSAGE_VIEW_BLOCKED] = $str;
        }*/
        
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
            
        // get contacts
        
        
        
        $content .= html_writer::end_tag('div');
        
        $content .= html_writer::end_tag('div');
          
        return $content;
    }
    
    // create new message
    public function print_create_message_page() {
        
        $content = '';
        
        echo $content;
    }
}

