$(document).on('click', 'input[name="edit"]', function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    kel_id = $("#kel").val();
    dapil = $("#dapil").val();
    saksi = $("#saksi").val();

    if(kel_id === '0' || kel_id === null || kel_id === undefined)
    {
        showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
    }
    else if(dapil === '0' || dapil === null || dapil === undefined)
    {
        showNotification('top', 'right','Harap pilih Dapil!', 'danger');
    }
    else
    {
        $("#"+id+" :input").prop("disabled", false);
        $("#"+id+" input.edit").prop("value", "Kirim");
        $("#"+id+" input.edit").prop("name", "kirim");
        $("#"+id+" input.hapus").hide();
    }
});