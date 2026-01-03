<?php
// src/controllers/ProductController.php
class ProductController {
    private $db;
    private $product;
    
    public function __construct() {
        // Connexion à la base de données
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }
    
    // Afficher la liste des produits
    public function index() {
        $page_title = "Liste des Produits";
        
        // Récupérer tous les produits
        $stmt = $this->product->read();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Compter le nombre total
        $total_products = $this->product->count();
        
        // Obtenir les statistiques
        $stats = $this->product->getStats();
        
        // Inclure la vue
        ob_start();
        include 'views/products/index.php';
        $content = ob_get_clean();
        
        // Inclure le template
        include 'views/layout/template.php';
    }
    
    // Afficher le formulaire de création
    public function create() {
        $page_title = "Ajouter un Produit";
        
        ob_start();
        include 'views/products/create.php';
        $content = ob_get_clean();
        
        include 'views/layout/template.php';
    }
    
    // Traiter la création du produit
    public function store() {

        
        // Vérifier si c'est une requête POST
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Récupérer les données du formulaire
            $this->product->name = $_POST['name'];
            $this->product->description = $_POST['description'];
            $this->product->price = $_POST['price'];
            $this->product->quantity = $_POST['quantity'];
            
            // Créer le produit
            if($this->product->create()) {
                $_SESSION['message'] = "Produit créé avec succès !";
                $_SESSION['message_type'] = "success";
                header("Location: index.php?action=list");
                exit();
            } else {
                $_SESSION['message'] = "Erreur lors de la création du produit.";
                $_SESSION['message_type'] = "danger";
                header("Location: index.php?action=create");
                exit();
            }
        } else {
            // Si ce n'est pas POST, rediriger vers le formulaire
            header("Location: index.php?action=create");
            exit();
        }
    }
    
    // Afficher un produit
    public function show() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ID produit manquant');
        
        $this->product->id = $id;
        $stmt = $this->product->readOne();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($product) {
            $page_title = "Détails du Produit: " . $product['name'];
            
            ob_start();
            include 'views/products/show.php';
            $content = ob_get_clean();
            
            include 'views/layout/template.php';
        } else {
            $_SESSION['message'] = "Produit non trouvé.";
            $_SESSION['message_type'] = "danger";
            header("Location: index.php?action=list");
            exit();
        }
    }
    
    // Afficher le formulaire d'édition
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ID produit manquant');
        
        $this->product->id = $id;
        $stmt = $this->product->readOne();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($product) {
            $page_title = "Modifier le Produit: " . $product['name'];
            
            ob_start();
            include 'views/products/edit.php';
            $content = ob_get_clean();
            
            include 'views/layout/template.php';
        } else {
            $_SESSION['message'] = "Produit non trouvé.";
            $_SESSION['message_type'] = "danger";
            header("Location: index.php?action=list");
            exit();
        }
    }
    
    // Traiter la mise à jour
    public function update() {
        session_start();
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = isset($_GET['id']) ? $_GET['id'] : die('ID produit manquant');
            
            $this->product->id = $id;
            $this->product->name = $_POST['name'];
            $this->product->description = $_POST['description'];
            $this->product->price = $_POST['price'];
            $this->product->quantity = $_POST['quantity'];
            
            if($this->product->update()) {
                $_SESSION['message'] = "Produit mis à jour avec succès !";
                $_SESSION['message_type'] = "success";
                header("Location: index.php?action=list");
                exit();
            } else {
                $_SESSION['message'] = "Erreur lors de la mise à jour.";
                $_SESSION['message_type'] = "danger";
                header("Location: index.php?action=edit&id=" . $id);
                exit();
            }
        }
    }
    
    // Supprimer un produit
    public function delete() {

        $id = isset($_GET['id']) ? $_GET['id'] : die('ID produit manquant');
        
        $this->product->id = $id;
        
        if($this->product->delete()) {
            $_SESSION['message'] = "Produit supprimé avec succès !";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression.";
            $_SESSION['message_type'] = "danger";
        }
        
        header("Location: index.php?action=list");
        exit();
    }
    
    // Rechercher des produits
    public function search() {
        $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : "";
        
        $page_title = "Résultats de recherche pour: " . $keywords;
        $stmt = $this->product->search($keywords);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total_results = count($products);
        
        ob_start();
        include 'views/products/search.php';
        $content = ob_get_clean();
        
        include 'views/layout/template.php';
    }
}
?>