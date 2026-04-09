<?php
include "../connection.php";

if (!isset($_GET['user_id'])) {
    die("User ID not provided.");
}

$user_id = (int) $_GET['user_id'];

// Start transaction (safer)
$connect->begin_transaction();

try {

    // 1️⃣ Delete from lecturers table first
    $stmt1 = $connect->prepare("DELETE FROM lecturers WHERE user_id = ?");
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();

    // 2️⃣ Delete from users table
    $stmt2 = $connect->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();

    // Commit changes
    $connect->commit();

    header("Location: usermanagement.php?msg=deleted");
    exit();

} catch (Exception $e) {

    // If error → rollback
    $connect->rollback();
    echo "Error deleting user.";
}
?>