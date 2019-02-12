$(document).on('click', 'input[name="hapus"]', function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    $.confirm({
        title: 'Konfirmasi',
        content: 'Anda yakin akan menghapus data suara tersebut?',
        type: 'red',
        typeAnimated: true,
        boxWidth: '30%',
        animation: 'rotateYR',
        closeAnimation: 'rotate',
        closeIcon: true,
        theme: 'supervan',
        buttons: {
            Yakin: {
                btnClass: 'btn-red',
                action : function(){
                $("#"+id+" :input").prop("disabled", false);
                $.ajax({
                       url: window.location.origin+"/suara/delete",
                       type: 'POST',
                       data: $('#'+id).serialize()+"&_method=DELETE",
                       success: function(response) 
                       {
                         jQuery.alert('Data suara berhasil dihapus!');
                         $('#'+id).remove();
                       },
                       error: function(xhr, Status, err)
                       {
                         jQuery.alert(Status);
                         $("#"+id+" :input").prop("disabled", true);
                         $("#"+id+" :input[type='submit']").prop("disabled", false);
                       }
                    });
                }
            },
            Tidak: {
                btnClass: 'btn-blue',
                action: function(){
                    jQuery.alert('Dibatalkan!');
                }
            }
        }
});
});