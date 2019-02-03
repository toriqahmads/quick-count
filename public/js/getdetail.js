    $(document).ready(function()
    {
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
                        dap_id = val.id_dapil;
                        $('#dapil').val(dap_id);
                    });

                    $.ajax({
                      url: window.location.origin+"/data/partai/",
                      type: "GET",
                      success: function(html){

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
                $.ajax({
                  url: window.location.origin+"/data/tps/" + kel_id,
                  type: "GET",
                  success: function(html){

                    var res = "<option value'0'>TPS</option>";
                    $.each(html, function(key, val)
                    {
                        res = res + "<option value='" + val.id_tps +"'>" + val.tps + "</option>";
                    });
                    $("#tps").html(res);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   } 
                });
            }
            return false;
        });
    });