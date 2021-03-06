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
              $.ajax({
                url: window.location.origin+"/data/partai/",
                type: "GET",
                success: function(html){
                  $.each(html, function(key, val)
                  {
                      $.ajax({
                          url: window.location.origin+"/data/getpres/"+val.id+"/a",
                          type: "GET",
                          
                          success: function(data){
                              var res = "";
                              res = '<div class="col-md-12 pl-1"><div class="form-group"><label>'+data[0]['partai']+'</label><input type="number" id="spartai'+data[0]['id']+'" name="suarapartai['+data[0]['id_partai']+']" class="form-control" value="0"><b>Suara partai harus diisi 0!</b></div></div>';
                              $.each(data, function(key, val2)
                              {
                                  res = res + '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val2.no_urut+'. '+val2.nama_depan+' ' +val2.nama_belakang+ '</label><input type="number" name="suara['+val.id+']['+val2.id+']" class="form-control" placeholder="" ></div></div>';
                              });
                              $("#"+val.id).html(res);
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