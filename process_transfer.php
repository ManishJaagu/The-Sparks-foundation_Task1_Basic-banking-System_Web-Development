<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bankvizdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Getting form data
$sender_name = $_POST['sender_name'];
$sender_account_number = $_POST['sender_account_number'];
$receiver_name = $_POST['receiver_name'];
$receiver_account_number = $_POST['receiver_account_number'];
$amount = $_POST['amount'];

// Check if the sender has enough balance
$sql = "SELECT balance FROM customers WHERE account_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $sender_account_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sender_balance = $row['balance'];

    if ($sender_balance >= $amount) {
        // Deducting from sender's balance
        $new_sender_balance = $sender_balance - $amount;
        $sql = "UPDATE customers SET balance = ? WHERE account_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $new_sender_balance, $sender_account_number);
        $stmt->execute();

        // Adding amount to receiver's balance
        $sql = "SELECT balance FROM customers WHERE account_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $receiver_account_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $receiver_balance = $row['balance'];
            $new_receiver_balance = $receiver_balance + $amount;

            $sql = "UPDATE customers SET balance = ? WHERE account_number = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ds", $new_receiver_balance, $receiver_account_number);
            $stmt->execute();

            // Recording the transaction
            $transfer_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO transactions (sender_name, sender_account_number, receiver_name, receiver_account_number, amount, transfer_date) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssds", $sender_name, $sender_account_number, $receiver_name, $receiver_account_number, $amount, $transfer_date);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Transfer successful.',
                'sender_balance' => $new_sender_balance,
                'receiver_balance' => $new_receiver_balance
            ]);
        } else {
            echo json_encode(['error' => 'Receiver not found']);
        }
    } else {
        echo json_encode(['error' => 'Insufficient balance']);
    }
} else {
    echo json_encode(['error' => 'Sender not found']);
}

$conn->close();
?>
