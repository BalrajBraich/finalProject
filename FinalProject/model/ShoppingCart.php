<?php

class ShoppingCart {
    private $pdo;
    private $session_id;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->session_id = session_id();
    }

    public function addToCart($productId) {
        $stmt = $this->pdo->prepare("INSERT INTO shopping_cart (session_id, product_id, quantity) VALUES (:session_id, :product_id, 1) 
                                     ON DUPLICATE KEY UPDATE quantity = quantity + 1");
        $stmt->execute(['session_id' => $this->session_id, 'product_id' => $productId]);
    }

    public function getCartItems() {
        $stmt = $this->pdo->prepare("SELECT p.id, p.name, p.description, p.image, c.quantity 
                                     FROM products p 
                                     JOIN shopping_cart c ON p.id = c.product_id 
                                     WHERE c.session_id = :session_id");
        $stmt->execute(['session_id' => $this->session_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeFromCart($productId) {
        $stmt = $this->pdo->prepare("DELETE FROM shopping_cart WHERE session_id = :session_id AND product_id = :product_id");
        $stmt->execute(['session_id' => $this->session_id, 'product_id' => $productId]);
    }

    public function handleRequest($action) {
        if (isset($_POST['productId'])) {
            $productId = $_POST['productId'];

            if ($action === 'addToCart') {
                $this->addToCart($productId);
            } elseif ($action === 'removeFromCart') {
                $this->removeFromCart($productId);
            }
        }
    }
}

?>
