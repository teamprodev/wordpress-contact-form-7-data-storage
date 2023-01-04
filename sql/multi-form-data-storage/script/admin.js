/******************************************************************************/
/******************************************************************************/

;(function($,doc,win) 
{
	"use strict";
    
    /**************************************************************************/
	
    $('.to-entry-preview-link').on('click',function(e)
    {
        e.preventDefault();
     
        var cell=$(this).parents('td.title');
        var body=$(this).nextAll('.to-entry-preview-body');
        
        if(parseInt(body.length,10)===1) cell.append(body);
        else body=cell.children('.to-entry-preview-body');
        
        body.toggle();
    });
    
    /**************************************************************************/
    
    $('#mfds_export').on('click',function(e)
    {   
        e.preventDefault();
        
        var url=[location.protocol,'//',location.host, location.pathname].join('');
        window.location=url+'?post_type=mfds_form_entry&mfds_action=1&mfds_export_option='+$('#mfds_export_option').val();
    });
    
    /**************************************************************************/
    
})(jQuery,document,window);

/******************************************************************************/
/******************************************************************************/