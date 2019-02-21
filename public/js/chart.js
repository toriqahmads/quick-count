function chart(title, data)
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
  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "{valueY}";
  labelBullet.locationY = 0;

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
  /*var label = chart.createChild(am4core.Label);
  label.text = title;
  label.fontSize = 20;
  label.isMeasured = false;
  label.x = 100;
  label.y = -15;*/
}