<?php
#-------------------------------------------------------------------------
# Module: Ping
# Version: 0.6, Claude SIOHAN Agi webconseil
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
	club C(255),
	nclub C(8),
	clast I(11)";
			
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
	idepreuve C(11),
	calendrier I(1) DEFAULT '0'";

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
  $sqlarray = $dict->CreateIndexSQL('unicite', cms_db_prefix().'module_ping_equipes', 'saison, libequipe, liendivision');//, array('UNIQUE'));
  $dict->ExecuteSQLArray($sqlarray);
//une nouvelle table pour les victoires brutes (pas de victoires détaillées pour l'instant)
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	statut L,
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
	spid_errors I(11),
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
	renc_id I(11),
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
	clglob I(4),
	aclglob I(4),
	points N(6.2),
	apoint N(6.2),
	clnat I(11),
	valcla I(4),
	valinit I(4),
	rangreg I(11),
	rangdep I(11),
	progmois N(6.2),
	progmoisplaces I(4) SIGNED,
	progann I(4) SIGNED";
			
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


# create table divisions
// table schema description
$flds = "
	id I(11) AUTO KEY,
	idorga I(11),
	idepreuve I(11),
	iddivision I(11),
	libelle C(255),
	saison C(10),
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
	saison C(10),
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
	    cms_db_prefix().'module_ping_div_tours', 'idepreuve, iddivision, tableau,saison',$idxoptarray);
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
	
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'sit_mens',
		    cms_db_prefix().'module_ping_sit_mens', 'mois, annee, licence',$idxoptarray);
		       $dict->ExecuteSQLArray($sqlarray);
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'divisions_ep',
				    cms_db_prefix().'module_ping_divisions', 'idepreuve, iddivision, saison',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);
#				
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'adversaires',
	    cms_db_prefix().'module_ping_adversaires', 'mois, annee, licence',$idxoptarray);
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

#
#    Pour les tâches CRON
#
//$this->SetPreference('LastRecupSpid', '');
//$this->SetPreference('LastRecupFftt', '');
//$this->SetPreference('LastRecupResults', '');
//$this->SetPreference('LastRecupRencontres', '');
#

// create a preference
//$this->SetPreference('defaultMonthSitMens', '5');
$this->SetPreference('phase', '1');
$this->SetPreference('populate_calendar', 'Oui');
$this->SetPreference('jour_sit_mens', '10');
$this->SetPreference('affiche_club_uniquement', 'Oui');
//$this->SetPreference('email_admin_ping','admin@localhost.com');
//$this->SetPreference('email_succes', 'Oui');
#
#Préférences de l'application
#
#
#Setup events
//$this->CreateEvent('OnUserAdded');
//$this->CreateEvent('OnUserDeleted');
#
//on insère les éléments par défaut
#indexes

$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
		    				cms_db_prefix().'module_ping_feuilles_rencontres', 'fk_id');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
	    cms_db_prefix().'module_ping_rencontres_parties', 'fk_id');
	       $dict->ExecuteSQLArray($sqlarray);
	
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL('renc_id',
			    cms_db_prefix().'module_ping_poules_rencontres', 'renc_id',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);
#
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>