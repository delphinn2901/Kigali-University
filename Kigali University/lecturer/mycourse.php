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
    <title>My Courses</title>
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

        <!-- Main -->
        <main class="main">
            <h1>My Courses</h1>
            <div class="prof">
                <p><?php echo $full_name; ?></p>
                <img src="IMG/profilee.jpg" alt="">
            </div>
            <hr><br><br>
<?php
include "../connection.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT c.course_code, c.course_name, c.credit
        FROM courses c
        JOIN lecturers l ON c.lecturer_id = l.lecturer_id
        WHERE l.user_id = '$user_id'";

$result = mysqli_query($connect, $sql);

if(!$result){
    die("Query Failed: ".mysqli_error($connect));
}
?>
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
                       <tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr style="border-bottom:1px solid #ddd;">
<td><?php echo $row['course_code']; ?></td>
<td><?php echo $row['course_name']; ?></td>
<td align="center"><?php echo $row['credit']; ?></td>
</tr>

<?php } ?>

</tbody>
                    </tbody>
                </table>
            </div>

        </main>

    </div>

</body>

</html>