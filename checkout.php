<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// fa retrieve la tot ce e in cart pt userul actual
$query = "SELECT c.tour_id, c.quantity, t.tour_price
          FROM CART c
          JOIN TOURS t ON c.tour_id = t.tour_id
          WHERE c.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    echo "Cosul e gol";
    // exit();
}

// calcul pret total
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['quantity'] * $item['tour_price'];
}

// insert in tabela TRANSACTIONS
$query = "INSERT INTO TRANSACTIONS (user_id, transaction_date, total_amount)
          VALUES (:user_id, NOW(), :total_amount)";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id, 'total_amount' => $total_amount]);

// obtinere transaction_id
$transaction_id = $pdo->lastInsertId(); // <- multumesc doamne pt google si gpt

// insert fiecare item din cart ca si un entry separat in tabela TRANSACTION_ITEMS
$query = "INSERT INTO TRANSACTION_ITEMS (transaction_id, tour_id, quantity, price)
          VALUES (:transaction_id, :tour_id, :quantity, :price)";
$stmt = $pdo->prepare($query);
foreach ($cart_items as $item) {
    $stmt->execute([
        'transaction_id' => $transaction_id,
        'tour_id' => $item['tour_id'],
        'quantity' => $item['quantity'],
        'price' => $item['tour_price']
    ]);
}

// curatare cos
$query = "DELETE FROM CART WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);

echo "Tranzactie finalizata cu succes!";
header("Location: user.php");
exit();
?>
