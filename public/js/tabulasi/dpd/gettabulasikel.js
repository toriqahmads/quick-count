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
        if(kab === '0' || kab === null || kab === undefined || kab == '' || kab == 0)
        {
            showNotification('top', 'right','Harap pilih kabupaten!', 'danger');
        }
        else
        {
            $('#kec').empty().append('<option selected value="0">Pilih kecamatan</option>');
            $('#kel').empty().append('<option selected value="0">Pilih kelurahan</option>');
            $('#tps').empty().append('<option selected value="0">Pilih TPS</option>');
            $('#dapil').empty().append('<option selected value="0">Pilih Dapil</option>');
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

  $("#kel").on('change', function()
  {
      var kel_id = $("#kel").val();
      
      if(kel_id === '0' || kel_id === null || kel_id === undefined || kel_id == '' || kel_id == 0)
      {
        showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
      }
      else
      {
        tingkat = $("#tingkat").val();
        $.ajax({
          url: window.location.origin+"/tabulasi/partai/kel/"+kel_id+"/"+tingkat,
          type: "GET",
          
          success: function(data){
              $.each(data, function(key, val)
              {
                var res = "";
                $.ajax({
                  url: window.location.origin+"/tabulasi/caleg/kel/"+val.id_partai+"/"+kel_id+"/"+tingkat,
                  type: "GET",
                  success: function(data){
                      res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val.partai+'</label><input type="number" name="suarapartai['+val.id_partai+']['+val.id+']" class="form-control" value="'+val.total_suara+'" placeholder="'+val.partai+'" disabled></div></div>';                    
                      $.each(data, function(key, val2)
                      {
                          res = res + '<div class="col-md-12 px-1"><div class="form-group"><label>'+val2.nama_depan_caleg+' '+val2.nama_belakang_caleg+'</label><input type="number" name="suara['+val2.id_partai+']['+val2.id_caleg+']['+val2.id+']" class="form-control" value="'+val2.total_suara+'" placeholder="'+val2.nama_depan_caleg+' '+val2.nama_belakang_caleg+'" disabled></div></div>';
                      });

                      $("#"+val.id_partai).html(res);
                      var total = 0;
                      $("#"+val.id_partai+" :input").each(function(){
                           total = total + parseInt($(this).val());
                      });
                      res = res + '<div class="input-group form-group-no input-lg"><div class="col-md-12 px-1"><input type="text" class="btn-info btn btn-round btn-block" value="'+total+'" name="total" disabled="true"></div>';
                      $("#"+val.id_partai).html(res);
                      delete res;
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   }
                });
              });
              chart(data);
              $("#chartdiv").prop("hidden", false);
          },
          error: function(xhr, Status, err) {
             showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
           }
      });
      }
      return false;
  });
});   

function chart(data)
{
  am4core.useTheme(am4themes_animated)
  var chart = am4core.create("chart", am4charts.XYChart);

  // Add data
  chart.data = data;

  // Create axes

  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "partai";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.minGridDistance = 30;

  categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
    if (target.dataItem && target.dataItem.index & 2 == 2) {
      return dy + 25;
    }
    return dy;
  });

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

  // Create series
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = "total_suara";
  series.dataFields.categoryX = "partai";
  series.name = "Total Suara";
  series.columns.template.column.cornerRadiusTopLeft = 10;
  series.columns.template.column.cornerRadiusTopRight = 10;
  series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
  series.columns.template.fillOpacity = .8;

  var columnTemplate = series.columns.template;
  columnTemplate.strokeWidth = 2;
  columnTemplate.strokeOpacity = 1;

  let hoverState = series.columns.template.column.states.create("hover");
  hoverState.properties.cornerRadiusTopLeft = 0;
  hoverState.properties.cornerRadiusTopRight = 0;
  hoverState.properties.fillOpacity = 1;

  series.columns.template.adapter.add("fill", (fill, target)=>{
    return chart.colors.getIndex(target.dataItem.index);
  })
  chart.cursor = new am4charts.XYCursor();
  chart.exporting.menu = new am4core.ExportMenu();
}