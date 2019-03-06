    $(document).ready(function()
    {
        $("#tingkat").on("change", function()
        {
            var tingkat = $("#tingkat").val();
            if(tingkat === '0' || tingkat === null || tingkat === undefined || tingkat === 0 || tingkat == '')
            {
                showNotification('top', 'right','Harap pilih tingkat!', 'danger');
            }
            else
            {
                if(tingkat == 'b' || tingkat == 'c' || tingkat == 'd' || tingkat == 'e')
                {
                    $.ajax({
                      url: window.location.origin+"/data/prov",
                      type: "GET",
                      success: function(html){

                        var res = '<option value="0" selected>Pilih provinsi</option>';
                        $.each(html, function(key, val)
                        {
                            res = res + "<option value='" + val.id +"'>" + val.prov + "</option>";
                        });
                        $(".prov").prop('hidden', false);
                        $("#prov").prop('disabled', false);
                        $("#prov").html(res);
                      },
                      error: function(xhr, Status, err) {
                         showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                       } 
                    });

                    if(tingkat == 'b')
                    {
                      $("#kab").prop('disabled', true);
                      $("#kec").prop('disabled', true);
                    }
                    else if(tingkat == 'c' || tingkat == 'd')
                    {
                      $("#kec").prop('disabled', true);
                    }
                    $(".kab").prop('hidden', true);
                    $(".kec").prop('hidden', true);
                    $(".dapil").prop('hidden', true);
                }
                else if(tingkat == 'a')
                {
                    $(".prov").prop('hidden', true);
                    $(".kab").prop('hidden', true);
                    $(".kec").prop('hidden', true);
                    $(".dapil").prop('hidden', true);
                    $("#prov").prop('disabled', true);
                    $("#kab").prop('disabled', true);
                    $("#kec").prop('disabled', true);
                    $("#dapil").prop('disabled', true);
                }
                
            }
            return false;
        });

        $("#prov").on("change", function()
        {
            var prov = $("#prov").val();
            var tingkat = $("#tingkat").val();
            if(prov === '0' || prov === null || prov === undefined || prov === 0 || prov == '')
            {
                showNotification('top', 'right','Harap pilih kab!', 'danger');
            }
            else
            {
                if(tingkat == 'b')
                {
                    $.ajax({
                      url: window.location.origin+"/data/dapilprov/" + prov + "/a",
                      type: "GET",
                      success: function(html){

                        var res = '<option value="0" selected>Pilih dapil</option>';
                        $.each(html, function(key, val)
                        {
                            if(prov == val.id_prov)
                            {
                                res = res + "<option value='" + val.id +"' selected>" + val.dapil + "</option>";
                            }
                            else
                            {
                                res = res + "<option value='" + val.id +"'>" + val.dapil + "</option>";
                            }
                            
                        });
                        $(".dapil").prop('hidden', false);
                        $("#dapil").prop('disabled', false);
                        $("#dapil").html(res);
                      },
                      error: function(xhr, Status, err) {
                         showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                       } 
                    });
                }

                if(tingkat == 'c' || tingkat == 'd' || tingkat == 'e')
                {
                    $.ajax({
                      url: window.location.origin+"/data/kab/" + prov,
                      type: "GET",
                      success: function(html){
                        var res = '<option value="0" selected>Pilih kabupaten</option>';
                        $.each(html, function(key, val)
                        {
                            res = res + "<option value='" + val.id +"'>" + val.kab + "</option>";
                        });
                        $(".kab").prop('hidden', false);
                        $("#kab").prop('disabled', false);
                        $("#kab").html(res);
                      },
                      error: function(xhr, Status, err) {
                         showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                       } 
                    });
                }
            }
            return false;
        });

        $("#kab").on("change", function()
        {
            var prov = $("#prov").val();
            var kab = $("#kab").val();
            var tingkat = $("#tingkat").val();
            if(kab === '0' || kab === null || kab === undefined || kab === 0 || kab == '')
            {
                showNotification('top', 'right','Harap pilih kabupaten!', 'danger');
            }
            else
            {
                if(tingkat == 'd' || tingkat == 'c')
                {
                  var jenis_dapil = tingkat == 'c' ? 'b' : 'c';
                    $.ajax({
                      url: window.location.origin+"/data/dapilprov/" + prov + "/" + jenis_dapil,
                      type: "GET",
                      success: function(html){
                        $.ajax({
                          url: window.location.origin+"/data/kabid/" + kab,
                          type: "GET",
                          success: function(data){
                            var res = '<option value="0" selected>Pilih dapil</option>';
                            $.each(html, function(key, val)
                            {
                              var dapilnya = tingkat == 'c' ? 'dapil_dprri' : 'dapil_dprprov';
                                if(data[0][dapilnya] == val.id)
                                {
                                    res = res + "<option value='" + val.id +"' selected>" + val.dapil + "</option>";
                                }
                                else
                                {
                                    res = res + "<option value='" + val.id +"'>" + val.dapil + "</option>";
                                }
                                
                            });
                            $(".dapil").prop('hidden', false);
                            $("#dapil").prop('disabled', false);
                            $("#dapil").html(res);
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

                if(tingkat == 'e')
                {
                    $.ajax({
                      url: window.location.origin+"/data/kec/" + kab,
                      type: "GET",
                      success: function(html){
                        var res = '<option value="0" selected>Pilih kecamatan</option>';
                        $.each(html, function(key, val)
                        {
                            res = res + "<option value='" + val.id_kec +"'>" + val.kec + "</option>";   
                        });
                        $(".kec").prop('hidden', false);
                        $("#kec").prop('disabled', false);
                        $(".dapil").prop('hidden', true);
                        $("#dapil").prop('disabled', true);
                        $("#kec").html(res);
                      },
                      error: function(xhr, Status, err) {
                         showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                       } 
                    });
                }
            }
            return false;
        });

        $("#kec").on("change", function()
        {
            var prov = $("#prov").val();
            var kab = $("#kab").val();
            var kec = $("#kec").val();
            var tingkat = $("#tingkat").val();
            if(kec === '0' || kec === null || kec === undefined || kec === 0 || kec == '')
            {
                showNotification('top', 'right','Harap pilih kecamatan!', 'danger');
            }
            else
            {
                if(tingkat == 'e')
                {
                    $.ajax({
                      url: window.location.origin+"/data/dapilkab/" + prov + "/" + kab + "/d",
                      type: "GET",
                      success: function(html){
                        $.ajax({
                          url: window.location.origin+"/data/kecid/" + kec,
                          type: "GET",
                          success: function(data){
                            var res = '<option value="0">Pilih dapil</option>';
                            $.each(html, function(key, val)
                            {
                                if(data[0]['id_dapil'] == val.id)
                                {
                                    res = res + "<option value='" + val.id +"' selected>" + val.dapil + "</option>";
                                }
                                else
                                {
                                    res = res + "<option value='" + val.id +"'>" + val.dapil + "</option>";
                                }
                                
                            });
                            $(".dapil").prop('hidden', false);
                            $("#dapil").prop('disabled', false);
                            $("#dapil").html(res);
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
            }
            return false;
        });

        $("#gender").change(function()
        {
            var gender = $("#gender").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih jenis kelamin!', 'danger');
            }
            else
            {
                return false;
            }
        });

        $("#partai").change(function()
        {
            var gender = $("#partai").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih partai!', 'danger');
            }
            else
            {
                return false;
            }
        });
    });