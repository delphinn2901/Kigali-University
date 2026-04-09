<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard – Course Catalog</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link rel="stylesheet" href="style.css">
</head>
<body>
  <aside class="sidebar">
    <div class="top-link">
                <a href="usermanagement.php"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>
    <nav class="nav">
      <a href="usermanagement.php"><i class="fa-solid fa-user-gear"></i> User Management</a>
      <a href="coursecatalog.php"><i class="fa-solid fa-book"></i> Course Catalog</a>
      <a href="systemreport.php"><i class="fa-chisel fa-regular fa-calendar"></i> System Reports</a>
      <a href="setting.html"><i class="fa-solid fa-gear"></i> Settings</a>
    </nav>
  </aside>

  <main class="main">
    <h1>Admin Dashboard</h1><br>
            <div class="prof">
                <p>Adminstrator</p>
                <img src="IMG/a7734f7af1d83b4207c3a6a4ea5f8351.jpg" alt="">
            </div><br><hr><br>
    
    <div class="topbar">
      <div class="breadcrumb">Dashboard &gt; <span>Add Course</span></div>
    </div>

    <section class="section">
      <div class="section-header">
     
        <a href="lecturer_reg.html"><button class="btn_addnew"><i class="fa-solid fa-user-plus"></i>  Add Course</button></a>
      
      </div>

    <form action="add_course.php" method="POST">

    <label>Course Code</label>
    <input type="text" name="course_code" required placeholder="e.g. CS101">

    <label>Course Name</label>
    <input type="text" name="course_name" required placeholder="e.g. Introduction to Computer Science">

    <label>Credit</label>
    <input type="number" name="credit" required min="1" max="10">

    <label>Lecturer</label>
    <select name="lecturer_id">
        <option value="">-- Select Lecturer --</option>
<?php
include "../connection.php";

$sql = "SELECT user_id, full_name 
        FROM users 
        WHERE role='lecturer'";

$result = $connect->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<option value='".$row['user_id']."'>".$row['full_name']."</option>";
}
?>


    </select>

    <label>Semester</label>
    <select name="semester" required>
        <option value="">-- Select Semester --</option>
        <option value="Semester 1">Semester 1</option>
        <option value="Semester 2">Semester 2</option>
    </select>

    <button type="submit">Add Course</button>

</form>

    </section>
  </main>
</body>
</html>

<?php
// add_course.php
include "../connection.php"; // make sure the path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form values safelyDD
    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $credit      = (int) $_POST['credit'];
    $lecturer_id = $_POST['lecturer_id'] ?: NULL; // NULL if no lecturer selected
    $semester    = $_POST['semester'];

    // Simple validation
    if (empty($course_code) || empty($course_name) || empty($credit) || empty($semester)) {
        echo "Please fill in all required fields.";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $connect->prepare("INSERT INTO courses (course_code, course_name, credit, lecturer_id, semester) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $course_code, $course_name, $credit, $lecturer_id, $semester);

        if ($stmt->execute()) {
            echo "<script>alert('Course Added Now');
                    location.replace('coursecatalog.php');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
