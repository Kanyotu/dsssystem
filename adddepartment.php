<?php

include 'checkadminindb.php';
include 'adminsidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept_name = $_POST['dept_name'];
    $studentnumber = $_POST['studentnumber'];
    $last_allocation_date = $_POST['last_allocation_date'];

    // echo"Debug: Received dept_name = $dept_name, studentnumber = $studentnumber, last_allocation_date = $last_allocation_date";

    $sql="SELECT * FROM departments WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $dept_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "<script>alert('Department already exists');</script>";
        exit();
    }

    if (empty($last_allocation_date)) {
        $last_allocation_date = null;
    }
    $sql = "INSERT INTO departments (name, num_students, last_allocation_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $dept_name, $studentnumber, $last_allocation_date);


    if ($stmt->execute()) {
        echo "<script>alert('Department added successfully'); window.location.href='admindashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding department: " . $stmt->error . "');</script>";
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Department</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

    <div class="main-content">
        <h1>Add New Department</h1>
        <p>Fill in the details below to create a new department.</p>

        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <label for="dept_name">Department Name</label>
                <input type="text" id="dept_name" name="dept_name" placeholder="Enter department name" required>

                <label for="dept_head">No of students</label>
                <input type="number" id="dept_head" name="studentnumber" placeholder="no of students" required>

                <label for="last_allocation_date">Last Allocation Date</label>
                <input type="date" id="last_allocation_date" name="last_allocation_date">

                <button type="submit">Add Department</button>
            </form>
        </div>
    </div>

</body>
</html>
