$(document).ready(function()
{
  var tingkat = $("#tingkat").val();
  var id_prov = $("#prov").val();
  var id_kab = $("#kab").val();
  var id_kec = $("#kec").val();
  var id_kel = $("#kel").val();
  var tps_id = $("#tps").val();
  var saksi = $("#saksi").val();
  var dap_id = $("#dapil_dprri").val();
  
  $.ajax({
    url: window.location.origin+"/data/partai/",
    type: "GET",
    success: function(html)
    {
      $.each(html, function(key, val)
      {
        var res = "";
        res = '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val.partai+'</label><input type="number" name="suarapartai['+val.id+']" class="form-control" placeholder="Suara Partai"></div></div>';
        $("#"+val.id).html(res);
          $.ajax({
              url: window.location.origin+"/data/caleg/"+dap_id+"/"+val.id+"/c",
              type: "GET",  
              success: function(data){
                  var res = "";
                  $.each(data, function(key, val2)
                  {
                      res = res + '<div class="col-md-12 pl-1"><div class="form-group"><label>'+val2.no_urut+'. '+val2.nama_depan+' ' +val2.nama_belakang+ '</label><input type="number" name="suara['+val.id+']['+val2.id+']" class="form-control" placeholder="" ></div></div>';
                  });
                  $("#"+val.id).append(res);
              },
          })
      });      
    },
    error: function(xhr, Status, err) {
       showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
     } 
  });
});