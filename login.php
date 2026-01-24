<?php
include 'database.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
         $row = $result->fetch_assoc();
         if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];
                $_SESSION['user_id'] = $row['user_id'];
                if ($row['role'] == 'admin') {
                    $stmt->close();
                    $conn->close();
                    header("Location: admindashboard.php");
                    exit();
                } else { 
                    $stmt->close();
                    $conn->close();
                    header("Location: departmentdashboard.php");
                     exit();
                }
         } else {
                echo "<script>alert('Invalid password');</script>";
            }
       
    } else {
        echo "<script>alert('Invalid username  ');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DSS Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="login-container">
        <h2>Decision Support System</h2>
        <p class="subtitle">Login to continue</p>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="footer-text">
            Authorized users only
        </p>
    </div>

</body>
</html>
