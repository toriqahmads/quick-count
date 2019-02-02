$(".kirim").click(function(e){
    e.preventDefault();
    id = $(this).parents("form").attr("id");
    $.ajax({
       url: $('#'+id).attr('action'),
       type: 'POST',
       data: $('#'+id).serialize(),
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