    $(document).ready(function()
    {
        var id_kec = $("#kec").val();
        var id_kel = $("#kel").val();
        var tps_id = $("#tps").val();
        var dap_id = $("#dapil").val();
        var saksi = $("#saksi").val();
        $.ajax({
          url: window.location.origin+"/data/partai/",
          type: "GET",
          success: function(html){

            $.each(html, function(key, val)
            {
                $.ajax({
                    url: window.location.origin+"/suara/suarapartaibysaksi/"+dap_id+"/"+val.id+"/"+tps_id+"/"+saksi,
                    type: "GET",
                    
                    success: function(data){
                        var res = "";
      
                        $.each(data, function(key, val2)
                        {
                            res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.partai+'</label><input type="text" name="suarapartai['+val2.id_partai+']['+val2.id+']" class="form-control" value="'+val2.jumlah_suara+'" placeholder="'+val2.partai+'" disabled></div></div>';
                        });
                        
                        $.ajax({
                            url: window.location.origin+"/suara/suaracalegbysaksi/"+dap_id+"/"+val.id+"/"+tps_id+"/"+saksi,
                            type: "GET",
                            
                            success: function(data){                    
                                $.each(data, function(key, val3)
                                {
                                    res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'</label><input type="text" name="suara['+val3.id_partai+']['+val3.id_caleg+']['+val3.id+']" class="form-control" value="'+val3.jumlah_suara+'" placeholder="'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'" disabled></div></div>';
                                });

                                res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-6 px-1"><input type="submit" class="edit btn-info btn btn-round btn-block" value="Edit" name="edit"></div><div class="col-md-6 px-1"><input type="submit" class="hapus btn-danger btn btn-round btn-block" value="Hapus" name="hapus"></div></div>';
                                $("#"+val.id).html(res);
                            },
                            error: function(xhr, Status, err) {
                               showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                             }
                        });

                    },
                    error: function(xhr, Status, err) {
                       showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                     }
                });
            });
          },
          error: function(xhr, Status, err) {
             showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
           } 
        });
    });