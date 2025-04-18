
SET NAMES utf8mb4;
USE siop1_wiki;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS ban;
DROP TABLE IF EXISTS user;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE, -- UNIQUE pour éviter les doublons
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL -- ENUM pour obliger à choisir entre 'user' ou 'admin'
) ENGINE=InnoDB;

-- Table `bans`
CREATE TABLE IF NOT EXISTS ban (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reason TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertion des utilisateurs fictifs avec génération de hash
INSERT INTO user (username, password, role) VALUES
('root', SHA2('root', 256), 'admin'), -- Utilisateur administrateur
('user1', SHA2('password1', 256), 'user'),       -- Premier utilisateur fictif
('user2', SHA2('password2', 256), 'user');       -- Deuxième utilisateur fictif


-- Insertion d'un ban temporaire pour 'user2' pour une durée de 7 jours
INSERT INTO ban (reason, start_date, end_date, user_id) VALUES
('Violation des règles de conduite', NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), 3);

