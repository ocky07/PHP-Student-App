<?php
include 'includes/db.php';

$id = $_GET['id'];
$sql = "SELECT student.*, classes.name AS class_name FROM student JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css">
    <title>View Student</title>
</head>
<body>
    <div class="container">
        <h1><?php echo $student['name']; ?></h1>
        <p>Email: <?php echo $student['email']; ?></p>
        <p>Address: <?php echo $student['address']; ?></p>
        <p>Class: <?php echo $student['class_name']; ?></p>
        <p>Created At: <?php echo $student['created_at']; ?></p>
        <img src="uploads/<?php echo $student['image']; ?>" alt="Image" style="width:150px;">
    </div>
</body>
</html>
