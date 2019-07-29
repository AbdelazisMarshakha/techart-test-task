$(function(){
    $('#messageERROR').text() == '' ? $('#messageERROR').hide() : '';
    $('.btns input').on('change',function(e){
        /*e.preventDefault();*/
        let active = $('input:checked[name="button-group"]').val();
        $.ajax({
            url: "http://tkache7a.beget.tech/clients_scripts/lendary/SAND-1144/account/activate",
            method: "POST",
            data: { 'active':active},
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