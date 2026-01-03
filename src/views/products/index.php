<?php
// src/views/products/list.php
?>
<div class="container">
    <!-- En-tête -->
    <div class="header">
        <h1><i class="fas fa-boxes"></i> Liste des Produits</h1>
        <p class="subtitle"><?php echo $total_products; ?> produit(s) au total</p>
        
        <div class="header-actions">
            <a href="index.php?action=create" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouveau Produit
            </a>
        </div>
    </div>
    
    <!-- Messages flash -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
            <i class="fas fa-<?php echo $_SESSION['message_type'] == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        </div>
    <?php endif; ?>
    
    <!-- Statistiques -->
    <?php if($total_products > 0): ?>
    <div class="stats-summary">
        <div class="stat-item">
            <i class="fas fa-calculator"></i>
            <div>
                <h4>Valeur totale</h4>
                <p class="stat-value"><?php echo number_format($stats['total_value'], 2); ?> €</p>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-chart-line"></i>
            <div>
                <h4>Prix moyen</h4>
                <p class="stat-value"><?php echo number_format($stats['average_price'], 2); ?> €</p>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <h4>Stock faible</h4>
                <p class="stat-value <?php echo $stats['low_stock'] > 0 ? 'text-danger' : 'text-success'; ?>">
                    <?php echo $stats['low_stock']; ?> produit(s)
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Barre de recherche -->
    <div class="search-container">
        <form action="index.php?action=search" method="GET" class="search-form">
            <input type="hidden" name="action" value="search">
            <input type="text" 
                   name="keywords" 
                   class="search-input" 
                   placeholder="Rechercher un produit..."
                   value="<?php echo isset($_GET['keywords']) ? htmlspecialchars($_GET['keywords']) : ''; ?>">
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <!-- Tableau des produits -->
    <?php if($total_products > 0): ?>
    <div class="table-container">
        <div class="table-responsive">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix (€)</th>
                        <th>Quantité</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                    <?php 
                    $stock_class = '';
                    if($product['quantity'] == 0) {
                        $stock_class = 'out-of-stock';
                        $stock_text = 'Rupture';
                        $stock_icon = 'fa-times';
                    } elseif($product['quantity'] < 10) {
                        $stock_class = 'low-stock';
                        $stock_text = 'Faible';
                        $stock_icon = 'fa-exclamation';
                    } else {
                        $stock_class = 'in-stock';
                        $stock_text = 'Disponible';
                        $stock_icon = 'fa-check';
                    }
                    ?>
                    <tr>
                        <td class="product-id">#<?php echo $product['id']; ?></td>
                        <td class="product-name">
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                        </td>
                        <td class="product-description">
                            <?php 
                            if(!empty($product['description'])) {
                                echo htmlspecialchars(substr($product['description'], 0, 60));
                                if(strlen($product['description']) > 60) echo '...';
                            } else {
                                echo '<span class="text-muted">Aucune description</span>';
                            }
                            ?>
                        </td>
                        <td class="product-price">
                            <span class="price-badge"><?php echo number_format($product['price'], 2); ?> €</span>
                        </td>
                        <td class="product-quantity">
                            <span class="quantity-badge <?php echo $stock_class; ?>">
                                <i class="fas <?php echo $stock_icon; ?>"></i>
                                <?php echo $product['quantity']; ?>
                                <span class="stock-text"><?php echo $stock_text; ?></span>
                            </span>
                        </td>
                        <td class="product-date">
                            <?php echo date('d/m/Y', strtotime($product['created_at'])); ?>
                        </td>
                        <td class="product-actions">
                            <div class="btn-group">
                                <a href="index.php?action=show&id=<?php echo $product['id']; ?>" 
                                   class="btn btn-sm btn-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?action=edit&id=<?php echo $product['id']; ?>" 
                                   class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?action=delete&id=<?php echo $product['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Supprimer"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Résumé -->
        <div class="table-footer">
            <div class="table-info">
                Affichage de <?php echo count($products); ?> produit(s)
            </div>
            <div class="table-actions">
                <a href="index.php?action=create" class="btn btn-outline">
                    <i class="fas fa-plus"></i> Ajouter un autre produit
                </a>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    
    <!-- Aucun produit -->
    <div class="no-data">
        <i class="fas fa-box-open fa-4x"></i>
        <h3>Aucun produit trouvé</h3>
        <p>Votre catalogue de produits est vide. Ajoutez votre premier produit !</p>
        <div class="no-data-actions">
            <a href="index.php?action=create" class="btn btn-success btn-lg">
                <i class="fas fa-plus"></i> Ajouter mon premier produit
            </a>
        </div>
    </div>
    
    <?php endif; ?>
</div>

<style>
/* Conteneur principal */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* En-tête */
.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
}

