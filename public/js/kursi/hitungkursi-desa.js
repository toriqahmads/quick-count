$(document).ready(function()
{
    $("#prov").change(function()
      {
          var tingkat = $("#tingkat").val();
          var prov = $("#prov").val();
          if(prov === '0' || prov === null || prov === undefined || prov == '' || prov == 0)
          {
              showNotification('top', 'right','Harap pilih provinsi!', 'danger');
          }
          else
          {
            if(tingkat == 'd' || tingkat == 'c')
            {
              var dapilnya = tingkat == 'c' ? 'b' : 'c';
              $.ajax({
                url: window.location.origin+"/data/dapilprov/" + prov + "/" + dapilnya,
                type: "GET",
                success: function(html){
                  var res = '<option value="0" selected>Pilih Dapil</option>';
                  $.each(html, function(key, val)
                  {
                    res = res + "<option value='" + val.id +"'>" + val.dapil + "</option>";
                  });
                  $("#dapil").html(res);
                  $('#kab').hide();
                },
                error: function(xhr, Status, err) {
                   showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                 } 
              });
          }
          else if(tingkat == 'e')
          {
            $('#kab').empty().append('<option selected value="0">Pilih kabupaten</option>');
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
            url: window.location.origin+"/data/dapilkab/" + prov + "/" + kab + "/d",
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
            url: window.location.origin+"/kursi2/"+dapil+"/"+tingkat,
            type: "GET",
            success: function(datas){
              $("#table").html(datas);
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
             }
          });
      }
      return false;
  });

  $(document).on("click", "#hitung", function(e)
  {
    e.preventDefault();
    var dapil = $("#dapil").val();
      if(dapil === '0' || dapil === null || dapil === undefined || dapil == '' || dapil == 0)
      {
          showNotification('top', 'right','Harap pilih dapil!', 'danger');
      }
      else
      {
          tingkat = $("#tingkat").val();
          $.ajax({
            url: window.location.origin+"/kursi2/hitung/"+dapil+"/"+tingkat,
            type: "GET",
            success: function(datas){
              $("#kursi").html(datas);
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
             }
          });
      }
      return false;
    });

  $(document).on("click", "#winner", function(e)
  {
    e.preventDefault();
    var dapil = $("#dapil").val();
      if(dapil === '0' || dapil === null || dapil === undefined || dapil == '' || dapil == 0)
      {
          showNotification('top', 'right','Harap pilih dapil!', 'danger');
      }
      else
      {
          tingkat = $("#tingkat").val();
          $.ajax({
            url: window.location.origin+"/kursi2/winner",
            type: "POST",
            data: $('#winnerform').serialize() + "&dapil="+dapil+"&tingkat="+tingkat,
            success: function(datas){
              $("#pemenang").html(datas);
            },
            error: function(xhr, Status, err) {
               showNotification('top', 'right','Terjadi error : '+ err, 'danger');
             }
          });
      }
      return false;
    });
});   