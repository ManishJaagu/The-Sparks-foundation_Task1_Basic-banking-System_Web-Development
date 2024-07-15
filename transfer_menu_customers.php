<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts link for "Inter tight" font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Font Awesome icon CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- AOS Library CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <!-- Local CSS -->
    <link rel="stylesheet" href="./styles/transfer_menu_customers.css">
    <link rel="stylesheet" href="./styles/common_styles.css">
    <title>BankViz Transfers Made Easy</title>
</head>
<body id="main-body">
    <!-- The header section -->
    <div class="header" data-aos="fade-down">
        <div class="left-section">
            <!-- Header-Logo Section -->
            <h1 class="bank-name">BankViz</h1>
            <h2>Customers</h2>
        </div>
        <div class="middle-section">
            <!-- Header-Middle Section -->
            <input id="search-box" class="search-box" type="text" placeholder="Search here" data-aos="fade-left" data-aos-delay="500">
            <button class="search-button" data-aos="fade-left" data-aos-delay="500"><i class="fa-solid fa-magnifying-glass" data-aos="fade-left" data-aos-delay="500"></i></button>
        </div>
        <div class="right-section">
            <!-- Header-Right Section -->
            <a href="./index.html" class="header-link" data-aos="fade-right" data-aos-delay="600">Home</a>
            <a href="./view_customers.php" class="header-link" data-aos="fade-right" data-aos-delay="600">View Customers</a>
            <a href="./transaction_history.php" class="header-link" data-aos="fade-right" data-aos-duration="500" data-aos-delay="200">Transaction History</a>
        </div>
    </div>

    <!-- SQL query to retrieve the row with id = 1 (my details) -->
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bankvizdb";

    // Creating connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checking connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve the row with id = 1
    $sql = "SELECT id, name, email, account_number, balance FROM customers WHERE id = 1";
    $result = $conn->query($sql);

    // Check if the query returned a result
    if ($result->num_rows > 0) {
        while ($row1 = $result->fetch_assoc()) {
            echo '<div class="customer-card your-info-card">
                <div class="user-card" data-aos="fade-in">
                    <div class="table-attribute">
                        <h3>Your Details</h3>
                    </div>
                    <div class="user-card-items">
                        <p class="attribute-name">ID:</p>
                        <p>' . $row1["id"] . '</p>
                        <p class="attribute-name">Name:</p>
                        <p>' . $row1["name"] . '</p>
                        <p class="attribute-name">E-Mail:</p>
                        <p>' . $row1["email"] . '</p>
                        <p class="attribute-name">Account Number:</p>
                        <p>' . $row1["account_number"] . '</p>
                        <p class="attribute-name">Balance:</p>
                        <p>' . $row1["balance"] . '</p>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo "0 results";
    }

    // Closing the connection
    $conn->close();
    ?>

    <div class="customer-card">
        <table class="table" data-aos="fade-down">
            <thead>
                <tr class="table-attribute">
                    <th class="attribute" scope="col">Sl. No.</th>
                    <th class="attribute" scope="col">Name</th>
                    <th class="attribute" scope="col">E-mail</th>
                    <th class="attribute" scope="col">Account Number</th>
                    <th class="attribute" scope="col">Bank Balance (in $)</th>
                    <th class="attribute" scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="customerTableBody">
                <?php
                $connection = new mysqli($servername, $username, $password, $dbname);

                // Checking connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // SQL query to retrieve all rows from customers table
                $sql = "SELECT * FROM customers";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $account_number = $row["account_number"];
                    $name = $row["name"];
                    $transfer_link = '';

                    // Disable the transfer option for ID 1 and name 'manish' as the user can't transfer amount to himself
                    if ($id == 1 && strtolower($name) === 'manish') {
                        $transfer_link = '<button class="btn btn-secondary" disabled>Transfer</button>';
                    } else {
                        $transfer_link = '<a href="transfer_page.php?receiver_id=' . $id . '&receiver_name=' . urlencode($row["name"]) . '&receiver_account_number=' . urlencode($row["account_number"]) . '" class="user-money-transfer-button">Transfer</a>';
                    }

                    echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["account_number"] . "</td>
                        <td>" . $row["balance"] . "</td>
                        <td>$transfer_link</td>
                    </tr>";
                }

                // Closing the connection
                $connection->close();
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

    <!-- AOS Library JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"></script>
    <script>AOS.init();</script>
    <script>
        //Search Functionality
        document.addEventListener('DOMContentLoaded', () => {
            const searchBox = document.getElementById('search-box');
            const customerTableBody = document.getElementById('customerTableBody');
            const searchButton = document.querySelector('.search-button');

            function filterTable() {
                const searchTerm = searchBox.value.toLowerCase();
                const rows = customerTableBody.getElementsByTagName('tr');

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

            //search button
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
