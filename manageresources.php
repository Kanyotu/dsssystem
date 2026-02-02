<?php
include 'checkadminindb.php';
include 'adminsidebar.php';

$sql = "SELECT * FROM resources";
$result = $conn->query($sql);
$resources = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $resources[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Resources</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">

        <div class="page-header">
            <h1>Manage Resources</h1>
            <p>Add, update, and view system resources</p>
        </div>

        <!-- Add Resource Form -->
        <div class="card">
            <h2>Add New Resource</h2>

            <form class="resource-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <div class="form-group">
                    <label>Resource Name</label>
                    <input type="text" placeholder="e.g. Chairs">
                </div>

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" placeholder="e.g. 100">
                </div>

                <div class="form-group">
                    <label>Cost (optional)</label>
                    <input type="number" step="0.01" placeholder="e.g. 1500.00">
                </div>

                <button type="submit" class="btn-primary">Add Resource</button>
            </form>
        </div>

        <!-- Resources Table -->
        <div class="card">
            <h2>Available Resources</h2>

            <table class="resource-table" border="1px solid #ccc" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($resources as $resource): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($resource['name']); ?></td>
                        <td><?php echo htmlspecialchars($resource['quantity']); ?></td>
                        <td>
                            <?php 
                                if (is_null($resource['cost'])) {
                                    echo "N/A";
                                } else {
                                    echo "$" . number_format($resource['cost'], 2);
                                }
                            ?>
                        </td>
                        <td>
                            <button class="btn-secondary">Edit</button>
                            <button class="btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>