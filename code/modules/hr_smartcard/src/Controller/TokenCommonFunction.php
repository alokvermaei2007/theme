<?php

namespace Drupal\hr_smartcard\Controller;

/**
 * Simple page controller for drupal.
 */
class TokenCommonFunction {

    /**
     * Create Smart Card
     * @param type $title
     */
    public function smartCardCurl($title, $fid_url, $url, $ecn,$email) {

        $body = array(
            'card' =>
            array(
                'message' => 'test check by sandeep2',
                'prices' =>
                array(
                    0 =>
                    array(
                        'amount' => 15,
                        'currency' => 'INR',
                    ),
                    1 =>
                    array(
                        'amount' => 10,
                        'currency' => 'USD',
                    ),
                ),
                'content_type' => 'video',
                'tags' =>
                array(
                    0 => 'tag1',
                    1 => 'tag2',
                ),
                'card_metadata' =>
                array(
                    'level' => 'intermediate',
                    'custom_data' => 'sd',
                ),
                'resource' =>
                array(
                    'title' => 'test check by sandeep new for image.',
                    'url' => 'http://google1.com',
                    'image_url' => 'https://pdf2jpg.net/pdf_to_jpg_og_image.png',
                ),
                'duration' => 45,
                'channel_ids' =>
                array(
                    0 => 215,
                ),
                'team_ids' =>
                array(
                    0 => 483,
                ),
            ),
        );
//        $ecn = '6a96b801-d492-4032-b180-3b42b3f5e625';
        if ($ecn) {
            $api_url = 'https://schwabsandbox.edcast.com/api/developer/v5/cards/' . $ecn;
            $type = 'PUT';
        }
        else {
            $api_url = trim($GLOBALS['api_url']);
            $type = 'POST';
        }
        $encoded_value = json_encode($body);
        $jwttokenencode = $this->authToken($email);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_POSTFIELDS => $encoded_value,
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "X-ACCESS-TOKEN: " . $jwttokenencode,
                "X-API-KEY: 3e2a643860f6905418739d26c0fea118"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        else {
            echo $response;
        }
        if (!empty($response)) {
            $id = $this->get_ecn($response);
        }
        return $id;
    }

    function get_ecn($json) {
        $decode_json = json_decode($json);
        $array = (array) $decode_json;
        if (!empty($array['card']->id)) {
            return $array['card']->id;
        }
    }

    function authToken($email) {
        $jwttoken = $this->createJWTToken($email);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://schwabsandbox.edcast.com/api/developer/v5/auth",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "X-API-KEY: " . $GLOBALS['apikey'],
                "X-AUTH-TOKEN:" . $jwttoken
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        else {
//            echo $response;
        }

        $decoded_value = json_decode($response);
        $decodetoken = $decoded_value->jwt_token;
        if ($decodetoken) {
//            echo $decodetoken;
            return $decodetoken;
        }
        else {
            echo 'error in Token Generation. Please contact To administarator';
        }
    }

    function createJWTToken($email) {
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = $this->base64url_encode(json_encode($headers));
//build the payload
        $payload = array(
            "email" => $email
        );
        $payload_encoded = $this->base64url_encode(json_encode($payload));

//build the signature
        $key = '7f95441e135752e6a686f8e08f3c7dfe7bbbc32d4966344d32592c4e2c2c298a';
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $key, true);
        $signature_encoded = $this->base64url_encode($signature);
        $token = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $token;
    }

    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

}
