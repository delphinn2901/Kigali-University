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
      <div class="breadcrumb">Dashboard &gt; <span>Add Course</span></div>
    </div>

    <section class="section">
      <div class="section-header">
     
        <!-- <a href="lecturer_reg.html"><button class="btn_addnew"><i class="fa-solid fa-user-plus"></i>  Add Course</button></a> -->
      
      </div>
<?php
include "../connection.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $credit      = (int) $_POST['credit'];
    $lecturer_user_id = $_POST['lecturer_id'];
    $semester    = $_POST['semester'];

    if (empty($course_code) || empty($course_name) || empty($credit) || empty($semester) || empty($lecturer_user_id)) {
        echo "Please fill in all required fields!";
    } else {
        // Ensure the lecturer exists in lecturers table
        $check = $connect->prepare("SELECT lecturer_id FROM lecturers WHERE user_id = ?");
        $check->bind_param("i", $lecturer_user_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows == 0) {
            // Insert into lecturers table if not exists
            $insert_lecturer = $connect->prepare("INSERT INTO lecturers (user_id, department) VALUES (?, 'Unknown')");
            $insert_lecturer->bind_param("i", $lecturer_user_id);
            $insert_lecturer->execute();
            $insert_lecturer->close();
        }
        $check->close();

        // Get lecturer_id from lecturers table
        $get_lecturer_id = $connect->prepare("SELECT lecturer_id FROM lecturers WHERE user_id = ?");
        $get_lecturer_id->bind_param("i", $lecturer_user_id);
        $get_lecturer_id->execute();
        $get_lecturer_id->bind_result($lecturer_id);
        $get_lecturer_id->fetch();
        $get_lecturer_id->close();

        // Insert course
        $stmt = $connect->prepare("INSERT INTO courses (course_code, course_name, credit, lecturer_id, semester) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $course_code, $course_name, $credit, $lecturer_id, $semester);

        if ($stmt->execute()) {
             echo "<script>alert('Course Added Now');
                    location.replace('coursecatalog.php');</script>";
        } else {
            echo "<p style='color:red;'>Error: ".$stmt->error."</p>";
        }

        $stmt->close();
    }
}
?>

<!-- Course Form -->
<form action="" method="POST">
    <label>Course Code</label>
    <input type="text" name="course_code" required placeholder="e.g. CS101">

    <label>Course Name</label>
    <input type="text" name="course_name" required placeholder="e.g. Intro to CS">

    <label>Credit</label>
    <input type="number" name="credit" required min="1" max="10">

    <label>Lecturer</label>
    <select name="lecturer_id" required>
        <option value="">-- Select Lecturer --</option>
        <?php
        $sql = "SELECT user_id, full_name FROM users WHERE role='lecturer'";
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
