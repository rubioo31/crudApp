-- Eliminar la base de datos si existe
DROP DATABASE IF EXISTS crudApp;

-- Crear la base de datos
CREATE DATABASE crudApp;
USE crudApp;

-- Crear tabla de categorias
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Crear tabla de productos
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category_id INT,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id)
      REFERENCES categories(id)
      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Crear tabla de pedidos
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_product FOREIGN KEY (product_id)
      REFERENCES products(id)
      ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos en la tabla categories
INSERT INTO categories (name) VALUES 
  ('Electronics'),
  ('Books'),
  ('Clothing');

-- Insertar datos en la tabla products
INSERT INTO products (name, price, category_id) VALUES 
  ('Smartphone', 699.99, 1),
  ('Laptop', 1299.99, 1),
  ('Novel Book', 19.99, 2),
  ('T-Shirt', 9.99, 3);

-- Insertar datos en la tabla orders
INSERT INTO orders (product_id, quantity, order_date) VALUES 
  (1, 2, '2025-02-05 10:00:00'),
  (3, 1, '2025-02-06 11:00:00'),
  (4, 3, '2025-02-07 09:30:00');
