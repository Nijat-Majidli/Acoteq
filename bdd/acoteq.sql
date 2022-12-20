DROP DATABASE IF EXISTS acoteq;

CREATE DATABASE acoteq;

USE acoteq;

CREATE TABLE Users(
   user_id INT NOT NULL AUTO_INCREMENT,   
   user_nom VARCHAR(255) NOT NULL,
   user_prenom VARCHAR(255) NOT NULL,
   user_societe VARCHAR(255) NOT NULL,
   user_siren INT NOT NULL,
   user_role VARCHAR(255) NOT NULL,
   user_adresse VARCHAR(255) NOT NULL,
   user_code_postal INT NOT NULL,
   user_ville VARCHAR(255) NOT NULL,
   user_pays VARCHAR(255) NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   user_mdp VARCHAR(255) NOT NULL,
   user_inscription DATETIME NOT NULL,
   user_connexion DATETIME NOT NULL,
   login_fail INT,
   user_blocked VARCHAR(255),
   unblock_time BIGINT,
   PRIMARY KEY(user_id, user_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`user_id`, `user_nom`, `user_prenom`, `user_societe`, `user_siren`, `user_role`, `user_adresse`, `user_code_postal`, `user_ville`, `user_pays`, `user_email`, `user_mdp`, `user_inscription`, `user_connexion`, `login_fail`, `user_blocked`, `unblock_time`) VALUES
(1, 'BOYER', 'Isabelle', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'i_boyer@iqaten.com', '$2y$10$Ro/a0Iq.oc7pBuboaDodx.S15PBF6XsvhOq6owLIOOAjm4DGzssUq', '2022-11-29 09:53:44', '2022-10-27 16:33:10', 0, NULL, NULL),
(2, 'SMITH', 'Adam', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'smith@iqaten.com', '$2y$10$DSdGrUmt7dFE7TnEYv1HWe0iha5PYtpExfrGJHwQSM70yLAD2hnHq', '2022-11-22 16:26:54', '2022-11-29 10:28:53', NULL, NULL, NULL),
(3, 'MULLER', 'George', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'muller@iqaten.com', '$2y$10$Xm9HlvqVLK6Sxb97lfMpruxDlmkSUKPJ4eZTgK9yTe1.WUpn/iEJa', '2022-11-22 16:28:40', '2022-10-10 09:56:57', NULL, NULL, NULL),
(4, 'WILLIAMS', 'Paul', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'williams@iqaten.com', '$2y$10$Bnx33UxAT64nNr0qVRIAsuhIcNIRxdhUERxTY4HuZdNBJTzwKpZiW', '2022-11-22 16:31:17', '2022-11-29 10:31:10', NULL, NULL, NULL),
(5, 'BECKER', 'David', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'becker@iqaten.com', '$2y$10$datiJtO9KT4fa6jPlpuWU.GPSa1AKenD7D3uVe4H/zu8cbGs4sOXW', '2022-11-22 16:32:55', '2022-11-28 20:49:14', NULL, NULL, NULL),
(6, 'TAYLOR', 'Marc', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'taylor@iqaten.com', '$2y$10$sz85IyN9QIqIipHz0TpkXeqtgDio7HtgIMBPrF7vffW9Jp9uaQlJm', '2022-11-27 14:49:04', '2022-11-27 14:49:04', NULL, NULL, NULL),
(7, 'BROWN', 'Michael', 'Thermo_2022', 987654321, 'fournisseur', '58 avenue de paris', 75001, 'Paris 01', 'France', 'brown@gmail.fr', '$2y$10$Tcj84Uhxjb.jBgCt4c4EE.lT3QIITmoLsg7YFHAQ.sPQwhQn8YIRC', '2022-11-22 16:36:38', '2022-10-10 11:34:04', NULL, NULL, NULL),
(8, 'MORRIS', 'Robert', 'Iso', 876543219, 'fournisseur', '31 rue du générale leclerc', 80000, 'Amiens', 'France', 'morris_robert77@hotmail.info', '$2y$10$Fte1KaFoZ90/UlG6sUcLIuASHS3lk1w/t2P7W2ZNzDhV3/25zBCD2', '2022-11-22 16:39:44', '2022-10-11 21:14:19', NULL, NULL, NULL),
(9, 'HALL', 'Richard', 'Btp_99', 234567891, 'client', '28 rue pasteur', 91120, 'Palaiseau', 'France', 'hall-richard85@free.fr', '$2y$10$4Xrji3cRVWAeLA2gBE4VUOQ9j2zJlctMJxAHZp5ZcQTmDExN/vc3q', '2022-11-22 16:44:08', '2022-11-22 16:44:08', NULL, NULL, NULL),
(10, 'MILLER', 'Thomas', 'Btp_99', 234567891, 'client', '28 rue pasteur', 91120, 'Palaiseau', 'France', 'sthomas@yahoo.com', '$2y$10$UQnn9STolu2XJztrDOmmuezjwA0M1nEzWAtijRmeRVSC.ufKwJ7Le', '2022-11-22 16:52:31', '2022-11-22 16:52:31', NULL, NULL, NULL),
(11, 'HERNANDEZ', 'Scott', 'Btp_99', 234567891, 'client', '28 rue pasteur', 91120, 'Palaiseau', 'France', 'hernandez@outlook.fr', '$2y$10$vAYv3o3K/sd0vLIlcup2qeat7reB8Ku5nV5a.zgO7qDTuNj2OdXGa', '2022-11-27 15:02:57', '2022-11-27 15:02:57', NULL, NULL, NULL),
(12, 'DUPONT', 'Eric', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'eric_dupont@iqaten.com', '$2y$10$LjPUh4b5LwLOloxnjLkzq.hS6G5f6UQI4122niFr8tGqQ4YhEoTHe', '2022-11-28 21:01:02', '2022-11-28 21:01:52', NULL, NULL, NULL),
(13, 'DUBOIS', 'Jeanne', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'jeanne_2000@iqaten.com', '$2y$10$pCw1i/gLEyyx3nF1p2tJW.7gg5j1Bgo7Z2auw/Ecvrl8YHidmF3la', '2022-11-28 21:44:31', '2022-11-28 21:44:31', NULL, NULL, NULL),
(14, 'DURAND', 'Bernard', 'Iqaten', 123456789, 'client', '14 rue de suresnes', 92000, 'Nanterre', 'France', 'b_durand@iqaten.com', '$2y$10$quJaZNZ.ieFeTf5ga7gb2e1yWuMaG4DtkDHGGZgSt1FdTpzEM9iVO', '2022-10-05 15:18:13', '2022-10-05 15:18:13', NULL, NULL, NULL),
(15, 'BARBIER', 'Agnès', 'Btp_99', 234567891, 'client', '28 rue pasteur', 91120, 'Palaiseau', 'France', 'barbier@gmail.com', '$2y$10$ZeMQAZ4N7XLeYViUIYHTdO4Dj2CRpGFDXRfQLtOZ0gz5gf53Lmdpm', '2022-10-11 11:17:08', '2022-10-11 11:17:08', NULL, NULL, NULL),
(16, 'NICOLAS', 'Huet', 'Alliance', 789123456, 'fournisseur', 'boulevard des états-unis', 60200, 'Compiègne', 'France', 'alliance_2005@yahoo.fr', '$2y$10$gotdzi8foZROqTZ3ibz2W.rge.EcJH2GgLLXBzc8LxmXbUsdbbexm', '2022-10-10 08:43:45', '2022-10-10 08:43:45', NULL, NULL, NULL);
COMMIT;


CREATE TABLE Equipe(
   equipe_id INT NOT NULL AUTO_INCREMENT,
   equipe_nom VARCHAR(255) NOT NULL,
   equipe_proprietaire VARCHAR(255) NOT NULL,
   equipe_membres TEXT,
   member_mails TEXT,
   equipe_creation DATETIME NOT NULL,
   equipe_modification DATETIME,
   user_id INT NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   PRIMARY KEY(equipe_id),
   FOREIGN KEY(user_id, user_email) REFERENCES Users(user_id, user_email) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `equipe` (`equipe_id`, `equipe_nom`, `equipe_proprietaire`, `equipe_membres`, `member_mails`, `equipe_creation`, `equipe_modification`, `user_id`, `user_email`) VALUES
(2, 'Team_smith_1', 'Adam SMITH, smith@iqaten.com', 'adam smith,  isabelle boyer,  david becker', ' smith@iqaten.com,  i_boyer@iqaten.com,  becker@iqaten.com', '2022-12-19 17:25:36', NULL, 2, 'smith@iqaten.com'),
(3, 'Team_smith_2', 'Adam SMITH, smith@iqaten.com', 'adam smith,  paul williams,  marc taylor', ' smith@iqaten.com,  williams@iqaten.com,  taylor@iqaten.com', '2022-12-19 17:53:39', '2022-12-19 18:05:21', 2, 'smith@iqaten.com'),
(4, 'Team_smith_3', 'Adam SMITH, smith@iqaten.com', 'adam smith,  jeanne dubois,  marc taylor', ' smith@iqaten.com,  jeanne_2000@iqaten.com,  taylor@iqaten.com', '2022-12-19 18:18:54', '2022-12-19 18:20:25', 2, 'smith@iqaten.com'),
(6, 'Team_richard', 'Richard HALL, hall-richard85@free.fr', 'richard hall,  thomas miller,  agnès barbier', ' hall-richard85@free.fr,  sthomas@yahoo.com,  barbier@gmail.com', '2022-12-20 12:14:00', NULL, 9, 'hall-richard85@free.fr'),
(7, 'Team_isabelle_1', 'Isabelle BOYER, i_boyer@iqaten.com', 'isabelle boyer,  jeanne dubois,  bernard durand,  adam smith', ' i_boyer@iqaten.com,  jeanne_2000@iqaten.com,  b_durand@iqaten.com,  smith@iqaten.com', '2022-12-20 12:46:52', NULL, 1, 'i_boyer@iqaten.com');


CREATE TABLE Demande(
   demande_id INT NOT NULL AUTO_INCREMENT,
   demande_proprietaire VARCHAR(255) NOT NULL,
   demande_societe VARCHAR(255) NOT NULL,
   demande_titre VARCHAR(255) NOT NULL,
   demande_description TEXT NOT NULL,
   demande_budget INT NOT NULL,
   demande_file_name VARCHAR(255) NOT NULL,
   demande_creation DATETIME NOT NULL,
   demande_modification DATETIME,
   demande_publication DATETIME,
   demande_equipe VARCHAR(255),
   demande_etat VARCHAR(255) NOT NULL,
   demande_notification VARCHAR(255) NOT NULL,
   equipe_id INT,
   user_id INT NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   PRIMARY KEY(demande_id),
   FOREIGN KEY(equipe_id) REFERENCES Equipe(equipe_id) ON DELETE CASCADE,
   FOREIGN KEY(user_id, user_email) REFERENCES Users(user_id, user_email) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `demande` (`demande_id`, `demande_proprietaire`, `demande_societe`, `demande_titre`, `demande_description`, `demande_budget`, `demande_file_name`, `demande_creation`, `demande_modification`, `demande_publication`, `demande_equipe`, `demande_etat`, `demande_notification`, `equipe_id`, `user_id`, `user_email`) VALUES
(1, 'SMITH Adam', 'Iqaten', 'Demande_smith_1', ' c\'est une demande_1 de m.smith.  ', 2500, 'demande_22 Email_structure.pdf', '2022-12-19 21:15:02', '2022-12-19 21:16:20', '2022-12-19 21:16:20', 'Team_smith_2', 'publié', 'envoyé', 2, 2, 'smith@iqaten.com'),
(2, 'SMITH Adam', 'Iqaten', 'Demande_smith_2', 'c\'est une demande 2.', 1500, 'demande_23 SQL_p2.pdf', '2022-12-19 21:17:49', NULL, '2022-12-19 21:18:04', 'Team_smith_1', 'publié', 'envoyé', 2, 2, 'smith@iqaten.com'),
(3, 'SMITH Adam', 'Iqaten', 'Demande_smith_3', 'c\'est une demande 3.', 3000, 'demande_23 SQL_p2.pdf', '2022-12-19 21:18:45', NULL, NULL, 'Team_smith_3', 'sauvegardé', 'non envoyé', 4, 2, 'smith@iqaten.com'),
(4, 'HALL Richard', 'Btp_99', 'Demande_richard_1', 'salut,\r\nc\'est une demande de m.hall richard. ', 3500, 'demande_23 SQL_p2.pdf', '2022-12-20 12:15:30', '2022-12-20 12:18:17', '2022-12-20 12:19:35', 'Team_richard', 'publié', 'envoyé', 6, 9, 'hall-richard85@free.fr'),
(5, 'HALL Richard', 'Btp_99', 'Demande_richard_2', 'bonjour,\r\nc\'est une demande_2 de m.hall richard.', 5550, 'demande_22 Sony_developpeur_web.pdf', '2022-12-20 12:16:57', NULL, '2022-12-20 12:16:57', 'Team_richard', 'publié', 'envoyé', 6, 9, 'hall-richard85@free.fr'),
(6, 'BOYER Isabelle', 'Iqaten', 'Demande_isabelle', 'bonjour,\r\nc\'est une demande numéro1', 7200, 'demande_22 Email_structure.pdf', '2022-12-20 12:48:44', NULL, '2022-12-20 12:48:44', 'Team_isabelle_1', 'publié', 'non envoyé', 7, 1, 'i_boyer@iqaten.com');


CREATE TABLE Reponse(
   reponse_id INT NOT NULL AUTO_INCREMENT,
   reponse_proprietaire VARCHAR(255) NOT NULL,
   reponse_societe VARCHAR(255) NOT NULL,
   reponse_titre VARCHAR(255) NOT NULL,
   reponse_description TEXT NOT NULL,
   reponse_budget INT NOT NULL,
   reponse_publication DATETIME NOT NULL,
   reponse_notification VARCHAR(255),
   reponse_modification DATETIME,
   user_id INT NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   demande_id INT NOT NULL,   
   PRIMARY KEY(reponse_id),
   FOREIGN KEY(user_id, user_email) REFERENCES Users(user_id, user_email) ON DELETE CASCADE,
   FOREIGN KEY(demande_id) REFERENCES Demande(demande_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reponse` (`reponse_id`, `reponse_proprietaire`, `reponse_societe`, `reponse_titre`, `reponse_description`, `reponse_budget`, `reponse_publication`, `reponse_notification`, `reponse_modification`, `user_id`, `user_email`, `demande_id`) VALUES
(1, 'BROWN Michael', 'Thermo_2022', 'Réponse brown pour la demande_1 de M Smith', 'Hello M. Smith.\r\nJe suis interresé par votre demande numéro 1. \r\n                             \r\n                             \r\n                            ', 2255, '2022-12-19 22:14:14', 'envoyé', '2022-12-19 22:41:47', 7, 'brown@gmail.fr', 1),
(2, 'MORRIS Robert', 'Iso', 'réponse_morris_demande smith_1', 'Monsieur smith\r\nJe me permet de vous contacter concernant votre demande_1. \r\n                            ', 2150, '2022-12-20 13:04:22', 'envoyé', '2022-12-20 13:05:38', 8, 'morris_robert77@hotmail.info', 1);


CREATE TABLE Commentaire(
   comment_id INT NOT NULL AUTO_INCREMENT,
   comment_proprietaire VARCHAR(255) NOT NULL,
   comment_societe VARCHAR(255) NOT NULL,
   comment_description TEXT NOT NULL,
   comment_publication DATETIME NOT NULL,
   comment_modification DATETIME,
   comment_visibilite VARCHAR(50),
   user_id INT NOT NULL,
   user_email VARCHAR(255) NOT NULL,
   user_id_1 INT NOT NULL,
   user_email_1 VARCHAR(255) NOT NULL,
   reponse_id INT NOT NULL,
   PRIMARY KEY(comment_id),
   FOREIGN KEY(user_id, user_email) REFERENCES Users(user_id, user_email) ON DELETE CASCADE,
   FOREIGN KEY(user_id_1, user_email_1) REFERENCES Users(user_id, user_email) ON DELETE CASCADE,
   FOREIGN KEY(reponse_id) REFERENCES Reponse(reponse_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `commentaire` (`comment_id`, `comment_proprietaire`, `comment_societe`, `comment_description`, `comment_publication`, `comment_modification`, `comment_visibilite`, `user_id`, `user_email`, `user_id_1`, `user_email_1`, `reponse_id`) VALUES
(2, 'Adam SMITH', 'Iqaten', 'bonjour m brown,\r\nmerci pour cette réponse.     ', '2022-12-19 22:52:10', '2022-12-19 23:16:40', 'visible', 2, 'smith@iqaten.com', 7, 'brown@gmail.fr', 1),
(3, 'Michael BROWN', 'Thermo_2022', 'j\'espere que vous allez accepter notre proposition.', '2022-12-19 23:18:11', NULL, 'visible', 2, 'smith@iqaten.com', 7, 'brown@gmail.fr', 1),
(4, 'Isabelle BOYER', 'Iqaten', ' bonjour m brown,\r\non va réfléchir sur votre proposition. ', '2022-12-20 12:24:25', '2022-12-20 12:45:25', 'visible', 1, 'i_boyer@iqaten.com', 7, 'brown@gmail.fr', 1),
(5, 'Adam SMITH', 'Iqaten', 'monsieur morris,\r\nmerci pour votre proposition.', '2022-12-20 13:06:56', NULL, 'non', 2, 'smith@iqaten.com', 8, 'morris_robert77@hotmail.info', 2);



