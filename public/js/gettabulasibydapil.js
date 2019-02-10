    $(document).ready(function()
    {
        $("#dapil").change(function()
        {
            var ch = '<div class="card"><div class="card-header"><h5 class="title">Chart</h5></div><div class="card-body"><div class="row" id="chartcanvas"></div></div></div>';
            $("#chart").html(ch);
            var dapil = $("#dapil").val();
            var nama_partai = [];

            if(dapil === '0' || dapil === null || dapil === undefined)
            {
                showNotification('top', 'right','Harap pilih dapil!', 'danger');
            }
            else
            {
                $.ajax({
                url: window.location.origin+"/data/partai/",
                type: "GET",
                success: function(html){
                  $.each(html, function(key, val)
                  {
                      $.ajax({
                          url: window.location.origin+"/suara/suarapartaibydapil/"+dapil+"/"+val.id,
                          type: "GET",
                          
                          success: function(data){
                              var res = "";
                              
                              $.each(data, function(key, val2)
                              {
                                  nama_partai.push(val2.partai);
                                  res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.partai+'</label><input type="text" name="suarapartai['+val2.id_partai+']['+val2.id+']" class="form-control" value="'+val2.total_suara+'" placeholder="'+val2.partai+'" disabled></div></div>';
                              });
                              
                              $.ajax({
                                  url: window.location.origin+"/suara/suaracalegbydapil/"+dapil+"/"+val.id,
                                  type: "GET",
                                  
                                  success: function(data){                  
                                      $.each(data, function(key, val3)
                                      {
                                          res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'</label><input type="text" name="suara['+val3.id_partai+']['+val3.id_caleg+']['+val3.id+']" class="form-control" value="'+val3.total_suara+'" placeholder="'+val3.nama_depan_caleg+' '+val3.nama_belakang_caleg+'" disabled></div></div>';
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
                  url: window.location.origin+"/suara/suarapartaibydapilforchart/"+dapil,
                  type: "GET",
                  
                  success: function(data){
                      var datas = [];
                      $.each(data, function(key, val)
                      {
                        var a = {"name": val.name, "data": [parseInt(val.data)]};
                        datas.push(a);
                      });
                      $("#chart").prop("hidden", false);
                                          
                      chartPartai(datas, nama_partai, dapil);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   }
              });
            }
            return false;
        });
    });

    function chartPartai(datas, nama, dapil)
    {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            title: {
                text: "Chart Perolehan Total Suara Partai pada Dapil "+dapil
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
                categories: ['Total Perolehan Suara pada Dapil ' + dapil],
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