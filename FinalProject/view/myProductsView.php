<?php
require_once __DIR__ . '/../core/config.php'; 

$controller = new BaseController();
$pdo = $controller->getPdo(); 

$productCont = new Product($pdo);
$products = $productCont->getAllProducts();
$itms =  new ShoppingCart($pdo);
$cartItems = $itms->getCartItems(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products</title>
</head>
<body>
    <h1>My Products</h1>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="addToCart">
                    <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    
    <h2>Shopping Cart</h2>
    <div class="cart">
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <h2><?php echo $item['name']; ?></h2>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="removeFromCart">
                        <input type="hidden" name="productId" value="<?php echo $item['id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
