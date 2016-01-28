<?php
#-------------------------------------------------------------------------
# Module: Ping
# Version: 0.2, Claude SIOHAN Agi webconseil
# Method: Install
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/**
 * For separated methods, you'll always want to start with the following
 * line which check to make sure that method was called from the module
 * API, and that everything's safe to continue:
 */ 
if (!isset($gCms)) exit;


/** 
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Install() method in the module body.
 */

$db = $gCms->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	actif I(1),
	licence I(11),
	nom C(255),
	prenom C(255),
	pts I(11),
	birthday D,
	sexe C(1),
	type C(1),
	certif C(255),
	validation D,
	echelon C(1),
	place I(4),
	point I(4),
	cat C(5),
	adresse C(255),
	ville C(255),
	codepostal C(5) ";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_joueurs",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
$dict = NewDataDictionary( $db );
$flds= "id I(11) KEY AUTO,
        saison C(100),
	phase I(1),
	libequipe C(255),
	libdivision C(255),
	friendlyname C(255),
	liendivision C(255),
	idpoule I(11),
	iddiv I(11),
	type_compet C(3) DEFAULT 'U',
	tag C(255),
	idepreuve C(11)";

$sqlarray= $dict->CreateTableSQL( cms_db_prefix()."module_ping_equipes",
				  $flds,
				  $taboptarray);
				
$dict->ExecuteSQLArray($sqlarray);
//on créé un index pour éviter les doublons
$idxflds = 'saison, libequipe, liendivision';
$tabname = cms_db_prefix()."module_ping_equipes";
$idxname = 'unicite';
//$idxoptarray = 'Unique';
$dict = NewDataDictionary( $db );
  $sqlarray = $dict->CreateIndexSQL('unicite', 'demo_module_ping_equipes', 'saison, libequipe, liendivision');//, array('UNIQUE'));
  $dict->ExecuteSQLArray($sqlarray);
//une nouvelle table pour les victoires brutes (pas de victoires détaillées pour l'instant)
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	saison C(255),
	datemaj ". CMS_ADODB_DT .",
	licence I(11),
	date_event D,
	epreuve C(255),
	nom C(255),
	numjourn I(11),
	classement I(4),
	victoire I(1),
	ecart N(6.2),
	type_ecart I(11),
	coeff N(3.2),
	pointres N(5.3),
	forfait I(1) ";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_parties_spid",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//une nouvelle table pour les points

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11)  AUTO KEY,
	saison C(255),
	licence I(11),
	advlic I(11),
	vd I,
	numjourn I(2),
	codechamp C(3),
	date_event D,
	advsexe C(3),
	advnompre C(255),
	pointres N(6.3),
	coefchamp N(3.2),
	advclaof C(4)";
			
// 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_parties",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	saison C(255),
	datemaj ". CMS_ADODB_DT .",
	licence I(11),
	sit_mens C(200),
	fftt I(11),
	maj_fftt D,
	spid I(11),
	spid_total I(11),
	maj_spid D,
	maj_total I(11)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_recup_parties",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


$dict = NewDataDictionary( $db );

// table schema description
$flds = "
     id I(11) AUTO KEY,
	saison C(255),
	idpoule I(11),
	iddiv I(11),
	club I(1),
	tour I(2),
	date_event D,
	affiche L, 
	uploaded I(1),
	libelle C(255),
	equa C(255),
	equb C(255),
	scorea I(2),
	scoreb I(2),
	lien C(255)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_poules_rencontres",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	datecreated ". CMS_ADODB_DT .",
	datemaj ". CMS_ADODB_DT .",
	saison C(255),
	mois I(2),
	annee I(4),
	phase I(1),
	licence I(11),
	categ C(10),
	nom C(255),
	prenom C(255),
	points N(6.2),
	clnat I(11),
	rangreg I(11),
	rangdep I(11),
	progmois N(6.2)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_sit_mens",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	datecreated ". CMS_ADODB_DT .",
	datemaj ". CMS_ADODB_DT .",
	mois I(2),
	annee I(4),
	phase I(1),
	licence I(11),
	categ C(10),
	nom C(255),
	prenom C(255),
	points N(6.2),
	clnat I(11),
	rangreg I(11),
	rangdep I(11),
	progmois N(6.2)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_adversaires",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	saison C(255),
	type_compet C(3),
	date_debut D,
	date_fin D,
	iddiv I(11),
	idpoule I(11),
	numjourn I(11),
	tag C(255),
	idepreuve I(11)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_calendrier",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


