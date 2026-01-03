<?php
require_once 'views/layout/template.php';

class HomeController {
    public function index() {
        $page_title = "Accueil - Gestion des Produits";
        
        ob_start();
        ?>
        <div class="hero-section">
            <div class="hero-content">
                <h2><i class="fas fa-rocket"></i> Bienvenue dans l'application CRUD</h2>
                <p>Gérez vos produits facilement avec cette application PHP moderne intégrée à Docker.</p>
                
                <div class="features">
                    <div class="feature-card">
                        <i class="fas fa-list"></i>
                        <h3>Liste des produits</h3>
                        <p>Consultez tous vos produits en un clin d'œil avec notre interface moderne et intuitive.</p>
                        <a href="index.php?action=list" class="btn btn-primary">
                            <i class="fas fa-list"></i> Voir la liste
                        </a>
                    </div>
                    
                    <div class="feature-card">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Ajouter un produit</h3>
                        <p>Ajoutez de nouveaux produits à votre catalogue avec notre formulaire simplifié.</p>
                        <a href="index.php?action=create" class="btn btn-success">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </a>
                    </div>
                    
                    <div class="feature-card">
                        <i class="fas fa-database"></i>
                        <h3>Base de données</h3>
                        <p>Gérez vos données avec phpMyAdmin intégré. Visualisez et modifiez vos tables.</p>
                        <a href="http://localhost:8082" target="_blank" class="btn btn-warning">
                            <i class="fas fa-database"></i> Accéder à phpMyAdmin
                        </a>
                    </div>
                </div>
                
                <div class="stats">
                    <h3><i class="fas fa-chart-bar"></i> Statistiques du système</h3>
                    <div class="stat-cards">
                        <div class="stat-card">
                            <h4>Version PHP</h4>
                            <p><?php echo phpversion(); ?></p>
                        </div>
                        <div class="stat-card">
                            <h4>Date du serveur</h4>
                            <p><?php echo date('d/m/Y H:i:s'); ?></p>
                        </div>
                        <div class="stat-card">
                            <h4>Statut Docker</h4>
                            <p>4 services actifs</p>
                        </div>
                        <div class="stat-card">
                            <h4>Environnement</h4>
                            <p>Développement</p>
                        </div>
                    </div>
                </div>
                
                <div class="quick-actions">
                    <h3><i class="fas fa-bolt"></i> Actions rapides</h3>
                    <div class="action-buttons">
                        <a href="index.php?action=create" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nouveau produit
                        </a>
                        <a href="index.php?action=list" class="btn btn-primary">
                            <i class="fas fa-sync"></i> Actualiser la liste
                        </a>
                        <a href="http://localhost:8082" target="_blank" class="btn btn-warning">
                            <i class="fas fa-cog"></i> Administration BDD
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
        $content = ob_get_clean();
        require_once 'views/layout/template.php';
    }
}
?>