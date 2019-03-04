  $(document).ready(function()
  {
      $("#prov").change(function()
      {
          var prov = $("#prov").val();
          if(prov === '0' || prov === null || prov === undefined || prov == '' || prov == 0)
          {
              showNotification('top', 'right','Harap pilih provinsi!', 'danger');
          }
          else
          {
              $('#kab').empty().append('<option selected value="0">Pilih kabupaten</option>');
              $('#kec').empty().append('<option selected value="0">Pilih kecamatan</option>');
              $('#kel').empty().append('<option selected value="0">Pilih kelurahan</option>');
              $('#dapil').empty().append('<option selected value="0">Pilih Dapil</option>');
              $.ajax({
                url: window.location.origin+"/data/kab/" + prov,
                type: "GET",
                success: function(html){
                  var res = "<option value='0' selected>Pilih Kabupaten</option>";
                  $.each(html, function(key, val)
                  {
                      res = res + "<option value='" + val.id +"'>" + val.kab + "</option>";
                  });
                  $('#kab').html(res);
                },
                error: function(xhr, Status, err) {
                   showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                 } 
              });
          }
          return false;
      });

      $("#kab").on('change', function()
      {
          var kab = $("#kab").val();
          if(kab === '0' || kab === null || kab === undefined || kab == '' || kab == 0)
          {
              showNotification('top', 'right','Harap pilih kabupaten!', 'danger');
          }
          else
          {
              $('#kec').empty().append('<option selected value="0">Pilih kecamatan</option>');
              $('#kel').empty().append('<option selected value="0">Pilih kelurahan</option>');
              $('#dapil').empty().append('<option selected value="0">Pilih Dapil</option>');
              $.ajax({
                url: window.location.origin+"/data/kec/" + kab,
                type: "GET",
                success: function(html){
                  var res = "<option value='0' selected>Pilih kecamatan</option>";
                  $.each(html, function(key, val)
                  {
                      res = res + "<option value='" + val.id_kec +"'>" + val.kec + "</option>";
                  });
                  $('#kec').html(res);
                },
                error: function(xhr, Status, err) {
                   showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                 } 
              });
          }
          return false;
      });

  $("#kec").on('change', function()
  {
      var kec_id = $("#kec").val();
      if(kec_id === '0' || kec_id === null || kec_id === undefined)
      {
          showNotification('top', 'right','Harap pilih kecamatan!', 'danger');
      }
      else
      {
          $.ajax({
            url: window.location.origin+"/data/kel/" + kec_id,
            type: "GET",
            success: function(html){
              var res = "<option value='0'>Kelurahan</option>";
              var dap_id = 0;

              $.each(html, function(key, val)
              {
                  res = res + "<option value='" + val.id_kel +"'>" + val.kel + "</option>";
                  dap_id = val.id_dapil;
                  $('#dapil').val(dap_id);
              });
              $('#kel').html(res);
              $('#tps').empty().append('<option selected value="0">TPS</option>');
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
             } 
          });
      }
      return false;
  });

  $("#kel").change(function()
  {
      var kel_id = $("#kel").val();
      
      if(kel_id === '0' || kel_id === null || kel_id === undefined)
      {
          showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
      }
      else
      {
          var tingkat = $("#tingkat").val();
        $.ajax({
          url: window.location.origin+"/data/partai/",
          type: "GET",
          success: function(html){

            $.each(html, function(key, val)
            {
                $.ajax({
                    url: window.location.origin+"/suara/desa/suarapartai/"+val.id+"/"+kel_id+"/"+tingkat,
                    type: "GET",
                    
                    success: function(data){
                        var res = "";
      
                        $.each(data, function(key, val2)
                        {
                            res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.partai+'</label><input type="number" name="suarapartai['+val2.id_partai+']['+val2.id+']" class="form-control" value="'+val2.jumlah_suara+'" placeholder="'+val2.partai+'" disabled></div></div>';
                        });
                        
                        $.ajax({
                            url: window.location.origin+"/suara/desa/suaracaleg/"+val.id+"/"+kel_id+"/"+tingkat,
                            type: "GET",
                            
                            success: function(data){                    
                                $.each(data, function(key, val3)
                                {
                                    res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val3.no_urut+'. '+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'</label><input type="number" name="suara['+val3.id_partai+']['+val3.id_caleg+']['+val3.id+']" class="form-control" value="'+val3.jumlah_suara+'" placeholder="" disabled></div></div>';
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
      }
      return false;
  });
});