<?php
include 'checkadminindb.php';
include 'adminsidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT COUNT(*) AS total_departments FROM departments";
$result = $conn->query($sql);
$total_departments = $result->fetch_assoc()['total_departments'];
$sql = "SELECT COUNT(*) AS total_resources FROM resources";
$result = $conn->query($sql);
$total_resources = $result->fetch_assoc()['total_resources'];
$sql = "SELECT COUNT(*) AS total_requests FROM resource_requests WHERE status = 'pending'";
$result = $conn->query($sql);
$total_requests = $result->fetch_assoc()['total_requests'];
$sql="SELECT COUNT(*) FROM users WHERE role='admin'";
$result = $conn->query($sql);
$total_admins = $result->fetch_assoc()['COUNT(*)'];
$conn->close();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admindashboard.css">
</head>
<body>


    <a href="adminprofile.php">
    <div class="namedisplay">
        👨‍💼Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
    </div>
    </a>

    <!-- Main Content -->
    <div class="main">

        <div class="header">
            <h1>Admin Dashboard</h1>
            <p>Decision Support System Overview</p>
        </div>

        <!-- Summary Cards -->
        <div class="cards">
            <div class="card">
                <h3>🏢Total Departments</h3>
                <p>View and manage all departments</p>
                <h4 class="number"><?php echo $total_departments; ?></h4>

            </div>

            <div class="card">
                <h3>Total Resources</h3>
                <p>Available system resources</p>
                <h4 class="number"><?php echo $total_resources; ?></h4>

            </div>

            <div class="card">
                <h3>⏳Pending Requests</h3>
                <p>Requests awaiting decisions</p>
                <h4 class="number"><?php echo $total_requests; ?></h4>
            </div>
            <div class="card">
                <h3>Total admins</h3>
                <p>Registered system administrators</p>
                <h4 class="number"><?php echo $total_admins; ?></h4>
            </div>

            <div class="card">
                <h3>🟢DSS Decisions</h3>
                <p>Generated recommendations</p>

            </div>
        </div>

        <!-- DSS Info -->
        <div class="section">
            <h2>Decision Support Summary</h2>
            <p>
                This dashboard allows administrators to manage departments,
                allocate resources, and run decision models to support
                fair and data-driven decisions.
            </p>
        </div>

        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>

    </div>

</body>
</html>
