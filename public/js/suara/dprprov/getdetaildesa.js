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
          $('#dapil').empty();
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
          $('#dapil').empty();

          $.ajax({
            url: window.location.origin+"/data/kec/" + kab,
            type: "GET",
            success: function(html){
              $.ajax({
                url: window.location.origin+"/data/kabid/" + kab,
                type: "GET",
                success: function(html){
                  $('#dapil').val(html[0]['dapil_dprprov']);
                  $.ajax({
                    url: window.location.origin+"/data/partai/",
                    type: "GET",
                    success: function(html){
                      var dap_id = $("#dapil").val();
                      $.each(html, function(key, val)
                      {
                        var res = "";
                        res = '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val.partai+'</label><input type="number" name="suarapartai['+val.id+']" class="form-control" placeholder="Suara Partai"></div></div>';
                        $("#"+val.id).html(res);
                          $.ajax({
                              url: window.location.origin+"/data/caleg/"+dap_id+"/"+val.id+"/d",
                              type: "GET",                              
                              success: function(data){
                                  var res = "";
                                  $.each(data, function(key, val2)
                                  {
                                      res = res + '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val2.no_urut+'. '+val2.nama_depan+' ' +val2.nama_belakang+ '</label><input type="number" name="suara['+val.id+']['+val2.id+']" class="form-control" placeholder="" ></div></div>';
                                  });
                                  $("#"+val.id).append(res);
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
                  })
                },
                error: function(xhr, Status, err) {
                   showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                 } 
              })
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

  $("#kec").change(function()
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
              });
              $('#kel').html(res);
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
             } 
          });
      }
      return false;
  });
});