<?php
// Database connection
$host = "localhost";
$dbname = "hotel_resevation";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and retrieve POST data
$card_name   = htmlspecialchars(trim($_POST['card_name']));
$card_number = preg_replace('/\D/', '', $_POST['card_number']); // Only digits
$expiry      = htmlspecialchars(trim($_POST['expiry']));
$cvv         = htmlspecialchars(trim($_POST['cvv']));
$amount      = floatval($_POST['amount']);

// Basic validation (you can enhance this)
if (strlen($card_number) != 16 || strlen($cvv) != 3) {
    die("Invalid card details.");
}

// For security: DO NOT store card number or CVV
// Simulate payment success
$status = 'Success';
$timestamp = date("Y-m-d H:i:s");

// Insert safe data into payments table
$sql = "INSERT INTO payments(card_name, expiry, amount, status, payment_date)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdss", $card_name, $expiry, $amount, $status, $timestamp);

if ($stmt->execute()) {
    echo "<h3>Payment Successful!</h3><p>Thank you, $card_name. Your payment of $$amount has been received.</p>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
