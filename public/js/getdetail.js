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
                $('#tps').empty().append('<option selected value="0">Pilih TPS</option>');
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
            if(kec_id === '0' || kec_id === null || kec_id === undefined || kec_id == '' || kec_id == 0)
            {
                showNotification('top', 'right','Harap pilih kecamatan!', 'danger');
            }
            else
            {
                $('#kel').empty().append('<option selected value="0">Pilih kelurahan</option>');
                $('#tps').empty().append('<option selected value="0">Pilih TPS</option>');
                $.ajax({
                  url: window.location.origin+"/data/kel/" + kec_id,
                  type: "GET",
                  success: function(html){
                    var res = "<option value='0'>Kelurahan</option>";
                    $.each(html, function(key, val)
                    {
                        res = res + "<option value='" + val.id_kel +"'>" + val.kel + "</option>";
                    });
                    $('#kel').html(res);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                   } 
                });
            }
            return false;
        });

        $("#kel").on('change', function()
        {
            var kel_id = $("#kel").val();
            
            if(kel_id === '0' || kel_id === null || kel_id === undefined)
            {
                showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
            }
            else
            {
                $('#tps').empty().append('<option selected value="0">Pilih TPS</option>');
                $.ajax({
                  url: window.location.origin+"/data/tps/" + kel_id,
                  type: "GET",
                  success: function(html){

                    var res = "<option value'0'>Pilih TPS</option>";
                    $.each(html, function(key, val)
                    {
                        res = res + "<option value='" + val.id_tps +"'>" + val.tps + "</option>";
                    });
                    $("#tps").html(res);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ err, 'danger');
                   } 
                });
            }
            return false;
        });
    });