<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
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

        <!-- Main Content -->
        <main class="main">

            <!-- Header -->
            <div class="header">
                
                <h2>STUDENT DASHBOARD</h2><br><br>
                <div class="prof">
                 <p><?php echo $full_name; ?></p>
                <img src="IMG/profilee.jpg" alt="">
            </div>

      
                <hr><br>
             
            </div>
            <section class="grid">

                <div class="card status">
                    <h3>Student Registration Status</h3>
                    <span class="badge">REGISTERED</span>
                    <p>Current Semester: <strong>Fall 2026</strong></p>
                </div>

                <div class="card notification">
                    <h3>Notification</h3>
                    <p><strong>Payment Confirmed</strong></p>
                    <p>Your tuition fee has been processed.</p>
                </div>

            </section>
            <!-- Courses Table -->
            <section class="card">
                <h3>Enrolled Courses</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Lecturer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CS101</td>
                            <td>Introduction to Computing</td>
                            <td>3</td>
                            <td>Nzabonima Eugene</td>
                        </tr>
                        <tr>
                            <td>CAL101</td>
                            <td>Calculus</td>
                            <td>4</td>
                            <td>Dr. Manzi Alpha</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Status & Notification -->


        </main>

    </div>

</body>

</html>