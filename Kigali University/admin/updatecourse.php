<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<?php
include "../connection.php";

$course = null;

// 1️⃣ Fetch existing data
if (isset($_GET['course_id'])) {
    $course_id = (int)$_GET['course_id'];
    $stmt = $connect->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $course = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// 2️⃣ Handle Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id   = (int)$_POST['course_id']; 
    $course_code = trim($_POST['course_code']);
    $course_name = trim($_POST['course_name']);
    $credit      = (int)$_POST['credit'];
    $semester    = $_POST['semester'];
    $l_id        = (int)$_POST['lecturer_id']; // This should be the actual lecturer_id

    if (!empty($course_id) && !empty($course_code)) {
        $update = $connect->prepare(
            "UPDATE courses 
             SET course_code = ?, course_name = ?, credit = ?, lecturer_id = ?, semester = ?
             WHERE course_id = ?"
        );

        // Match types: s = string, i = integer
        $update->bind_param("ssissi", $course_code, $course_name, $credit, $l_id, $semester, $course_id);

        if ($update->execute()) {
            echo "<script>alert('Updated!'); window.location='coursecatalog.php';</script>";
            exit;
        } else {
            echo "Error: " . $connect->error;
        }
        $update->close();
    }
}
?>

<?php if($course): ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="style.css">
    <title>Update courses</title>
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
                <p>HABIMANA Amani Felix</p>
                <img src="IMG/a7734f7af1d83b4207c3a6a4ea5f8351.jpg" alt="">
            </div><br><hr><br>
    
    <div class="topbar">
      <div class="breadcrumb">Dashboard &gt; <span>Edit Course</span></div>
    </div>

    <section class="section">
      <div class="section-header">
        <h3>Edit Course</h3>
        <a href="add_course.php"><button class="btn"><i class="fa-solid fa-user-plus"></i>  Add Course</button></a>

      </div>
     <form action="" method="POST">
        <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
        
        <label>Course Code</label>
        <input type="text" name="course_code" value="<?= htmlspecialchars($course['course_code']) ?>" required>

        <label>Course Name</label>
        <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>

        <label>Credit</label>
        <input type="number" name="credit" value="<?= $course['credit'] ?>" required>

        <label>Lecturer ID</label>
        <input type="number" name="lecturer_id" value="<?= $course['lecturer_id'] ?>" required>

        <label>Semester</label>
        <select name="semester" required>
            <option value="Semester 1" <?= ($course['semester'] == "Semester 1") ? "selected" : "" ?>>Semester 1</option>
            <option value="Semester 2" <?= ($course['semester'] == "Semester 2") ? "selected" : "" ?>>Semester 2</option>
        </select>

        <button type="submit">Update Course</button>
    </form>
   </body>
   </html>
<?php else: ?>
    <p>Course not found or ID missing.</p>
<?php endif; ?>