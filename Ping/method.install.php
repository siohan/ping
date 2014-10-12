<?php
#-------------------------------------------------------------------------
# Module: Ping
# Version: 0.1beta, Claude SIOHAN Agi webconseil
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
	adresse C(255),
	ville C(255),
	codepostal C(5) ";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_joueurs",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

/*$sql = "INSERT INTO mairie_module_ping  (id_user, nom_complet, adresse, codepostal, commune, email, tranche, active)
						VALUES ('0', 'SIOHAN Claude', '30, rue Park thomas', '29950', 'Clohars-Fouesnant', 'claude.siohan@gmail.com', 'A', '1')";
$db->Execute($sql);
*/

$dict = NewDataDictionary( $db );
$flds= "id I(11) KEY AUTO,
        saison C(100),
	phase I(1),
	libequipe C(255),
	libdivision C(255),
	friendlyname C(255),
	liendivision C(255),
	idpoule I(11),
	iddiv I(11)";

$sqlarray= $dict->CreateTableSQL( cms_db_prefix()."module_ping_equipes",
				  $flds,
				  $taboptarray);
				
$dict->ExecuteSQLArray($sqlarray);

//une nouvelle table pour les victoires brutes (pas de victoires détaillées pour l'instant)
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
     id I(11) AUTO KEY,
     saison C(255),
     datemaj T,
     licence I(11),
	date_event D,
	epreuve C(255),
     nom C(255),
	numjourn I(11),
     classement I(4),
     victoire I(1),
	ecart N(6,3),
	coeff N(3,2),
	pointres N(4,2),
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
	datemaj D,
	licence I(11),
	sit_mens C(200),
	fftt I(11),
	spid I(11)";
			
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
	datecreated T,
	datemaj T,
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

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	type_compet C(3),
	date_compet D,
	iddiv I(11),
	idpoule I(11),
	numjourn I(11)";
			
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
	datecreated T,
	datemaj T,
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
	datecreated T,
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
	code_compet C(3),
	coefficient N(3.2)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_type_competitions",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//$db->CreateSequence(cms_db_prefix().'module_ping_type_competitions');

// create a sequence
$db->CreateSequence(cms_db_prefix()."module_ping_seq");

// create a permission
$this->CreatePermission('Ping Use', 'Ping Use');
$this->CreatePermission('Ping Set Prefs','Ping Set Prefs');
$this->CreatePermission('Ping Manage user', 'Ping Manage user');
//$this->CreatePermission('Ping Delete user', 'Delete user');
//$this->CreatePermission('Use Ping', 'Use Ping');

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


#Setup events
$this->CreateEvent('OnUserAdded');
//$this->CreateEvent('NewsArticleEdited');
$this->CreateEvent('OnUserDeleted');
//$this->CreateEvent('NewsCategoryAdded');
//$this->CreateEvent('NewsCategoryEdited');
//$this->CreateEvent('NewsCategoryDeleted');


//on insère les éléments par défaut
$insert_sql = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, code_compet, coefficient) VALUES ('', ?, ?, ?)";
$res = $db->Execute($insert_sql, array('Critérium fédéral Seniors', 'I', '1.25'));
$res = $db->Execute($insert_sql, array('Critérium fédéral Jeunes', 'J', '1.00'));
$res = $db->Execute($insert_sql, array('Chpt France par équipes masculin', '1', '1.00'));
$res = $db->Execute($insert_sql, array('Chpt France par équipes féminin', '1', '1.00'));
$res = $db->Execute($insert_sql, array('Coupe Nationale Vétérans', 'K', '0.75'));
$res = $db->Execute($insert_sql, array('Championnat de France Vétérans', 'V', '1.00'));
$res = $db->Execute($insert_sql, array('Critérium fédéral Seniors', 'I', '1.25'));
$res = $db->Execute($insert_sql, array('Championnat Jeunes', '+', '0.75'));
$res = $db->Execute($insert_sql, array('Championnat jenues poussins benjamins', 'ECP', '1.25'));
$res = $db->Execute($insert_sql, array('Interclubs jeunes', 'EIJ', '0.50'));
$res = $db->Execute($insert_sql, array('Tournoi Rég - Dep', 'Z', '0.50'));
$res = $db->Execute($insert_sql, array('Tournoi National et Internat.', 'T', '0.75'));

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>