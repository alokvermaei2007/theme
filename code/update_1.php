<?php
 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://test2.com/api/developer/v5/auth",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "X-API-KEY : <API-KEY>",
    "X-AUTH-TOKEN: <JWT.encode(payload, secret_key)>"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
echo $response;exit;
curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}  

exit;
 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://BASE-ORG-URL/api/developer/v5/cards",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n    \"card\": {\n        \"message\": \"Testting card\",\n        \"external_id\": \"uniqueid-qwertytest\",\n        \"prices\": [\n            {\n                \"amount\": 15,\n                \"currency\": \"INR\"\n            },\n            {\n                \"amount\": 10,\n                \"currency\": \"USD\"\n            }\n        ],\n        \"is_paid\": \"false\",\n        \"content_type\": \"video\",\n        \"tags\": [\n            \"tag1\",\n            \"tag2\"\n        ],\n        \"card_metadata\": {\n            \"level\": \"intermediate\",\n            \"custom_data\": \"sd\"\n        },\n        \"resource\": {\n            \"title\": \"source title\",\n            \"url\": \"http://www.africau.edu/images/default/sample.pdf\"\n        },\n        \"duration\": 45,\n        \"channel_ids\": [\n            215\n        ],\n        \"team_ids\": [\n            483\n        ]\n    }\n}",
  CURLOPT_HTTPHEADER => array(
    "X-API-KEY: <API-KEY>",
    "X-ACCESS-TOKEN: <JWT-TOKEN>",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
} 
?>
