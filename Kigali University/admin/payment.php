<form action="" method="POST">

    <label>Select Student</label>
    <select name="student_id" required>
        <option value="">-- Select Student --</option>
        <?php
        // Connect to DB
        $conn = new mysqli("localhost", "username", "password", "database_name");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch students
        $sql = "SELECT s.student_id, u.full_name 
                FROM students s 
                JOIN users u ON s.user_id = u.user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<option value="'. $row['student_id'] .'">'. $row['full_name'] .'</option>';
            }
        }
        ?>
    </select>

    <label>Amount</label>
    <input type="number" name="amount" step="0.01" required placeholder="e.g. 500.00">

    <label>Status</label>
    <select name="status" required>
        <option value="unpaid">Unpaid</option>
        <option value="paid">Paid</option>
    </select>

    <label>Payment Date</label>
    <input type="date" name="payment_date" required>

    <button type="submit">Record Payment</button>

</form>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];
    $payment_date = $_POST['payment_date'];

    $stmt = $conn->prepare("INSERT INTO payments (student_id, amount, status, payment_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $student_id, $amount, $status, $payment_date);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Payment recorded successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
