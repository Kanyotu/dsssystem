<?php
include 'checkadminindb.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="adminprofile.css">
</head>
<body>

    <div class="profile-page">

        <!-- Header -->
        <div class="profile-header">
            <div class="avatar">👨‍💼</div>
            <h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <p class="role">Administrator</p>
        </div>

        <!-- Info Cards -->
        <div class="profile-cards">
            <div class="card">
                <h3>Access Level</h3>
                <p>Full System Control</p>
            </div>
            <div class="card">
                <h3>Departments Managed</h3>
                <p>All</p>
            </div>
            <div class="card">
                <h3>Pending Requests</h3>
                <p>12</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="profile-actions">
            <a href="admindashboard.php" class="btn">⬅ Back to Dashboard</a>
            <a href="logout.php" class="btn danger">🚪 Logout</a>
        </div>

    </div>

</body>
</html>
