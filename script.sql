-- Création de la base de donnés
CREATE database services;
USE services;
--create user tapha identified by `polipoli`;
--grant all privileges on services.* to "tapha";
--flush privileges;

-- Création de la table des utilisateurs
CREATE TABLE users (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    typeUser ENUM('medecin', 'infirmier', 'secretaire', 'admin') NOT NULL
);

-- Création de la table des médecins
CREATE TABLE medecin (
    idMedecin INT AUTO_INCREMENT PRIMARY KEY,
    nom_m VARCHAR(50) NOT NULL,
    prenom_m VARCHAR(50) NOT NULL,
    adresse_m VARCHAR(255),
    grade_m VARCHAR(50),
    specialite_m VARCHAR(100),
    numTel_m VARCHAR(15),
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users(idUser)
);

-- Création de la table des infirmiers
CREATE TABLE infirmier (
    idInfirmier INT AUTO_INCREMENT PRIMARY KEY,
    nom_i VARCHAR(50) NOT NULL,
    prenom_i VARCHAR(50) NOT NULL,
    adresse_i VARCHAR(255),
    specialite_i VARCHAR(100),
    numTel_i VARCHAR(15),
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users(idUser)
);

-- Création de la table des secrétaires
CREATE TABLE secretaire (
    idSecretaire INT AUTO_INCREMENT PRIMARY KEY,
    nom_s VARCHAR(50) NOT NULL,
    prenom_s VARCHAR(50) NOT NULL,
    adresse_s VARCHAR(255),
    numTel_s VARCHAR(15),
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users(idUser)
);

-- Création de la table de l'administrateur
CREATE TABLE admin (
    idAdmin INT AUTO_INCREMENT PRIMARY KEY,
    nom_a VARCHAR(50) NOT NULL,
    prenom_a VARCHAR(50) NOT NULL,
    adresse_a VARCHAR(255),
    numTel_a VARCHAR(15),
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users(idUser)
);

-- Création de la table des patients
CREATE TABLE patient (
    idPatient INT AUTO_INCREMENT PRIMARY KEY,
    nom_p VARCHAR(50) NOT NULL,
    prenom_p VARCHAR(50) NOT NULL,
    adresse_p VARCHAR(255),
    numTel_p VARCHAR(15),
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users(idUser)
);

-- Création de la table des rendez-vous
CREATE TABLE rendezvous (
    idRendezvous INT AUTO_INCREMENT PRIMARY KEY,
    idMedecin INT,
    idPatient INT,
    date_rdv DATE,
    heure_rdv TIME,
    description_rdv TEXT,
    FOREIGN KEY (idMedecin) REFERENCES medecin(idMedecin),
    FOREIGN KEY (idPatient) REFERENCES patient(idPatient)
);
