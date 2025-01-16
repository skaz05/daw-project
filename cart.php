<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/header.php';

// verificam pt sesiune
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// fetch pt cart // aici poate pot sa fac un template?
$query = "SELECT c.cart_id, t.tour_name, t.tour_price, c.quantity, c.date_added 
          FROM CART c
          JOIN TOURS t ON c.tour_id = t.tour_id
          WHERE c.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/style.css">
    <title>Cart</title>
</head>
<body>
<header>
    <h1>Cos de cumparaturi</h1>
</header>
<div class="container">
    <?php if (count($cartItems) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Excursie</th>
                    <th>Pret</th>
                    <th>Cantitate</th>
                    <th>Subtotal</th>
                    <th>Actiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cartItems as $item):
                    $subtotal = $item['tour_price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['tour_name']) ?></td>
                        <td>$<?= number_format($item['tour_price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <form method="POST" action="includes/update_cart.php" style="display:inline;">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width: 50px;">
                                <button type="submit">Update</button>
                            </form>
                            <form method="POST" action="includes/remove_cart.php" style="display:inline;">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <button type="submit">Stergere</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
        <a href="checkout.php" class="btn-checkout">Catre plata</a>
    <?php else: ?>
        <p>Cos gol</p>
    <?php endif; ?>
</div>
</body>
</html>
