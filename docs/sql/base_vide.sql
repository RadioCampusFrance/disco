/* Fichier a importer pour installer la base de données de départ */

CREATE TABLE IF NOT EXISTS f_airplay (
  airplay int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(200) NOT NULL DEFAULT '',
  dcreat datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  dmodif datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  c_user int(10) unsigned NOT NULL DEFAULT '0',
  m_user int(10) unsigned NOT NULL DEFAULT '0',
  publie tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (airplay)
) ;

CREATE TABLE IF NOT EXISTS f_airplay_cd (
  airplay int(10) unsigned NOT NULL DEFAULT '0',
  cd int(10) unsigned NOT NULL DEFAULT '0',
  ordre int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY cle (airplay,cd),
  KEY airplay (airplay),
  KEY cd (cd)
) ;

CREATE TABLE IF NOT EXISTS f_artiste (
  artiste int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(300) NOT NULL DEFAULT '',
  siteweb varchar(150) NOT NULL DEFAULT '',
  myspace varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (artiste),
  UNIQUE KEY artiste (artiste),
  KEY libelle (libelle)
) ;

CREATE TABLE IF NOT EXISTS f_cd (
  cd int(10) unsigned NOT NULL AUTO_INCREMENT,
  artiste int(10) unsigned NOT NULL DEFAULT '0',
  titre char(250) NOT NULL DEFAULT '',
  label int(10) unsigned DEFAULT NULL,
  maison int(10) unsigned DEFAULT NULL,
  distrib int(10) unsigned DEFAULT NULL,
  dsortie date NOT NULL,
  annee char(4) NOT NULL DEFAULT '',
  `type` int(10) unsigned DEFAULT NULL,
  support int(10) unsigned DEFAULT NULL,
  genre int(10) unsigned DEFAULT NULL,
  langue int(10) unsigned DEFAULT NULL,
  rotation int(10) unsigned DEFAULT NULL,
  user_progra int(10) unsigned DEFAULT NULL,
  dprogra int(10) unsigned NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  dsaisie date NOT NULL,
  dvd tinyint(3) unsigned NOT NULL DEFAULT '0',
  note_moy float(5,2) NOT NULL DEFAULT '0.00',
  airplay tinyint(1) unsigned NOT NULL DEFAULT '0',
  retour_mail varchar(100) NOT NULL DEFAULT '',
  retour_label tinyint(1) unsigned NOT NULL DEFAULT '0',
  retour_comment text NOT NULL,
  various tinyint(1) unsigned NOT NULL DEFAULT '0',
  nb_piste int(10) unsigned NOT NULL DEFAULT '0',
  rivendell tinyint(1) NOT NULL,
  etiquette tinyint(1) unsigned NOT NULL DEFAULT '0',
  libartiste char(100) NOT NULL DEFAULT '',
  libelle char(250) NOT NULL DEFAULT '',
  discid char(10) NOT NULL DEFAULT '',
  ref_label char(45) NOT NULL DEFAULT '',
  suppr tinyint(1) unsigned NOT NULL DEFAULT '0',
  retour_attendu int(10) unsigned NOT NULL DEFAULT '0',
  img varchar(255) NOT NULL DEFAULT '',
  ecoute varchar(128) DEFAULT NULL,
  PRIMARY KEY (cd),
  UNIQUE KEY cd (cd),
  KEY artiste (artiste),
  KEY genre (genre),
  KEY support (support),
  KEY `type` (`type`),
  KEY airplay (cd,airplay),
  KEY dprogra (dprogra),
  KEY alllabel (label,maison,distrib),
  KEY jsaisie_anne (annee),
  KEY label (label,maison,distrib)
)  ;

CREATE TABLE IF NOT EXISTS f_cd_comment (
  dbkey int(10) unsigned NOT NULL AUTO_INCREMENT,
  chrono datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  cd int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (dbkey),
  KEY cd (cd)
) ;

