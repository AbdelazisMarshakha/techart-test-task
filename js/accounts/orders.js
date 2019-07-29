$(function(){
    $('#messageERROR').hide();
    $('button').on('click',function(e){
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            url: "http://tkache7a.beget.tech/clients_scripts/lendary/SAND-1144/orders/delete",
            method: "POST",
            data: { 'id':id},
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