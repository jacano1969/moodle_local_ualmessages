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
function get_messages_unread($user, $msg_length, $search) {
    
    global $OUTPUT, $DB, $CFG;
    
    $message_count=0;
    $user_messages="";
    
    // get all unread messages for user
    if($search!='') {
        $search = str_replace("'", "''", $search);
        $msg_unread = $DB->get_records_select('message', " useridto=$user->id and fullmessage like('%$search%')", null, 'timecreated');
    } else {
        $msg_unread = $DB->get_records_select('message', " useridto=$user->id", null, 'timecreated');
    }
    
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
    
    if($message_count==0) {
        $user_messages = '';
    }
    
    return $user_messages;
}



/**
 * Description: function to display all read messsages
 *              for a particular user
 *
 * Author: Daniel J. Somers 30/10/2012
 */
function get_messages_read($user, $msg_length, $search) {
    
    global $OUTPUT, $DB, $CFG;
    
    $message_count=0;
    $user_messages="";
    
    // get all read messages for user
    if($search!='') {
        $search = str_replace("'", "''", $search);
        $msg_read = $DB->get_records_select('message_read', " useridto=$user->id and fullmessage like('%$search%')", null, 'timecreated');
    } else {
        $msg_read = $DB->get_records_select('message_read', " useridto=$user->id", null, 'timecreated');
    }
    
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
    
    if($message_count==0) {
        $user_messages = '';
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
        
        $recent_conversations .= html_writer::start_tag('ul', array('class'=>'messages'));
        
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
                $recent_conversations .= html_writer::start_tag('li', array('class'=>'current'));
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

            $recent_conversations .= html_writer::start_tag('form', array('name'=>'sendmessage','method'=>'post','action'=>'create.php'));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'usertoid','value'=>$msg_from_user_id));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'userfromid','value'=>$USER->id));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'id','value'=>$message_id));
            $recent_conversations .= html_writer::start_tag('label');
            $recent_conversations .= get_string('yourmessage','local_ualmessages');
            $recent_conversations .= html_writer::end_tag('label');
            $recent_conversations .= html_writer::tag('textarea', '', array('name'=>'message','rows'=>'4', 'cols'=>'100'));
            $recent_conversations .= html_writer::empty_tag('input', array('type'=>'submit','value'=>get_string('send','local_ualmessages')));
            $recent_conversations .= html_writer::end_tag('form');
            
        }
        
        $recent_conversations .= html_writer::end_tag('div');
    }    
        
    return $recent_conversations;

}   
    
    

    
// added for contactsearch

function get_contactsearch_contacts($contact, $incontactlist, $isblocked, $search) {
        
    global $OUTPUT, $USER;
    
    $this_contact="";
    
    $fullname  = fullname($contact);
    $fullnamelink  = $fullname;
    
    // check if search if used
    if($search!='')
    {
        if($search!='' && stripos($fullname,$search,0)===false)
        {
            return $this_contact;
        }
    }

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
    //http://localhost/moodle/message/index.php?history=1&user1=2&user2=3
    $strhistory = str_replace('/message/index.php', '/local/ualmessages/view.php',$strhistory);
    
    $this_contact.= html_writer::start_tag('tr');
    $this_contact.= html_writer::start_tag('td', array('class' => 'pix'));
    $this_contact.= $OUTPUT->user_picture($contact, array('size' => 20, 'courseid' => SITEID));
    $this_contact.= html_writer::end_tag('td');

    $this_contact.= html_writer::start_tag('td', array('class' => 'contact'));

    /*$popupoptions = array(
            'height' => MESSAGE_DISCUSSION_HEIGHT,
            'width' => MESSAGE_DISCUSSION_WIDTH,
            'menubar' => false,
            'location' => false,
            'status' => true,
            'scrollbars' => true,
            'resizable' => true);*/

    $link = $action = null;
    if (!empty($selectcontacturl)) {
        $link = new moodle_url($selectcontacturl.'&user2='.$contact->id);
    } else {
        $link = new moodle_url("/local/ualmessages/index.php?id=$contact->id");
        //$action = new popup_action('click', $link, "message_$contact->id", $popupoptions);
    }
    $this_contact.= $OUTPUT->action_link($link, $fullnamelink, $action, array('class' => $linkclass,'title' => get_string('sendmessageto', 'message', $fullname)));

    $this_contact.= html_writer::end_tag('td');

    $this_contact.= html_writer::tag('td', '&nbsp;'.$strcontact.$strblock.'&nbsp;'.$strhistory, array('class' => 'link'));

    $this_contact.= html_writer::end_tag('tr');
    
    return $this_contact;
}

