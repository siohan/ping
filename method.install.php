<?php
#-------------------------------------------------------------------------
# Module: Ping
# Version: 1.2.3, Claude SIOHAN
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
$uid = null;
if( cmsms()->test_state(CmsApp::STATE_INSTALL) ) {
  $uid = 1; // hardcode to first user
} else {
  $uid = get_userid();
}

// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	actif I(1) DEFAULT '1',
	licence C(11),
	nom C(255),
	prenom C(255),
	club C(255),
	nclub C(8),
	sexe C(1),
	type C(1), 
	certif C(255),
	validation C(100),
	cat C(20),
	clast I(5),
	mutation D ,
	natio C(2)
	arb C(2),
	ja C(3),
	tech C(10)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_joueurs",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
$dict = NewDataDictionary( $db );
$flds= "id I(11) KEY AUTO,
		idequipe I(11),
        saison C(10),
		phase I(1),
		numero_equipe I(2),
		libequipe C(255),
		libdivision C(255),
		friendlyname C(255),
		liendivision C(255),
		idpoule I(11),
		iddiv I(11),
		type_compet C(3) DEFAULT 'U',
		tag C(255),
		idepreuve C(11),
		calendrier I(1) DEFAULT 0,
		horaire C(5) DEFAULT '14:00',
		maj_class I(11) DEFAULT 0,
		class_mini I(4) DEFAULT  0,
		page_contenu I(4),
		date_created I(11)";

$sqlarray= $dict->CreateTableSQL( cms_db_prefix()."module_ping_equipes",
				  $flds,
				  $taboptarray);
				
$dict->ExecuteSQLArray($sqlarray);

//une nouvelle table pour les victoires brutes (pas de victoires détaillées pour l'instant)
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	statut L,
	saison C(10),
	datemaj ". CMS_ADODB_DT .",
	licence C(11),
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
	forfait I(1),
	idpartie I(11) ";
			
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
	saison C(10),
	licence C(11),
	advlic C(11),
	vd I,
	numjourn I(2),
	codechamp C(3),
	date_event D,
	advsexe C(3),
	advnompre C(255),
	pointres N(6.3),
	coefchamp N(3.2),
	advclaof C(4),
	idpartie I(11)";
			
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
	scope C(1),
	idPere I(11)";

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
	saison C(10),
	datemaj ". CMS_ADODB_DT .",
	licence C(11),
	sit_mens C(200),
	fftt I(11),
	maj_fftt I(11),
	spid I(11),
	spid_total I(11),
	spid_errors I(11),
	maj_spid I(11),
	maj_total I(11),
	pts_spid N(6.3),
	pts_fftt N(6.3)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_recup_parties",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


$dict = NewDataDictionary( $db );

// table schema description
$flds = "
     id I(11) AUTO KEY,
     eq_id I(11),
	renc_id I(11),
	saison C(10),
	idpoule I(11),
	iddiv I(11),
	club I(1),
	tour I(2),
	date_event D,
	affiche I(1) DEFAULT 0, 
	uploaded I(1) DEFAULT 0,
	libelle C(255),
	equa C(255),
	equb C(255),
	scorea I(2) DEFAULT 0,
	scoreb I(2) DEFAULT 0,
	lien C(255),
	idepreuve I(4),
	countdown I(1) DEFAULT 0,
	horaire C(5),
	equip_id1 I(11),
	equip_id2 I(11)";
			
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
	saison C(10),
	mois I(2),
	annee I(4),
	phase I(1),
	licence C(11),
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



$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	datecreated I(11), 
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
	friendlyname C(255),
	code_compet C(3) UNIQUE,
	coefficient N(3.2),
	indivs L,
	tag C(255),
	idepreuve I(11),
	idorga I(11),
	typepreuve C(1),
	actif I(1) DEFAULT(1),
	saison C(11),
	suivi I(1) DEFAULT (0),
	date_created I(11),
	date_maj I(11)";
			
// create it. 
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_type_competitions",
				   $flds, 
				   $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
$dict = NewDataDictionary( $db );

