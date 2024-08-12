<?php
include 'includes/db.php';

$sql = "SELECT student.id, student.name, student.email, student.created_at, student.image, classes.name AS class_name 
        FROM student 
        JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css">
    <title>Student List</title>
</head>
<body>
    <div class="container">
        <h1>Students</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Created At</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['class_name']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><img src="uploads/<?php echo $row['image']; ?>" alt="Image" style="width:50px;"></td>
                        <td>
                            <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
