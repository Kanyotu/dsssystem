<?php
include 'checkdepartmentuserindb.php';
include 'departmentsidebar.php';
$username = $_SESSION['username'];
// Fetch department-specific data
$sql = "SELECT department_id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$department_id = $row['department_id'];

$sql = "
SELECT 
    COUNT(*) AS total,
    SUM(status = 'pending') AS pending,
    SUM(status = 'approved') AS approved,
    SUM(status = 'denied') AS denied
FROM resource_requests
WHERE department_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $department_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

$total_requests = $data['total'];
$total_pending_requests = $data['pending'];
$total_approved_requests = $data['approved'];
$total_denied_requests = $data['denied'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Department Dashboard</title>
    <link rel="stylesheet" href="department_style.css">
</head>
<body>

    <div class="topright-info">
        <a href="department_profile.php" class="profile-link">👤 
        <h5>
            You are logged in as: <?php echo htmlspecialchars($username); ?>
        </h5>
        </a>
    </div>

     <!-- Main Content -->
    <div class="main-content">

        <h1>Department Dashboard</h1>
        <p class="subtitle">Overview of your department activity</p>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Requests</h3>
                <p><?php echo htmlspecialchars($total_requests); ?></p>
            </div>

            <div class="stat-card">
                <h3>Pending Requests</h3>
                <p><?php echo htmlspecialchars($total_pending_requests) ?></p>
            </div>

            <div class="stat-card">
                <h3>Approved Allocations</h3>
                <p><?php echo htmlspecialchars($total_approved_requests); ?></p>
            </div>

            <div class="stat-card">
                <h3>Denied Requests</h3>
                <p><?php echo htmlspecialchars($total_denied_requests); ?></p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="activity-box">
            <h2>Recent Activity</h2>

            <ul>
                <li>📦 Requested 20 chairs — <span class="pending">Pending</span></li>
                <li>✅ 10 desks allocated — <span class="approved">Approved</span></li>
                <li>❌ Projector request denied — <span class="denied">Denied</span></li>
            </ul>
        </div>

    </div>

</body>
</html>

