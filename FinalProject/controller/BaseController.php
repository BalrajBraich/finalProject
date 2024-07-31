<?php
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../model/UserController.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/ShoppingCart.php';
$baseController = new BaseController($pdo);

class BaseController {
    private $pdo;
    private $userController;
    private $shoppingCart;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->userController = new UserController($this->pdo);
            $this->shoppingCart = new ShoppingCart($this->pdo);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

  

    public function handleRequest($action) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        switch ($action) {
            case 'resume':
                $this->loadView('resumeView');
                break;
            case 'pastProjects':
                $this->loadView('pastProjectsView');
                break;
            case 'myProducts':
                $this->loadView('myProductsView');
                break;
            case 'addToCart':
            case 'removeFromCart':
                $this->shoppingCart->handleRequest($action);
                $this->loadView('myProductsView');
                break;
            case 'fan':
                $this->handleFanPage();
                break;
            case 'news':
                $this->handleNews();
                break;
            case 'adminLogin':
                $this->handleAdminLogin();
                break;
            case 'createNews':
                $this->handleCreateNews();
                break;
            case 'deleteNews':
                $this->handleDeleteNews();
                break;
            case 'logout':
                $this->handleLogout();
                break;
              case 'addNews':
            echo 'Loading addNewsView';
            $this->loadView('addNewsView');
            break;
    case 'saveNews':
        $this->handleSaveNews();
        break;
    case 'viewNews':
        $this->handleViewNews();
        break;
            case 'adminLogin':
                $this->handleAdminLogin();
                break;
            default:
                $this->loadView('homeView');
                break;
        }
    }

    private function handleAdminLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                if ($this->userController->login($username, $password)) {
                    $user = $this->userController->getUserByUsername($username);
                    if ($user['is_admin']) {
                        $_SESSION['admin_id'] = $user['id'];
                        $this->loadView('adminDashboardView');
                        exit();
                    } else {
                        echo '<p>Access denied. You are not an admin.</p>';
                    }
                } else {
                    echo '<p>Login failed. Please try again.</p>';
                }
            } else {
                echo '<p>Username and password are required.</p>';
            }
        }

        $this->loadView('adminLoginView');
    }


    private function handleCreateNews() {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $_POST['title'];
                $content = $_POST['content'];

                $stmt = $this->pdo->prepare("INSERT INTO news1 (title, content) VALUES (?, ?)");
                $stmt->execute([$title, $content]);
            }
            $this->loadView('adminDashboardView');
        } else {
            echo '<p>Access denied. You are not an admin.</p>';
        }
    }
    
    
    private function handleSaveNews() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $stmt = $this->pdo->prepare("INSERT INTO news1 (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header('Location: index.php?action=adminDashboard');
        exit();
    }
}

private function handleViewNews() {
    $stmt = $this->pdo->query("SELECT * FROM news1");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->loadView('newsView', ['news' => $news]);
}


    private function handleDeleteNews() {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            if (isset($_POST['newsId'])) {
                $newsId = $_POST['newsId'];

                $stmt = $this->pdo->prepare("DELETE FROM news1 WHERE id = ?");
                $stmt->execute([$newsId]);
            }
            $this->loadView('adminDashboardView');
        } else {
            echo '<p>Access denied. You are not an admin.</p>';
        }
    }

  private function handleNews() {
    $stmt = $this->pdo->query("SELECT * FROM news1 ORDER BY created_at DESC");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $this->loadView('newsView', ['news' => $news]);
}



    private function handleRemoveFromCart() {
        if (isset($_POST['productId'])) {
            $productId = $_POST['productId'];
            $this->shoppingCart->removeFromCart($productId);
        }
        // Reload the myProducts view
        $this->loadView('myProductsView');
    }


 private function loadView($viewName, $data = []) {
    extract($data);
    $headerPath = __DIR__ . '/../includes/header.php';
    $footerPath = __DIR__ . '/../includes/footer.php';
    $viewPath = __DIR__ . '/../view/' . $viewName . '.php';

    if (file_exists($headerPath)) {
        require_once $headerPath;
    }

    if (file_exists($viewPath)) {
        require_once $viewPath;
    } else {
        echo '<h1>Error</h1>';
        echo '<p>View not found: ' . htmlspecialchars($viewPath) . '</p>';
    }

    if (file_exists($footerPath)) {
        require_once $footerPath;
    }
}


    private function handleFanPage() {
        if (!isset($_SESSION['user_id'])) {
            $this->loadView('fanView');
            exit();
        } else {
            $this->loadView('fanProfileView');
        }
    }

    private function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['login-username'];
            $password = $_POST['login-password'];

            if ($this->userController->login($username, $password)) {
                $_SESSION['user_id'] = $this->userController->getUserIdByUsername($username);
                $this->loadView('fanProfileView');
                exit();
            } else {
                echo '<p>Login failed. Please try again.</p>';
            }
        }

        $this->loadView('loginView');
    }
    
        public function getPdo() {
        return $this->pdo;
    }

    private function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['register-username'];
            $password = $_POST['register-password'];

            $this->userController->register($username, $password);
            header('Location: index.php?action=login');
            exit();
        }

        $this->loadView('registerView');
    }

    private function handleLogout() {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
?>