//création d'un index unique : 
//CREATE UNIQUE INDEX nodoublons ON ping_module_ping_sit_mens (licence, mois, annee);

// table schema description
$flds = "
	id I(11) AUTO KEY,
	datecreated ". CMS_ADODB_DT .",
	datemaj ". CMS_ADODB_DT .",
	licence I(11),
	type_contact C(255),
	contact C(255),
	description C(255)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_comm",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// table schema description
$flds = "
	id I(11) AUTO KEY,
	datecreated ". CMS_ADODB_DT .",
	status C(255),
	designation C(255),
	action C(255)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_recup",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//table type_competitions
$dict = NewDataDictionary( $db );
$flds = "
	id I(11) AUTO KEY,
	name C(255),
	code_compet C(3) UNIQUE,
	coefficient N(3.2),
	indivs L,
	tag C(255),
	idepreuve I(11),
	idorga I(11)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_type_competitions",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#On insère les données au niveau national
$insert_sql = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (`id`, `name`, `code_compet`, `coefficient`, `indivs`, `tag`, `idepreuve`, `idorga`) VALUES ('', ?, ?, ?, ?, ?, ?, ?)";
//$db->execute($insert_sql, array( 'Tournoi National et Internat.', NULL, '0.75', 1, '{Ping action=\'individuelles\' idepreuve=\'3064\'}', 3064, 100001));
//$db->execute($insert_sql, array( 'CHAMPIONNAT POLICE', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3917\'}', 3917, 100001));
$db->execute($insert_sql, array( 'Tournoi OPEN', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'4537\'}', 4537, 100001));
$db->execute($insert_sql, array( 'Coupe Dom-Tom', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'4312\'}', 4312, 100001));
$db->execute($insert_sql, array( 'Finales par classement', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3001\'}', 3001, 100001));
$db->execute($insert_sql, array( 'Championnat FSGT', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3907\'}', 3907, 100001));
$db->execute($insert_sql, array( 'Championnat de France Seniors', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3058\'}', 3058, 100001));
$db->execute($insert_sql, array( 'Engagements Critérium Fédéral', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'4480\'}', 4480, 100001));
$db->execute($insert_sql, array( 'Championnats de France Corpo.', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3062\'}', 3062, 100001));
$db->execute($insert_sql, array( 'Championnats de France Jeunes', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3060\'}', 3060, 100001));
$db->execute($insert_sql, array( 'Challenge Bernard Jeu', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3070\'}', 3070, 100001));
$db->execute($insert_sql, array( 'Finales Individuelles', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3065\'}', 3065, 100001));
$db->execute($insert_sql, array( 'Critérium fédéral', NULL, '1.00', 1, '{Ping action=\'individuelles\' idepreuve=\'1072\'}', 1072, 100001));
$db->execute($insert_sql, array( 'Championnat des Jeunes FFTT', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'5721\'}', 5721, 100001));
$db->execute($insert_sql, array( 'Championnat par équipes corpo', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'4544\'}', 4544, 100001));
$db->execute($insert_sql, array( 'Changement de type', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'4972\'}', 4972, 100001));
$db->execute($insert_sql, array( 'Interclubs Jeunes', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'3057\'}', 3057, 100001));
$db->execute($insert_sql, array( 'Championnat France des Régions', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'3000\'}', 3000, 100001));
$db->execute($insert_sql, array( 'Coupe Nationale Vétérans', NULL, '0.75', 0, '{Ping action=\'par-equipes\' idepreuve=\'3055\'}', 3055, 100001));
$db->execute($insert_sql, array( 'Coupe de France des Clubs', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'5602\'}', 5602, 100001));
$db->execute($insert_sql, array( 'Coupe Nationale Corporative', NULL, NULL, 0, '{Ping action=\'par-equipes\' idepreuve=\'3056\'}', 3056, 100001));
$db->execute($insert_sql, array( 'Chpt France par équipes féminin', NULL, '1.00', 0, '{Ping action=\'par-equipes\' idepreuve=\'2012\'}', 2012, 100001));
$db->execute($insert_sql, array( 'Chpt France par équipes masculin', NULL, '1.00', 0, '{Ping action=\'par-equipes\' idepreuve=\'1073\'}', 1073, 100001));
$db->execute($insert_sql, array( 'Championnat de France FFSU/UNSS', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3874\'}', 3874, 100001));
$db->execute($insert_sql, array( 'Challenge USCF', NULL, NULL, 1, '{Ping action=\'individuelles\' idepreuve=\'3884\'}', 3884, 100001));
$db->execute($insert_sql, array( 'Championnats de France Vétérans', NULL, '1.00', 1, '{Ping action=\'individuelles\' idepreuve=\'3061\'}', 3061, 100001));

