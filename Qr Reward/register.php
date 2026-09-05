<?php

$conn = new mysqli("localhost", "root", "", "qr_reward", 3306);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);
$password = $_POST["password"];

// Convert empty email/phone to NULL
if ($email === "") {
    $email = NULL;
}

if ($phone === "") {
    $phone = NULL;
}

// Customer must provide email OR phone
if ($email === NULL && $phone === NULL) {
    die("Please enter either an email or phone number.");
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$sql = "INSERT INTO users (name, email, phone, password)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $phone,
    $hashed_password
);

if ($stmt->execute()) {

    echo "Account created successfully! ";

} else {

    echo "Registration failed: " . $stmt->error;

}

$stmt->close();
$conn->close();

?>