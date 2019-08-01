<?php

if (!empty($_REQUEST)) {
    $headers = [
        'Content-Type: application/x-www-form-urlencoded'
    ];

    $url = $_REQUEST['url'];
    $fields = json_decode($_REQUEST['jsonData'], true);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
    curl_exec($ch);
    curl_close($ch);
}
?>