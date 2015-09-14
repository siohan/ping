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
	tag C(255)";
			
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
//créé un index sur la table
$dict->ExecuteSQLArray($sqlarray);
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
	uploaded I(1)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_tours",
				$flds, 
				$taboptarray);
$dict->ExecuteSQLArray($sqlarray);
//on créé un index sur la table div_poules
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_tours',
	    cms_db_prefix().'module_ping_div_poules', 'idepreuve, iddivision, tableau',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
#
# create table div_classement//debut de la création
// table schema description
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
	saison C(255)";

// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_classement",
				 $flds, 
				$taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
#
$dict = NewDataDictionary( $db );
$flds = "
	licence I(11),
	type_compet C(3),
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
$qslarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_feuilles_rencontres", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//Création de la table parties des rencontres par équipes
$flds = "
	id I(11) AUTO KEY,
	fk_id I(11),
	joueurA C(255),
	cltA C(255),
	joueurB C(255),
	cltB C(255)";
$qslarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_rencontres_parties", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

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
/**
* Css
*/

$css_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css'. DIRECTORY_SEPARATOR .'bootstrap-table.css';
if (file_exists($css_file))
{
 $css = @file_get_contents($css_file);
 $css_id = $db->GenID(cms_db_prefix().'css_seq');
 $db->Execute('insert into '.cms_db_prefix().'css (css_id, css_name, css_text, media_type, create_date) values (?,?,?,?,?)',
   array($css_id, 'Ping table', $css, 'screen', date('Y-m-d')));
}


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