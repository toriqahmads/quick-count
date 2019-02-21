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
              $('#tps').empty().append('<option selected value="0">Pilih TPS</option>');
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
        var prov = $("#prov").val();
        var tingkat = $("#tingkat").val();
        if(kab === '0' || kab === null || kab === undefined || kab == '' || kab == 0)
        {
            showNotification('top', 'right','Harap pilih kabupaten!', 'danger');
        }
        else
        {
          $.ajax({
            url: window.location.origin+"/data/dapilkab/" + prov + "/" + kab + "/c",
            type: "GET",
            success: function(html){
              var res = "<option value='0' selected>Dapil</option>";
              $.each(html, function(key, val)
              {
                  res = res + "<option value='" + val.id +"'>" + val.dapil + "</option>";
              });
              $('#dapil').html(res);
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ err, 'danger');
             } 
          });
        }
        return false;
    });

  $("#dapil").on('change', function()
  {
      var dapil = $("#dapil").val();
      if(dapil === '0' || dapil === null || dapil === undefined || dapil == '' || dapil == 0)
      {
          showNotification('top', 'right','Harap pilih dapil!', 'danger');
      }
      else
      {
          tingkat = $("#tingkat").val();
          $.ajax({
            url: window.location.origin+"/tabulasi/partai/dapil/"+dapil+"/"+tingkat,
            type: "GET",
            success: function(datas){
              var id_partai = [];
              $.each(datas, function(key, val)
              {
                id_partai.push(val.id_partai);
              });
              var id_partais = JSON.stringify(id_partai);
                $.ajax({
                  url: window.location.origin+"/tabulasi/caleg/dapil/"+id_partais+"/"+dapil+"/"+tingkat,
                  type: "GET",
                  success: function(data){
                    var datachart = [];
                      $.each(datas, function(keys, val)
                      {
                        var res = '';
                        res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val.partai+'</label><input type="number" name="suarapartai['+val.id_partai+']['+val.id+']" class="form-control" value="'+val.total_suara+'" placeholder="'+val.partai+'" disabled></div></div>';
                        $.each(data, function(key, val2)
                        {
                          if(val.id_partai == val2.id_partai)
                          {
                            res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.no_urut+'. '+val2.nama_depan_caleg+' '+val2.nama_belakang_caleg+'</label><input type="number" name="suara['+val2.id_partai+']['+val2.id_caleg+']['+val2.id+']" class="form-control" value="'+val2.total_suara+'" placeholder="" disabled></div></div>';
                          }
                        });
                        $("#"+val.id_partai).html(res);
                        var total = 0;
                        $("#"+val.id_partai+" :input").each(function(){
                             total = total + parseInt($(this).val());
                        });
                        datachart.push({partai: val.partai, total_suara: total});
                        res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-12 px-1"><input type="text" class="btn-info btn btn-round btn-block" value="'+total+'" name="total" disabled="true"></div>';
                        $("#"+val.id_partai).html(res);
                        delete res;
                      });
                      chart("Jumlah Suara Partai DPR Kabupaten by Dapil", datachart);
                      $("#chartdiv").prop("hidden", false);
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
      }
      return false;
  });
});   