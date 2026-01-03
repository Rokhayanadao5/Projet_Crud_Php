// Gestion des messages flash
document.addEventListener('DOMContentLoaded', function() {
    // Suppression automatique des messages après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Confirmation pour la suppression
    const deleteButtons = document.querySelectorAll('a[href*="action=delete"], button[type="submit"][onclick*="confirm"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ? Cette action est irréversible.')) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // Validation des formulaires
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f56565';
                    
                    // Ajout d'un message d'erreur
                    let errorMsg = field.nextElementSibling;
                    if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.style.color = '#f56565';
                        errorMsg.style.fontSize = '0.9rem';
                        errorMsg.style.marginTop = '5px';
                        errorMsg.textContent = 'Ce champ est obligatoire';
                        field.parentNode.appendChild(errorMsg);
                    }
                } else {
                    field.style.borderColor = '#e2e8f0';
                    const errorMsg = field.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('error-message')) {
                        errorMsg.remove();
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Afficher une alerte globale
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Veuillez remplir tous les champs obligatoires';
                form.prepend(alertDiv);
            }
        });
    });

    // Animation pour les boutons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(0)';
        });
        
        button.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Gestion du prix - format automatique
    const priceInputs = document.querySelectorAll('input[name="price"]');
    priceInputs.forEach(input => {
        input.addEventListener('blur', function() {
            let value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });
        
        input.addEventListener('input', function() {
            // Permet seulement les nombres et un point décimal
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    });

    // Tooltips pour les boutons d'action
    const actionButtons = document.querySelectorAll('.btn-sm');
    actionButtons.forEach(button => {
        const title = button.getAttribute('title') || 
                     button.querySelector('i').className.includes('fa-eye') ? 'Voir' :
                     button.querySelector('i').className.includes('fa-edit') ? 'Modifier' :
                     button.querySelector('i').className.includes('fa-trash') ? 'Supprimer' : '';
        
        if (title) {
            button.setAttribute('title', title);
        }
    });

    // Animation de chargement pour les formulaires
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading"></span> En cours...';
                submitBtn.disabled = true;
                
                // Annulation après 10 secondes max
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 10000);
            }
        });
    });

    // Gestion de la quantité - validation
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 0) {
                this.value = 0;
            }
        });
    });

    // Amélioration de l'expérience utilisateur sur mobile
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Augmenter la taille des zones cliquables sur mobile
        const clickables = document.querySelectorAll('a, button, .btn');
        clickables.forEach(el => {
            el.style.minHeight = '44px';
            el.style.minWidth = '44px';
            el.style.display = 'flex';
            el.style.alignItems = 'center';
            el.style.justifyContent = 'center';
        });
    }

    // Système de recherche local (client-side)
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Rechercher un produit...';
    searchInput.style.cssText = `
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 20px;
        font-size: 16px;
    `;
    
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (table.rows.length > 1) {
            const container = table.closest('.table-container');
            if (container) {
                const existingSearch = container.querySelector('.search-input');
                if (!existingSearch) {
                    const searchContainer = document.createElement('div');
                    searchContainer.style.position = 'relative';
                    searchContainer.innerHTML = '<i class="fas fa-search" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #a0aec0;"></i>';
                    searchInput.className = 'search-input';
                    searchContainer.prepend(searchInput.cloneNode(true));
                    table.parentNode.insertBefore(searchContainer, table);
                    
                    // Fonction de recherche
                    searchContainer.querySelector('input').addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        const rows = table.querySelectorAll('tbody tr');
                        
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(searchTerm) ? '' : 'none';
                        });
                    });
                }
            }
        }
    });

    // Copie des IDs au clic
    const idCells = document.querySelectorAll('td:first-child');
    idCells.forEach(cell => {
        if (cell.textContent.match(/^\d+$/)) {
            cell.style.cursor = 'pointer';
            cell.title = 'Cliquer pour copier l\'ID';
            
            cell.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    const originalText = this.textContent;
                    this.textContent = '✓ Copié!';
                    this.style.color = '#48bb78';
                    this.style.fontWeight = 'bold';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                        this.style.fontWeight = '';
                    }, 2000);
                });
            });
        }
    });
});

// Fonction utilitaire pour afficher un toast
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    `;
    
    if (type === 'success') {
        toast.style.background = 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)';
    } else if (type === 'error') {
        toast.style.background = 'linear-gradient(135deg, #f56565 0%, #e53e3e 100%)';
    } else {
        toast.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
    }
    
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Ajout des animations CSS pour les toasts
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);