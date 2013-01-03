

var ualmessagescode = ualmessagescode || (function(){
   
    "use strict";

    $("#msgsearchname").live("keypress", function() {
        
        var searchText = $(this).val();
        var courseId = $('#viewing').val();
        
        $.get("contactsearch.php", {'courseid': courseId, 'search': searchText}, function(data){
            $('#message_participants').html(data);
        });
        
    });

}());