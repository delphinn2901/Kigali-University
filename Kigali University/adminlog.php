<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css"/>
</head>

<body style="margin:0;
             padding:0;
             background-image:url('bg.jpg');
             background-size:cover;
             background-position:center;
             background-repeat:no-repeat;
             height:100vh;
             font-family:Arial, sans-serif;">
    <div class="top-link">
        <a href="home.html"><img src="IMG/LOGO.png" alt="kigali university"></a>
    </div>

    <div class="tabs">
        <button class="tab active"><a href="login.php">Student</a></button>
        <button class="tab"><a href="leclogin.php">Lecturer</a></button>
        <button class="tab"><a href="adminlog.php">Admin</a></button>
    </div>
    <div class="login-wrapper">
        <!-- Form -->
         <div class="primg">
            <img src="IMG/7122c1ac1382dea3563d776c1f158654.png" alt="">
         </div>
        <div class="links">
            <a href="login.php">Admin Login</a>
           
        </div>

<?php
session_start();
include "connection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = "";

if (isset($_POST['submit'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $connect->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        // 🔥 TEMP TEST (remove later)
        // var_dump($user['password']); exit();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];

            if ($user['role'] == 'admin') {
                header("Location: admin/usermanagement.php");
            } elseif ($user['role'] == 'Lecturer') {
                header("Location: lecturer/lecturer.php");
            } else {
                header("Location: student/student.php");
            }
            exit();

        } else {
            $error = "Wrong password!";
        }

    } else {
        $error = "User not found!";
    }
}
?>



<form method="POST" class="login-form">
  <label>Email</label>
    <input type="text" name="email" placeholder="Enter email" required />

    <br><br>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" required />

    <div class="forgot">
        <a href="#">Forgot password?</a><br>
        <a href="signup.php">Create new account</a>
    </div>

    <button type="submit" name="submit" class="login-btn">Login</button>


</form>

<?php
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
</div>
</body>
</html>