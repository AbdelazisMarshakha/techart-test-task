$(function(){
    $('#messageERROR').hide();
    $('#submit').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url: window.location.href,
            method: "POST",
            data: { 'retailCRM':$("#retailCRM").val(),'password':$("#password").val()  },
            dataType: "json",
            success:function(json){
                if(json.success===false){
                    $('#messageERROR').show();
                }else{
                    window.location.reload(false);
                }
            }
        });
        
    });
});