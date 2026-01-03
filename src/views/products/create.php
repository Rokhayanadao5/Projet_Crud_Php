<?php
// src/views/products/create.php
?>
<div class="container">
    <div class="header">
        <h1><i class="fas fa-plus-circle"></i> Ajouter un Nouveau Produit</h1>
        <p>Remplissez le formulaire ci-dessous pour ajouter un produit à votre catalogue.</p>
        <a href="index.php?action=list" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
    
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
    
    <div class="form-container">
        <form action="index.php?action=store" method="POST" id="addProductForm" novalidate>
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Informations générales</h3>
                
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-tag"></i> Nom du produit *
                        <span class="required">(obligatoire)</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="name" 
                           name="name" 
                           required
                           minlength="3"
                           maxlength="255"
                           placeholder="Ex: Ordinateur Portable Dell XPS 15">
                    <div class="form-hint">Minimum 3 caractères, maximum 255 caractères</div>
                    <div class="error-message" id="name-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="description">
                        <i class="fas fa-align-left"></i> Description
                    </label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              rows="5"
                              maxlength="1000"
                              placeholder="Décrivez votre produit en détail..."></textarea>
                    <div class="form-hint">Maximum 1000 caractères</div>
                    <div class="char-counter">
                        <span id="charCount">0</span>/1000 caractères
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3><i class="fas fa-chart-line"></i> Détails financiers et stock</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">
                            <i class="fas fa-euro-sign"></i> Prix (€) *
                            <span class="required">(obligatoire)</span>
                        </label>
                        <div class="input-with-icon">
                            <input type="number" 
                                   class="form-control" 
                                   id="price" 
                                   name="price" 
                                   required
                                   step="0.01"
                                   min="0.01"
                                   max="999999.99"
                                   placeholder="0.00">
                            <span class="input-icon">€</span>
                        </div>
                        <div class="form-hint">Prix unitaire en euros (ex: 999.99)</div>
                        <div class="error-message" id="price-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">
                            <i class="fas fa-boxes"></i> Quantité en stock *
                            <span class="required">(obligatoire)</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               id="quantity" 
                               name="quantity" 
                               required
                               min="0"
                               max="999999"
                               value="0">
                        <div class="form-hint">Nombre d'unités disponibles (0 pour épuisé)</div>
                        <div class="error-message" id="quantity-error"></div>
                    </div>
                </div>
                
                <div class="stock-presets">
                    <p class="presets-label"><i class="fas fa-bolt"></i> Quantités prédéfinies :</p>
                    <div class="presets">
                        <button type="button" class="preset-btn" data-value="0">
                            <i class="fas fa-times-circle"></i> Rupture (0)
                        </button>
                        <button type="button" class="preset-btn" data-value="5">
                            <i class="fas fa-exclamation-circle"></i> Faible (5)
                        </button>
                        <button type="button" class="preset-btn" data-value="10">
                            <i class="fas fa-check-circle"></i> Normal (10)
                        </button>
                        <button type="button" class="preset-btn" data-value="50">
                            <i class="fas fa-warehouse"></i> Abondant (50)
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="form-preview">
                <h3><i class="fas fa-eye"></i> Aperçu du produit</h3>
                <div class="preview-card">
                    <div class="preview-header">
                        <h4 id="previewName">Nom du produit</h4>
                        <span class="preview-price" id="previewPrice">0.00 €</span>
                    </div>
                    <p class="preview-description" id="previewDescription">Description apparaîtra ici...</p>
                    <div class="preview-footer">
                        <span class="preview-stock" id="previewStock">
                            <i class="fas fa-box"></i> Stock : <span id="previewQuantity">0</span> unités
                        </span>
                        <span class="preview-status" id="previewStatus"></span>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="index.php?action=list" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="reset" class="btn btn-outline" id="resetBtn">
                    <i class="fas fa-redo"></i> Réinitialiser
                </button>
                <button type="submit" class="btn btn-success" id="submitBtn">
                    <i class="fas fa-save"></i> Enregistrer le produit
                </button>
            </div>
            
            <div class="form-info">
                <i class="fas fa-info-circle"></i> Les champs marqués d'un <span class="required">*</span> sont obligatoires.
            </div>
        </form>
    </div>
