<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $fullName = trim($_POST['fullName']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    // query in db pt adaugare user
    $query = "INSERT INTO USERS (email, fullName, password) VALUES (:email, :fullName, :password)";

    // verificare daca sunt goale field-urile
    if (empty($email) || empty($fullName) || empty($password) || empty($password2)) {
        $error = "Toate campurile sunt obligatorii";
    } elseif ($password !== $password2) {
        $error = "Verificarea parolei a esuat";
    } else {
        // verificare daca exista contul deja in baza mailului
        $query = "SELECT COUNT(*) FROM USERS WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error = "Email-ul exista deja in baza de date";
        } else {
            // inserare user nou in db
            $query = "INSERT INTO USERS (email, full_name, password, registration_date) VALUES (:email, :fullName, :password, NOW())";
            $stmt = $pdo->prepare($query);

            $stmt->execute([
                'email' => $email,
                'fullName' => $fullName,
                'password' => $password
            ]);

            $success = "User creat cu succes. Puteti accesa contul";
            // exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/style.css">
    <title>Registration</title>
</head>
<body>
<header>
    <h1>Travel Agency</h1>
</header>
<div class="container">
    <h1>Inregistrare</h1>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>
    
    <form method="POST" action="register.php">
        <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>
        <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        <label for="password2">Password verification:</label>
            <input type="password" id="password2" name="password2" required>
        <button type="submit">Inregistrare</button>
    </form>
</div>
<footer>
    &copy; <?= date('Y') ?> Sebi Travel Agency. All rights reserved.
</footer>
</body>
</html>
