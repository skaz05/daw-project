<?php
session_start();
require_once 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tour_id'])) {
    $user_id = $_SESSION['user_id'];
    $tour_id = $_POST['tour_id'];

    // verifica daca excursia cu id respectiv e deja in cart pt userul requester
    $query = "SELECT cart_id, quantity FROM CART WHERE user_id = :user_id AND tour_id = :tour_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id, 'tour_id' => $tour_id]);
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // update pt cantitate daca exista
        $query = "UPDATE CART SET quantity = quantity + 1 WHERE cart_id = :cart_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['cart_id' => $cartItem['cart_id']]);
    } else {
        // altfel insereaza excursie noua
        $query = "INSERT INTO CART (user_id, tour_id, quantity, date_added) VALUES (:user_id, :tour_id, 1, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $user_id, 'tour_id' => $tour_id]);
    }

    // redirect -> tours.php dupa adaugare in cart
    header("Location: ../tours.php?status=adaugat");
    exit();
}
?>
