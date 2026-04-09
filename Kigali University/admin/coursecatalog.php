<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard – Course Catalog</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link rel="stylesheet" href="style.css">
</head>
<style>
.btn-edit{
    background-color: #3498db;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    margin-right: 5px;
}

.btn-edit:hover{
    background-color: #2980b9;
    transform: scale(1.05);

}

.btn-delete{
    background-color: #e74c3c;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.btn-delete:hover{
    background-color: #c0392b;
    transform: scale(1.05);

}

td a{
    display: inline-block;
}
</style>
<body>
  <aside class="sidebar">
    <div class="top-link">
                <a href="usermanagement.php"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>
    <nav class="nav">
       <a href="usermanagement.php"><i class="fa-solid fa-user-gear"></i> User Management</a>
      <a href="coursecatalog.php"><i class="fa-solid fa-book"></i> Course Catalog</a>
      <a href="systemreport.php"><i class="fa-chisel fa-regular fa-calendar"></i> System Reports</a>
      <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
    </nav>
  </aside>

  <main class="main">
    <h1>Admin Dashboard</h1><br>
           <div class="prof">
              
                <p>Administrator</p>
                <img src="IMG/profl.jpg" alt="">
            </div><br><hr><br>
    
    <div class="topbar">
      <div class="breadcrumb">Dashboard &gt; <span>Course Catalog</span></div>
    </div>

    <section class="section">
      <div class="section-header">
        <h3>Course Catalog</h3>
        <a href="add_course.php"><button class="btn"><i class="fa-solid fa-user-plus"></i>  Add Course</button></a>

      </div>
<table>
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Credit</th>
            <th>Lecturer Name</th>
            <th>Semester</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
  <?php
include "../connection.php";

$sql = "SELECT c.course_id, c.course_name, c.course_code, c.credit, 
               u.full_name AS lecturer_name, c.semester
        FROM courses c
        LEFT JOIN lecturers l ON c.lecturer_id = l.lecturer_id
        LEFT JOIN users u ON l.user_id = u.user_id
        ORDER BY c.course_name";

$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['credit']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lecturer_name'] ?? 'Not Assigned') . "</td>";
        echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
       echo "<td>";
echo "<a href='updatecourse.php?course_id=" . $row['course_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i>Edit</a>";

echo "<a href='deletecourse.php?course_id=" . urlencode($row['course_id']) . "' 
           class='btn-delete'
           onclick=\"return confirm('Are you sure you want to delete this course?');\"><i class='fa-solid fa-trash'></i>
           Delete
        </a>";
echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No courses found</td></tr>";
}
?>
    </tbody>
</table>



    </section>
  </main>
</body>
</html>
