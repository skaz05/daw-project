<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// obtine toate trip-urile din db
$query = "SELECT tour_id, tour_name, tour_price, description, start_date, end_date FROM TOURS WHERE active = 1";
$stmt = $pdo->query($query);
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Excursii/tururi Disponibile</h1>

    <?php if (count($tours) > 0): ?>
        <div class="tours">
            <?php foreach ($tours as $tour): ?>
                <div class="tour">
                    <h2><?= htmlspecialchars($tour['tour_name']) ?></h2>
                    <p><strong>Pret:</strong> $<?= number_format($tour['tour_price'], 2) ?></p>
                    <p><strong>Data:</strong> <?= htmlspecialchars($tour['start_date']) ?> <-> <?= htmlspecialchars($tour['end_date']) ?></p>
                    <p><?= htmlspecialchars($tour['description']) ?></p>
                    <div class="card-footer">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="includes/add_to_cart.php">
                                <input type="hidden" name="tour_id" value="<?= $tour['tour_id'] ?>">
                                <button type="submit" class="btn-cart">Adăugare în cart</button>
                            </form>
                        <?php else: ?>
                            <p><a href="login.php">Log in</a> pentru a rezerva această excursie.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Momentan nu avem excursii sau tururi disponibile. Va rugam sa reveniti mai tarziu sau sa ne sunati!</p>
    <?php endif; ?>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'adaugat'): ?>
        <div class="confirmation">Excursie adaugata in cos cu succes!</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
