<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure les dépendances
require_once 'config/database.php';
require_once 'model/Product.php';

// Gestion des routes
$action = $_GET['action'] ?? 'home';


// Initialiser le contrôleur
switch($action) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'list':
    case 'show':
    case 'create':
    case 'edit':
    case 'store':
    case 'update':
    case 'delete':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        
        switch($action) {
            case 'list': $controller->index(); break;
           // case 'show': $controller->show(); break;
            case 'create': $controller->create(); break;
            case 'edit': $controller->edit(); break;
            case 'store': $controller->store(); break;
            case 'update': $controller->update(); break;
        }
        break;
        
    default:
        // Redirection vers l'accueil
        header('Location: index.php?action=home');
        exit;
}
?>