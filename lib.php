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

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');


/**
 * Description: function to display all unread messsages
 *              for a particular user
 *
 * Author: Daniel J. Somers 29/10/2012
 */
function get_messages_unread($user, $msg_length) {
    
    global $OUTPUT, $DB, $CFG;
    
    $message_count=0;
    $user_messages="";
    
    // get all unread messages for user
    $msg_unread = $DB->get_records_select('message', " useridto=$user->id", null, 'timecreated');
    
    if(!empty($msg_unread))
    {
        foreach($msg_unread as $unread)
        {
            // prepare the message text
            $msg = substr($unread->fullmessage,0,$msg_length);
            $msg = strip_tags($msg);
            $msg = ltrim($msg);
            $msg = str_replace('-','',$msg);
            
            if(strlen($msg) > $msg_length) {
                $msg.=' ...';
            }
            
            // prepare link to message
            $msg_from_user_id = $unread->useridfrom;
            $link = $CFG->wwwroot.'/local/ualmessages/view.php?id='.$unread->id;
            
            // get the time message created
            $msg_created = $unread->timecreated;
            
            // get current time
            $current_time = time();
            
            // get difference
            $diff = $current_time - $msg_created;
            $days_since = round($diff / 86400);
                
            // is time today ?
            if(date('Ymd') == date('Ymd', $msg_created)){
                $msg_created = 'Today';
            } else if ($days_since <= 3){
                $msg_created = $days_since . ' days ago';
            } else {
                $msg_created = date('M jS ',$msg_created);
            }
                          
            $msg_from_user = $DB->get_record('user', array('id'=>$msg_from_user_id));                

            // format and append each message
            $user_messages .= html_writer::start_tag('li', array('class'=>'unread'));
            $user_messages .= html_writer::start_tag('a', array('href'=>$link));
            $user_messages .= html_writer::start_tag('p', array('class'=>'user'));
            $user_messages .= $msg_from_user->firstname . ' ' . $msg_from_user->lastname;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::start_tag('p', array('class'=>'excerpt'));
            $user_messages .= ' '.$msg;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::end_tag('a');
            $user_messages .= html_writer::start_tag('p', array('class'=>'time'));
            $user_messages .= ' '.$msg_created;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::end_tag('li');
                  
            $message_count++;
        }
    }
    
    return $user_messages;
}



/**
 * Description: function to display all read messsages
 *              for a particular user
 *
 * Author: Daniel J. Somers 30/10/2012
 */
function get_messages_read($user, $msg_length) {
    
    global $OUTPUT, $DB, $CFG;
    
    $message_count=0;
    $user_messages="";
    
    // get all read messages for user
    $msg_read = $DB->get_records_select('message_read', " useridto=$user->id", null, 'timecreated');
    
    if(!empty($msg_read))
    {
        foreach($msg_read as $read)
        {
            // prepare the message text
            $msg = substr($read->fullmessage,0,$msg_length);
            $msg = strip_tags($msg);
            $msg = ltrim($msg);
            $msg = str_replace('-','',$msg);
            
            if(strlen($msg) > $msg_length) {
                $msg.=' ...';
            }
            
            // prepare link to message
            $msg_from_user_id = $read->useridfrom;
            $link = $CFG->wwwroot.'/local/ualmessages/view.php?id='.$read->id;
            
            // get the time message created
            $msg_created = $read->timecreated;
            
            // get current time
            $current_time = time();
            
            // get difference
            $diff = $current_time - $msg_created;
            $days_since = round($diff / 86400);
                
            // is time today ?
            if(date('Ymd') == date('Ymd', $msg_created)){
                $msg_created = 'Today';
            } else if ($days_since <= 3){
                $msg_created = $days_since . ' days ago';
            } else {
                $msg_created = date('M jS ',$msg_created);
            }
                          
            $msg_from_user = $DB->get_record('user', array('id'=>$msg_from_user_id));                

            // format and append each message
            $user_messages .= html_writer::start_tag('li');
            $user_messages .= html_writer::start_tag('a', array('href'=>$link));
            $user_messages .= html_writer::start_tag('p', array('class'=>'user'));
            $user_messages .= $msg_from_user->firstname . ' ' . $msg_from_user->lastname;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::start_tag('p', array('class'=>'excerpt'));
            $user_messages .= ' '.$msg;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::end_tag('a');
            $user_messages .= html_writer::start_tag('p', array('class'=>'time'));
            $user_messages .= ' '.$msg_created;
            $user_messages .= html_writer::end_tag('p');
            $user_messages .= html_writer::end_tag('li');
                  
            $message_count++;
        }
    }
    
    return $user_messages;
}


