<?php
header("Content-Type: application/json");

$url = "https://www.tesla.com/inventory/api/v4/inventory-results?query=" . urlencode(json_encode([
    "query" => [
        "model" => "my",
        "condition" => "new",
        "options" => new stdClass(),
        "arrangeby" => "Price",
        "order" => "asc",
        "market" => "TR",
        "language" => "tr",
        "super_region" => "north america",
        "lng" => 28.9533,
        "lat" => 41.0145,
        "zip" => "34096",
        "range" => 0,
        "region" => "TR"
    ],
    "offset" => 0,
    "count" => 24,
    "outsideOffset" => 0,
    "outsideSearch" => false,
    "isFalconDeliverySelectionEnabled" => true,
    "version" => "v2"
]));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Referer: https://www.tesla.com/",
    "Origin: https://www.tesla.com",
    "x-requested-with: XMLHttpRequest"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    http_response_code(500);
    exit;
}

curl_close($ch);

echo $response;
