<?php
class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isAdmin($userId) {
        $stmt = $this->pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() === '1';
    }
    
    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
    }

    public function login($username, $password) {
        $query = 'SELECT * FROM users WHERE username = :username';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $user && $password == $user['password'];
    }

    public function getUserIdByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['id'] : null;
    }

    public function getUserByUsername($username) {
        $query = 'SELECT * FROM users WHERE username = :username';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $user;
    }

    public function updateProfilePhoto($userId, $filePath) {
        $stmt = $this->pdo->prepare("UPDATE users SET profile_photo = :profile_photo WHERE id = :id");
        $stmt->execute(['profile_photo' => $filePath, 'id' => $userId]);
    }

    public function getUserProfile($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
