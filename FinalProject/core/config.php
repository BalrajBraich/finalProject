<?php
define('DB_HOST', 'localhost');  
define('DB_USER', 'test');      
define('DB_PASS', '12345');           
define('DB_NAME', 'test'); 
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
?>
