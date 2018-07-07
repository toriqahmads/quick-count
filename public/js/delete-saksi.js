$('#hapus').onclick(function(e)
{
    e.prefentDefault();
    $.confirm({
        title: 'Konfirmasi',
        content: 'Anda yakin akan menghapus data saksi tersebut?',
        buttons: {
            confirm: function(){
                $.ajax({
                       url: $('#hapussaksi').attr('action'),
                       type: 'POST',
                       data: $('#hapussaksi').serialize(),
                       success: function(response) 
                       {
                         $.alert('Data saksi berhasil dihapus!');
                       },
                       error: function(xhr, Status, err)
                       {
                        $.alert('Data saksi gagal dihapus!');
                       }
                    });
            },
            cancel: function () {
                $.alert('Canceled!');
            }
        }
    });
});