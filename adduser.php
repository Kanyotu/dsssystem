<?php
include 'checkadminindb.php';
include 'adminsidebar.php';
// Fetch departments from the database
$sql = "SELECT * FROM departments";
$deptresult = $conn->query($sql);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $department_id = $_POST['department_id'];

    if(empty($username) || empty($password) || empty($confirm_password) || empty($department_id)){
        echo "<script>alert('All fields are required');</script>";
    } 

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        echo "<script>alert('Username already exists');</script>";
        exit();
    }

    if($password !== $confirm_password){
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, department_id) VALUES (?, ?, 'department', ?)");
        $stmt->bind_param("ssi", $username, $hashed_password, $department_id);

        if($stmt->execute()){
            echo "<script>alert('Department user created successfully');</script>";
            header("Location: admindashboard.php");
            exit();
        } else {
            echo "<script>alert('Error creating department user: " . $stmt->error . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Department User</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Add Department User</h1>
        <p>Create a user account for a department.</p>

        <div class="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>

                <label>Assign Department</label>
                <select name="department_id" required>
                    <option value="">-- Select Department --</option>
                    <!-- PHP will populate departments here -->
                    <?php
                    if ($deptresult->num_rows > 0) {
                        while ($row = $deptresult->fetch_assoc()) {
                            echo "<option value='" . $row['department_id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select><br><br>

                <button type="submit">Create Department User</button>
            </form>

            <p class="note">
                Department users can only access their assigned department.
            </p>
        </div>
    </div>

</body>
</html>
