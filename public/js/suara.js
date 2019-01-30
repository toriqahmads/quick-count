    $(document).ready(function()
    {
        $("#dapil").change(function()
        {
            var dap_id = $("#dapil").val();
            
            if(dap_id === '0' || dap_id === null || dap_id === undefined)
            {
                showNotification('top', 'right','Harap pilih dapil!', 'danger');
            }
            else
            {
                $.ajax({
                  url: window.location.origin+"/data/partai/",
                  type: "GET",
                  success: function(html){

                    $.each(html, function(key, val)
                    {
                        $.ajax({
                            url: window.location.origin+"/data/caleg/"+dap_id+"/"+val.id,
                            type: "GET",
                            
                            success: function(data){
                                var res = "";
                                $.each(data, function(key, val2)
                                {
                                    res = res + '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val2.nama_depan+' ' +val2.nama_belakang+ '</label><input type="text" name="suara['+val.id+']['+val2.id+']" class="form-control" placeholder="'+val2.nama_depan+ ' ' +val2.nama_belakang + '" ></div></div>';
                                });
                                $("#"+val.id).html(res);
                            },
                        })
                    });
                    
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   } 
                });
            }
            return false;
        });
    });