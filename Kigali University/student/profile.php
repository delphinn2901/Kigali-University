<?php
session_start();
include "../connection.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM students WHERE user_id='$user_id'";
$result = mysqli_query($connect, $sql);

$student = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link rel="stylesheet" href="css_st/student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

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
<body>

<div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
         <div class="top-link">
                <a href="student.php"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>
     
           <ul>
                <li><a href="student.php"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="profile.php"><i class="fa-solid fa-circle-user"></i> Profile</a></li>
                <li><a href="my schedule.php"><i class="fa-solid fa-calendar"></i> My Schedule</a></li>
                <li><a href="coursereg.php"><i class="fa-etch fa-solid fa-book"></i> Course Registration</a></li>
                <li class="logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>


            </ul>
    </aside>

   

    <main class="main">

        <div class="header">
            <div class="prof">
                <h2>My Profile</h2>
                <h4>Complete your student information</h4>
                <p><?php echo $full_name; ?></p>
                <img src="IMG/profilee.jpg" alt="">
            </div>
        </div>
       
                
                

        <section class="card profile-card">
            <?php if(!$student){ ?>

            <form method="POST">

                <label>Registration Number</label>
                <input type="text" name="reg_number" placeholder="E.g: 202420001" required>
                <br>
                <label>Department</label>
                <input type="text" name="department" placeholder="E.g: Computer Science" required>
<br>
                <label>Year of Study</label>
                <select name="year_of_study" required>
                    <option value="">Select Year</option>
                    <option value="Year 1">Year 1</option>
                    <option value="Year 2">Year 2</option>
                    <option value="Year 3">Year 3</option>
                    <option value="Year 4">Year 4</option>
                </select>
<br>
                <button type="submit" name="submit">Save Information</button>

            </form>
<?php } ?>
  
<?php
include "../connection.php";

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    // get form data and escape
    $reg_number    = mysqli_real_escape_string($connect, $_POST['reg_number']);
    $department    = mysqli_real_escape_string($connect, $_POST['department']);
    $year_of_study = mysqli_real_escape_string($connect, $_POST['year_of_study']);

    // check if reg_number already exists
    $check = "SELECT * FROM students WHERE reg_number='$reg_number'";
    $result = mysqli_query($connect, $check);

    if (mysqli_num_rows($result) > 0) {

        echo "<script>
                alert('Registration number already exists!');
                location.replace('student_profile_form.php');
              </script>";

    } else {

        // insert new student
    session_start();
$user_id = $_SESSION['user_id']; // get the logged-in user's id

$sql = "INSERT INTO students (user_id, reg_number, department, year_of_study)
        VALUES ('$user_id', '$reg_number', '$department', '$year_of_study')";
        if (mysqli_query($connect, $sql)) {

            echo "<script>
                    alert('Student information saved successfully!');
                    location.replace('profile.php');
                  </script>";

        } else {

            echo "<script>
                    alert('Error saving student information');
                    location.replace('profile.php');
                  </script>";

        }
    }
}
?>


<!-- Display student information -->

<?php
include "../connection.php";

// check if student is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first!');
            location.replace('login.php');
          </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE user_id='$user_id'";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    // echo "<script>
    //         alert('No profile found!');
    //         location.replace('profile.php');
    //       </script>";
    exit;
}
?>


    <h2>My Profile</h2>
        <a href="updateprofile.php"><button class="btn"><i class="fa-solid fa-user-plus"></i>Edit Profile</button></a>

 <?php if($student){ ?>



<table width="50px">
<tr>
<th>Registration Number</th>
<td><?php echo $student['reg_number']; ?></td>
</tr>

<tr>
<th>Department</th>
<td><?php echo $student['department']; ?></td>
</tr>

<tr>
<th>Year of Study</th>
<td><?php echo $student['year_of_study']; ?></td>
</tr>

</table>

<?php } ?>
      </section>

    </main>

</div>


</body>
</html>