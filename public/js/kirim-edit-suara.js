$(document).on('click', 'input[name="kirim"]', function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    kel_id = $("#kel").val();
    tps = $("#tps").val();
    dapil = $("#dapil").val();
    saksi = $("#saksi").val();

    if(kel_id === '0' || kel_id === null || kel_id === undefined)
    {
        showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
    }

    else if(tps === '0' || tps === null || tps === undefined)
    {
        showNotification('top', 'right','Harap pilih TPS!', 'danger');
    }
    else if(dapil === '0' || dapil === null || dapil === undefined)
    {
        showNotification('top', 'right','Harap pilih TPS!', 'danger');
    }
    else
    {
        $.ajax({
         url: $('#'+id).attr('action'),
         type: 'POST',
         data: $('#'+id).serialize() + "&tps="+tps+"&dapil="+dapil+"&saksi="+saksi,
         success: function(response) 
         {
            showNotification('top', 'right','Berhasil diupdate!', 'info');
            $("#"+id+" :input").prop("disabled", true);
            $("#"+id+" :input[type='submit']").prop("disabled", false);
            $("#"+id+" input.edit").prop("value", "Edit");
            $("#"+id+" input.edit").prop("name", "edit");
            $("#"+id+" input.hapus").show();
         },
         error: function(xhr, Status, err)
         {
           showNotification('top', 'right', Status, 'danger');
         }
      });
    }
});