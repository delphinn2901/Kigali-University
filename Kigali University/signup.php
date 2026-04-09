<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css" />
</head>

<body style="margin:0;
             padding:0;
             background-size:cover;
             background-position:center;
             background-repeat:no-repeat;
             height:100vh;
             font-family:Arial, sans-serif;">
    <div class="top-link">
        <a href="home.html"><img src="IMG/LOGO.png" alt="kigali university"></a>
    </div>

 <div class="tabs">
        <button class="tab active"><a href="home.html">Home</a></button>
        <button class="tab">About Us</button>
        <button class="tab">Contact</button>
    </div>
    <div class="login-wrapper">
        <!-- Form -->
         <div class="primg">
            <img src="IMG/7122c1ac1382dea3563d776c1f158654.png" alt="">
         </div>
        <div class="links">
            <a href="signup.php">Sign up</a>
        </div>
 <form class="login-form" method="POST">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
            <option value="admin">Admin</option>

        </select>

        <div class="forgot">
                <a href="#">Forgot password?</a><br>
                <a href="login.php">Already have an account</a>
            </div>
        
            <button type="submit" name="submit" class="login-btn">SignUp</button>

    </form>

    </div>

</body>

</html>
<?php
include "connection.php";

if (isset($_POST['submit'])) {

    // get form data
    $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
    $email     = mysqli_real_escape_string($connect, $_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role      = mysqli_real_escape_string($connect, $_POST['role']);

    // check if email already exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $check);

    if (mysqli_num_rows($result) > 0) {

        echo "<script>
                alert('Email already exists, please login');
                location.replace('login.php');
              </script>";

    } else {

        // insert new user
        $sql = "INSERT INTO users (full_name, email, password, role)
                VALUES ('$full_name', '$email', '$password', '$role')";
                

        if (mysqli_query($connect, $sql)) {

            echo "<script>alert('Account created successfully, Now login');
                    location.replace('login.php');</script>";

        } else {

            echo "<script>
                    alert('Error creating account');
                    location.replace('signup.php');
                  </script>";

        }
    }
}
?>

