<?php
include 'includes/db.php';

$id = $_GET['id'];
$sql = "SELECT image FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unlink($student['image']);

    $stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css">
    <title>Delete Student</title>
</head>
<body>
    <div class="container">
        <h1>Delete Student</h1>
        <p>Are you sure you want to delete <?php echo $student['name']; ?>?</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
