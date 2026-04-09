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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecturer Course Management</title>
    <link rel="stylesheet" href="css_lec/lecture.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
         <div class="top-link">
                <a href="lecturer.php"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>
        
        <ul>
            <li><a href="lecturer.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="mycourse.php"><i class="fa-solid fa-book"></i> My Courses</a></li>
            <li><a href="studentlist.php"><i class="fa-solid fa-users"></i> Student List</a></li>
            <li class="logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>

        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header">
            <h1>Lecturer Course Management</h1><br>
             <div class="prof">
                <p><?php echo $full_name; ?></p>
                <img src="IMG/profilee.jpg" alt="">
            </div>
            <hr><br>
            <p class="course">CS101 - Intro to Database</p>
        </div>
        

        <!-- Search -->
        <div class="search-box">
            <input type="text" placeholder="Search by ID or Name">
            <button>Search</button>
        </div>

        <!-- Student Table -->
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Reg Date</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>202420001</td>
                        <td>Mucyo Remy</td>
                        <td>Computer Science</td>
                        <td>Jan 21, 2026</td>
                       
                    </tr>
                    <tr>
                        <td>202420002</td>
                        <td>NAHIMANA Eugene</td>
                        <td>Computer Science</td>
                        <td>Jan 22, 2026</td>
                   
                    </tr>
                    <tr>
                        <td>202420003</td>
                        <td>CYUSA Kevin</td>
                        <td>Computer Science</td>
                        <td>Jan 21, 2026</td>
                      
                    </tr>
                    <tr>
                        <td>202420004</td>
                        <td>Manzi Willy</td>
                        <td>Computer Science</td>
                        <td>Jan 24, 2026</td>
                       
                    </tr>
                </tbody>
            </table>
        </div>

       

    </main>
    

</div>

</body>
</html>
