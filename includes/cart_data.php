<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['items' => []]);
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT t.tour_name AS name, t.tour_price AS price, c.quantity 
          FROM CART c 
          JOIN TOURS t ON c.tour_id = t.tour_id 
          WHERE c.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['items' => $cartItems]);