/**
 * Description: function to display a recent conversation
 *              based on a a particular message
 *
 * Author: Daniel J. Somers 30/10/2012
 */
function get_recent_conversation($message_id) {
    
    global $OUTPUT, $DB, $CFG, $USER;
    
    $recent_conversations="";
    
    $logged_in_user_id = $USER->id;
    
    // get message data (unread message)
    $msg = $DB->get_record('message', array('id'=>$message_id));
    
    if(!$msg){
        // it might be an already read message
        $msg = $DB->get_record('message_read', array('id'=>$message_id));
    }

    $msg_from_user_id = $msg->useridfrom;
    $msg_from_user = $DB->get_record('user', array('id'=>$msg_from_user_id));
    $msg_from_user_name = $msg_from_user->firstname . ' ' . $msg_from_user->lastname;
    
    $recent_conversations .= html_writer::start_tag('div', array('class'=>'inbox'));
    $recent_conversations .= html_writer::start_tag('h2');
    $recent_conversations .= get_string('yourrecentconversationwith','local_ualmessages') .' '. $msg_from_user_name;
    $recent_conversations .= html_writer::end_tag('h2');
    
    // get conversation history
    if ($messages = message_get_history($USER, $msg_from_user, 10, false)) {
        
        $recent_conversations .= html_writer::start_tag('ul');
        
        foreach ($messages as $message) {
            
            $this_msg_from_user_id = $message->useridfrom;
            
            // get the time message created
            $msg_created = $message->timecreated;
            
            // get current time
            $current_time = time();
            
            // get difference
            $diff = $current_time - $msg_created;
            $days_since = round($diff / 86400);
                
            // is time today ?
            if(date('Ymd') == date('Ymd', $msg_created)){
                $msg_created = 'Today';
            } else if ($days_since <= 3){
                $msg_created = $days_since . ' days ago';
            } else {
                $msg_created = date('M jS ',$msg_created);
            }
            
            if($this_msg_from_user_id==$logged_in_user_id){
                $recent_conversations .= html_writer::start_tag('li');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'user'));
                $recent_conversations .= $OUTPUT->user_picture($USER, array('size'=>60));
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'excerpt'));
                $recent_conversations .= $message->smallmessage;
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'time'));
                $recent_conversations .= $msg_created;
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::end_tag('li');
            } else {
                $recent_conversations .= html_writer::start_tag('li');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'user'));
                $recent_conversations .= $OUTPUT->user_picture($msg_from_user, array('size'=>60));
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'excerpt'));
                $recent_conversations .= $message->smallmessage;
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::start_tag('p', array('class'=>'time'));
                $recent_conversations .= $msg_created;
                $recent_conversations .= html_writer::end_tag('p');
                $recent_conversations .= html_writer::end_tag('li');
            }
        }            
        
        $recent_conversations .= html_writer::end_tag('ul');
    }
    
    $recent_conversations .= html_writer::end_tag('div');
    
    //send message form
    $context = get_context_instance(CONTEXT_SYSTEM);
    
    if (has_capability('moodle/site:sendmessage', $context)) {
        $recent_conversations .= html_writer::start_tag('div', array('class' => 'mdl-align messagesend'));
        if (!empty($messageerror)) {
            $recent_conversations .= html_writer::tag('span', $messageerror, array('id' => 'messagewarning'));
        } else {
            // Display a warning if the current user is blocking non-contacts and is about to message to a non-contact
            // Otherwise they may wonder why they never get a reply
            $blocknoncontacts = get_user_preferences('message_blocknoncontacts', '', $logged_in_user_id);
            if (!empty($blocknoncontacts)) {
                $contact = $DB->get_record('message_contacts', array('userid' => $logged_in_user_id, 'contactid' => $msg_from_user_id));
                if (empty($contact)) {
                    $msg = get_string('messagingblockednoncontact', 'message', $msg_from_user_name);
                    $recent_conversations .= html_writer::tag('span', $msg, array('id' => 'messagewarning'));
                }
            }

            $recent_conversations .= html_writer::start_tag('form', array('name'=>'sendmessage','method'=>'post','action'=>'view.php'));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'id','value'=>$message_id));
            $recent_conversations .= html_writer::tag('textarea', '', array('name'=>'message','rows'=>'4', 'cols'=>'100'));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'submit','value'=>get_string('send','local_ualmessages')));
            $recent_conversations .= html_writer::end_tag('form');
            
        }
        
        $recent_conversations .= html_writer::end_tag('div');
    }    
        
    return $recent_conversations;

}   
    
    
    