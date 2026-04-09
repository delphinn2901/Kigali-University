<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Registration</title>
    <link rel="stylesheet" href="css_st/student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT full_name FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

if ($row) {
    $full_name = $row['full_name'];
} else {
    $full_name = "Unknown User";
}
?>
<body>

<div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="top-link">
                <a href="student.php"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>
           <ul>
                <li><a href="student.php"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="profile.php"><i class="fa-solid fa-circle-user"></i> Profile</a></li>
                <li><a href="my schedule.php"><i class="fa-solid fa-calendar"></i> My Schedule</a></li>
                <li><a href="coursereg.php"><i class="fa-etch fa-solid fa-book"></i> Course Registration</a></li>
                <li class="logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>


            </ul>
    </aside>

    <!-- Main -->
    <main class="main">
        <h1>Course Registration</h1>
       <div class="prof">
                 <p><?php echo $full_name; ?></p>
                <img src="IMG/profilee.jpg" alt="">
            </div>
       <br> <hr><br>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CS101</td>
                        <td>Intro to Database</td>
                        <td>3</td>
                        <td><button class="btn">Register</button></td>
                    </tr>
                    <tr>
                        <td>WEB202</td>
                        <td>Web Development</td>
                        <td>4</td>
                        <td><button class="btn">Register</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

</div>

</body>
</html>
