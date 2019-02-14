$(document).ready(function()
{
    $("#prov").on('change', function()
    {
      var prov = $("#prov").val();
      if(prov === '0' || prov === null || prov === undefined || prov == '' || prov == 0)
      {
          showNotification('top', 'right','Harap pilih provinsi!', 'danger');
      }
      else
      {
          tingkat = $("#tingkat").val();
          $.ajax({
            url: window.location.origin+"/data/partai",
            type: "GET",
            success: function(datas){
              var id_partai = [];
              $.each(datas, function(key, val)
              {
                id_partai.push(val.id);
              });
              var id_partais = JSON.stringify(id_partai);
                $.ajax({
                  url: window.location.origin+"/tabulasi/caleg/prov/"+id_partais+"/"+prov+"/"+tingkat,
                  type: "GET",
                  success: function(data){
                    $.each(data, function(key, val2)
                    {
                      var res = '';
                      res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.nama_depan_caleg+' '+val2.nama_belakang_caleg+'</label><input type="number" name="suara['+val2.id_partai+']['+val2.id_caleg+']['+val2.id+']" class="form-control" value="'+val2.total_suara+'" placeholder="'+val2.nama_depan_caleg+' '+val2.nama_belakang_caleg+'" disabled></div></div>';
                      $("#"+val2.id_partai).html(res);
                      var total = 0;
                      $("#"+val2.id_partai+" :input").each(function(){
                           total = total + parseInt($(this).val());
                      });
                      res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-12 px-1"><input type="text" class="btn-info btn btn-round btn-block" value="'+total+'" name="total" disabled="true"></div>';
                      $("#"+val2.id_partai).html(res);
                      delete res;
                    });
                    chart("Jumlah Suara Presiden By Provinsi", data);
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