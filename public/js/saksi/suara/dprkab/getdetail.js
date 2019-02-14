$(document).ready(function()
{
  var tingkat = $("#tingkat").val();
  var id_prov = $("#prov").val();
  var id_kab = $("#kab").val();
  var id_kec = $("#kec").val();
  var id_kel = $("#kel").val();
  var tps_id = $("#tps").val();
  var saksi = $("#saksi").val();
  var dap_id = $("#dapil").val();
  
  $.ajax({
    url: window.location.origin+"/data/partai/",
    type: "GET",
    success: function(html)
    {
      $.each(html, function(key, val)
      {
          $.ajax({
              url: window.location.origin+"/data/caleg/"+dap_id+"/"+val.id+"/e",
              type: "GET",
              
              success: function(data){
                  var res = "";
                  res = '<div class="col-md-12 pl-1"><div class="form-group"><label>'+data[0]['partai']+'</label><input type="text" name="suarapartai['+data[0]['id_partai']+']" class="form-control" placeholder="Suara Partai"></div></div>';
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
});