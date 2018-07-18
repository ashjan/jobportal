<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
        link_frm = '<?php echo base_url();?>jobs/camp_admin';
        link_cmp = '<?php echo base_url();?>campaign/admin/';
        
        
    
    $("#login-form").submit( function(e) {
       var pag = $('#page').val();
        var lgn = $('#lgn').val();
        var pas = $('#pas').val();
        var proc = $('#proc').val();
        
        e.preventDefault();
        $.ajax({
        url: link_cmp,
        type: 'post',
        dataType: 'html',
        data: {login: lgn ,
        password: pas,
        page: pag,
        process: proc},
        success: function(data) {
            
                   console.log(data);
            if (data.reply == 1) {
                
                    window.location.replace(link_cmp); //HTTP Redirect
                }
                window.location.replace(link_cmp); 
                 }
    });
});
        </script>
</body>
</html>