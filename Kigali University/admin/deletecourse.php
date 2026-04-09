<?php
include "../connection.php";

if (isset($_GET['course_id'])) {
    $course_id = (int) $_GET['course_id'];

    $stmt = $connect->prepare("DELETE FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        header("Location: coursecatalog.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record.";
    }
}
?>