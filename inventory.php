<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SeERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_name'], $_POST['category'], $_POST['quantity'], $_POST['price'], $_POST['supplier'])) {
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $category = $conn->real_escape_string($_POST['category']);
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        $supplier = $conn->real_escape_string($_POST['supplier']);

        // Insert data into the database
        $sql = "INSERT INTO products (product_name, category, quantity, price, supplier) 
                VALUES ('$product_name', '$category', $quantity, $price, '$supplier')";

        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully.<br>";
            if (empty($product_name) && ($product_name) < 5) {
                $errors[] = "Product Name is required.";
            }
            if (empty($category)) {
                $errors[] = "Category is required.";
            } elseif (!is_numeric($quantity)) {
                $errors[] = "Quantity must be a number.";
            } 
            if (empty($price)) {
                $errors[] = "Price is required.";
            } else if (($price) < 0) {
                $errors[] = "Enter a valid price.";
            }
            if (empty($supplier)) {
                $errors[] = "Supplier is required.";
            } else if (($supplier) < 5) {
                $errors[] = "Enter a valid supplier name.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Form data is incomplete.<br>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
</head>
<body>
    <h1>Inventory Management</h1>
    <form method="POST" action="">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <label for="supplier">Supplier:</label>
        <input type="text" id="supplier" name="supplier" required><br><br>

        <input type="submit" value="Add Product">
    
</body>
</html>