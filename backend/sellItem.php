<?php
// Database connection settings
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_database_user';
$pass = 'your_database_password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $price_bought = $_POST['price_bought'];
    $userKey = $_POST['userKey'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $source = $_POST['source'];

    // Handle image upload
    $image = $_FILES['image'];
    $imagePath = "uploads/" . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $imagePath);

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO products (name, quantity, price, price_bought, userKey, date, description, source, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sidssssss", $name, $quantity, $price, $price_bought, $userKey, $date, $description, $source, $imagePath);

    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
