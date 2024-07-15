<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts link for "Inter Tight" font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Font Awesome icon CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- AOS Library CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css">
    <!-- Local CSS -->
    <link rel="stylesheet" href="./styles/transaction_history.css">
    <link rel="stylesheet" href="./styles/common_styles.css">
    <title>BankViz Transaction History</title>
</head>
<body id="main-body">
    <!-- The header section -->
    <div class="header" data-aos="fade-down">
        <div class="left-section">
            <!-- Header-Logo Section -->
            <h1 class="bank-name">BankViz</h1>
            <h2>Transaction History</h2>
        </div>
        <div class="middle-section">
            <!-- Header-Middle Section -->
            <input id="search-box" class="search-box" type="text" placeholder="Search here" data-aos="fade-left" data-aos-delay="500">
            <button class="search-button" data-aos="fade-left" data-aos-delay="500"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div class="right-section">
            <!-- Header-Right Section -->
            <a href="./index.html" class="header-link" data-aos="fade-right" data-aos-delay="600">Home</a>
            <a href="./transfer_menu_customers.php" class="header-link" data-aos="fade-right" data-aos-delay="600">Transfer</a>
        </div>
    </div>
    <div class="transaction-history-table">
        <table style="width: 100%;">
            <thead>
                <tr class="table-attribute">
                    <th class="attribute" scope="col">Date</th>
                    <th class="attribute" scope="col">Sender</th>
                    <th class="attribute" scope="col">Sender's Account</th>
                    <th class="attribute" scope="col">Receiver</th>
                    <th class="attribute" scope="col">Receiver's Account</th>
                    <th class="attribute" scope="col">Amount (in $)</th>
                </tr>
            </thead>
            <tbody id="transactionTableBody">
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

            // Retrieving transaction history
            $sql = "SELECT sender_name, sender_account_number, receiver_name, receiver_account_number, amount, DATE_FORMAT(transfer_date, '%Y-%m-%d %H:%i:%s') AS formatted_date FROM transactions ORDER BY transfer_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["formatted_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sender_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sender_account_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["receiver_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["receiver_account_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["amount"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No transactions found.</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <!-- The footer section -->
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
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.min.js"></script>
    <script>AOS.init();</script>
    <script>
        //Search Functionality
        document.addEventListener('DOMContentLoaded', () => {
            const searchBox = document.getElementById('search-box');
            const transactionTableBody = document.getElementById('transactionTableBody');
            const searchButton = document.querySelector('.search-button');

            function filterTable() {
                const searchTerm = searchBox.value.toLowerCase();
                const rows = transactionTableBody.getElementsByTagName('tr');

                for (const row of rows) {
                    const cells = row.getElementsByTagName('td');
                    let isMatch = false;

                    for (const cell of cells) {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            isMatch = true;
                            break;
                        }
                    }

                    if (isMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }

            // Search button
            searchButton.addEventListener('click', filterTable);

            //press Enter key in the search box
            searchBox.addEventListener('keyup', (event) => {
                if (event.key === 'Enter') {
                    filterTable();
                }
            });
        });
    </script>
</body>
</html>
