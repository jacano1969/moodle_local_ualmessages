

var ualmessagescode = ualmessagescode || (function(){
   
    "use strict";

    $("#msgsearchname").live("keyup", function() {
        
        var searchText = $(this).val();
        var courseId = $('#viewing').val();
        
        $.get("contactsearch.php", {'courseid': courseId, 'search': searchText}, function(data){
            
            if($('#message_participants').length>0){
                $('#message_participants').html(data);
            }
            
            if($('#message_contacts').length>0){
                $('#message_contacts').html(data);
            }
            
        });
        
    });

}());