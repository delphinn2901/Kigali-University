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
  <title>Admin Dashboard – System Reports</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
      <div class="breadcrumb">Dashboard &gt; <span>System Reports</span></div>
    </div>

    <div class="cards">
      <div class="card"><h4>Total Users</h4><div class="value">10,245</div></div>
      <div class="card"><h4>Active Courses</h4><div class="value">48</div></div>
      <div class="card"><h4>System Logs</h4><div class="value">1,203</div></div>
      <div class="card"><h4>Errors</h4><div class="value">12</div></div>
    </div>
  </main>
</body>
</html>