public function print_message_view_history_page($user1, $user2, $history) {
    
    global $DB;
    
    // get message data (unread message)
    $msg = $DB->get_records_select('message', " useridfrom=$user1 AND useridto=$user2", null, 'timecreated', '*', 0, 1);
       
    if(!$msg){
        // message might be from current user
        $msg = $DB->get_records_select('message', " useridfrom=$user2 AND useridto=$user1", null, 'timecreated', '*', 0, 1);
    }
    
    if(!$msg){        
        // it might be an already read message
        $msg = $DB->get_records_select('message_read', " useridfrom=$user1 AND useridto=$user2", null, 'timecreated', '*', 0, 1);
    }
    
    if(!$msg){        
        // it might be an already read message from current user
        $msg = $DB->get_records_select('message_read', " useridfrom=$user2 AND useridto=$user1", null, 'timecreated', '*', 0, 1);
    }
    
    if(!$msg)
    {
        return;
    } else {
        $message_id = 0;
        foreach($msg as $msgid) {
            if($message_id==0) {
                $message_id = $msgid->id;
            }    
        }
       
        echo $this->print_message_view_page($message_id);
    }
}

// create new message
public function print_send_message_page($user_id_to) {
    
    global $USER, $CFG, $DB, $OUTPUT;
    
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
    $content .= html_writer::start_tag('li');
    $content .= html_writer::start_tag('a', array('href'=>$CFG->httpswwwroot.'/local/ualmessages/contacts.php'));
    $content .= get_string('contacts', 'local_ualmessages');
    $content .= html_writer::end_tag('a');
    $content .= html_writer::end_tag('li');
    $content .= html_writer::end_tag('ul');      
    
    $content .= html_writer::start_tag('p');
    $content .= html_writer::start_tag('h2');
    $content .= get_string('createanewmessage','local_ualmessages');
    $content .= html_writer::end_tag('h2');
    $content .= html_writer::end_tag('p');
    
    $content .= html_writer::start_tag('p');
    $content .= get_string('to','local_ualmessages') . ':';
            
    // get user to 
    $user_to = $DB->get_record('user', array('id'=>$user_id_to));
    $user_to_pic = $OUTPUT->user_picture($user_to, array('size'=>40));
    $user_to_user_name = $user_to->firstname . ' ' . $user_to->lastname;
    $content .= html_writer::end_tag('p');
    
    $content .= html_writer::start_tag('form', array('id' => 'messagefilter','method' => 'get','action' => 'create.php'));
    $content .= $user_to_pic . $user_to_user_name;
    $content .= html_writer::start_tag('input', array('type'=>'submit', 'value'=>'edit'));
    $content .= html_writer::end_tag('form');
    
    $content .= html_writer::start_tag('form', array('name'=>'sendmessage','method'=>'post','action'=>'create.php'));
    $content .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'userfromid','value'=>$USER->id));
    $content .= html_writer::empty_tag('input', array('type'=>'hidden','name'=>'usertoid','value'=>$user_to->id));
    $content .= html_writer::start_tag('label');
    $content .= get_string('yourmessage','local_ualmessages');
    $content .= html_writer::end_tag('label');
    $content .= html_writer::tag('textarea', '', array('name'=>'message','rows'=>'4', 'cols'=>'100'));
    $content .= html_writer::empty_tag('input', array('type'=>'submit','value'=>get_string('send','local_ualmessages')));
    $content .= html_writer::end_tag('form');
        
    //$content .= html_writer::start_tag('form', array('id' => 'messagefilter','method' => 'post','action' => 'create.php'));
    //$content .= html_writer::start_tag('input', array('type'=>'hidden', 'name'=>'usertoid' 'value'=>$user_to->id));
    
    //$content .= html_writer::end_tag('form');
    
    
    //$content .= message box
    
    //$content .= send button
    
    //check for message and send to user id
    
    echo $content;
}
    
    