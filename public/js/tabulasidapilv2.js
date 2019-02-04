    $(document).ready(function()
    {
        $("#dapil").change(function()
        {
            var dapil = $("#dapil").val();
            if(dapil === '0' || dapil === null || dapil === undefined)
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
                          url: window.location.origin+"/suara/suarapartaibydapil/"+dapil+"/"+val.id,
                          type: "GET",
                          
                          success: function(data){
                              var res = '<div class="table-responsive table-striped table-bordered"><table class="table"><thead class="text-primary"><th>Nama</th><th>Total Suara</th></thead><tbody>';
                              
                              $.each(data, function(key, val2)
                              {
                                  res = res + '<tr><td>'+val2.partai+'</td><td>'+val2.total_suara+'</td></tr>';
                              });
                              
                              $.ajax({
                                  url: window.location.origin+"/suara/suaracalegbydapil/"+dapil+"/"+val.id,
                                  type: "GET",
                                  
                                  success: function(data){                    
                                      $.each(data, function(key, val3)
                                      {
                                          res = res + '<tr><td>'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'</td><td>'+val3.total_suara+'</td></tr>';
                                      });
                                      res = res + '</tbody></div>';
                                      //res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-6 px-1"><input type="submit" class="edit btn-info btn btn-round btn-block" value="Edit" name="edit"></div><div class="col-md-6 px-1"><input type="submit" class="hapus btn-danger btn btn-round btn-block" value="Hapus" name="hapus"></div></div>';
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
            }
            return false;
        });
    });