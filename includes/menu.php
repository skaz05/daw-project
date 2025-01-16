<nav class="menu">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="tours.php">Tours</a></li>
        <li><button id="cart-button" class="btn-cart-link">Cart</button></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="user.php">Dashboard</a></li>
            <?php if ($_SESSION['role'] === "admin"): ?>
                <li><a href="admin.php">Admin Panel</a></li>
                <!-- <p>Role: <?= htmlspecialchars($_SESSION['role']); ?></p> -->
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Inregistrare</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php if (isset($_SESSION['user_id'])): ?>
    <?php if ($_SESSION['role'] === "admin"): ?>
        <!-- <li><a href="admin.php">Admin Panel</a></li> -->
        <p>Role: <?= htmlspecialchars($_SESSION['role']); ?></p>
    <?php endif; ?>
<?php endif; ?>