<!-- <?php
// Connect to DB
$conn = new mysqli("localhost", "username", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval
if (isset($_POST['approve_id'])) {
    $registration_id = $_POST['approve_id'];
    $stmt = $conn->prepare("UPDATE registrations SET status='approved' WHERE registration_id=?");
    $stmt->bind_param("i", $registration_id);
    $stmt->execute();
    echo "<p style='color:green;'>Registration approved successfully!</p>";
    }

// Fetch pending registrations
$sql = "SELECT r.registration_id, s.registration_number, u.full_name, c.course_name, r.registered_at
        FROM registrations r
        JOIN students s ON r.student_id = s.student_id
        JOIN users u ON s.user_id = u.user_id
        JOIN courses c ON r.course_id = c.course_id
        WHERE r.status='pending'";
$result = $conn->query($sql);
?>

<h2>Pending Registrations</h2>

<?php if ($result->num_rows > 0): ?>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Student Name</th>
        <th>Registration Number</th>
        <th>Course</th>
        <th>Registered At</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['registration_number']; ?></td>
        <td><?php echo $row['course_name']; ?></td>
        <td><?php echo $row['registered_at']; ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="approve_id" value="<?php echo $row['registration_id']; ?>">
                <button type="submit">Approve</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>No pending registrations.</p>
<?php endif; ?>

<?php $conn->close(); ?> -->
