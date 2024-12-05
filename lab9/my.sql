
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);


INSERT INTO users (username, password, email, role) 
VALUES 
('admin', 'hashed_password', 'admin@example.com', 'admin'),
('user1', 'hashed_password', 'user1@example.com', 'user');

INSERT INTO articles (title, content, author_id) 
VALUES 
('Добро пожаловать на спортивный сайт', 'Новости спорта каждый день!', 1),
('Тренировки на выносливость', 'Как правильно тренироваться?', 1);


SELECT a.title, a.content, u.username AS author, a.created_at 
FROM articles a 
JOIN users u ON a.author_id = u.id 
ORDER BY a.created_at DESC;
