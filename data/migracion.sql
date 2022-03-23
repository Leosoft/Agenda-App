
CREATE DATABASE agenda;
USE agenda;

CREATE TABLE usuarios(
    id INT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR (30) NOT NULL,
    apellido VARCHAR(50),
    email VARCHAR(60) NOT NULL,
    edad INT(3),
    telefono VARCHAR(15),
    discord VARCHAR(60),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);