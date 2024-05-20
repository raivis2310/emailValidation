<?php

$eMail = (string)readline("Write your e-mail: ");

$response = file_get_contents("https://api.emailvalidation.io/v1/info?apikey=ema_live_x9bWqG04h28QNM2idtI8Fv04EigVlw2USxHZBHqV&email={$eMail}");
$data = json_decode($response, true);

echo $data["reason"] . "\n";

if ($data["reason"] == "valid_mailbox") {
    function sendEmail($to, $subject, $body)
    {
        $apiKey = 'a2dd40a3-4d4f6ca0';
        $domain = 'sandbox4935dbd9f0334555a0bb55eda1c5fd83.mailgun.org';
        $from = 'you@yourdomain.com';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/' . $domain . '/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $body
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    $to = $eMail;
    $subject = 'Hello from Mailgun';
    $body = 'This is a test email sent using the Mailgun API.';

    $response = sendEmail($to, $subject, $body);
    echo "Response: " . $response;
}