#
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	libelle C(255),
	idorga I(11),
	code C(5),
	scope C(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_organismes",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#On insère les valeurs dans la table
$insert_sql = "INSERT INTO ".cms_db_prefix()."module_ping_organismes (`id`, `libelle`, `idorga`, `code`, `scope`) VALUES ('', ?, ?, ?, ?)";
$db->execute($insert_sql, array( 'FFTT', 100001, 'FEDE', 'F'));
$db->execute($insert_sql, array( 'ZONE 1 (CE-IDF)', 10001, 'Z01', 'Z'));
$db->execute($insert_sql, array( 'ZONE 2 (BR-PDL)', 10002, 'Z02', 'Z'));
$db->execute($insert_sql, array( 'ZONE 3 (AQ-LI-MP-PC)', 10003, 'Z03', 'Z'));
$db->execute($insert_sql, array( 'ZONE 4 (AU-CO-CA-LR-PR-RA)', 10004, 'Z04', 'Z'));
$db->execute($insert_sql, array( 'ZONE 5 (AL-BO-CHA-FC-LO)', 10005, 'Z05', 'Z'));
$db->execute($insert_sql, array( 'ZONE 6 (BN-HN-NPC-PI)', 10006, 'Z06', 'Z'));
$db->execute($insert_sql, array( 'ZONE 7 (DOM-TOM)', 10007, 'Z07', 'Z'));
$db->execute($insert_sql, array( 'RHONE ALPES', 1001, 'L01', 'L'));
$db->execute($insert_sql, array( 'ALSACE ', 1002, 'L02', 'L'));
$db->execute($insert_sql, array( 'AQUITAINE', 1003, 'L03', 'L'));
$db->execute($insert_sql, array( 'PAYS DE LA LOIRE', 1004, 'L04', 'L'));
$db->execute($insert_sql, array( 'AUVERGNE', 1005, 'L05', 'L'));
$db->execute($insert_sql, array( 'BOURGOGNE', 1006, 'L06', 'L'));
$db->execute($insert_sql, array( 'BRETAGNE', 1007, 'L07', 'L'));
$db->execute($insert_sql, array( 'CHAMPAGNE - ARDENNE', 1008, 'L08', 'L'));
$db->execute($insert_sql, array( 'PACA', 1009, 'L09', 'L'));
$db->execute($insert_sql, array( 'NORD/PAS-DE-CALAIS', 1010, 'L10', 'L'));
$db->execute($insert_sql, array( 'FRANCHE COMTE', 1011, 'L11', 'L'));
$db->execute($insert_sql, array( 'ILE DE FRANCE', 1012, 'L12', 'L'));
$db->execute($insert_sql, array( 'LANGUEDOC ROUSSILLON', 1013, 'L13', 'L'));
$db->execute($insert_sql, array( 'LIMOUSIN', 1014, 'L14', 'L'));
$db->execute($insert_sql, array( 'LORRAINE', 1015, 'L15', 'L'));
$db->execute($insert_sql, array( 'BASSE NORMANDIE', 1017, 'L17', 'L'));
$db->execute($insert_sql, array( 'HAUTE NORMANDIE', 1018, 'L18', 'L'));
$db->execute($insert_sql, array( 'PICARDIE', 1019, 'L19', 'L'));
$db->execute($insert_sql, array( 'POITOU CHARENTES', 1020, 'L20', 'L'));
$db->execute($insert_sql, array( 'PROVENCE', 1021, 'L21', 'L'));
$db->execute($insert_sql, array( 'MIDI-PYRENEES', 1022, 'L22', 'L'));
$db->execute($insert_sql, array( 'CENTRE', 1023, 'L23', 'L'));
$db->execute($insert_sql, array( 'LIGUE CORSE DE TENNIS DE TABLE', 1024, 'L24', 'L'));
$db->execute($insert_sql, array( 'GUYANE.L', 1030, 'L30', 'L'));
$db->execute($insert_sql, array( 'REUNION.L', 1031, 'L31', 'L'));
$db->execute($insert_sql, array( 'NOUVELLE CALEDONIE', 1032, 'L32', 'L'));
$db->execute($insert_sql, array( 'GUADELOUPE.L', 1033, 'L33', 'L'));
$db->execute($insert_sql, array( 'LIGUE MARTINIQUE', 1034, 'L34', 'L'));
$db->execute($insert_sql, array( 'MAYOTTE.L', 1036, 'L36', 'L'));
$db->execute($insert_sql, array( 'TAHITI', 1037, 'L37', 'L'));
$db->execute($insert_sql, array( 'WALLIS ET FUTUNA L', 1038, 'L38', 'L'));
$db->execute($insert_sql, array( 'AIN', 1, 'D01', 'D'));
$db->execute($insert_sql, array( 'AISNE', 2, 'D02', 'D'));
$db->execute($insert_sql, array( 'ALLIER', 3, 'D03', 'D'));
$db->execute($insert_sql, array( 'ALPES HTE PROVENCE', 4, 'D04', 'D'));
$db->execute($insert_sql, array( 'HAUTES ALPES', 5, 'D05', 'D'));
$db->execute($insert_sql, array( 'ALPES MARITIMES', 6, 'D06', 'D'));
$db->execute($insert_sql, array( 'ARDENNES', 8, 'D08', 'D'));
$db->execute($insert_sql, array( 'ARIEGE', 9, 'D09', 'D'));
$db->execute($insert_sql, array( 'AUBE', 10, 'D10', 'D'));
$db->execute($insert_sql, array( 'AUDE', 11, 'D11', 'D'));
$db->execute($insert_sql, array( 'AVEYRON', 12, 'D12', 'D'));
$db->execute($insert_sql, array( 'BOUCHES DU RHONE', 13, 'D13', 'D'));
$db->execute($insert_sql, array( 'CALVADOS', 14, 'D14', 'D'));
$db->execute($insert_sql, array( 'CANTAL', 15, 'D15', 'D'));
$db->execute($insert_sql, array( 'CHARENTE', 16, 'D16', 'D'));
$db->execute($insert_sql, array( 'CHARENTE MARITIME', 17, 'D17', 'D'));
$db->execute($insert_sql, array( 'CHER', 18, 'D18', 'D'));
$db->execute($insert_sql, array( 'CORREZE', 19, 'D19', 'D'));
$db->execute($insert_sql, array( 'COTE D\'OR', 21, 'D21', 'D'));
$db->execute($insert_sql, array( 'CÔTES D ARMOR', 22, 'D22', 'D'));
$db->execute($insert_sql, array( 'CREUSE', 23, 'D23', 'D'));
$db->execute($insert_sql, array( 'DORDOGNE', 24, 'D24', 'D'));
$db->execute($insert_sql, array( 'DOUBS', 25, 'D25', 'D'));
$db->execute($insert_sql, array( 'DROME/ARDECHE', 26, 'D26', 'D'));
$db->execute($insert_sql, array( 'EURE', 27, 'D27', 'D'));
$db->execute($insert_sql, array( 'EURE ET LOIR', 28, 'D28', 'D'));
$db->execute($insert_sql, array( 'FINISTERE', 29, 'D29', 'D'));
$db->execute($insert_sql, array( 'GARD', 30, 'D30', 'D'));
$db->execute($insert_sql, array( 'HAUTE GARONNE', 31, 'D31', 'D'));
$db->execute($insert_sql, array( 'GERS', 32, 'D32', 'D'));
$db->execute($insert_sql, array( 'GIRONDE', 33, 'D33', 'D'));
$db->execute($insert_sql, array( 'HERAULT', 34, 'D34', 'D'));
$db->execute($insert_sql, array( 'ILLE ET VILAINE', 35, 'D35', 'D'));
$db->execute($insert_sql, array( 'INDRE', 36, 'D36', 'D'));
$db->execute($insert_sql, array( 'INDRE ET LOIRE', 37, 'D37', 'D'));
$db->execute($insert_sql, array( 'ISERE', 38, 'D38', 'D'));
$db->execute($insert_sql, array( 'JURA', 39, 'D39', 'D'));
$db->execute($insert_sql, array( 'LANDES', 40, 'D40', 'D'));
$db->execute($insert_sql, array( 'LOIR ET CHER', 41, 'D41', 'D'));
$db->execute($insert_sql, array( 'LOIRE', 42, 'D42', 'D'));
$db->execute($insert_sql, array( 'HAUTE LOIRE', 43, 'D43', 'D'));
$db->execute($insert_sql, array( 'LOIRE ATLANTIQUE', 44, 'D44', 'D'));
$db->execute($insert_sql, array( 'LOIRET', 45, 'D45', 'D'));
$db->execute($insert_sql, array( 'LOT', 46, 'D46', 'D'));
$db->execute($insert_sql, array( 'LOT ET GARONNE', 47, 'D47', 'D'));
$db->execute($insert_sql, array( 'LOZERE', 48, 'D48', 'D'));
$db->execute($insert_sql, array( 'MAINE ET LOIRE', 49, 'D49', 'D'));
$db->execute($insert_sql, array( 'MANCHE', 50, 'D50', 'D'));
$db->execute($insert_sql, array( 'MARNE', 51, 'D51', 'D'));
$db->execute($insert_sql, array( 'HAUTE-MARNE', 52, 'D52', 'D'));
$db->execute($insert_sql, array( 'MAYENNE', 53, 'D53', 'D'));
$db->execute($insert_sql, array( 'MEURTHE ET MOSELLE', 54, 'D54', 'D'));
$db->execute($insert_sql, array( 'MEUSE', 55, 'D55', 'D'));
$db->execute($insert_sql, array( 'MORBIHAN', 56, 'D56', 'D'));
$db->execute($insert_sql, array( 'MOSELLE', 57, 'D57', 'D'));
$db->execute($insert_sql, array( 'NIEVRE', 58, 'D58', 'D'));
$db->execute($insert_sql, array( 'NORD', 59, 'D59', 'D'));
$db->execute($insert_sql, array( 'OISE', 60, 'D60', 'D'));
$db->execute($insert_sql, array( 'ORNE', 61, 'D61', 'D'));
$db->execute($insert_sql, array( 'PAS DE CALAIS', 62, 'D62', 'D'));
$db->execute($insert_sql, array( 'PUY DE DOME', 63, 'D63', 'D'));
$db->execute($insert_sql, array( 'PYRENEES ATLANTIQUES', 64, 'D64', 'D'));
$db->execute($insert_sql, array( 'HAUTES PYRENEES', 65, 'D65', 'D'));
$db->execute($insert_sql, array( 'PYRENEES ORIENTALES', 66, 'D66', 'D'));
$db->execute($insert_sql, array( 'BAS RHIN', 67, 'D67', 'D'));
$db->execute($insert_sql, array( 'HAUT RHIN', 68, 'D68', 'D'));
$db->execute($insert_sql, array( 'Rhône-Lyon TT', 69, 'D69', 'D'));
$db->execute($insert_sql, array( 'HAUTE SAONE', 70, 'D70', 'D'));
$db->execute($insert_sql, array( 'SAONE ET LOIRE', 71, 'D71', 'D'));
$db->execute($insert_sql, array( 'SARTHE', 72, 'D72', 'D'));
$db->execute($insert_sql, array( 'SAVOIE', 73, 'D73', 'D'));
$db->execute($insert_sql, array( 'HAUTE SAVOIE', 74, 'D74', 'D'));
$db->execute($insert_sql, array( 'PARIS', 75, 'D75', 'D'));
$db->execute($insert_sql, array( 'SEINE MARITIME', 76, 'D76', 'D'));
$db->execute($insert_sql, array( 'SEINE ET MARNE', 77, 'D77', 'D'));
$db->execute($insert_sql, array( 'YVELINES', 78, 'D78', 'D'));
$db->execute($insert_sql, array( 'DEUX SEVRES', 79, 'D79', 'D'));
$db->execute($insert_sql, array( 'SOMME', 80, 'D80', 'D'));
$db->execute($insert_sql, array( 'TARN', 81, 'D81', 'D'));
$db->execute($insert_sql, array( 'TARN ET GARONNE', 82, 'D82', 'D'));
$db->execute($insert_sql, array( 'VAR', 83, 'D83', 'D'));
$db->execute($insert_sql, array( 'VAUCLUSE', 84, 'D84', 'D'));
$db->execute($insert_sql, array( 'VENDEE', 85, 'D85', 'D'));
$db->execute($insert_sql, array( 'VIENNE', 86, 'D86', 'D'));
$db->execute($insert_sql, array( 'HAUTE VIENNE', 87, 'D87', 'D'));
$db->execute($insert_sql, array( 'VOSGES', 88, 'D88', 'D'));
$db->execute($insert_sql, array( 'YONNE', 89, 'D89', 'D'));
$db->execute($insert_sql, array( 'BELFORT', 90, 'D90', 'D'));
$db->execute($insert_sql, array( 'ESSONNE', 91, 'D91', 'D'));
$db->execute($insert_sql, array( 'HAUTS DE SEINE', 92, 'D92', 'D'));
$db->execute($insert_sql, array( 'SEINE-SAINT-DENIS', 93, 'D93', 'D'));
$db->execute($insert_sql, array( 'VAL DE MARNE', 94, 'D94', 'D'));
$db->execute($insert_sql, array( 'VAL D OISE', 95, 'D95', 'D'));
$db->execute($insert_sql, array( 'HAUTE CORSE', 98, 'D98', 'D'));
$db->execute($insert_sql, array( 'CORSE DU SUD', 99, 'D99', 'D'));
$db->execute($insert_sql, array( 'GUADELOUPE', 100, 'D9A', 'D'));
$db->execute($insert_sql, array( 'COMITE MARTINIQUE', 101, 'D9B', 'D'));
$db->execute($insert_sql, array( 'GUYANE', 102, 'D9C', 'D'));
$db->execute($insert_sql, array( 'REUNION', 103, 'D9D', 'D'));
$db->execute($insert_sql, array( 'COMITE PROVINCIAL NORD', 104, 'D9E', 'D'));
$db->execute($insert_sql, array( 'COMITE PROVINCIAL SUD', 105, 'D9F', 'D'));
$db->execute($insert_sql, array( 'MAYOTTE', 106, 'D9G', 'D'));
$db->execute($insert_sql, array( 'TAHITI', 107, 'D9H', 'D'));
$db->execute($insert_sql, array( 'WALLIS ET FUTUNA', 108, 'D9W', 'D'));
#
# create table divisions
// table schema description
$flds = "
	id I(11) AUTO KEY,
	idorga I(11),
	idepreuve I(11),
	iddivision I(11),
	libelle C(255),
	saison C(255),
	indivs I(1),
	scope C(1),
	uploaded C(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_divisions",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
# create table div_poules//debut de la création
// table schema description
$flds = "
	id I(11) AUTO KEY,
	idepreuve I(11),
	iddivision I(11),
	libelle C(255),
	tour I(3),
	tableau I(11),	
	lien C(255),
	saison C(255),
	uploaded I(1),
	date_debut D,
	date_fin D,
	uploaded_parties I(1),
	uploaded_classement I(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_tours",
				$flds, 
				$taboptarray);
$dict->ExecuteSQLArray($sqlarray);
//on créé un index sur la table div_tours
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_tours',
	    cms_db_prefix().'module_ping_div_tours', 'idepreuve, iddivision, tableau',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
#
# create table div_classement//debut de la création
// table schema description
$dict = NewDataDictionary( $db );
$flds = "
	id I(11) AUTO KEY,
	idepreuve I(11),
	iddivision I(11),
	tableau I(11),
	tour I(11),
	rang I(11),
	nom C(255),
	clt C(255),
	club C(255),
	points N(6,3),
	saison C(255),
	uploaded I(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_classement",
				 $flds, 
				$taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
#
#
# create table div_parties//debut de la création
// table schema description
$dict = NewDataDictionary( $db );
$flds = "
	id I(11) AUTO KEY,
	idepreuve I(11),
	iddivision I(11),
	tableau I(11),
	tour I(2),
	libelle C(255), 
	vain C(255),
	perd C(255),
	forfait I(1), 
	saison C(255),
	uploaded I(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_parties",
				 $flds, 
				$taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
#
$dict = NewDataDictionary( $db );
$flds = "
	licence I(11),
	type_compet C(3),
	idepreuve I(11),
	date_debut D,
	date_fin D";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_participe",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
//une table pour les classements des poules
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	idequipe I(11),
	saison C(255),
	code_compet C(3),
	iddiv I(11),
	idpoule I(11),
	poule C(255),
	clt I(2),
	equipe C(255),
	joue I(4),
	pts I(3) ";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_classement",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//Création de la table feuille de rencontre
$flds = "
	id I(11) AUTO KEY,
	fk_id I(11),
	xja C(255),
	xca C(255),
	xjb C(255),
	xcb C(255)";
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_feuilles_rencontres", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//Création de la table parties des rencontres par équipes
$flds = "
	id I(11) AUTO KEY,
	fk_id I(11),
	joueurA C(255),
	scoreA I(1),
	joueurB C(255),
	scoreB I(1)";
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_rencontres_parties", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
/*
#On créé une nouvelle table pour le tableau de bord
#
$flds = "
	id I(11) AUTO KEY,
	rank I(11),
	name C(255),
	status I(1),
	hidden I(1)";
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_control_panel", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
# On insère des valeurs
#On insère les valeurs dans la table
$insert_sql = "INSERT INTO `demo_module_ping_control_panel` (`id`, `order`, `name`, `status`, `hidden`) VALUES (\', ?, ?, ?, ?)";
$db->execute($insert_sql, array( '1', 'Compte et test connexion', 0, 0));
*/
#
# Les indexs
//on créé un index sur la table div_tours
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'calendrier',
	    cms_db_prefix().'module_ping_calendrier', 'idepreuve, date_debut',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
#
//mieux vaut créer un index sur la clé étrangère fk_id
//$db->CreateSequence(cms_db_prefix().'module_ping_type_competitions');
#
#
// create a permission
$this->CreatePermission('Ping Use', 'Ping Use');
$this->CreatePermission('Ping Set Prefs','Ping Set Prefs');
$this->CreatePermission('Ping Manage user', 'Ping Manage user');
$this->CreatePermission('Ping Delete', 'Ping Delete');
#
// create a preference
//$this->SetPreference("mini_trancheA', '0');
/* les victoires normales */
$this->SetPreference('vicNorm0_24', '6');
$this->SetPreference('vicNorm25_49', '5,5');
$this->SetPreference('vicNorm50_99', '5');
$this->SetPreference('vicNorm100_149', '4');
$this->SetPreference('vicNorm150_199', '3');
$this->SetPreference('vicNorm200_299', '2');
$this->SetPreference('vicNorm300_399', '1');
$this->SetPreference('vicNorm400_499', '0,5');
$this->SetPreference('vicNormPlus500', '0');
#
#    Pour les tâches CRON
#
$this->SetPreference('LastRecupSpid', '');
$this->SetPreference('LastRecupFftt', '');
#
/*
* Css


$css_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css'. DIRECTORY_SEPARATOR .'bootstrap-table.css';
if (file_exists($css_file))
{
 $css = @file_get_contents($css_file);
 $css_id = $db->GenID(cms_db_prefix().'css_seq');
 $db->Execute('insert into '.cms_db_prefix().'css (css_id, css_name, css_text, media_type, create_date) values (?,?,?,?,?)',
   array($css_id, 'Ping table', $css, 'screen', date('Y-m-d')));
}
*/

/* les victoires anormales */
$this->SetPreference('vicAnorm0_24', '6');
$this->SetPreference('vicAnorm25_49', '7');
$this->SetPreference('vicAnorm50_99', '8');
$this->SetPreference('vicAnorm100_149', '10');
$this->SetPreference('vicAnorm150_199', '13');
$this->SetPreference('vicAnorm200_299', '17');
$this->SetPreference('vicAnorm300_399', '22');
$this->SetPreference('vicAnorm400_499', '28');
$this->SetPreference('vicAnormPlus500', '40');
#
/* défaites normales */
$this->SetPreference('defNorm0_24', '-5');
$this->SetPreference('defNorm25_49', '-4,5');
$this->SetPreference('defNorm50_99', '-4');
$this->SetPreference('defNorm100_149', '-3');
$this->SetPreference('defNorm150_199', '-2');
$this->SetPreference('defNorm200_299', '-1');
$this->SetPreference('defNorm300_399', '-0,5');
$this->SetPreference('defNorm400_499', '0');
$this->SetPreference('defNormPlus500', '0');
#
/* défaites Anormales */
$this->SetPreference('defAnorm0_24', '-5');
$this->SetPreference('defAnorm25_49', '-6');
$this->SetPreference('defAnorm50_99', '-7');
$this->SetPreference('defAnorm100_149', '-8');
$this->SetPreference('defAnorm150_199', '-10');
$this->SetPreference('defAnorm200_299', '-12,5');
$this->SetPreference('defAnorm300_399', '-16');
$this->SetPreference('defAnorm400_499', '-20');
$this->SetPreference('defAnormPlus500', '-29');


// create a preference
$this->SetPreference('defaultMonthSitMens', '5');
$this->SetPreference('phase', '1');
$this->SetPreference('populate_calendar', 'Oui');
$this->SetPreference('affiche_club_uniquement', 'Oui');
#
#Préférences de l'application
#
#
#Setup events
$this->CreateEvent('OnUserAdded');
$this->CreateEvent('OnUserDeleted');
#
//on insère les éléments par défaut
#indexes

$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
		    				cms_db_prefix().'module_ping_feuilles_rencontres', 'fk_id');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
	    cms_db_prefix().'module_ping_rencontres_parties', 'fk_id');
	       $dict->ExecuteSQLArray($sqlarray);
#
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>