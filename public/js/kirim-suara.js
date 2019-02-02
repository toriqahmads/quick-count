$(".kirim").click(function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    tps = $("#tps").val();
    dapil = $("#dapil").val();
    saksi = $("#saksi").val();
    $.ajax({
       url: $('#'+id).attr('action'),
       type: 'POST',
       data: $('#'+id).serialize() + "&tps="+tps+"&dapil="+dapil+"&saksi="+saksi,
       success: function(response) 
       {
         showNotification('top', 'right','Berhasil dikirim!', 'info');
         $('#'+id).hide();
       },
       error: function(xhr, Status, err)
       {
         showNotification('top', 'right', Status, 'danger');
       }
    });
});