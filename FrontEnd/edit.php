<?php
include 'includes/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$classesResult = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    $imagePath = $student['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imagePath = 'uploads/' . uniqid() . '-' . basename($image['name']);
        $imageType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        if ($imageType === 'jpg' || $imageType === 'png') {
            move_uploaded_file($image['tmp_name'], $imagePath);
        } else {
            echo "Invalid image format. Only JPG and PNG are allowed.";
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssdsi", $name, $email, $address, $class_id, $imagePath, $id);
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
    <title>Edit Student</title>
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control"><?php echo $student['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Class</label>
                <select name="class_id" class="form-control">
                    <?php while ($class = $classesResult->fetch_assoc()): ?>
                        <option value="<?php echo $class['class_id']; ?>" <?php echo $student['class_id'] == $class['class_id'] ? 'selected' : ''; ?>><?php echo $class['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
                <img src="uploads/<?php echo $student['image']; ?>" alt="Image" style="width:50px;">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
