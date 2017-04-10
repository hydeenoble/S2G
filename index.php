<?php
require_once 'action.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SS2G</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-filestyle.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">SS2G</a>
        </div>
    </div>
</nav>
<div class="container-fluid bg">
    <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-7">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                <h2 class="text-center">Upload SpreadSheet</h2>
                <p class="text-danger text-center" style="font-size: 16px"><b><?= $error; ?></b></p>
                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary span-btn">
                        Browse&hellip; <input type="file" style="display: none;" name="excel_file" id="excel_file">
                    </span>
                    </label>
                    <input type="text" class="form-control span-text" readonly>
                    <label class="input-group-btn">
                    <span class="btn btn-primary span-btn">
                        Generate Graph <input type="submit" style="display: none;" name="submit">
                    </span>
                    </label>
                </div>
            </form>


        </div>

        <div class="col-md-5 how-to-wrapper">
            <h2 class="text-center heading">Getting Started</h2>
            <hr style="border-color: #0e0e0e">
            <p class="text">S2G is a platform that generates graphs from an upload Spreadsheet.</p>
            <p class="text">S2G (version 1.0.0) only accepts Spreadsheets with .xlsx and xlx extensions with the first two columns as String Data type (e.g. first name and laste name) and the thrid coumn as an Integer (e.g. 34, 43 e.t.c)</p>
            <br>
            <h4>Example 1</h4>
            <table class="table table-bordered">
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Score</th>
                </tr>
                <tr>
                    <td>Emehinola</td>
                    <td>Idowu</td>
                    <td>99</td>
                </tr>
                <tr>
                    <td>Hydee</td>
                    <td>Noble</td>
                    <td>82</td>
                </tr>
            </table>

            <h4>Example 2</h4>
            <table class="table table-bordered">
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Age</th>
                </tr>
                <tr>
                    <td>Emehinola</td>
                    <td>Idowu</td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>Hydee</td>
                    <td>Noble</td>
                    <td>21</td>
                </tr>
            </table>
        </div>
    </div>

</div>
<script>
    $(function() {

        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });

    });
</script>
</body>
</html>