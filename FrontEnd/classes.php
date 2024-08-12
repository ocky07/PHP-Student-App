<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $class_name);
        $stmt->execute();
        header("Location: classes.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
    $class_id = $_POST['class_id'];
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $stmt = $conn->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
        $stmt->bind_param("si", $class_name, $class_id);
        $stmt->execute();
        header("Location: classes.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    header("Location: classes.php");
    exit;
}

$classesResult = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css">
    <title>Manage Classes</title>
</head>
<body>
    <div class="container">
        <h1>Classes</h1>
        <form method="POST">
            <div class="form-group">
                <label>New Class Name</label>
                <input type="text" name="class_name" class="form-control" required>
            </div>
            <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
        </form>
        <h2>Existing Classes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($class = $classesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $class['name']; ?></td>
                        <td><?php echo $class['created_at']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $class['class_id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $class['class_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