</div>

<style>
/* Styles généraux */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    margin-bottom: 30px;
}

.header h1 {
    color: #2d3748;
    font-size: 2rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.header p {
    color: #718096;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

/* Conteneur du formulaire */
.form-container {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
}

/* Sections du formulaire */
.form-section {
    margin-bottom: 35px;
    padding-bottom: 25px;
    border-bottom: 2px solid #f7fafc;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section h3 {
    color: #2d3748;
    font-size: 1.4rem;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Groupes de formulaire */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #4a5568;
    display: flex;
    align-items: center;
    gap: 8px;
}

.required {
    color: #e53e3e;
    font-size: 0.9rem;
    font-weight: normal;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f7fafc;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.form-hint {
    color: #a0aec0;
    font-size: 0.85rem;
    margin-top: 8px;
}

.error-message {
    color: #e53e3e;
    font-size: 0.9rem;
    margin-top: 5px;
    display: none;
}

.error-message.show {
    display: block;
}

/* Compteur de caractères */
.char-counter {
    text-align: right;
    color: #a0aec0;
    font-size: 0.85rem;
    margin-top: 5px;
}

/* Ligne de formulaire */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0;
}

/* Input avec icône */
.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #4a5568;
    font-weight: bold;
}

/* Presets de stock */
.stock-presets {
    margin-top: 30px;
}

.presets-label {
    color: #4a5568;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.presets {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.preset-btn {
    padding: 10px 15px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 6px;
    color: #4a5568;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.preset-btn:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

.preset-btn.active {
    background: #667eea;
    border-color: #667eea;
    color: white;
}

/* Aperçu */
.form-preview {
    background: #f7fafc;
    border-radius: 10px;
    padding: 25px;
    margin: 30px 0;
}

.form-preview h3 {
    color: #2d3748;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.preview-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f7fafc;
}

.preview-header h4 {
    color: #2d3748;
    font-size: 1.2rem;
    margin: 0;
}

.preview-price {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 1.1rem;
}

.preview-description {
    color: #718096;
    line-height: 1.6;
    margin-bottom: 15px;
    min-height: 60px;
}

.preview-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-stock {
    color: #4a5568;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.preview-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-out {
    background: #fed7d7;
    color: #742a2a;
}

.status-low {
    background: #feebc8;
    color: #744210;
}

.status-normal {
    background: #c6f6d5;
    color: #22543d;
}

/* Actions du formulaire */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 2px solid #f7fafc;
}

/* Info du formulaire */
.form-info {
    background: #e6f7ff;
    padding: 15px 20px;
    border-radius: 8px;
    margin-top: 25px;
    color: #0066cc;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
    
    .header h1 {
        font-size: 1.6rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .form-container {
        padding: 20px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .presets {
        flex-direction: column;
    }
    
    .preset-btn {
        justify-content: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .preview-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .preview-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const form = document.getElementById('addProductForm');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const quantityInput = document.getElementById('quantity');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitBtn');
    
    // Éléments d'aperçu
    const previewName = document.getElementById('previewName');
    const previewDescription = document.getElementById('previewDescription');
    const previewPrice = document.getElementById('previewPrice');
    const previewQuantity = document.getElementById('previewQuantity');
    const previewStatus = document.getElementById('previewStatus');
    const previewStock = document.getElementById('previewStock');
    
    // Presets de quantité
    const presetButtons = document.querySelectorAll('.preset-btn');
    
    // Mise à jour de l'aperçu en temps réel
    function updatePreview() {
        // Nom
        const name = nameInput.value || 'Nom du produit';
        previewName.textContent = name;
        
        // Description
        const description = descriptionInput.value || 'Description apparaîtra ici...';
        previewDescription.textContent = description.length > 100 
            ? description.substring(0, 100) + '...' 
            : description;
        
        // Prix
        const price = parseFloat(priceInput.value) || 0;
        previewPrice.textContent = price.toFixed(2) + ' €';
        
        // Quantité et statut
        const quantity = parseInt(quantityInput.value) || 0;
        previewQuantity.textContent = quantity;
        
        // Mise à jour du statut
        if (quantity === 0) {
            previewStatus.textContent = 'Rupture de stock';
            previewStatus.className = 'preview-status status-out';
            previewStock.innerHTML = '<i class="fas fa-box"></i> Stock : <span class="text-danger">' + quantity + '</span> unités';
        } else if (quantity < 10) {
            previewStatus.textContent = 'Stock faible';
            previewStatus.className = 'preview-status status-low';
            previewStock.innerHTML = '<i class="fas fa-box"></i> Stock : <span class="text-warning">' + quantity + '</span> unités';
        } else {
            previewStatus.textContent = 'En stock';
            previewStatus.className = 'preview-status status-normal';
            previewStock.innerHTML = '<i class="fas fa-box"></i> Stock : <span class="text-success">' + quantity + '</span> unités';
        }
    }
    
    // Compteur de caractères pour la description
    descriptionInput.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        updatePreview();
    });
    
    // Mise à jour de l'aperçu pour tous les champs
    [nameInput, priceInput, quantityInput].forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    
    // Presets de quantité
    presetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            quantityInput.value = value;
            
            // Mise en évidence du bouton sélectionné
            presetButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            updatePreview();
        });
    });
    
    // Validation en temps réel
    function validateField(input, min, max, isNumber = false) {
        const value = input.value.trim();
        const errorElement = document.getElementById(input.id + '-error');
        
        // Réinitialiser l'erreur
        errorElement.classList.remove('show');
        input.style.borderColor = '#e2e8f0';
        
        // Validation
        if (!value) {
            showError(input, errorElement, 'Ce champ est obligatoire');
            return false;
        }
        
        if (value.length < min) {
            showError(input, errorElement, `Minimum ${min} caractères`);
            return false;
        }
        
        if (value.length > max) {
            showError(input, errorElement, `Maximum ${max} caractères`);
            return false;
        }
        
        if (isNumber) {
            const numValue = parseFloat(value);
            if (isNaN(numValue) || numValue < 0) {
                showError(input, errorElement, 'Valeur numérique invalide');
                return false;
            }
        }
        
        return true;
    }
    
    function showError(input, errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
        input.style.borderColor = '#e53e3e';
    }
    
    // Validation à la saisie
    nameInput.addEventListener('blur', () => validateField(nameInput, 3, 255));
    priceInput.addEventListener('blur', () => validateField(priceInput, 1, 10, true));
    quantityInput.addEventListener('blur', () => validateField(quantityInput, 1, 6, true));
    
    // Validation à la soumission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const isNameValid = validateField(nameInput, 3, 255);
        const isPriceValid = validateField(priceInput, 1, 10, true);
        const isQuantityValid = validateField(quantityInput, 1, 6, true);
        
        if (isNameValid && isPriceValid && isQuantityValid) {
            // Animation de chargement
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
            submitBtn.disabled = true;
            
            // Soumission du formulaire après un délai (pour voir l'animation)
            setTimeout(() => {
                form.submit();
            }, 1000);
        } else {
            // Scroll vers la première erreur
            const firstError = document.querySelector('.error-message.show');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Bouton réinitialiser
    document.getElementById('resetBtn').addEventListener('click', function() {
        setTimeout(() => {
            presetButtons.forEach(btn => btn.classList.remove('active'));
            updatePreview();
        }, 100);
    });
    
    // Initialisation
    updatePreview();
});
</script>