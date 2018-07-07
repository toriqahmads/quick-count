$(".hapus").click(function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    idtr = $(this).parents("tr").attr("id");
    $.confirm({
        title: 'Konfirmasi',
        content: 'Anda yakin akan menghapus data saksi tersebut?',
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
                $.ajax({
                       url: $('#'+id).attr('action'),
                       type: 'POST',
                       data: $('#'+id).serialize(),
                       success: function(response) 
                       {
                         jQuery.alert('Data saksi berhasil dihapus!');
                         $('#'+idtr).remove();
                       },
                       error: function(xhr, Status, err)
                       {
                         jQuery.alert('Data saksi gagal dihapus!');
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