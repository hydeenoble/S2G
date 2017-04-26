<?php
/**
 * Created by PhpStorm.
 * User: hydee
 * Date: 4/10/17
 * Time: 4:05 PM
 */
header('Access-Control-Allow-Origin: *');

error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = mysqli_connect('127.0.0.1', 'root', 'root', 's2g');
if (mysqli_connect_errno()) {
    echo 'Database Connection failed with following errors: ' . mysqli_connect_error();
    die();
}

if (empty($_GET['from']) or empty($_GET['to'])) {
    header('Location: index.php');
} else {
    $from = $_GET['from'];
    $to = $_GET['to'];
}

$data = array();

$getTotalQuery = "SELECT amount FROM customers WHERE id BETWEEN '" . $from . "' AND '" . $to . "'";
$getDebitQuery = "SELECT transc_date, amount FROM customers WHERE transc_type = 'debit' AND id BETWEEN '" . $from . "' AND '" . $to . "'";
$getCreditQuery = "SELECT transc_date, amount FROM customers WHERE transc_type = 'credit' AND id BETWEEN '" . $from . "' AND '" . $to . "'";

// Execute the query, or else return the error message.
$result = $db->query($getTotalQuery) or exit("Error code ({$db->errno}): {$db->error}");
$debitResult = $db->query($getDebitQuery) or exit("Error code ({$db->errno}): {$db->error}");
$creditResult = $db->query($getCreditQuery) or exit("Error code ({$db->errno}): {$db->error}");

$totalAmount = 0;
$debitAmount = 0;
$creditRating = 0;
$creditAmount = 0;
$data['debit'][] = [];
$data['credit'][] = [];

foreach ($debitResult as $row) {
    $data['debit'][] = $row;
}

foreach ($creditResult as $row) {
    $data['credit'][] = $row;
}

$debitResult2 = $db->query($getDebitQuery) or exit("Error code ({$db->errno}): {$db->error}");

while ($row = mysqli_fetch_assoc($debitResult2)) {
    $debitAmount += $row['amount'];
}
$creditResult2 = $db->query($getCreditQuery) or exit("Error code ({$db->errno}): {$db->error}");
while ($row = mysqli_fetch_assoc($creditResult2)) {
    $creditAmount += $row['amount'];
}

while ($row = mysqli_fetch_assoc($result)) {
    $totalAmount += $row['amount'];
}
if ($creditAmount < 1) {
    $data['credit'][] = [];
}
if ($debitAmount < 1) {
    $data['debit'][] = [];
}

$data['total_credit'] = $creditAmount;
$data['total_debit'] = $debitAmount;
$data['credit_rating'] = ($debitAmount / $totalAmount) * 100;

print json_encode($data);