-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 25 nov. 2020 à 05:25
-- Version du serveur :  10.1.47-MariaDB-0+deb9u1
-- Version de PHP : 7.3.16-1+0~20200320.56+debian9~1.gbp370a75

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `inscription`
--

-- --------------------------------------------------------

--
-- Structure de la table `annee_academique`
--

CREATE TABLE `annee_academique` (
  `lib_annee` varchar(100) CHARACTER SET latin1 NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `an_precedent` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table contenant les années académiques';

-- --------------------------------------------------------

--
-- Structure de la table `autorisation`
--

CREATE TABLE `autorisation` (
  `id` int(11) NOT NULL,
  `code_auto` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenoms` varchar(100) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(100) NOT NULL,
  `Nationalite` varchar(5) NOT NULL,
  `annee_auto` varchar(100) NOT NULL,
  `annee_inscrit` varchar(15) NOT NULL,
  `observ_auto` varchar(100) NOT NULL,
  `num_bac` varchar(50) NOT NULL,
  `session_bac` varchar(50) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `FF` int(11) DEFAULT NULL,
  `FI` int(11) DEFAULT NULL,
  `type_auto` int(11) NOT NULL,
  `memo1` text NOT NULL,
  `memo2` text NOT NULL,
  `valide` varchar(10) NOT NULL DEFAULT 'NON',
  `promotion` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

CREATE TABLE `banque` (
  `id` int(11) NOT NULL,
  `nom_banque` varchar(30) NOT NULL,
  `banqueIdentifiant` varchar(30) NOT NULL,
  `banquePassword` varchar(30) NOT NULL,
  `UnivIdentifiant` varchar(30) NOT NULL,
  `UnivPassword` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `code_dept` varchar(100) CHARACTER SET latin1 NOT NULL,
  `lib_dept` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table des départements du BENIN';

-- --------------------------------------------------------

--
-- Structure de la table `duplicata`
--

CREATE TABLE `duplicata` (
  `id` int(11) NOT NULL,
  `matricule` varchar(150) NOT NULL,
  `annee_acad` varchar(50) NOT NULL,
  `num_enregistrement` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(100) NOT NULL,
  `num_carte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ecole_dpt`
--

CREATE TABLE `ecole_dpt` (
  `id` int(11) NOT NULL,
  `ecole` varchar(20) NOT NULL,
  `departement` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ecole_ufr`
--

CREATE TABLE `ecole_ufr` (
  `num` int(11) NOT NULL,
  `code_ecole` varchar(100) CHARACTER SET latin1 NOT NULL,
  `code_ufr` varchar(100) CHARACTER SET latin1 NOT NULL,
  `lib_ecole` text CHARACTER SET latin1 NOT NULL,
  `detail_ecole` text CHARACTER SET latin1 NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table des écoles de l''UAK';

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `code` varchar(100) CHARACTER SET latin1 NOT NULL,
  `libelle` text CHARACTER SET latin1 NOT NULL,
  `ecole` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inscrit_ecu`
--

CREATE TABLE `inscrit_ecu` (
  `matricule` int(11) NOT NULL,
  `annee_academique` int(11) NOT NULL,
  `code_ecu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mapping`
--

CREATE TABLE `mapping` (
  `id` int(11) NOT NULL,
  `filiere` varchar(25) NOT NULL,
  `verdict` varchar(20) NOT NULL,
  `fil_auto` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mode`
--

CREATE TABLE `mode` (
  `num` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `Intitule` varchar(400) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='mode d''acces' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `montant`
--

CREATE TABLE `montant` (
  `filiere` varchar(100) NOT NULL,
  `statut` varchar(100) NOT NULL,
  `zone` int(11) NOT NULL,
  `FF` int(11) NOT NULL,
  `FI` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `num` int(11) NOT NULL,
  `code` varchar(100) CHARACTER SET latin1 NOT NULL,
  `libelle` varchar(200) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `param`
--

CREATE TABLE `param` (
  `id` int(11) NOT NULL,
  `annee_academique` varchar(100) NOT NULL,
  `an_precedent` varchar(100) NOT NULL,
  `moyenne_ecu_mini` float NOT NULL,
  `moyenne_ue_mini` float NOT NULL,
  `pourcentage_ue_mini` float NOT NULL,
  `session_bac` int(11) NOT NULL,
  `montant_ecu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `cod_pays` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cod_zone` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lib_pays` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lib_nation` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table des pays et nationalites';

-- --------------------------------------------------------

--
-- Structure de la table `penalite`
--

CREATE TABLE `penalite` (
  `id` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `annee_academique` varchar(100) NOT NULL,
  `montant` int(11) NOT NULL,
  `observation` text NOT NULL,
  `etablissement` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reprise_ecu`
--

CREATE TABLE `reprise_ecu` (
  `matricule` varchar(100) NOT NULL,
  `annee_academique` varchar(100) NOT NULL,
  `code_ecu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `resultatbac`
--

CREATE TABLE `resultatbac` (
  `NumTable` varchar(31) NOT NULL DEFAULT '',
  `session` varchar(10) NOT NULL,
  `Serie` varchar(5) DEFAULT NULL,
  `Lieu_Nais` varchar(50) DEFAULT NULL,
  `Date_Nais` varchar(25) DEFAULT NULL,
  `Nom` varchar(63) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `Prenoms` varchar(63) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sexe` varchar(1) NOT NULL,
  `Nationalite` varchar(50) NOT NULL,
  `Moyenne` float(4,2) NOT NULL,
  `observation` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Base Internet';

-- --------------------------------------------------------

--
-- Structure de la table `result_ecu`
--

CREATE TABLE `result_ecu` (
  `id` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `code_ecu` varchar(15) NOT NULL,
  `annee_acad` varchar(100) NOT NULL,
  `moyenne` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `matricule` varchar(100) NOT NULL,
  `nom` varchar(100) CHARACTER SET latin1 NOT NULL,
  `prenoms` varchar(100) CHARACTER SET latin1 NOT NULL,
  `sexe` varchar(10) CHARACTER SET latin1 NOT NULL,
  `date_naissance` varchar(150) NOT NULL,
  `lieu_naissance` varchar(150) CHARACTER SET latin1 NOT NULL,
  `situ_fam` varchar(100) NOT NULL,
  `nombre_enfant` int(11) NOT NULL,
  `date_entre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `telephone` int(11) NOT NULL,
  `pays_naissance` varchar(25) NOT NULL,
  `Nationalite` varchar(25) NOT NULL,
  `departement` varchar(25) NOT NULL,
  `adresse_postal` text CHARACTER SET latin1 NOT NULL,
  `num_table` varchar(100) CHARACTER SET latin1 NOT NULL,
  `session` varchar(100) CHARACTER SET latin1 NOT NULL,
  `code_auto` varchar(100) CHARACTER SET latin1 NOT NULL,
  `serie` varchar(15) NOT NULL,
  `email_uak` varchar(100) NOT NULL,
  `promotion` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table des informations personnelles des étudiants';

-- --------------------------------------------------------

--
-- Structure de la table `table_ecu_new`
--

CREATE TABLE `table_ecu_new` (
  `code_ecu` varchar(15) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `credit` int(11) NOT NULL,
  `code_ue` varchar(15) NOT NULL,
  `promotion` varchar(11) NOT NULL DEFAULT 'P4',
  `semestre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `table_ue_new`
--

CREATE TABLE `table_ue_new` (
  `code_ue` varchar(15) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `credit` int(11) NOT NULL,
  `code_ecole` varchar(100) NOT NULL,
  `promotion` varchar(11) NOT NULL DEFAULT 'P4',
  `semestre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ufr`
--

CREATE TABLE `ufr` (
  `num` int(11) NOT NULL,
  `code_ufr` varchar(100) CHARACTER SET latin1 NOT NULL,
  `lib_ufr` text CHARACTER SET latin1 NOT NULL,
  `detail_ufr` text CHARACTER SET latin1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='table des ufr de l''UAK';

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) CHARACTER SET latin1 NOT NULL,
  `prenoms` varchar(100) CHARACTER SET latin1 NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mot_de_passe` varchar(100) CHARACTER SET latin1 NOT NULL,
  `droit` int(11) NOT NULL,
  `etab` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table des utilisateurs de la plateforme';

-- --------------------------------------------------------

--
-- Structure de la table `verdict`
--

CREATE TABLE `verdict` (
  `id` int(11) NOT NULL,
  `matricule` varchar(25) NOT NULL,
  `filiere` varchar(25) NOT NULL,
  `annee_academique` varchar(25) NOT NULL,
  `result_semestre_1` varchar(25) NOT NULL,
  `result_semestre_2` varchar(25) NOT NULL,
  `moyenne` varchar(25) NOT NULL,
  `observation` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

CREATE TABLE `zone` (
  `COD_ZONE` int(11) NOT NULL,
  `LIB_ZONE` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annee_academique`
--
ALTER TABLE `annee_academique`
  ADD PRIMARY KEY (`lib_annee`);

--
-- Index pour la table `autorisation`
--
ALTER TABLE `autorisation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `banque`
--
ALTER TABLE `banque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`code_dept`);

--
-- Index pour la table `duplicata`
--
ALTER TABLE `duplicata`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ecole_dpt`
--
ALTER TABLE `ecole_dpt`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `ecole_ufr`
--
ALTER TABLE `ecole_ufr`
  ADD PRIMARY KEY (`code_ecole`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `inscrit_ecu`
--
ALTER TABLE `inscrit_ecu`
  ADD PRIMARY KEY (`matricule`,`annee_academique`,`code_ecu`);

--
-- Index pour la table `mapping`
--
ALTER TABLE `mapping`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mode`
--
ALTER TABLE `mode`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `montant`
--
ALTER TABLE `montant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `param`
--
ALTER TABLE `param`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `penalite`
--
ALTER TABLE `penalite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reprise_ecu`
--
ALTER TABLE `reprise_ecu`
  ADD PRIMARY KEY (`matricule`,`annee_academique`,`code_ecu`);

--
-- Index pour la table `resultatbac`
--
ALTER TABLE `resultatbac`
  ADD PRIMARY KEY (`NumTable`,`session`);

--
-- Index pour la table `result_ecu`
--
ALTER TABLE `result_ecu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matricule`);

--
-- Index pour la table `table_ecu_new`
--
ALTER TABLE `table_ecu_new`
  ADD PRIMARY KEY (`code_ecu`,`promotion`);

--
-- Index pour la table `table_ue_new`
--
ALTER TABLE `table_ue_new`
  ADD PRIMARY KEY (`code_ue`,`code_ecole`,`promotion`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ufr`
--
ALTER TABLE `ufr`
  ADD PRIMARY KEY (`code_ufr`),
  ADD UNIQUE KEY `code_ufr` (`code_ufr`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `verdict`
--
ALTER TABLE `verdict`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`COD_ZONE`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `autorisation`
--
ALTER TABLE `autorisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `banque`
--
ALTER TABLE `banque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `duplicata`
--
ALTER TABLE `duplicata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecole_dpt`
--
ALTER TABLE `ecole_dpt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mapping`
--
ALTER TABLE `mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `montant`
--
ALTER TABLE `montant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `param`
--
ALTER TABLE `param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `penalite`
--
ALTER TABLE `penalite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `result_ecu`
--
ALTER TABLE `result_ecu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `verdict`
--
ALTER TABLE `verdict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
