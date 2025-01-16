<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        $query = "UPDATE CART SET quantity = :quantity WHERE cart_id = :cart_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['quantity' => $quantity, 'cart_id' => $cart_id]);
    }
    header("Location: ../cart.php");
    exit();
}
?>