#
//une table pour les classements des poules
$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	idequipe I(11),
	saison C(10),
	code_compet C(3),
	iddiv I(11),
	idpoule I(11),
	poule C(255),
	clt C(2),
	equipe C(255),
	joue I(4),
	pts I(3),
	totvic I(3), 
	totdef I(3), 
	numero C(10), 
	idclub I(10), 
	vic I(3), 
	def I(3), 
	nul I(3), 
	pf I(3), 
	pg I(3), 
	pp I(3), 
	num_equipe I(11) DEFAULT 0";//nouveauté 0.8 numéro officiel d'une équipe (FFTT)
			
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
	scoreB I(1),
	detail C(255)";
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_rencontres_parties", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
#
//on créé une nouvelle table pour les coordonnées du correspondant et de la salle
$flds = "idclub I(11) KEY,
		numero C(10),
		nom C(255),
		nomsalle C(255),
		adressesalle1 C(255),
		adressesalle2 C(255),
		codepsalle C(6),
		villesalle C(255),
		web C(255),
		nomcor C(255),
		prenomcor C(255),
		mailcor C(255),
		telcor C(10),
		lat N(10.8),
		lng N(11.8)";
		
$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_coordonnees",$flds);
$dict->ExecuteSQLArray( $sqlarray );

//Pour le brulage
$dict = NewDataDictionary( $db );
			$flds = "id I(11) AUTO PRIMARY,
				licence C(10),
				J1 I(2) DEFAULT 0,
				J2 I(2) DEFAULT 0,
				J3 I(2) DEFAULT 0,
				J4 I(2) DEFAULT 0,
				J5 I(2) DEFAULT 0,
				J6 I(2) DEFAULT 0,
				J7 I(2) DEFAULT 0,
				J8 I(2) DEFAULT 0,
				J9 I(2) DEFAULT 0,
				J10 I(2) DEFAULT 0,
				J11 I(2) DEFAULT 0,
				J12 I(2) DEFAULT 0,
				J13 I(2) DEFAULT 0,
				J14 I(2) DEFAULT 0";

			$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_brulage",$flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		
		//on recréé les tables pour récupérer les résultats des épreuves individuelles
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
						   $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
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
			uploaded I(1),
			date_created ". CMS_ADODB_DT ."";

		// create it. 
		$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_div_classement",
						 $flds, $taboptarray);
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

