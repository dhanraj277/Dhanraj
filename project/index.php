<?php
$host = "localhost";
$db = "hotel_resevation";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['checkin_date'], $_POST['checkout_date'], $_POST['adults'], $_POST['children'])) {
        $checkin = $_POST['checkin_date'];
        $checkout = $_POST['checkout_date'];
        $adults = (int)$_POST['adults'];
        $children = (int)$_POST['children'];

        $stmt = $pdo->prepare("INSERT INTO reservation (checkin_date, checkout_date, adults, children) VALUES (?, ?, ?, ?)");
        $stmt->execute([$checkin, $checkout, $adults, $children]);

        echo "<script>alert('Reservation successful!');</script>";
    }

    // Handle contact form submission
    if (isset($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message'])) {
        $name = htmlspecialchars(trim($_POST['contact_name']));
        $email = htmlspecialchars(trim($_POST['contact_email']));
        $subject = htmlspecialchars(trim($_POST['contact_subject']));
        $message = htmlspecialchars(trim($_POST['contact_message']));

        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);

        echo "<script>alert('Message sent successfully!');</script>";
    }catch (PDOException $e) {
        die("Error: " . $e->getMessage());
}
?>