CREATE TABLE IF NOT EXISTS f_cd_emprunt (
  dbkey int(10) unsigned NOT NULL AUTO_INCREMENT,
  cd int(10) unsigned NOT NULL DEFAULT '0',
  numex int(10) unsigned NOT NULL DEFAULT '1',
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  disparu tinyint(1) unsigned NOT NULL DEFAULT '0',
  chrono datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  ret_user int(10) unsigned NOT NULL DEFAULT '0',
  ret_chrono datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  emp_user int(10) unsigned NOT NULL DEFAULT '0',
  emp_chrono datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (dbkey),
  KEY cle (cd,numex),
  KEY `user` (`user`),
  KEY disparu (disparu),
  KEY cd (cd)
) ;

CREATE TABLE IF NOT EXISTS f_cd_genre (
  dbkey int(10) unsigned NOT NULL AUTO_INCREMENT,
  cd int(10) unsigned NOT NULL DEFAULT '0',
  genre int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (dbkey),
  KEY cd (cd),
  KEY cle (cd,genre)
) ;

CREATE TABLE IF NOT EXISTS f_cd_note (
  dbkey int(10) unsigned NOT NULL AUTO_INCREMENT,
  cd int(10) unsigned NOT NULL DEFAULT '0',
  `user` int(10) unsigned NOT NULL DEFAULT '0',
  note INT UNSIGNED NOT NULL DEFAULT '10',
  PRIMARY KEY (dbkey),
  KEY cd (cd)
);

CREATE TABLE IF NOT EXISTS f_genre (
  genre int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(45) NOT NULL DEFAULT '',
  principal tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (genre),
  UNIQUE KEY genre (genre),
  KEY libelle (libelle)
) ;

INSERT INTO `f_genre` (`genre`, `libelle`, `principal`) VALUES
(1, 'Rock', 1),
(2, 'Pop', 1),
(3, 'Reggae/Dub', 1),
(4, 'Electro', 1),
(23, 'Jazz', 1),
(50, 'Compilation', 0),
(51, 'A DETERMINER', 0),
(56, 'B.O.F.', 0),
(58, 'Expérimental', 0),
(63, 'Noise', 0),
(69, 'Techno', 0),
(72, 'Métal', 0),
(82, 'Rap', 0),
(106, 'Inclassable', 0),
(111, 'Ambient', 0),
(123, 'Punk', 0),
(131, 'Indies', 0),
(142, 'House', 0),
(149, 'Documentaire', 0),
(152, 'Chanson', 1),
(153, 'Classic', 1),
(154, 'Country/Blues', 1),
(155, 'Folk/Accoustique', 1),
(156, 'Funk/Soul', 1),
(157, 'Hip-Hop', 1),
(158, 'World-Latino', 1),
(159, 'Bass Music', 0),
(160, 'Court', 0),
(161, 'Down-Tempo', 0),
(163, 'Extrême', 0),
(164, 'Français', 0),
(165, 'GOLD', 0),
(166, 'Groove/RnB', 0),
(167, 'Instru', 0),
(168, 'Local', 0),
(169, 'Long', 0),
(170, 'Math-rock/post-rock', 0),
(171, 'Poésie', 0),
(172, 'Reprise', 0);

CREATE TABLE IF NOT EXISTS f_label (
  label int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(45) NOT NULL DEFAULT '',
  email varchar(45) NOT NULL DEFAULT '',
  telephone varchar(45) NOT NULL DEFAULT '',
  adresse varchar(45) NOT NULL DEFAULT '',
  adresse2 varchar(45) NOT NULL DEFAULT '',
  cp varchar(45) NOT NULL DEFAULT '',
  ville varchar(45) NOT NULL DEFAULT '',
  mail_progra varchar(250) DEFAULT NULL,
  contact1 varchar(150) NOT NULL DEFAULT '',
  siteweb varchar(150) NOT NULL DEFAULT '',
  suppr tinyint(1) unsigned NOT NULL DEFAULT '0',
  info text NOT NULL,
  PRIMARY KEY (label),
  KEY label (label),
  KEY libelle (libelle)
) ;

CREATE TABLE IF NOT EXISTS f_langue (
  langue int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(45) NOT NULL DEFAULT '',
  actif tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (langue),
  UNIQUE KEY langue (langue),
  KEY libelle (libelle)
) ;

