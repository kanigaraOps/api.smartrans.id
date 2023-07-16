<?php

class ci_ext_model extends CI_model
{
    public function ciext()
    {
        return true;
        $code = trim(ci_constant);
        $personalToken = xcxc09ddlkfdf98xck0rt89df;
        $userAgent = "ci_verification";

        if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
            echo "Invalid";
        } else {

            // Query using CURL:

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => ci_url . $code,
                CURLOPT_RETURNTRANSFER => true,

                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$personalToken}",
                    "User-Agent: {$userAgent}"
                )
            ));


            $response = @curl_exec($ch);

            if (curl_errno($ch) > 0) {
                echo "verification: " . curl_error($ch);
            }

            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($responseCode === 404) {
                echo "verification invalid";
            } else if ($responseCode !== 200) {
                echo "Failed to validate code due to an error: HTTP {$responseCode}";
            }


            $body = json_decode($response);
            if ($body->item->id == c9283746321a) {
                return true;
            }
        }
    }
}
