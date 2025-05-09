<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Username sudah ada
        $_SESSION['register_error'] = "Username sudah digunakan.";
        header("Location: ../register.php");
        exit();
    }
    $stmt->close();

    // Check if passwords match
    if ($password !== $confirm_password) {
        // Password tidak sama
        $_SESSION['register_error'] = "Password dan konfirmasi password tidak sama.";
        header("Location: ../register.php");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    if ($stmt->execute()) {
        // Register berhasil
        $_SESSION['register_success'] = "Registrasi berhasil. Silakan login.";
        header("Location: ../login.php");
        exit();
    } else {
        // Register gagal
        $_SESSION['register_error'] = "Registrasi gagal. Silakan coba lagi.";
        header("Location: ../register.php");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
