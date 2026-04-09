<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<?php
include "../connection.php";

// 1️⃣ Get user id
if (!isset($_GET['user_id'])) {
    die("User ID not provided.");
}

$user_id = (int) $_GET['user_id'];

// 2️⃣ Fetch existing data
$stmt = $connect->prepare("
    SELECT users.full_name, users.role, lecturers.department
    FROM users
    LEFT JOIN lecturers ON users.user_id = lecturers.user_id
    WHERE users.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();


// 3️⃣ Update logic
if (isset($_POST['update'])) {

    $full_name = $_POST['full_name'];
    $role      = $_POST['role'];
    $department = $_POST['department'] ?? null;

    // Update users table
    $stmt1 = $connect->prepare("UPDATE users SET full_name=?, role=? WHERE user_id=?");
    $stmt1->bind_param("ssi", $full_name, $role, $user_id);
    $stmt1->execute();

    // If lecturer → update department
    if ($role == "lecturer") {

        $stmt2 = $connect->prepare("UPDATE lecturers SET department=? WHERE user_id=?");
        $stmt2->bind_param("si", $department, $user_id);
        $stmt2->execute();
    }

    header("Location: usermanagement.php?msg=updated");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
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
      <div class="breadcrumb">Dashboard &gt; <span>Update User</span></div>
    </div>
<h2>Update User</h2>

<form method="POST">
    <label>Full Name:</label><br>
    <input type="text" name="full_name"
        value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="student" <?php if($user['role']=="student") echo "selected"; ?>>Student</option>
        <option value="lecturer" <?php if($user['role']=="lecturer") echo "selected"; ?>>Lecturer</option>
    </select><br><br>

    <label>Department (Lecturer only):</label><br>
    <input type="text" name="department"
        value="<?php echo htmlspecialchars($user['department'] ?? ''); ?>"><br><br>

    <button type="submit" name="update">Update</button>
</form>
</main
</body>
</html>