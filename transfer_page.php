<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    <link rel="stylesheet" href="./styles/transfer_page.css">
    <link rel="stylesheet" href="./styles/common_styles.css">
    <title>Transfer Money</title>
</head>
<body id="main-body">
<div class="header" data-aos="fade-down">
    <div class="left-section">
        <h1 class="bank-name">BankViz</h1>
        <h2>Transfer Money</h2>
    </div>
    <div class="right-section">
        <a href="./index.html" class="header-link" data-aos="fade-right" data-aos-delay="600">Home</a>
        <a href="./view_customers.php" class="header-link" data-aos="fade-right" data-aos-delay="600">Customers</a>
        <a href="./transaction_history.php" class="header-link" data-aos="fade-right" data-aos-duration="500" data-aos-delay="200">Transaction History</a>
    </div>
</div>
<div class="transfer-section" data-aos="fade-up">
    <div class="transfer-card">
        <div class="transfer-card-bank-logo">
            <h2>BankViz Transfer</h2>
            <h3>Transfer Money</h3>
        </div>
        
        <form id="transfer-form" action="process_transfer.php" method="POST" onsubmit="showTransferMessage()">
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bankvizdb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieving sender's data
            $sql = "SELECT id, name, email, account_number, balance FROM customers WHERE id = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row1 = $result->fetch_assoc()) {
                    $sender_name = htmlspecialchars($row1["name"]);
                    $sender_account_number = htmlspecialchars($row1["account_number"]);
                    $sender_balance = htmlspecialchars($row1["balance"]);
                }
            } else {
                echo "Error: No sender found.";
                exit();
            }

            // Retrieving receiver's data from GET parameters
            $receiver_name = htmlspecialchars($_GET['receiver_name'] ?? '');
            $receiver_account_number = htmlspecialchars($_GET['receiver_account_number'] ?? '');
            ?>

            <div class="form-group">
                <label for="sender">Sender: </label>
                <input type="text" id="sender_name" name="sender_name" value="<?php echo $sender_name; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="sender-account-number">Sender's Account Number:</label>
                <input type="text" id="sender_account_number" name="sender_account_number" value="<?php echo $sender_account_number; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="sender-bank-balance">Sender's Bank Balance:</label>
                <input type="text" id="sender-bank-balance" name="sender-bank-balance" value="<?php echo $sender_balance; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="receiver-name">Receiver:</label>
                <input type="text" id="receiver_name" name="receiver_name" value="<?php echo $receiver_name; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="receiver-account-number">Receiver's Account Number:</label>
                <input type="text" id="receiver_account_number" name="receiver_account_number" value="<?php echo $receiver_account_number; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="amount">Amount to Transfer:</label>
                <input type="number" id="amount" name="amount" min="1" required>
            </div>
            <button type="submit" value="Transfer" class="transfer-button">Transfer</button>
            <br>
            <p id="transfer-message" style="display: none;">Transaction successful</p>
        </form>
    </div>
</div>
<div class="footer">
    <div class="footer-company-links">
        <div class="icons">
            <i class="fa-brands fa-facebook-f"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-snapchat"></i>
            <i class="fa-brands fa-pinterest"></i>
            <i class="fa-brands fa-x-twitter"></i>
            <i class="fa-brands fa-linkedin-in"></i>
            <i class="fa-brands fa-threads"></i>
            <i class="fa-brands fa-twitch"></i>
        </div>
        <div class="footer-links">
            <a href="#" class="footer-link">Terms</a>
            <a href="#" class="footer-link">Privacy</a>
            <a href="#contact-us-div" class="footer-link">Contact</a>
            <a href="#" class="footer-link">BankViz © 2024</a>
        </div>
        <p>2024 BankViz corporation. All rights reserved.</p>
        <p>A Project by Manish</p>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
<script>
    AOS.init();

    function showTransferMessage() {
        document.getElementById('transfer-message').style.display = 'block';
    }
</script>
</body>
</html>
