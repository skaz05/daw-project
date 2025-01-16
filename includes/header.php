<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/style.css">
    <title>Travel with Sebastian</title>
</head>
<body>
<header>
    <h1>Agentie de turism - Sebastian Tour</h1>
    <?php include 'menu.php'; ?>
</header>

<!-- popup pt cos - elem. dinamic -->
<div id="cart-popup" class="cart-popup">
    <div class="cart-popup-content">
        <span class="close-popup">&times;</span>
        <h2>Cos de cumparaturi</h2>
        <div id="cart-items">
            <p>loading...</p>
        </div>
        <a href="cart.php" class="btn-checkout">Catre cos</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cartButton = document.getElementById('cart-button');
    const cartPopup = document.getElementById('cart-popup');
    const closePopup = document.querySelector('.close-popup');
    const cartItems = document.getElementById('cart-items');

    // deschidere popup
    cartButton.addEventListener('click', () => {
        cartPopup.style.display = 'flex';
        fetchCartItems();
    });

    // inchidere popup
    closePopup.addEventListener('click', () => {
        cartPopup.style.display = 'none';
    });

    // functie ajax pt fetch cart din db
    function fetchCartItems() {
        fetch('includes/cart_data.php')
            .then(response => response.json())
            .then(data => {
                if (data.items.length > 0) {
                    cartItems.innerHTML = data.items.map(item => `
                        <p><strong>${item.name}</strong>: $${item.price} x ${item.quantity}</p>
                    `).join('');
                } else {
                    cartItems.innerHTML = '<p>Cosul este gol.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching cart data:', error);
                cartItems.innerHTML = '<p>Nu s-au putut incarca articolele din cos.</p>';
            });
    }
});
</script>
