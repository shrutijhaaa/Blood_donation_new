<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>
<?php
// Include the database configuration file
include 'db_config.php';

// Fetch all data from the donate table
$sql = "SELECT * FROM donate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations List</title>
    <link rel="stylesheet" href="admin.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            overflow-y: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
            color: red;
        }
        select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <script>
        function updateStatus(selectElement, id) {
            const selectedStatus = selectElement.value;
            alert("Status for ID " + id + " updated to: " + selectedStatus);
            // You can send this status to the server using an AJAX call if needed
        }
    </script>
</head>
<body>

<header>
        <div class="logo">
            <img src="images/logo1.jpg" alt="Logo">
        </div>
           <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <!-- Display user's initial in a styled div -->
                        <a href="logout.php" class="fas fa-user-alt"></a>
                    <?php else: ?>
                        <a href="login.php" class="">Login</a>
                    <?php endif; ?>
</header>
  
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="blood_group.php">Available Blood</a></li>
                <li><a href="Doner_list.php">Donor List</a></li>
                <li><a href="Requested_blood.php">Request for Blood</a></li>
            </ul>
        </div>
        <div class="dashboard">
            <div class="table-container">
                <h1>All Donors</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Blood Group</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Pin Code</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th> <!-- New Status Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['Name'] . "</td>";
                                echo "<td>" . $row['Gender'] . "</td>";
                                echo "<td>" . $row['Age'] . "</td>";
                                echo "<td>" . $row['Blood_group'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Mobile_number'] . "</td>";
                                echo "<td>" . $row['State'] . "</td>";
                                echo "<td>" . $row['District'] . "</td>";
                                echo "<td>" . (!empty($row['Pin code']) ? $row['Pin code'] : 'N/A') . "</td>";
                                echo "<td>" . $row['Address'] . "</td>";
                                echo "<td>" . (!empty($row['Date']) ? $row['Date'] : 'N/A') . "</td>";
                                echo "<td>" . (!empty($row['Time']) ? $row['Time'] : 'N/A') . "</td>";
                                echo "<td>";
                                echo "<select onchange=\"updateStatus(this, " . $row['id'] . ")\">";
                                echo "<option value=\"Pending\">Pending</option>";
                                echo "<option value=\"Donation Done\">Donation Done</option>";
                                echo "</select>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='14'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
