<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die('Not Fine!!');
}
$data = file_get_contents('php://input');

$testData = json_decode($data);

$jsondata = $testData;
$amount = $jsondata->additional_data->amount->amount;
$currency = $jsondata->additional_data->amount->currency;
$hash = $jsondata->additional_data->hash;

$text = "deposite recived amount : $amount and currency = $currency and finally hash = $hash";
file_put_contents('data.txt', $text);
?>

//You can use database instead of file_put_contents also!
