<?php header('Access-Control-Allow-Origin: *'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>ChartJS - LineGraph</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">SS2G</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center">RESULTS</h2>
    <hr>
    <div class="row">
        <div class="col-md-4 col-lg-4 top-div credit-rating-div">
            <h4 id="credit-rating" >CREDIT RATING = </h4>
            <span class="tooltiptext">
                A credit rating is an evaluation of the credit risk of a prospective debtor
                (an individual, a business, company or a government), predicting their ability
                to pay back the debt, and an implicit forecast of the likelihood of the debtor
                defaulting. <br><br>
                it is calculated as follows:
                <br><br>
                TAD = total amount debited <br>
                TAT = total amount in transaction (debit + credit) <br>
                CR = credit rating <br><br>
                CR = (TAD / TAT) * 100%.<br><br>

                CR less than 40% signifies bad credit rating (likelihood of the debtor defaulting and 50% chance of paying back). <br><br>
                CR greater than 40% but less than 70% signifies a fair credit rating (50% chance of defaulting). <br><br>
                CR greater than 70% signifies a good credit rating (ability
                to pay back the debt). <br>

            </span>
        </div>
        <div class="col-md-4 col-lg-4 top-div">
            <h4 id="total-credit">TOTAL CREDIT = &#8358; </h4>
        </div>
        <div class="col-md-4 col-lg-4">
            <h4 id="total-debit">TOTAL DEBIT = &#8358; </h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 col-lg-12  credit-canvas">
            <canvas id="credit-canvas"></canvas>
        </div>
        <div class="col-md-12  col-lg-12 debit-canvas">
            <canvas id="debit-canvas"></canvas>
        </div>
    </div>
    <div class="col-md-12">
        <br><br>
        <a href="index.php" class="pull-right btn btn-primary">Upload another spreadsheet</a>
    </div>
</div>

<!-- javascript -->
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<script type="text/javascript" src="js/Chart.min.js"></script>
<script type="text/javascript" src="js/linegraph.js"></script>
</body>
</html>