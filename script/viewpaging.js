

var ualmessagespaging = ualmessagespaging || (function(){
   
    "use strict";
    
    $(document).ready(function(){
        
    $('div.paging a').each(function() {   
        var viewed = $('#viewing').val(); 
        var _href = $(this).attr("href");
        var newhref = _href + '&viewing=' + viewed;
        $(this).attr("href", newhref); 
    });
    
    });
    
}());

