<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SS2G</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fusioncharts-suite-xt/js/fusioncharts.js"></script>
    <script type="text/javascript" src="fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js"></script>
    <script type="text/javascript" src="fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js"></script>
    <script type="text/javascript" src="fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js"></script>
    <script type="text/javascript" src="fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js"></script>

</head>
<body>


<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("php-wrapper-master/src/fusioncharts.php");


$db = mysqli_connect('127.0.0.1','root','root','s2g');
if (mysqli_connect_errno()){
    echo 'Database Connection failed with following errors: ' . mysqli_connect_error();
    die();
}

if (empty($_GET['from']) or empty($_GET['to'])){
    header('Location: index.php');
}else{
    $from = $_GET['from'];
    $to = $_GET['to'];
}

$getTotalQuery = "SELECT amount FROM customers WHERE id BETWEEN '".$from."' AND '".$to."'";;
$getDebitQuery = "SELECT transc_date, amount FROM customers WHERE transc_type = 'debit' AND id BETWEEN '".$from."' AND '".$to."'";
$getCreditQuery = "SELECT transc_date, amount FROM customers WHERE transc_type = 'credit' AND id BETWEEN '".$from."' AND '".$to."'";

// Execute the query, or else return the error message.
$result = $db->query($getTotalQuery) or exit("Error code ({$db->errno}): {$db->error}");
$debitResult = $db->query($getDebitQuery) or exit("Error code ({$db->errno}): {$db->error}");
$debitResult2 = $db->query($getDebitQuery) or exit("Error code ({$db->errno}): {$db->error}");
$creditResult = $db->query($getCreditQuery) or exit("Error code ({$db->errno}): {$db->error}");

$totalAmount = 0;
$debitAmount = 0;
$creditRating = 0;




// If the query returns a valid response, prepare the JSON string
if ($debitResult) {
    // The `$arrData` array holds the chart attributes and data
    $arrData_debit = array(
        "chart" => array(
            "caption" => "Debit Chart",
            "paletteColors" => "#0075c2",
            "bgColor" => "#ffffff",
            "borderAlpha"=> "20",
            "canvasBorderAlpha"=> "0",
            "usePlotGradientColor"=> "0",
            "plotBorderAlpha"=> "10",
            "showXAxisLine"=> "1",
            "xAxisLineColor" => "#999999",
            "showValues" => "0",
            "divlineColor" => "#999999",
            "divLineIsDashed" => "1",
            "showAlternateHGridColor" => "0"
        )
    );

    $pieArrData_debit = array(
        "chart" => array(
            "caption" => "Pie Chart",
            "subcaption" =>  "Debit",
            "startingangle" =>  "120",
            "showlabels" =>  "0",
            "showlegend" =>  "1",
            "enablemultislicing" =>  "0",
            "slicingdistance" =>  "15",
            "showpercentvalues" =>  "1",
            "showpercentintooltip" =>  "0",
            "plottooltext" =>  "Age group : $"."label Total visit : $"."datavalue",
            "theme" =>  "ocean"
        )
    );

    $arrData_debit["data"] = array();
    $pieArrData_debit["data"] = array();

    // Push the data into the array
    while($row = mysqli_fetch_array($debitResult)) {
        array_push($arrData_debit["data"], array(
                "label" => $row["transc_date"],
                "value" => $row["amount"]
            )
        );

        array_push($pieArrData_debit["data"], array(
                "label" => $row["transc_date"],
                "value" => $row["amount"]
        ));
    }

    /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

    $jsonEncodedData = json_encode($arrData_debit);
    $jsonEncodedDataPie = json_encode($pieArrData_debit);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

    $columnChart = new FusionCharts("column2D", "chart-debit" , 1000, 500, "debit-bar", "json", $jsonEncodedData);
    $pie3dChart = new FusionCharts("pie3d", "pie-debit", "100%", 500, "debit-pie", "json", $jsonEncodedDataPie);

    // Render the chart
    $columnChart->render();
    $pie3dChart->render();

    // Close the database connection
//    $db->close();
}

