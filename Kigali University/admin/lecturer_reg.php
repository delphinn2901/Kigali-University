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
      <div class="breadcrumb">Dashboard &gt; <span>Course Catalog</span></div>
    </div>

    <section class="section">
      <div class="section-header">
     
          <!-- <a href="lecturer_reg.html"><button class="btn_add"><i class="fa-solid fa-user-plus"></i>  Add User</button></a> -->
      
      </div>
        <h2>Lecturer Details</h2>

    <form method="POST">
        <!-- user_id comes from session or admin selection -->
        <input type="hidden" name="user_id" value="3">
        <label>Select Lecturer</label>
    <select name="user_id" required>
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

        <label>Department</label>
        <input type="text" name="department" required>

        <button type="submit">Save Lecturer</button>
    </form>
    </section>
  </main>
</body>
</html>
<?php
include "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST['user_id'];
    $department = $_POST['department'];

    // check if already exists
    $check = $connect->prepare("SELECT lecturer_id FROM lecturers WHERE user_id=?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        echo "Lecturer already exists.";

    } else {

        $stmt = $connect->prepare("INSERT INTO lecturers (user_id, department) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $department);

        if ($stmt->execute()) {
             echo "<script>alert('Lecturer inserted successfully');
                    location.replace('usermanagement.php');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
}
?>
