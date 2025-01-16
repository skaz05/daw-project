<?php
require_once 'includes/db.php';
session_start();

// verifica daca exista sesiune -> obtine user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // obtin detalii despre user din db
    $query = "SELECT full_name FROM USERS WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // daca exista user => msj personalizat
        $user_name = htmlspecialchars($user['full_name']);
        $message = "Welcome, $user_name!";
    } else {
        // daca e sesiune dar nu e info -> cornercase -> msj generic
        $message = "Welcome!";
    }
} else {
    // fara sesiune -> msj generic
    $message = "Welcome!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1><?= $message ?></h1>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- daca nu este logat -->
        <p><a href="login.php">Log in</a> pt toate features.</p>
    <?php else: ?>
        <!-- daca este logat -->
        <p><a href="logout.php">Log out</a></p>
    <?php endif; ?>
    <p>Pe acest site veti gasi oferte de nerefuzat!</p>
</body>
</html>
