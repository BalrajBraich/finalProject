<?php
require_once __DIR__ . '/../core/config.php';
global $pdo;
$controller = new UserController($pdo);

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=fan');
    exit();
}

$userId = $_SESSION['user_id'];
$userProfile = $controller->getUserProfile($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fan Profile</title>
</head>
<body>
    <h1>Fan Profile</h1>
    
    <h2>Welcome, <?php echo htmlspecialchars($userProfile['username']); ?></h2>
    
    <!-- Profile Photo Upload -->
    <h2>Upload Profile Photo</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="uploadProfilePhoto">
        <label for="profile-photo">Select photo:</label>
        <input type="file" id="profile-photo" name="profile-photo" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
    
    <!-- Display Profile Photo -->
    <?php if (!empty($userProfile['profile_photo'])): ?>
        <img src="<?php echo htmlspecialchars($userProfile['profile_photo']); ?>" alt="Profile Photo">
    <?php endif; ?>
</body>
</html>
