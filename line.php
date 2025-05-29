<?php

$access_token='bhiZ2IDh21XqkjupJZCbW/yfaZ5EoH8aisZCzLj6kLWkOy0ydO9E8vdM9Wz1TBcVxMCwuUikLa2LIOnqrDIphbzFpVRZm/LPnS/Jt3tFh5TKltYOWugRTTvkLLniMbRQQZ75wjQYjpxZoPNBjjBVTAdB04t89/1O/w1cDnyilFU=';
$userId = 'Ce62421bae012eba889d1d0c8bc0429fa';
$message = 'สวัสดีจาก PHP LINE API!';

$url = 'https://api.line.me/v2/bot/message/push';

$data = [
    'to' => $userId,
    'messages' => [
        ['type' => 'text', 'text' => $message]
    ]
];

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$result = curl_exec($ch);
curl_close($ch);

//echo $result;
