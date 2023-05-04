<?php
// Retrieve the payment information from the form
$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];
$card_number = $_POST['card_number'];
$expiration_date = $_POST['expiration_date'];
$cvv = $_POST['cvv'];

// TODO: Validate user input and ensure that the payment information is correct

// Connect to the payment gateway and process the payment
$payment_gateway_url = 'https://payment-gateway.com/process-payment';
$payment_data = [
    'name' => $name,
    'email' => $email,
    'amount' => $amount,
    'card_number' => $card_number,
    'expiration_date' => $expiration_date,
    'cvv' => $cvv
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $payment_gateway_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payment_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$payment_response = curl_exec($ch);

// Check the payment response and display a success or error message
$response_data = json_decode($payment_response, true);
if ($response_data && is_array($response_data) && $response_data['success']) {
    echo "Payment successful! Thank you for your purchase.";
} else {
    echo "Payment failed: " . ($response_data['error_message'] ?? "Unknown error");
}


curl_close($ch);
?>
