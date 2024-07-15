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
    <link rel="stylesheet" href="./styles/view_customers.css">
    <link rel="stylesheet" href="./styles/common_styles.css">
    <title>BankViz Customers</title>
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
            <a href="./transfer_menu_customers.php"  class="header-link" data-aos="fade-right" data-aos-delay="600">Transfer</a>
            <a href="./transaction_history.php" class="header-link" data-aos="fade-right" data-aos-duration="500" data-aos-delay="200">Transaction History</a>
        </div>
    </div>
    <div class="index-customer-card customer-card">
        <table class="table" data-aos="fade-down">
            <thead>
                <tr class="table-attribute">
                    <th class="attribute" scope="col">Sl. No.</th>
                    <th class="attribute" scope="col">Name</th>
                    <th class="attribute" scope="col">E-mail</th>
                    <th class="attribute" scope="col">Account Number</th>
                    <th class="attribute" scope="col">Bank Balance (in $)</th>
                </tr>
            </thead>
            <tbody id="customerTableBody">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bankvizdb";
                //creating connection
                $connection = new mysqli($servername, $username, $password, $dbname);

                //To check whether the database is connected or not, if yes:
                if ($connection->connect_error) 
                {
                    die("Connection failed: ". $connection->connect_error);
                }

                //read all the rows from the database
                $sql = "SELECT * FROM customers";
                $result = $connection->query($sql);
                
                if (!$result) 
                {
                    die("Invalid query: ". $connection->connect_error);
                }

                //read data from each row
                while ($row = $result->fetch_assoc()) 
                {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["account_number"] . "</td>
                    <td>" . $row["balance"] . "</td>
                </tr>";
                }
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
         //for Search Functionality
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

        // press Enter key in the search box
        searchBox.addEventListener('keyup', (event) => {
            if (event.key === 'Enter') {
                filterTable();
            }
        });
    });
    </script>
</body>
</html>
