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
  <title>Admin Dashboard – User Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: #f5f7fb;
      color: #1f2937;
      display: flex;
      height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: #E5AD05;
      color: #fff;
      padding: 24px 18px;
      display: flex;
      flex-direction: column;
    }
    .sidebar h2 {
      font-size: 20px;
      margin-bottom: 32px;
      font-weight: 700;
    }
    .top-link img{
    width: 100px;
    height: 100px;
    margin-left: 50px;
}

    .nav a {
      display: block;
      padding: 12px 14px;
      border-radius: 10px;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      margin-bottom: 10px;
      font-size: 14px;
    }
    .nav a.active, .nav a:hover {
      background: #1e293b;
      color: #fff;
    }

    /* Main */
    .main {
      flex: 1;
      padding: 28px 32px;
      overflow-y: auto;
    }
    .main .prof img{
    width: 70px;
    height: 70px;
    border-radius: 40PX;
    margin-left: 1100px;
    margin-top: -50px;
}
.main .prof p{
    margin-left: 980px;
    font-weight: bold;
}

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }
    .breadcrumb {
      font-size: 14px;
      color: #6b7280;
    }
    .breadcrumb span {
      color: #111827;
      font-weight: 600;
    }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      background: #fff;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .card h4 {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 10px;
    }
    .card .value {
      font-size: 28px;
      font-weight: 700;
    }
    .card small {
      color: #16a34a;
      font-weight: 500;
    }

    /* User Management */
    .section {
      background: #fff;
      border-radius: 18px;
      padding: 22px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
    }
    .section-header h3 {
      font-size: 18px;
      font-weight: 700;
    }
    .actions {
      display: flex;
      gap: 12px;
    }
    .search {
      padding: 10px 14px;
      border-radius: 10px;
      border: 1px solid #e5e7eb;
      font-size: 14px;
    }
    .btn {
      padding: 10px 16px;
      border-radius: 10px;
      border: none;
      background: #E5AD05;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: #f9fafb;
    }
    th, td {
      padding: 14px 12px;
      text-align: left;
      font-size: 14px;
    }
    th {
      color: #6b7280;
      font-weight: 600;
    }
    tbody tr {
      border-bottom: 1px solid #e5e7eb;
    }
    .role {
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
    }
    .student { background: #e0f2fe; color: #0369a1; }
    .lecturer { background: #dcfce7; color: #166534; }
    .status {
      font-size: 13px;
      font-weight: 500;
    }
    .online { color: #16a34a; }
    .offline { color: #6b7280; }

    @media (max-width: 1100px) {
      .cards { grid-template-columns: repeat(2, 1fr); }
    }
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
      <div class="breadcrumb">Dashboard &gt; <span>User Management</span></div>
    </div>

  <div class="cards">
      <div class="card">
        <h4>Total Registered Students</h4>
        <div class="value">10,203</div>
        <small>+12 this week</small>
      </div>
      <div class="card">
        <h4>Active Courses</h4>
        <div class="value">48</div>
      </div>
      <div class="card">
        <h4>Pending Approvals</h4>
        <div class="value">15</div>
      </div>
      <div class="card">
        <h4>Active Lecturers</h4>
        <div class="value">22</div>
      </div>
    </div> 



</div>

    <section class="section">
      <div class="section-header">
        <h3>User Management</h3>
        <div class="actions">
          <input type="text" class="search" placeholder="Search by Email or Name">
          <a href="lecturer_reg.php"><button class="btn"><i class="fa-solid fa-user-plus"></i>  Add User</button></a>
        </div>
      </div>
<?php
include "../connection.php";

// fetch students and lecturers with department
// $sql = "SELECT users.user_id, users.full_name, users.role, lecturers.department
//         FROM users
//         LEFT JOIN lecturers ON users.user_id = lecturers.user_id
//         WHERE users.role IN ('student','lecturer')
//         ORDER BY users.full_name";

$sql = "SELECT 
    users.user_id, 
    users.full_name, 
    users.role,
    COALESCE(lecturers.department, students.department) AS department
FROM users
LEFT JOIN lecturers ON users.user_id = lecturers.user_id
LEFT JOIN students ON users.user_id = students.user_id
WHERE users.role IN ('Student','Lecturer')
ORDER BY users.full_name;";

$result = $connect->query($sql);
?>

<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Role</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

<?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
        echo "<td>" . htmlspecialchars($row['department'] ?? '-') . "</td>";

        echo "<td>
                <a href='update_user.php?user_id=" . urlencode($row['user_id']) . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                
                <a href='delete_user.php?user_id=" . urlencode($row['user_id']) . "' 
                   class='btn-delete'
                   onclick=\"return confirm('Are you sure you want to delete this user?');\"><i class='fa-solid fa-trash'></i>
                   Delete
                </a>
              </td>";

        echo "</tr>";
    }

} else {

    echo "<tr><td colspan='4'>No users found</td></tr>";

}
?>

</tbody>
</table>


    </section>

  </main>
</body>
</html>