#On créé une nouvelle table pour le tableau de bord
#
		try {
		    $ping_par_equipes_type = new CmsLayoutTemplateType();
		    $ping_par_equipes_type->set_originator($this->GetName());
		    $ping_par_equipes_type->set_name('Résultats Par Equipes');
		    $ping_par_equipes_type->set_dflt_flag(TRUE);
		    $ping_par_equipes_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_par_equipes_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_par_equipes_type->reset_content_to_factory();
		    $ping_par_equipes_type->save();
		}
		   
		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}
		
		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_par_equipes.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Par Equipes'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_par_equipes_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//design pour les résultats d'une équipe
		try {
		    $ping_equipe_type = new CmsLayoutTemplateType();
		    $ping_equipe_type->set_originator($this->GetName());
		    $ping_equipe_type->set_name('Résultats pour une équipe');
		    $ping_equipe_type->set_dflt_flag(TRUE);
		    $ping_equipe_type->set_description('Tableau de classement et résultats de la poule');
		    $ping_equipe_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_equipe_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_equipe_type->reset_content_to_factory();
		    $ping_equipe_type->save();
		}
		   
		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}
		
		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_equipe.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping clt et rslts pour une équipe'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_equipe_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		
		//design pour tous les classements des équipes
		try {
		    $ping_clts_type = new CmsLayoutTemplateType();
		    $ping_clts_type->set_originator($this->GetName());
		    $ping_clts_type->set_name('Classements Club');
		    $ping_clts_type->set_dflt_flag(TRUE);
		    $ping_clts_type->set_description('Ping Classements des équipes du club');
		    $ping_clts_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_clts_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_clts_type->reset_content_to_factory();
		    $ping_clts_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_classements.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Classements des équipes du club'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_clts_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		
		//design pour tous les classements des équipes
		try {
		    $ping_sitmens_type = new CmsLayoutTemplateType();
		    $ping_sitmens_type->set_originator($this->GetName());
		    $ping_sitmens_type->set_name('Situation Mensuelle');
		    $ping_sitmens_type->set_dflt_flag(TRUE);
		    $ping_sitmens_type->set_description('La situation mensuelle');
		    $ping_sitmens_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_sitmens_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_sitmens_type->reset_content_to_factory();
		    $ping_sitmens_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_sitmens.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Situation Mensuelle'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_sitmens_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
			
		//Design pour la liste des joueurs
		try {
		    $ping_liste_type = new CmsLayoutTemplateType();
		    $ping_liste_type->set_originator($this->GetName());
		    $ping_liste_type->set_name('Liste Joueurs');
		    $ping_liste_type->set_dflt_flag(TRUE);
		    $ping_liste_type->set_description('Ping la liste des joueurs');
		    $ping_liste_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_liste_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_liste_type->reset_content_to_factory();
		    $ping_liste_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_liste_joueurs.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Liste Joueurs'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_liste_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin de la liste des joueurs
				
		//Design pour les résultats de chaque joueur
		try {
		    $ping_playerresults_type = new CmsLayoutTemplateType();
		    $ping_playerresults_type->set_originator($this->GetName());
		    $ping_playerresults_type->set_name('Résultats par joueur');
		    $ping_playerresults_type->set_dflt_flag(TRUE);
		    $ping_playerresults_type->set_description('Ping Résultats Par Joueur');
		    $ping_playerresults_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_playerresults_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_playerresults_type->reset_content_to_factory();
		    $ping_playerresults_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_resultats_joueur.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Résultats Joueur'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_playerresults_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin de la liste des joueurs
					
		//Design pour la situation mensuelle provisoire
		try {
		    $ping_sitprov_type = new CmsLayoutTemplateType();
		    $ping_sitprov_type->set_originator($this->GetName());
		    $ping_sitprov_type->set_name('Situation En Live');
		    $ping_sitprov_type->set_dflt_flag(TRUE);
		    $ping_sitprov_type->set_description('Ping Situation En Live');
		    $ping_sitprov_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_sitprov_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_sitprov_type->reset_content_to_factory();
		    $ping_sitprov_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_sit_prov.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Situation En Live'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_sitprov_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin de la situation mensuelle live
						
	//design pour les feuilles de rencontres

	try {
	    $ping_feuille_type = new CmsLayoutTemplateType();
	    $ping_feuille_type->set_originator($this->GetName());
	    $ping_feuille_type->set_name('feuille_rencontre');
	    $ping_feuille_type->set_dflt_flag(TRUE);
	    $ping_feuille_type->set_description('Ping Feuille Rencontre');
	    $ping_feuille_type->set_lang_callback('Ping::page_type_lang_callback');
	    $ping_feuille_type->set_content_callback('Ping::reset_page_type_defaults');
	    $ping_feuille_type->reset_content_to_factory();
	    $ping_feuille_type->save();
	}

	catch( CmsException $e ) {
	    // log it
	    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
	    return $e->GetMessage();
	}

	try {
	    $fn = cms_join_path(dirname(__FILE__),'templates','orig_feuille_match.tpl');
	    if( file_exists( $fn ) ) {
	        $template = @file_get_contents($fn);
	        $tpl = new CmsLayoutTemplate();
	        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Feuille Rencontre'));
	        $tpl->set_owner($uid);
	        $tpl->set_content($template);
	        $tpl->set_type($ping_feuille_type);
	        $tpl->set_type_dflt(TRUE);
	        $tpl->save();
	    }
	}
	catch( \Exception $e ) {
	  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
	  return $e->GetMessage();
	}
	//fin de la feuille de rencontre
			
		//design pour les tops flops	
		try {
		    $ping_topflop_type = new CmsLayoutTemplateType();
		    $ping_topflop_type->set_originator($this->GetName());
		    $ping_topflop_type->set_name('Top Flop');
		    $ping_topflop_type->set_dflt_flag(TRUE);
		    $ping_topflop_type->set_description('Ping Top Flop');
		    $ping_topflop_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_topflop_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_topflop_type->reset_content_to_factory();
		    $ping_topflop_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_topflop.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Top Flop'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_topflop_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin des tops flops
					
		//design pour le SPID			
		try {
		    $ping_spid_type = new CmsLayoutTemplateType();
		    $ping_spid_type->set_originator($this->GetName());
		    $ping_spid_type->set_name('Spid');
		    $ping_spid_type->set_dflt_flag(TRUE);
		    $ping_spid_type->set_description('Ping Résultats Spid');
		    $ping_spid_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_spid_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_spid_type->reset_content_to_factory();
		    $ping_spid_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','orig_spid.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Résultats Spid'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_spid_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin des résultats SPID
		
		//DESIGN POUR LE COMPTE A REBOURS			
		try {
		    $ping_countdown_type = new CmsLayoutTemplateType();
		    $ping_countdown_type->set_originator($this->GetName());
		    $ping_countdown_type->set_name('Countdown');
		    $ping_countdown_type->set_dflt_flag(TRUE);
		    $ping_countdown_type->set_description('Ping Countdown');
		    $ping_countdown_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_countdown_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_countdown_type->reset_content_to_factory();
		    $ping_countdown_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','displaycountdown.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Countdown'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_countdown_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		//fin des résultats SPID
		
		//DESIGN POUR LES COORDONNEES			
		try {
		    $ping_coordonnees_type = new CmsLayoutTemplateType();
		    $ping_coordonnees_type->set_originator($this->GetName());
		    $ping_coordonnees_type->set_name('Coordonnees');
		    $ping_coordonnees_type->set_dflt_flag(TRUE);
		    $ping_coordonnees_type->set_description('Coordonnées salle et correspondant');
		    $ping_coordonnees_type->set_lang_callback('Ping::page_type_lang_callback');
		    $ping_coordonnees_type->set_content_callback('Ping::reset_page_type_defaults');
		    $ping_coordonnees_type->reset_content_to_factory();
		    $ping_coordonnees_type->save();
		}

		catch( CmsException $e ) {
		    // log it
		    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		    return $e->GetMessage();
		}

		try {
		    $fn = cms_join_path(dirname(__FILE__),'templates','coordonnees.tpl');
		    if( file_exists( $fn ) ) {
		        $template = @file_get_contents($fn);
		        $tpl = new CmsLayoutTemplate();
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Coordonnees'));
		        $tpl->set_owner($uid);
		        $tpl->set_content($template);
		        $tpl->set_type($ping_coordonnees_type);
		        $tpl->set_type_dflt(TRUE);
		        $tpl->save();
		    }
		}
		catch( \Exception $e ) {
		  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
		  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
		  return $e->GetMessage();
		}
		
				$dict = NewDataDictionary( $db );
		try {
			    $ping_indivs_type = new CmsLayoutTemplateType();
			    $ping_indivs_type->set_originator($this->GetName());
			    $ping_indivs_type->set_name('Resultats Indivs');
			    $ping_indivs_type->set_dflt_flag(TRUE);
			    $ping_indivs_type->set_lang_callback('Ping::page_type_lang_callback');
			    $ping_indivs_type->set_content_callback('Ping::reset_page_type_defaults');
			    $ping_indivs_type->reset_content_to_factory();
			    $ping_indivs_type->save();
			}

			catch( CmsException $e ) {
			    // log it
			    debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
			    audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
			    return $e->GetMessage();
			}

			try {
			    $fn = cms_join_path(dirname(__FILE__),'templates','orig_indivs.tpl');
			    if( file_exists( $fn ) ) {
			        $template = @file_get_contents($fn);
			        $tpl = new CmsLayoutTemplate();
			        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Ping Indivs'));
			        $tpl->set_owner($uid);
			        $tpl->set_content($template);
			        $tpl->set_type($ping_indivs_type);
			        $tpl->set_type_dflt(TRUE);
			        $tpl->save();
			    }
			}
			catch( \Exception $e ) {
			  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
			  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
			  return $e->GetMessage();
			}	

# Les indexs
//on créé un index 
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fftt_idpartie',
	    cms_db_prefix().'module_ping_parties', 'idpartie',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
#
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'spid_idpartie',
		    cms_db_prefix().'module_ping_parties_spid', 'idpartie',$idxoptarray);
		       $dict->ExecuteSQLArray($sqlarray);

	
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'sit_mens',
		    cms_db_prefix().'module_ping_sit_mens', 'mois, annee, licence',$idxoptarray);
		       $dict->ExecuteSQLArray($sqlarray);

$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'recup_renc',
	    cms_db_prefix().'module_ping_poules_rencontres', 'renc_id, eq_id',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);

#
#
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL('unicite',
				cms_db_prefix().'module_ping_recup_parties', 'licence',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);
#
#
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL('id_compet',
					    cms_db_prefix().'module_ping_type_competitions', 'idepreuve, idorga',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);
#
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL('unicite',
				cms_db_prefix().'module_ping_equipes', 'saison, phase, idepreuve,numero_equipe',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);

$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL('licence_unicite',
				cms_db_prefix().'module_ping_joueurs', 'licence',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);

$dict = NewDataDictionary( $db );
			
//on créé un index pour cette table
$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_tours',
		cms_db_prefix().'module_ping_div_tours', 'idepreuve, iddivision, tableau',$idxoptarray);
$dict->ExecuteSQLArray($sqlarray);

//on créé un index pour cette table
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_divisions',
				   cms_db_prefix().'module_ping_divisions', 'idepreuve, iddivision',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on créé un index pour cette table
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_cla',
				   cms_db_prefix().'module_ping_div_classement', 'tableau, rang, nom',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
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
#
// create a permission
$this->CreatePermission('Ping Use', 'Ping Use');
$this->CreatePermission('Ping Set Prefs','Ping Set Prefs');
$this->CreatePermission('Ping Manage user', 'Ping Manage user');
$this->CreatePermission('Ping Delete', 'Ping Delete');
#
#    LES PREFERENCES
#
$this->SetPreference('LastRecupSpid', time());
$this->SetPreference('LastRecupFftt', time());
$this->SetPreference('LastRecupUsers', time());
$this->SetPreference('LastRecupRencontres', time());
$this->SetPreference('LastRecupClassements', time());
$this->SetPreference('LastResetSpid', time());
$this->SetPreference('LastResetSitMens', time());
$this->SetPreference('LastRecupDivisions', time());
$this->SetPreference('LastRecupTours', time());
$this->SetPreference('LastRecupDivCla', time());
$this->SetPreference('LastVerifAdherents', time());

$this->SetPreference('max_size', '500000');
$this->SetPreference('max_width', '800');
$this->SetPreference('max_height', '800');
$this->SetPreference('allowed_extensions', 'jpg,gif,jpeg,png');

//Les intervalles de récupération
$this->SetPreference('interval_classement', 259200);
$this->SetPreference('interval_joueurs', 2592000);
$this->SetPreference('interval_equipes', 1296000);
$this->SetPreference('interval_feuilles_parties', 172800);
$this->SetPreference('interval_compets', 2592000);
$this->SetPreference('interval_spid', 172800);	
$this->SetPreference('epreuv_tab', '0' );
$this->SetPreference('compte_tab', '0');
$this->SetPreference('contacts_tab', '0');
$this->SetPreference('nettoyage_journal', 3);

$this->SetPreference('last_indivs_cla', time());
$this->SetPreference('details_indivs', 'details_indivs');
$this->SetPreference('jour_sit_mens', '10');
$this->SetPreference('affiche_club_uniquement', 'Oui');


//on insère les éléments par défaut
#indexes


#
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>
