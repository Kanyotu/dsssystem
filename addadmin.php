<?php
include 'checkadminindb.php';
include 'adminsidebar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Admin user created successfully');</script>";
            header("Location: admindashboard.php");
            exit();
        } else {
            echo "<script>alert('Error creating admin user: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Admin</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
             display: flex;
            /*justify-content: center;
            align-items: center; */
            height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 30px;
            width: 450px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input:focus {
            outline: none;
            border-color: #4e4376;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4e4376;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #2b5876;
        }

        .note {
            margin-top: 15px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Add Admin User</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Create Admin</button>
        </form>

        <p class="note">
            Admin accounts have full system access
        </p>
    </div>

</body>
</html>