if ($creditResult) {
    // The `$arrData` array holds the chart attributes and data
    $arrData_credit = array(
        "chart" => array(
            "caption" => "Credit Chart",
            "paletteColors" => "#0075c2",
            "bgColor" => "#ffffff",
            "borderAlpha"=> "20",
            "canvasBorderAlpha"=> "0",
            "usePlotGradientColor"=> "0",
            "plotBorderAlpha"=> "10",
            "showXAxisLine"=> "1",
            "xAxisLineColor" => "#999999",
            "showValues" => "0",
            "divlineColor" => "#999999",
            "divLineIsDashed" => "1",
            "showAlternateHGridColor" => "0"
        )
    );

    $pieArrData_credit = array(
        "chart" => array(
            "caption" => "Pie Chart",
            "subcaption" =>  "Credit",
            "startingangle" =>  "120",
            "showlabels" =>  "0",
            "showlegend" =>  "1",
            "enablemultislicing" =>  "0",
            "slicingdistance" =>  "15",
            "showpercentvalues" =>  "1",
            "showpercentintooltip" =>  "0",
            "plottooltext" =>  "Age group : $"."label Total visit : $"."datavalue",
            "theme" =>  "ocean"
        )
    );

    $arrData_credit["data"] = array();
    $pieArrData_credit["data"] = array();

    // Push the data into the array
    while($row = mysqli_fetch_array($creditResult)) {
        array_push($arrData_credit["data"], array(
                "label" => $row["transc_date"],
                "value" => $row["amount"]
            )
        );

        array_push($pieArrData_credit["data"], array(
                "label" => $row["transc_date"],
                "value" => $row["amount"]
        ));
    }

    /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

    $jsonEncodedData = json_encode($arrData_credit);
    $jsonEncodedDataPie = json_encode($pieArrData_credit);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

    $columnChart = new FusionCharts("column2D", "bar-credit" , 1000, 500, "credit-bar", "json", $jsonEncodedData);
    $pie3dChart = new FusionCharts("pie3d", "pie-credit", "100%", 500, "credit-pie", "json", $jsonEncodedDataPie);

    // Render the chart
    $columnChart->render();
    $pie3dChart->render();

    // Close the database connection
//    $db->close();
}


while($row = mysqli_fetch_assoc($debitResult2)){
    $debitAmount += $row['amount'];
}

while($row = mysqli_fetch_assoc($result)){
    $totalAmount += $row['amount'];
}
$creditRating = ($debitAmount / $totalAmount) * 100;
?>

<h2 class="text-center">CHARTS</h2>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <h4>CREDIT RATING = <?= floor($creditRating)."%"?></h4>
        </div>
        <div class="col-md-6 col-lg-6">
            <a href="index.php" class="pull-right btn btn-primary">Upload another spreadsheet</a>
        </div>
    </div>
    <br>
</div>


<div class="container">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Debit Chart</a></li>
        <li><a data-toggle="tab" href="#menu1">Credit Chart</a></li>
    </ul>

    <div class="tab-content">
        <br><br>
        <div id="home" class="tab-pane fade in active">
            <div class="live-chart-wrapper">
                <span id="debit-bar" class="chart" style="height:500px"><!-- Fusion Charts will render here--></span>
            </div>
            <br><br>
            <div class="live-chart-wrapper">
                <span id="debit-pie" class="chart" style="height:500px"><!-- Fusion Charts will render here--></span>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade">
            <div class="live-chart-wrapper">
                <span id="credit-bar" class="chart" style="height:500px"><!-- Fusion Charts will render here--></span>
            </div>
            <br><br>
            <div class="live-chart-wrapper">
                <span id="credit-pie" class="chart" style="height:500px"><!-- Fusion Charts will render here--></span>
            </div>
    </div>
</div>
    <br><br><br><br>

</body>
</html>
