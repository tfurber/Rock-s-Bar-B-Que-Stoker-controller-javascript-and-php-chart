<?php
echo "<PRE>";
$contents = file_get_contents("data.txt");

#print_r($contents);
#exit;

$outputarr = json_decode("{".$contents."}", true);
#var_dump($outputarr);
#exit;


?>

<html>
  <head>
<meta http-equiv="refresh" content="30">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['YYYYmmDD HH:MM', 'domeactual','dometarget','meatactual','meatarget', 'blower'],

<?php
$i=0;

foreach($outputarr as $key => $subarr) {

        foreach($subarr as $thisdate => $subarr2) {
                $i++;
                $domeactual = $subarr2["sensors"][1]["tc"];
                $dometarget = $subarr2["sensors"][1]["ta"];
                $meattactual = $subarr2["sensors"][0]["tc"];
                $meattarget = $subarr2["sensors"][0]["ta"];

                if ($subarr2["blowers"][0]["on"] == 1) {
                        $blower = 1;
                } else {
                        $blower = 0;
                }

                echo "['$thisdate',$domeactual,$dometarget, $meattactual,$meattarget,$blower]";
                if ($i < count($outputarr)) {
                        echo ",";
                }
        }
}
?>

      ]);

    var options = {
      title : 'stoker temp over time',
      vAxis: {
        0: {title: 'AA'},
        1: {title: 'BB'}
        },

      hAxis: {title: 'Year-Month-Day',direction: 1},
      seriesType: 'bars',
      series: {

  0: {type: "line", color: "black", pointSize: 5, lineWidth: 3},
  1: {type: "line", color: "orange", pointSize: 5, lineWidth: 3},
  2: {type: "line", color: "green", pointSize: 5, lineWidth: 3},
  3: {type: "line", color: "blue", pointSize: 5, lineWidth: 3},
  4: {type: "bar", color: "Red", targetAxisIndex: 1,}
        },
        legend: { position: "top" },
        orientation: "horizontal" ,
        chartArea: {width: "80%", height: "80%"},
        isStacked: true
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 1600px; height: 801px;"></div>
<div id=main>

<?php

krsort($outputarr);
$z=0;
foreach($outputarr as $key => $subarr) {

        foreach($subarr as $thisdate => $subarr2) {
                $z++;
                if ($z == 100) { exit; }
                $domeactual = number_format($subarr2["sensors"][1]["tc"],2);
                $dometarget = number_format($subarr2["sensors"][1]["ta"],2);
                $meattactual = number_format($subarr2["sensors"][0]["tc"],2);
                $meattarget = number_format($subarr2["sensors"][0]["ta"],2);

                if ($subarr2["blowers"][0]["on"] == 1) {
                        $blower = 1;
                } else {
                        $blower = 0;
                }
                echo "<br>when:$thisdate domeactual:$domeactual dometarget:$dometarget meattactual:$meattactual meattarget:$meattarget blower:$blower";
        }
}
?>


</div>

</body>
</html>

