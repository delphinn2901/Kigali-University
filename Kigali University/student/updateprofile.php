<?php
session_start();
include "../connection.php";

if (isset($_POST['submit'])) {

    $user_id = $_SESSION['user_id'];

    // get form data safely
    $reg_number    = mysqli_real_escape_string($connect, $_POST['reg_number']);
    $department    = mysqli_real_escape_string($connect, $_POST['department']);
    $year_of_study = mysqli_real_escape_string($connect, $_POST['year_of_study']);

    // check if reg_number exists for another user
    $check = "SELECT * FROM students WHERE reg_number='$reg_number' AND user_id != '$user_id'";
    $result = mysqli_query($connect, $check);

    if (mysqli_num_rows($result) > 0) {

        echo "<script>
                alert('Registration number already exists!');
                location.replace('edit_profile.php');
              </script>";

    } else {

        // UPDATE query
        $sql = "UPDATE students 
                SET reg_number='$reg_number', 
                    department='$department', 
                    year_of_study='$year_of_study'
                WHERE user_id='$user_id'";

        if (mysqli_query($connect, $sql)) {

            echo "<script>
                    alert('Profile updated successfully!');
                    location.replace('profile.php');
                  </script>";

        } else {

            echo "<script>
                    alert('Error updating profile');
                    location.replace('edit_profile.php');
                  </script>";
        }
    }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css_st/student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>

    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="top-link">
                <a href="home.html"><img src="IMG/LOGO.png" alt="kigali university"></a>
            </div>

            <ul>
                <li><a href="student.php"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="profile.php"><i class="fa-solid fa-circle-user"></i> Profile</a></li>
                <li><a href="my schedule.php"><i class="fa-solid fa-calendar"></i> My Schedule</a></li>
                <li><a href="coursereg.php"><i class="fa-etch fa-solid fa-book"></i> Course Registration</a></li>
                <li class="logout"><a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>


            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main">
            <div class="header">
            <h2>Edit your Profile</h2>
        </div>
<?php
include "../connection.php";

$user_id = $_SESSION['user_id'];

// fetch existing data
$sql = "SELECT * FROM students WHERE user_id='$user_id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
?>

<form method="POST">

    <label>Registration Number</label>
    <input type="text" name="reg_number"
           value="<?php echo $row['reg_number']; ?>"
           placeholder="E.g: 202420001" required>
    <br>

    <label>Department</label>
    <input type="text" name="department"
           value="<?php echo $row['department']; ?>"
           placeholder="E.g: Computer Science" required>
    <br>

    <label>Year of Study</label>
    <select name="year_of_study" required>
        <option value="">Select Year</option>
        <option value="Year 1" <?php if($row['year_of_study']=="Year 1") echo "selected"; ?>>Year 1</option>
        <option value="Year 2" <?php if($row['year_of_study']=="Year 2") echo "selected"; ?>>Year 2</option>
        <option value="Year 3" <?php if($row['year_of_study']=="Year 3") echo "selected"; ?>>Year 3</option>
        <option value="Year 4" <?php if($row['year_of_study']=="Year 4") echo "selected"; ?>>Year 4</option>
    </select>
    <br>

    <button type="submit" name="submit">Save Information</button>

</form>
        </main>

    </div> 


</body>   
</html>