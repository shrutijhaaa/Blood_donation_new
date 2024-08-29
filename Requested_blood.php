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

// Update status if the admin has submitted the form
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $new_status = $_POST['status'];

    // Update the status in the database
    $sql = "UPDATE book_blood SET Status='$new_status' WHERE id='$id'";
    $conn->query($sql);
}

// Fetch all data from the book_blood table
$sql = "SELECT * FROM book_blood";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Booking List</title>
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
    </style>
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
                <li><a href="Doner_list.php">Doner List</a></li>
                <li><a href="Requested_blood.php">Request for Blood</a></li>
            </ul>
        </div>
        <div class="dashboard">
            <div class="table-container">
                <h1>Requested Blood</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Blood Group</th>
                            <th>State</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['Name'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Phone_Number'] . "</td>";
                                echo "<td>" . $row['Blood_Group'] . "</td>";
                                echo "<td>" . $row['State'] . "</td>";
                                echo "<td>" . $row['Date'] . "</td>";
                                echo "<td>" . $row['Time'] . "</td>";
                            echo "<td>";
                                echo "<select onchange=\"updateStatus(this, " . $row['id'] . ")\">";
                                echo "<option value=\"Pending\">Pending</option>";
                                echo "<option value=\"Done\">Done</option>";
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
