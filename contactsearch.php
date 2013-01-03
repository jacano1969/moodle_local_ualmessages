<?php

require('../../config.php');
require('lib.php');

$PAGE->set_context($context);
$PAGE->set_url('/local/ualmessages/index.php');

if(!empty($_GET['search'])) {
    $search = $_GET['search'];
} else {
    return;
}

if(!empty($_GET['courseid'])) {
    $course_id = $_GET['courseid'];
}

    // prepare search
    $search = stripcslashes(clean_text(trim($search)));
        
    $course_id = intval(substr($course_id, 7));
    if(!empty($course_id)) {
        
        $countparticipants = count_enrolled_users($coursecontexts[$course_id]);
        $participants = get_enrolled_users($coursecontexts[$course_id], '', 0, 'u.*', '', $page*50, 50);
        
        $pagingbar = new paging_bar($countparticipants, $page, 50, $PAGE->url, 'page');
        $content .= $OUTPUT->render($pagingbar);
        
        //$content .= html_writer::start_tag('table', array('id' => 'message_participants', 'class' => 'boxaligncenter', 'cellspacing' => '2', 'cellpadding' => '0', 'border' => '0'));
        
        $iscontact = true;
        $isblocked = false;
        foreach ($participants as $participant) {
            if ($participant->id != $USER->id) {                    
                $participant->messagecount = 0;
                
                $fullname  = fullname($participant);

                // check if search if used
                if($search!='' && stripos($fullname,$search,0)===false)
                {
                    continue;
                } else {
                
                    $fullnamelink  = $fullname;
                
                    $linkclass = '';
                    if (!empty($selecteduser) && $participant->id == $selecteduser->id) {
                        $linkclass = 'messageselecteduser';
                    }
                    
                    if ($participant->messagecount > 0 ){
                        $fullnamelink = '<strong>'.$fullnamelink.' ('.$participant->messagecount.')</strong>';
                    }
                
                    $strcontact = $strblock = $strhistory = null;
                    //$strcontact = message_get_contact_add_remove_link($iscontact, $isblocked, $participant);
                    //$strblock   = message_get_contact_block_link($iscontact, $isblocked, $participant);
                    //$strhistory = message_history_link($USER->id, $participant->id, true, '', '', 'icon');
                    //http://localhost/moodle/message/index.php?history=1&user1=2&user2=3
                    //$strhistory = str_replace('/message/index.php', '/local/ualmessages/view.php',$strhistory);
    
                    $content .= html_writer::start_tag('tr');
                    $content .= html_writer::start_tag('td', array('class' => 'pix'));
                    $content .= $OUTPUT->user_picture($participant, array('size' => 20, 'courseid' => SITEID));
                    $content .= html_writer::end_tag('td');
                
                    $content .= html_writer::start_tag('td', array('class' => 'contact'));
                
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
                        $link = new moodle_url($selectcontacturl.'&user2='.$participant->id);
                    } else {
                        //can $selectcontacturl be removed and maybe the be removed and hardcoded?
                        $link = new moodle_url("/local/ualmessages/send.php?id=$participant->id");
                        //$action = new popup_action('click', $link, "message_$participant->id", $popupoptions);
                    }
                    $content .= $OUTPUT->action_link($link, $fullnamelink, $action, array('class' => $linkclass,'title' => get_string('sendmessageto', 'message', $fullname)));
                
                    $content .= html_writer::end_tag('td');
                
                    $content .= html_writer::tag('td', '&nbsp;'.$strcontact, array('class' => 'link'));
                
                    $content .= html_writer::end_tag('tr');
                }
            }
        }
    } else {   // get all contacts
        
        // find contacts
        $countunreadtotal = message_count_unread_messages($USER);
        $blockedusers = message_get_blocked_users($USER, '');
        list($onlinecontacts, $offlinecontacts, $strangers) = message_get_contacts($USER, '');
        
        //$content .= html_writer::start_tag('div', array('class' => 'contactselector mdl-align'));
        
        $countonlinecontacts  = count($onlinecontacts);
        $countofflinecontacts = count($offlinecontacts);
        $countstrangers       = count($strangers);
        $isuserblocked = null;
    
        if ($countonlinecontacts + $countofflinecontacts == 0) {
            $content .= html_writer::tag('div', get_string('contactlistempty', 'message'), array('class' => 'heading'));
        }
    
        $content .= html_writer::start_tag('table', array('id' => 'message_contacts', 'class' => 'boxaligncenter'));
    
    
        if($countonlinecontacts) {
                    
            //if (empty($titletodisplay)) {
                //message_print_heading(get_string('onlinecontacts', 'message', $countonlinecontacts));
            //}
    
            $isuserblocked = false;
            $isusercontact = true;
            foreach ($onlinecontacts as $contact) {
                if ($contact->messagecount >= 0) {
                    $content .= $this->get_contacts($contact, $isusercontact, $isuserblocked, $search);
                }
            }
        }
    
        if ($countofflinecontacts) {
                    
            //if (empty($titletodisplay)) {
                //message_print_heading(get_string('offlinecontacts', 'message', $countofflinecontacts));
            //}
    
            $isuserblocked = false;
            $isusercontact = true;
            foreach ($offlinecontacts as $contact) {
                if ($contact->messagecount >= 0) {
                    $content .= $this->get_contacts($contact, $isusercontact, $isuserblocked, $search);
                }
            }
    
        }
        
        if ($countstrangers) {
            //message_print_heading(get_string('incomingcontacts', 'message', $countstrangers));
    
            $isuserblocked = false;
            $isusercontact = false;
            foreach ($strangers as $stranger) {
                if ($stranger->messagecount >= 0) {
                    $content .= $this->get_contacts($stranger, $isusercontact, $isuserblocked, $search);
                }
            }
        }
        
        //$content .= html_writer::end_tag('table');
    
        if ($countstrangers && ($countonlinecontacts + $countofflinecontacts == 0)) {  // Extra help
            $content .= html_writer::tag('div','('.get_string('addsomecontactsincoming', 'message').')',array('class' => 'note'));
        }

        //$content .= html_writer::end_tag('div');
    }

    //$content .= html_writer::end_tag('table');

    //$content .= html_writer::end_tag('div');
    
    //$content .= html_writer::end_tag('div');
      
    echo $content;

