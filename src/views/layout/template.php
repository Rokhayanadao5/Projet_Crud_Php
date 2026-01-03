<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Gestion des Produits'; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .features { display: flex; gap: 20px; margin: 30px 0; flex-wrap: wrap; }
        .feature-card { flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .feature-card i { font-size: 2rem; color: #667eea; margin-bottom: 15px; }
        .stats { margin-top: 40px; }
        .stat-cards { display: flex; gap: 20px; margin-top: 20px; }
        .stat-card { flex: 1; background: white; padding: 15px; border-radius: 8px; text-align: center; }
        .hero-section { background: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .no-data { text-align: center; padding: 40px; color: #666; }
        .in-stock { color: #48bb78; }
        .low-stock { color: #ed8936; }
        .form-row { display: flex; gap: 20px; }
        .form-group.half { flex: 1; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .product-detail .detail-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .product-card.large { padding: 30px; }
        .product-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .info-item { background: #f8f9fa; padding: 15px; border-radius: 8px; }
        .info-section { margin-bottom: 30px; }
        .product-quantity.large { font-size: 1.2rem; padding: 10px 20px; }
        .half { width: 48%; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1><i class="fas fa-boxes"></i> Gestion des Produits</h1>
            <nav class="nav-links">
                <a href="index.php"><i class="fas fa-home"></i> Accueil</a>
                <a href="index.php?action=list"><i class="fas fa-list"></i> Liste</a>
                <a href="index.php?action=create"><i class="fas fa-plus"></i> Ajouter</a>

            </nav>
        </header>

        <main>
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                    <i class="fas fa-<?php echo $_SESSION['message_type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <?php echo $content ?? 'Contenu non trouvé'; ?>
        </main>

        <footer class="footer">
            <p>Application CRUD • PHP 8.2 • MySQL • Docker • <?php echo date('Y'); ?></p>
            <p>Conteneurs Docker : PHP-FPM • Nginx (8081) • MySQL (3307) • phpMyAdmin (8080)</p>
        </footer>
    </div>

    <script>
        // Confirmation pour la suppression
        document.addEventListener('DOMContentLoaded', function() {
            const deleteLinks = document.querySelectorAll('a[href*="action=delete"]');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if(!confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>