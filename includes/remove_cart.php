<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    $query = "DELETE FROM CART WHERE cart_id = :cart_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['cart_id' => $cart_id]);

    header("Location: ../cart.php");
    exit();
}
?>
