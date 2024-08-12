<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    if (!empty($name) && !empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imagePath = 'uploads/' . uniqid() . '-' . basename($image['name']);
        $imageType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        if ($imageType === 'jpg' || $imageType === 'png') {
            move_uploaded_file($image['tmp_name'], $imagePath);

            $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssds", $name, $email, $address, $class_id, $imagePath);
            $stmt->execute();
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid image format. Only JPG and PNG are allowed.";
        }
    } else {
        echo "Name and image are required.";
    }
}

$classesResult = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css">
    <title>Create Student</title>
</head>
<body>
    <div class="container">
        <h1>Create Student</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Class</label>
                <select name="class_id" class="form-control">
                    <?php while ($class = $classesResult->fetch_assoc()): ?>
                        <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
