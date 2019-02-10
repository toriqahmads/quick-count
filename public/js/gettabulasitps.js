    $(document).ready(function()
    {   
        var nama_kel;
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
                    });

                    $('#dapil').val(dap_id);
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
            nama_kel = $("#kel option:selected").text();
            
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

        $("#tps").change(function()
        {
            var ch = '<div class="card"><div class="card-header"><h5 class="title">Chart</h5></div><div class="card-body"><div class="row" id="chartcanvas"></div></div></div>';
            $("#chart").html(ch);
            var tps_id = $("#tps").val();
            var nama_tps = $("#tps option:selected").text();
            
            if(tps_id === '0' || tps_id === null || tps_id === undefined)
            {
                showNotification('top', 'right','Harap pilih TPS!', 'danger');
            }
            else
            {
              dap_id = $('#dapil').val();
              $.ajax({
                url: window.location.origin+"/data/partai/",
                type: "GET",
                success: function(html){
                  $.each(html, function(key, val)
                  {
                      $.ajax({
                          url: window.location.origin+"/suara/suarapartai/"+dap_id+"/"+val.id+"/"+tps_id,
                          type: "GET",
                          
                          success: function(data){
                              var res = "";
                              $.each(data, function(key, val2)
                              {
                                  res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.partai+'</label><input type="text" name="suarapartai['+val2.id_partai+']['+val2.id+']" class="form-control" value="'+val2.jumlah_suara+'" placeholder="'+val2.partai+'" disabled></div></div>';
                              });
                              
                              $.ajax({
                                  url: window.location.origin+"/suara/suaracaleg/"+dap_id+"/"+val.id+"/"+tps_id,
                                  type: "GET",
                                  
                                  success: function(data){                    
                                      $.each(data, function(key, val3)
                                      {
                                          res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'</label><input type="text" name="suara['+val3.id_partai+']['+val3.id_caleg+']['+val3.id+']" class="form-control" value="'+val3.jumlah_suara+'" placeholder="'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'" disabled></div></div>';
                                      });

                                      $("#"+val.id).html(res);
                                      var total = 0;
                                      $("#"+val.id+" :input").each(function(){
                                           total = total + parseInt($(this).val());
                                      });
                                      res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-12 px-1"><input type="text" class="btn-info btn btn-round btn-block" value="'+total+'" name="total" disabled="true"></div>';
                                      $("#"+val.id).html(res);
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
                  });
                },
                error: function(xhr, Status, err) {
                   showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                 } 
              });

              $.ajax({
                  url: window.location.origin+"/suara/suarapartaibytpsforchart/"+dap_id+"/"+tps_id,
                  type: "GET",
                  
                  success: function(data){
                      var datas = [];
                      $.each(data, function(key, val)
                      {
                        var a = {"name": val.name, "data": [parseInt(val.data)]};
                        datas.push(a);
                      });
                      $("#chart").prop("hidden", false);
                      console.log(datas);                   
                      chartPartai(datas, nama_kel, nama_tps);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   }
              });
            }
            return false;
        });
    });

    function chartPartai(datas, kel, tps)
    {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            title: {
                text: 'Total Perolehan Suara pada kelurahan ' + kel + ' di ' + tps
            },

            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'flat', // flat, rounded, arrow
                    columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: datas,
            xaxis: {
                categories: [kel + ' : ' + tps],
            },
            yaxis: {
                title: {
                    text: 'Suara'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " suara"
                    }
                }
            }
        }

        
        var chart = new ApexCharts(
            document.querySelector("#chartcanvas"),
            options
        );

        chart.render();
    }