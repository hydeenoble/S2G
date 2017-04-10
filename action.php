<?php
/**
 * Created by PhpStorm.
 * User: hydee
 * Date: 3/14/17
 * Time: 12:43 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'Classes/PHPExcel.php';

$db = mysqli_connect('127.0.0.1','root','root','s2g');
if (mysqli_connect_errno()){
    echo 'Database Connection failed with following errors: ' . mysqli_connect_error();
    die();
}

$allowed_extensions = array('xls','xlsx');
$error = "";

if (isset($_POST['submit'])){

    $id_sql = "SELECT MAX(Id) FROM customers";
    $last_table_row = mysqli_fetch_assoc($db->query($id_sql));
    $last_table_id = $last_table_row['MAX(Id)'] + 1;

//    echo $last_table_id . "jsfkjfs";
//    var_dump($_FILES['excel_file']);

    if   ($_FILES['excel_file']['size'] > 0){
//        var_dump($_FILES['excel_file']);
        $file = explode(".", $_FILES['excel_file']['name']);
        $extension = array_pop($file);

        if (in_array($extension, $allowed_extensions)) {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES["excel_file"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            move_uploaded_file($_FILES["excel_file"]["tmp_name"], $target_file);

            if (chmod($target_file, 0777)){
                $inputFileName = $target_file;
                //  Read your Excel workbook
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch(Exception $e) {
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                }

//  Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestDataColumn();

                for ($row = 2; $row <= $highestRow; $row++) {
                    //  Read a row of data into an array
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $sql = "INSERT INTO customers (transc_date,amount,transc_type) VALUES('".$rowData[0][0]."','".$rowData[0][1]."','".$rowData[0][2]."')";

                    if ($db->query($sql) === FALSE) {
                        echo "Error: " . $sql . "<br>" . $db->error;
                    }
                }

//    print_r($response);

                unlink($target_file);

                $last_inserted_id = $db->insert_id;

                header("Location: chart.html?from=$last_table_id&to=$last_inserted_id");
            }
        }else{
            $error = "You are trying to upload a ". strtoupper($extension) ." file. Please only .xlsx and .xls files are allowed";
        }
    }else{
        $error = "No file selected";
    }
}