.header h1 {
    font-size: 2.2rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 20px;
}

.header-actions {
    margin-top: 15px;
}

/* Boutons */
.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
}

.btn-sm {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 6px;
}

.btn-primary {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
}

.btn-outline {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
}

/* Alertes */
.alert {
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert i {
    font-size: 1.3rem;
}

/* Statistiques */
.stats-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-item {
    background: white;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
}

.stat-item i {
    font-size: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-item h4 {
    color: #4a5568;
    font-size: 0.9rem;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    color: #2d3748;
    font-size: 1.5rem;
    font-weight: bold;
}

.text-danger { color: #e53e3e; }
.text-success { color: #38a169; }

/* Recherche */
.search-container {
    margin-bottom: 25px;
}

.search-form {
    display: flex;
    gap: 10px;
}

.search-input {
    flex: 1;
    padding: 14px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    width: 50px;
    cursor: pointer;
    transition: all 0.3s;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* Tableau */
.table-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
}

.table-responsive {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.products-table th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 600;
    text-align: left;
    padding: 16px 15px;
    border-bottom: 2px solid #e2e8f0;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.products-table td {
    padding: 18px 15px;
    border-bottom: 1px solid #e2e8f0;
    color: #4a5568;
    vertical-align: middle;
}

.products-table tbody tr:hover {
    background: #f8f9fa;
}

/* Styles des cellules */
.product-id {
    font-weight: bold;
    color: #667eea;
    font-family: 'Courier New', monospace;
}

.product-name strong {
    color: #2d3748;
    font-size: 1.05rem;
}

.product-description {
    max-width: 250px;
}

.text-muted {
    color: #a0aec0;
    font-style: italic;
}

.price-badge {
    display: inline-block;
    padding: 8px 14px;
    background: #c6f6d5;
    color: #22543d;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.95rem;
}

.quantity-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
}

.in-stock {
    background: #c6f6d5;
    color: #22543d;
}

.low-stock {
    background: #fed7d7;
    color: #742a2a;
}

.out-of-stock {
    background: #fed7d7;
    color: #742a2a;
    opacity: 0.7;
}

.stock-text {
    font-size: 0.8rem;
    opacity: 0.8;
}

.product-date {
    color: #718096;
    font-size: 0.9rem;
    white-space: nowrap;
}

/* Groupe de boutons */
.btn-group {
    display: flex;
    gap: 5px;
}

.btn-group .btn-sm {
    min-width: 40px;
}

/* Pied de tableau */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    color: #718096;
    font-size: 0.9rem;
}

/* Aucune donnée */
.no-data {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
}

.no-data i {
    color: #a0aec0;
    margin-bottom: 25px;
}

.no-data h3 {
    color: #4a5568;
    margin-bottom: 15px;
    font-size: 1.8rem;
}

.no-data p {
    color: #718096;
    margin-bottom: 30px;
    font-size: 1.1rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.no-data-actions {
    margin-top: 25px;
}

.btn-lg {
    padding: 15px 35px;
    font-size: 1.1rem;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
    
    .header {
        padding: 20px;
    }
    
    .header h1 {
        font-size: 1.8rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .stats-summary {
        grid-template-columns: 1fr;
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .search-btn {
        width: 100%;
        padding: 12px;
    }
    
    .products-table {
        display: block;
    }
    
    .products-table th,
    .products-table td {
        padding: 12px 10px;
        font-size: 0.85rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .table-footer {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>

<script>
// Confirmation de suppression avec nom du produit
function confirmDelete(productId, productName) {
    return confirm('Êtes-vous sûr de vouloir supprimer le produit "' + productName + '" (ID: ' + productId + ')? Cette action est irréversible.');
}

// Recherche en temps réel (optionnel)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const tableRows = document.querySelectorAll('.products-table tbody tr');
    
    if(searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Animation des lignes
    tableRows.forEach((row, index) => {
        row.style.animationDelay = (index * 0.05) + 's';
        row.classList.add('fade-in');
    });
});

// Animation CSS pour l'apparition des lignes
const style = document.createElement('style');
style.textContent = `
    .fade-in {
        animation: fadeInRow 0.5s ease forwards;
        opacity: 0;
    }
    
    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>