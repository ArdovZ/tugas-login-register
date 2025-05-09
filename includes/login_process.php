<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Username not found
        $_SESSION['login_error'] = "Username tidak ditemukan.";
        header("Location: ../login.php");
        exit();
    } else {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            // Password salah
            $_SESSION['login_error'] = "Password salah.";
            header("Location: ../login.php");
            exit();
        }
    }
    $stmt->close();
    $conn->close();
}
?>
