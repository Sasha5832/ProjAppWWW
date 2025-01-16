<?php
session_start();
include('cfg.php'); // Połączenie z bazą danych

// Inicjalizacja koszyka
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Dodanie produktu do koszyka
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];
    $query = "SELECT id, tytul, cena_netto, podatek_vat FROM produkty WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $id = $product['id'];
        $name = $product['tytul'];
        $price = $product['cena_netto'] + ($product['cena_netto'] * $product['podatek_vat'] / 100);

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'name' => $name,
                'price' => $price,
                'quantity' => 1,
            ];
        } else {
            $_SESSION['cart'][$id]['quantity']++;
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Usuwanie produktu z koszyka
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Edycja ilości produktu
if (isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = (int)$_POST['id'];
    $quantity = max(1, (int)$_POST['quantity']); // Minimalna ilość to 1
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Obliczanie sumy i liczników
$totalPrice = 0;
$totalItems = 0;
foreach ($_SESSION['cart'] as $product) {
    $totalPrice += $product['price'] * $product['quantity'];
    $totalItems += $product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f8ff; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; text-align: center; }
        h1, h2 { color: #1e90ff; }
        .product { margin: 20px 0; padding: 20px; border: 1px solid #1e90ff; border-radius: 5px; background-color: #ffffff; }
        .cart { margin: 20px 0; padding: 20px; border: 1px solid #1e90ff; border-radius: 5px; background-color: #ffffff; text-align: left; }
        .button { display: inline-block; padding: 10px 20px; margin: 10px; color: #ffffff; background-color: #1e90ff; text-decoration: none; border-radius: 5px; }
        .button:hover { background-color: #4682b4; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #1e90ff; padding: 10px; text-align: center; }
        th { background-color: #1e90ff; color: white; }
        input[type="number"] { width: 50px; text-align: center; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Twój Koszyk</h1>

        <!-- Lista produktów -->
        <h2>Produkty dostępne</h2>
        <?php
        $query = "SELECT id, tytul, cena_netto, podatek_vat FROM produkty WHERE status_dostepnosci = 1";
        $result = $link->query($query);

        while ($row = $result->fetch_assoc()):
            $priceWithVAT = $row['cena_netto'] + ($row['cena_netto'] * $row['podatek_vat'] / 100);
        ?>
            <div class="product">
                <h3><?= htmlspecialchars($row['tytul']) ?></h3>
                <p>Cena: <?= number_format($priceWithVAT, 2) ?> zł</p>
                <a href="?action=add&id=<?= $row['id'] ?>" class="button">Dodaj do koszyka</a>
            </div>
        <?php endwhile; ?>

        <!-- Koszyk -->
        <div class="cart">
            <h2>Produkty w koszyku</h2>
            <?php if (empty($_SESSION['cart'])): ?>
                <p>Koszyk jest pusty.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Tytuł</th>
                        <th>Cena za sztukę</th>
                        <th>Ilość</th>
                        <th>Łączna cena</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                    <?php foreach ($_SESSION['cart'] as $id => $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= number_format($product['price'], 2) ?> zł</td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td><?= number_format($product['price'] * $product['quantity'], 2) ?> zł</td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1">
                                    <button type="submit" class="button">Zmień</button>
                                </form>
                            </td>
                            <td><a href="?action=remove&id=<?= $id ?>" class="button">Usuń</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p class="total">Suma: <?= number_format($totalPrice, 2) ?> zł</p>
                <p class="total">Liczba wszystkich produktów: <?= $totalItems ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