INSERT INTO `f_langue` (`langue`, `libelle`, `actif`) VALUES
(1, 'Anglais', 0),
(2, 'Français', 0),
(5, 'Instru', 0),
(8, 'Autre', 0),
(9, 'Espagnol', 0),
(12, 'Allemand', 0),
(21, 'Portuguais', 0),
(32, 'Italien', 0),
(36, 'n/a', 0),
(37, 'Arabe', 0),
(47, 'Japonais', 0);

CREATE TABLE IF NOT EXISTS f_piste (
  dbkey int(10) unsigned NOT NULL AUTO_INCREMENT,
  piste int(10) unsigned NOT NULL DEFAULT '0',
  cd int(10) unsigned NOT NULL DEFAULT '0',
  disque int(10) unsigned NOT NULL DEFAULT '0',
  titre varchar(300) NOT NULL DEFAULT '',
  artiste int(10) unsigned DEFAULT NULL,
  langue int(10) unsigned NOT NULL DEFAULT '0',
  anim tinyint(1) unsigned NOT NULL DEFAULT '0',
  rivendell tinyint(1) NOT NULL,
  star tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (dbkey),
  KEY cd (cd),
  KEY artiste (artiste),
  KEY piste (cd,disque,piste)
) ;

CREATE TABLE IF NOT EXISTS f_rotation (
  rotation int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(45) NOT NULL DEFAULT '',
  ordre int(10) unsigned NOT NULL DEFAULT '0',
  airplay tinyint(1) unsigned NOT NULL DEFAULT '1',
  retour_label varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (rotation),
  KEY rotation (rotation),
  KEY libelle (libelle)
) ;

INSERT INTO `f_rotation` (`rotation`, `libelle`, `ordre`, `airplay`, `retour_label`) VALUES
(1, 'Faible', 3, 1, 'a été mis en rotation faible.'),
(2, 'Moyenne', 2, 1, 'a été mis en rotation moyenne.'),
(3, 'Forte', 1, 1, 'a été mis en rotation forte.'),
(4, 'Archive', 5, 0, 'a été mis à disposition des émissions spéciales.'),
(5, 'Rebut', 7, 0, 'n''a pas été retenu.'),
(7, 'Cadeau auditeur', 6, 0, 'n''a pas été retenu.'),
(6, 'Sp', 4, 1, 'a été mis à disposition des émissions spéciales.');

CREATE TABLE IF NOT EXISTS f_support (
  support int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (support),
  KEY support (support),
  KEY libelle (libelle)
) ;


INSERT INTO `f_support` (`support`, `libelle`) VALUES
(1, 'CD'),
(2, 'MP3'),
(4, '7"'),
(5, '2xCD'),
(7, 'K7'),
(8, 'mini-CD'),
(9, '2xLP'),
(10, 'LP'),
(11, '12"'),
(12, 'n/a');

CREATE TABLE IF NOT EXISTS f_type (
  `type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  libelle char(45) NOT NULL DEFAULT '',
  airplay tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`type`),
  KEY `type` (`type`),
  KEY libelle (libelle)
) ;

INSERT INTO `f_type` (`type`, `libelle`, `airplay`) VALUES
(1, 'Album', 1),
(2, 'Single', 0),
(3, 'EP', 1),
(4, 'Maxi-Single', 1),
(12, 'n/a', 1),
(13, 'Compilation', 1);

CREATE TABLE IF NOT EXISTS f_user (
  `user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  suppr tinyint(1) unsigned NOT NULL DEFAULT '0',
  inactif date DEFAULT NULL,
  nom varchar(200) NOT NULL DEFAULT '',
  prenom varchar(200) NOT NULL DEFAULT '',
  cotisation tinyint(1) unsigned NOT NULL DEFAULT '0',
  role varchar(45) DEFAULT NULL,
  emission varchar(200) NOT NULL DEFAULT '',
  email varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  username varchar(45) NOT NULL,
  PRIMARY KEY (`user`),
  KEY `user` (`user`)
) ;
