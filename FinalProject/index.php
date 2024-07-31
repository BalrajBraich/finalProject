<?php
require_once 'core/config.php';
require_once 'controller/BaseController.php';

$controller = new BaseController();
$action = isset($_POST['action']) ? $_POST['action'] : null;

include 'includes/header.php'; // Corrected path for header

$controller->handleRequest($action);

include 'includes/footer.php'; // Corrected path for footer
?>
