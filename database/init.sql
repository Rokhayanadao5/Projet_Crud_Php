-- Création de la table produits
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer des données de test
INSERT INTO products (name, description, price, quantity) VALUES
('Ordinateur Portable', 'PC portable 15 pouces, 16GB RAM, 512GB SSD', 999.99, 10),
('Smartphone', 'Smartphone Android, 128GB, 6.5 pouces', 499.99, 25),
('Tablette', 'Tablette 10 pouces, 64GB, WiFi', 299.99, 15),
('Casque Audio', 'Casque sans fil avec réduction de bruit', 199.99, 30),
('Clavier Mécanique', 'Clavier gaming RGB switches bleus', 89.99, 50);