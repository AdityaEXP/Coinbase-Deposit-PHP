<?php

function createNewAddress($private_key, $api_key , $name , $URL, $account_id){
    $json = new stdClass();
    $json->method = "POST";
    $json->path = "/v2/accounts/".$account_id."/addresses";
    $json->secretapikey = $private_key;
    $json->apikey = $api_key;

    $body = new stdClass();
    $body->name = $name;

    $result = json_encode($json);
    $body = json_encode($body);
    $time= time();
    $sign = $time.$json->method.$json->path.$body;
    $hmac = hash_hmac("SHA256", $sign, $json->secretapikey);

    $header = array(
        "CB-ACCESS-KEY:".$api_key,
        "CB-ACCESS-SIGN:".$hmac,
        "CB-ACCESS-TIMESTAMP:".time(),
        "CB-VERSION:2019-11-15",
        "Content-Type:application/json"
    );

    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

$account_id = '31535d53-xxxx'; //Coinbase Account ID
$private_key = 'Doadlrxxxx'; //Coinbase Private Key
$api_key = 'ysEZjxxxx'; //Coinbase API KEY
$name = '1798520510'; //User TgId to add balance
$currency = 'LTC'; //Crypto To Send

$url = "https://api.coinbase.com/v2/accounts/$account_id/addresses";


$result = createNewAddress(
    $private_key,
    $api_key,
    $name,
    $url,
    $account_id
);
$finalResult = json_decode($result);
print_r("$currency : ".$finalResult->data->address);
?>
