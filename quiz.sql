CREATE DATABASE quiz_db;

USE quiz_db;

-- Table pour le thème "sport"
CREATE TABLE sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    reponse1 VARCHAR(255) NOT NULL,
    reponse2 VARCHAR(255) NOT NULL,
    reponse3 VARCHAR(255) NOT NULL,
    reponse4 VARCHAR(255) NOT NULL,
    bonne_reponse INT NOT NULL
);

-- Table pour le thème "géographie"
CREATE TABLE geographie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    reponse1 VARCHAR(255) NOT NULL,
    reponse2 VARCHAR(255) NOT NULL,
    reponse3 VARCHAR(255) NOT NULL,
    reponse4 VARCHAR(255) NOT NULL,
    bonne_reponse INT NOT NULL
);

-- Table pour le thème "histoire"
CREATE TABLE histoire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    reponse1 VARCHAR(255) NOT NULL,
    reponse2 VARCHAR(255) NOT NULL,
    reponse3 VARCHAR(255) NOT NULL,
    reponse4 VARCHAR(255) NOT NULL,
    bonne_reponse INT NOT NULL
);