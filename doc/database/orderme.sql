USE orderme;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255),
    name VARCHAR(255) NOT NULL
) CHARSET=utf8mb4;
CREATE TABLE desks(
    id INT PRIMARY KEY,
    user_id INT,
    available  TINYINT(1),
    ordered  TINYINT(1),
    FOREIGN KEY FK_desks_users(user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

CREATE TABLE dishs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    type VARCHAR(255) NOT NULL,
    price INT NOT NULL
) CHARSET=utf8mb4;

CREATE TABLE orders(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    dish_id INT NOT NULL ,
    quantity INT NOT NULL,
    FOREIGN KEY FK_orders_dishs(dish_id) REFERENCES dishs(id),
    FOREIGN KEY FK_orders_users(user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

CREATE TABLE carts(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    dish_id INT NOT NULL ,
    quantity INT NOT NULL,
    FOREIGN KEY FK_carts_dishs(dish_id) REFERENCES dishs(id),
    FOREIGN KEY FK_carts_users(user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

INSERT INTO users (email, password, role, name)
VALUES
('caiupi@gmail.com', 'caiupi', 'admin','Administator');

INSERT INTO desks(id, available, ordered)
VALUES
(1,1,0); 
INSERT INTO desks(id, available, ordered)
VALUES
(2,1,0);
INSERT INTO desks(id, available, ordered)
VALUES
(3,1,0);

INSERT INTO dishs(name,description,type,price) 
VALUES 
('Toscano','Antipasto Toscano','Antipasto',10);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Formaggi','Formaggi misti','Antipasto',10);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Bruschetta','Bruscheta di pomodoro','Antipasto',10);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Mare','Insalata di mare','Antipasto',10);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Pesto','Spaghetti al pesto','Primi',12);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Carbonara','Spaghetti alla carbonara','Primi',12);

INSERT INTO dishs(name,description,type,price) 
VALUES 
('Bolognese','Spaghetti alla bolognese','Primi',12);

INSERT INTO dishs(name,description,type,price) 
VALUES 
('Scoglio','Spaghetti ai frutti di mare','Primi',12);

INSERT INTO dishs(name,description,type,price) 
VALUES 
('Bisteca','Bistecca Fiorentina','Secondi',25);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Tagliata','Tagliata di manzo','Secondi',18);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Filetto','Filetto al peppe verde','Secondi',25);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Orata','Orata alla griglia','Secondi',23);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Mista','Insalata mista','Contorni',5);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Patate','Patate arrosto','Contorni',5);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Spinaci','Spinaci saltati','Contorni',5);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Tiramisu','Tiramisu','Dolci',6);
INSERT INTO dishs(name,description,type,price) 
VALUES 
('Panna','Panna cotta','Dolci',5);
INSERT INTO dishs(name,description,type,price)
VALUES
('Cheesecake','Cheesecake ai frutti di bosco','Dolci',7);

