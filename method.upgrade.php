<?php
#-------------------------------------------------------------------------
# Module: Ping
# Author: Claude SIOHAN
# Version: 1.2.3
# Method: Upgrade
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

$db = $this->GetDb();			/* @var $db ADOConnection */
$dict = NewDataDictionary($db); 	/* @var $dict ADODB_DataDict */
$uid = null;
if( cmsms()->test_state(CmsApp::STATE_INSTALL) ) {
  $uid = 1; // hardcode to first user
} else {
  $uid = get_userid();
}/**
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Upgrade() method in the module body.
 */
$now = trim($db->DBTimeStamp(time()), "'");
$current_version = $oldversion;
switch($current_version)
{
  // we are now 1.0 and want to upgrade to latest
 case "0.1beta1":
	{
		//do magic
	}
   
 case "0.1beta2":
	{
   		//and this is here for the next version
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_equipes",
						      "type_compet C(3) DEFAULT 'U'");
		$dict->ExecuteSQLArray( $sqlarray );
		$sql = "UPDATE ".cms_db_prefix()."module_ping_equipes SET type_compet = 'U'";
		$db->Execute($sql);
	
	
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_poules_rencontres",
						      "affiche L");
		$dict->ExecuteSQLArray( $sqlarray );
	
	
		$sqlarray = $dict->DropColumnSQL(cms_db_prefix()."module_ping_competitions",
						      "indivs");
		$dict->ExecuteSQLArray( $sqlarray );
	
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_parties_spid",
						      "type_ecart I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_parties_spid",
						      "datemaj ". CMS_ADODB_DT. "");
		$dict->ExecuteSQLArray( $sqlarray );
		//qqs changements dans la table calendrier
		$sqlarray = $dict->RenameColumnSQL(cms_db_prefix()."module_ping_calendrier",
						      "date_compet", "date_debut", "date_debut ". CMS_ADODB_DT ."");
	 	$dict->ExecuteSQLArray( $sqlarray );

		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_calendrier",
						     "date_debut D");
	 	$dict->ExecuteSQLArray( $sqlarray );
		$sqlarray = $dict->AddcolumnSQL(cms_db_prefix()."module_ping_calendrier",
						      "date_fin D");
		$dict->ExecuteSQLArray( $sqlarray );
	
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup_parties",
						     "datemaj ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );

		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_sit_mens",
						     "datecreated ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );

		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_sit_mens",
						     "datemaj ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );


		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_comm",
						     "datecreated ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );

		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_comm",
						     "datemaj ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );

		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup",
						     "datecreated ". CMS_ADODB_DT. "");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		$sql = "ALTER TABLE ".cms_db_prefix()."module_ping_type_competitions ADD UNIQUE `ind_code_compet` (`code_compet`)";
		$db->Execute($sql);

		$sql = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, code_compet, coefficient) VALUES ('', ?, ?, ?)";
		$db->Execute($sql, array('Indéterminé', 'U', '0.00'));

		
	}



 case "0.1beta3" : 
 case "0.1beta3.1" :
 case "0.1beta3.2" : 
 case "0.1rc1" :
 case "0.1" :

	{
		$dict = NewDataDictionary( $db );
		$flds = "
			licence I(11),
			type_compet C(3)";

		// create it. 
		$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_participe",
						   $flds, 
						   $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
	
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
	
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_parties_spid",
						     "pointres N(6.3) ");
	 	$dict->ExecuteSQLArray( $sqlarray );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_type_competitions",
						"indivs L");
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 1";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 2";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 6";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 7";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 8";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 10";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions` SET `indivs` = '1' WHERE `id` = 11";
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = "ALTER TABLE ".cms_db_prefix()."module_ping_type_competitions ADD UNIQUE `ind_code_compet` (`code_compet`)";
		$dict->ExecuteSQLArray($sqlarray);
		
	}
	
case "0.1.1" : 	
	
	{
		
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
		
	}
	
case "0.2" :
case "0.2.1" :
case "0.2.2" :
	{
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_recup_parties", "maj_fftt D");
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_recup_parties", "maj_spid D");
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_recup_parties", "spid_total I(11)");
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'ind_code_compet',
		         cms_db_prefix().'module_ping_type_competitions', 'code_compet', 'UNIQUE');
		       $dict->ExecuteSQLArray($sqlarray);
	}
case "0.2.3" : 
case "0.2.3.1" :
	{
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_type_competitions", "tag C(255)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$db_prefix = cms_db_prefix();
		//on fait un update sur la table existante pour mettre le tag à jour
		$query = "SELECT id, code_compet, indivs FROM ".cms_db_prefix()."module_ping_type_competitions";
		$dbresult = $db->Execute($query);
		
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$tag = "{Ping action='";
				$id = $row['id'];
				$code = $row['code_compet'];
				$indivs = $row['indivs'];
				
				if($indivs =='1')
				{
					$tag.="individuelles'";
				}
				else
				{
					$tag.="par-equipes'";
				}
				$tag.=" type_compet='$code'";
				$tag.="}";
				
				$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET tag = ? WHERE id = ?";
				$db->Execute($sqlarray, array($tag,$id));
				//unset($tag);
			}
		
		
		}
		
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_calendrier", "tag C(255)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on fait un update sur la table existante pour mettre le tag à jour
		$query = "SELECT cal.id,cal.date_debut,cal.date_fin,cal.numjourn, tc.code_compet, tc.indivs FROM ".cms_db_prefix()."module_ping_type_competitions AS tc, ".cms_db_prefix()."module_ping_calendrier AS cal WHERE cal.type_compet = tc.code_compet";
		$dbresult = $db->Execute($query);
		
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$tag = "{Ping action='";
				$id = $row['id'];
				$code = $row['code_compet'];
				$indivs = $row['indivs'];
				$date_debut = $row['date_debut'];
				$date_fin = $row['date_fin'];
				
				if($indivs =='1')
				{
					$tag.="individuelles'";
				}
				else
				{
					$tag.="par-equipes'";
				}
				$tag.=" type_compet='$code' ";
				$tag.=" date_debut='$date_debut' date_fin='$date_fin'";
				$tag.="}";
				
				$sqlarray = "UPDATE ".cms_db_prefix()."module_ping_calendrier SET tag = ? WHERE id = ?";
				$db->Execute($sqlarray, array($tag,$id));
				//unset($tag);
			}
		
		
		}
		
		//$insert_sql = "UPDATE INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, code_compet, coefficient,indivs) VALUES ('', ?, ?, ?, ?)";
		
		$css_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css'. DIRECTORY_SEPARATOR .'bootstrap-table.css';
		if (file_exists($css_file))
		{
		 $css = @file_get_contents($css_file);
		 //$css_id = $db->GenID(cms_db_prefix().'css_seq');
		//pour la version 2.0 de cmsms
		//$db->Execute('insert into '.cms_db_prefix().'layout_stylesheets (id, name, content, description,media_type, media_query) values ("",?,?,?,?,?)',
		//   array('Ping table', $css, 'Css pour les tableaux du module Ping','screen',''));
		$db->Execute('insert into '.cms_db_prefix().'css (css_id, css_name, css_text, media_type, media_query) values ("",?,?,?,?)',
		   array('Ping table', $css, 'screen',''));
		}
		$db_prefix = cms_db_prefix();
		$sqlarray = $dict->CreateIndexSQL('code_compet',$db_prefix."module_ping_type_competitions",'code_compet',array('UNIQUE'=>1));
		
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_sit_mens", "saison C(255)");
		$dict->ExecuteSQLArray( $sqlarray );
		$query = "UPDATE ".cms_db_prefix()."module_ping_sit_mens SET saison= '2014-2015' WHERE mois>=9 AND annee = '2014' OR annee = '2015'";
		$db->Execute($query);
		
		
	}
case "0.2.4" : 
	{
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_calendrier", "saison C(255)");
		$dict->ExecuteSQLArray( $sqlarray );
		$query = "UPDATE ".cms_db_prefix()."module_ping_calendrier SET saison= '2014-2015' WHERE MONTH(date_debut)>=9 AND YEAR(date_debut) = '2014' OR (MONTH(date_debut)<=7 AND YEAR(date_debut) = '2015')";
		$db->Execute($query);
		
		//modification de la table participe
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_participe", "date_debut D, date_fin D");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on supprime tous les enregistrements de la table participe !!
		//du coup , on fait uniquement des insert !
		
		$query = "TRUNCATE TABLE ".cms_db_prefix()."module_ping_participe";
		$db->Execute($query);
		
		//on met à jour la table avec les éléments existants depuis la table spid
		
		$query = "SELECT DISTINCT sp.licence,sp.date_event,sp.epreuve, tc.indivs,tc.code_compet FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE sp.epreuve = tc.name AND saison = '2014-2015' AND tc.indivs = 1 ORDER BY sp.licence ASC";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$query1 = "INSERT INTO ".cms_db_prefix()."module_ping_participe (licence, type_compet, date_debut) VALUES (?, ?, ?)";
				$dbresultat = $db->Execute($query1, array($row['licence'],$row['code_compet'], $row['date_event']));

			}
		}
		
		
	}
	
case "0.2.5" :
case "0.3" : 
	{
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_equipes", "tag C(255)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_type_competitions", "idepreuve I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_type_competitions", "idorga I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
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
						   $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
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
						   $flds, $taboptarray);
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
			saison C(255),
			uploaded I(1)";

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
			//on créé un index pour cette table
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_tours',
				    cms_db_prefix().'module_ping_div_tours', 'idepreuve, iddivision, tableau',$idxoptarray);
			$dict->ExecuteSQLArray($sqlarray);
			//
			//un nouvel index
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'sit_mens',
				    cms_db_prefix().'module_ping_sit_mens', 'licence, mois, annee',$idxoptarray);
			$dict->ExecuteSQLArray($sqlarray);
			//
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL('unicite',
				         cms_db_prefix().'module_ping_equipes', 'saison, libequipe, liendivision',$idxoptarray);
				       $dict->ExecuteSQLArray($sqlarray);
		
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_joueurs", "type C(1), certif C(255), validation D, echelon C(1), place I(4), point I(4), cat C(5)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		
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
		
		#indexes

		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
				    				cms_db_prefix().'module_ping_feuilles_rencontres', 'fk_id');
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
			    cms_db_prefix().'module_ping_rencontres_parties', 'fk_id');
			       $dict->ExecuteSQLArray($sqlarray);
			
			
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_equipes", "idepreuve C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//add a new column to calendar
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_calendrier", "idepreuve C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
	}
	
	
case  "0.3.0.1" :
	{
		$dict = NewDataDictionary($db);
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
		
		#indexes

		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
				    				cms_db_prefix().'module_ping_feuilles_rencontres', 'fk_id');
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'fk_id',
			    cms_db_prefix().'module_ping_rencontres_parties', 'fk_id');
			       $dict->ExecuteSQLArray($sqlarray);
	}
	case "0.3.0.2" :
	case "0.3.0.3" :
	{
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
		
		$dict = NewDataDictionary( $db );
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'calendrier',
	    cms_db_prefix().'module_ping_calendrier', 'idepreuve, date_debut',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);
		//On crée un nouveau champ dans la table participe
		//$dict->NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_participe", "idepreuve C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		//on créé aussi des dates pour les tours
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_div_tours", "date_debut D,date_fin D");
		$dict->ExecuteSQLArray( $sqlarray );
		
	}
	
	
	case "0.3.1" : 
	case "0.4" :
	case "0.4.1" :
	case "0.4.2" :
	{
		$db = $this->GetDb();
		//$dict->ExecuteSQLArray($sqlarray);
		//On crée un nouveau champ dans la table participe
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_div_tours", "uploaded_parties I(1), uploaded_classement I(1)");
		$dict->ExecuteSQLArray( $sqlarray );
		//un nouvel index
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_class',
			    cms_db_prefix().'module_ping_div_classement', 'tableau, nom, saison',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//Créa table control_panel
		$dict = NewDataDictionary( $db );
		$flds = "
			id I(11) AUTO KEY,
			rank I(11),
			name C(255),
			status I(1),
			hidden I(1)";
		$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_control_panel", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		#On insère les valeurs dans la table
		$insert_sql = "INSERT INTO `demo_module_ping_control_panel` (`id`, `rank`, `name`, `status`, `hidden`) VALUES ('', ?, ?, ?, ?)";
		$db->execute($insert_sql, array( 1, 'Compte et test connexion', 0, 0));
		
	}
	
	
	case "0.4.3" : 
	case "0.4.4" :
	{
		$db = $this->GetDb();
		//$dict->ExecuteSQLArray($sqlarray);
		//On crée un nouveau champ dans la table participe
		$dict = NewDataDictionary( $db );
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'sit_mens',
			    cms_db_prefix().'module_ping_sit_mens', 'mois, annee, licence',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
	}
	
	
	case "0.4.5":
	case "0.4.6":
	case "0.5":
	{
		$db = $this->GetDb();
		$query = "SELECT tag,idepreuve,date_debut,date_fin FROM ".cms_db_prefix()."module_ping_calendrier";
		$result = $db->Execute($query);
		if($result && $result->RecordCount()>0)
		{
			while($row = $result->FetchRow())
			{
				
				$tag = $row['tag'];
				$idepreuve = $row['idepreuve'];
				$date_debut = $row['date_debut'];
				$date_fin = $row['date_fin'];
				$query2 = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
				$dbresult2 = $db->Execute($query2, array($idepreuve));
				
				if($dbresult2 && $dbresult2->RecordCount()>0)
				{
					$row = $dbresult2->FetchRow();
					$name = $row['name'];
					$service = new retrieve_ops();
					$insert = $service->insert_cgcalendar($name,$tag,$date_debut,$date_fin);
				}

			}
		}
		$insert_sql = "INSERT INTO ".cms_db_prefix()."module_templates (module_name, template_name, content, create_date, modified_date) VALUES ( ?, ?, ?, ?, ?)";
		$result = $db->Execute($insert_sql, array('CGCalendar','calendar_Rookie','{if !isset($smarty.get.nojs)}
		<script type=\'text/javascript\'>{jsmin}
		// the jsmin plugin is included with CGExtensions.
		if( typeof jQuery != \'undefined\' ) {
			  $(document).ready(function(){
				    $(document).on(\'click\',\'a.calendar-nav\',function(ev){
					      // allow paginating through months via ajax.
					      ev.preventDefault();
					      var url = $(this).attr(\'href\')+\'&nojs=1&showtemplate=false\';
					      url = url.replace(/amp;/g,\'\');
					      $(\'#cal-calendar\').load(url);
					    });
					
					    if( jQuery().dialog ) {
						      $(document).on(\'click\',\'a.calendar-daylist\',function(ev){
							        // demonstrate viewing a day list in a popup dialog
							        // and mixing smarty and javascript code.
							        // uses jquery ui dialog... but could just as easily use fancybox etc.
							        // you could add parameters here for changing the template from the default, etc, or even filter by category.
							        ev.preventDefault();
							        var day = new Date( $(this).data(\'day\') * 1000 );
							        var m = day.getMonth()+1;
							        var d = day.getDate();
							        var y = day.getFullYear();
							        var url = \'{module_action_link module=CGCalendar display=list day=DDDD  month=MMMM year=YYYY jsfriendly=1}&showtemplate=false\';
							        url = url.replace(\'MMMM\',m).replace(\'DDDD\',d).replace(\'YYYY\',y);
							        $(\'#cal-dayview\').load(url,function(data){
								          $(\'#cal-dayview\').dialog({
									            title: \'{$mod->Lang(\'dayview\')}\'
									          })
									        });
									      });
									    }
									  })
									} 
									// jquery test
									{/jsmin}</script&gt;
									{/if}
									
									{strip}
									{if !isset($smarty.get.nojs)}
									<div style=\'display: none;\'>{* a simple wrapper *}
									  <div id=\'cal-dayview\'></div>
									</div>
									{/if}
									
									<table class=\'widget_calendar\' id=\'cal-calendar\'>
									<caption class=\'calendar-month\'>
									   <span class=\'calendar-prev\'><a class=\'calendar-nav\' href=\'{$navigation.prev}\'>&amp;laquo;</a></span>
									     <span class=\'calendar-lbl\'>{$date|cms_date_format:\'%b %Y\'}</span>
									   <span class=\'calendar-next\'><a class=\'calendar-nav\' href=\'{$navigation.next}\'>&amp;raquo;</a></span>
									</caption>
									<tbody><tr>
									{foreach from=$day_names item=day key=key}
									<th class=\'cal-dayhdr cal-{$day_short_names[$key]|strtolower}\' abbr=\'{$day}\'>{$day_short_names[$key]}</th>
									{/foreach}</tr>
								
									<tr>
									{* initial empty days *}
									{if $first_of_month_weekday_number > 0}
									<td colspan=\'{$first_of_month_weekday_number}\'>&amp;nbsp;</td>
									{/if}
									
									{* iterate over the days of this month *}
									{assign var=weekday value=$first_of_month_weekday_number}
									{foreach from=$days item=day key=key}
									{if $weekday == 7}
									  {assign var=weekday value=0}
									</tr>\r\n<tr>
									{/if}
									<td {if isset($day.class)}class=\'{$day.class} cal-day cal-{$day_short_names[$weekday]|strtolower}\'{/if}>\r\n
									{if isset($day.events.0)}<a class=\'calendar-daylist\' data-day=\'{$day.date}\' href=\'{$day.ni_url}\'>{$key}</a>{* by default use the non inline (replace content tag) version of the URL *}\r\n
									{*<ul>
										{foreach from=$day.events item=event}
										<li>
									   
									  {$style=\'\'}{if $event.bgcolor}{$style=\'style=\\\'color: {$event.fgcolor}; background-color: {$event.bgcolor}\\\'\'}{/if}
									  <a class=\'calendar-event\' href=\'{$event.url}\' {$style}>{$event.event_title|summarize:20}</a></li>
									{/foreach}
									</ul>*}
									{else}{$key}{/if}
									</td>
									{math assign=weekday equation=\'x + 1\' x=$weekday}
									{/foreach}
							
									{* remaining empty days *}
									{if $weekday != 7}
									<td colspan=\'{math equation=\'7-x\' x=$weekday}\'>&amp;nbsp;</td>
										{/if}
									</tr>
									</tbody></table>
									
									{/strip}',$now,$now));
						if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');
				
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_parties_spid", "statut L");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$query = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET statut = '1'";
		$db->Execute($query);
	}	
	
	case "0.5.1" :
	case "0.5.2" :
	case "0.5.3" :
	 
	{
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_sit_mens", "clglob I(4), aclglob I(4),apoint I(4),valcla I(4), valinit I(4),progmoisplaces I(4) SIGNED,progann I(4) SIGNED");
		$dict->ExecuteSQLArray( $sqlarray );
	}
	
	
//if(version_compare($oldversion,'0.5.3.2')<0)
	case "0.5.3.1" :
	case "0.5.3.2" :
	
	{
		$prefs = array('vicNorm0_24','vicNorm25_49','vicNom50_99', 'vicNorm100_149','vicNorm150_199',
				'vicNorm200_299','vicNorm300_399','vicNorm400_499','vicNormPlus500', 
				'vicAnorm0_24', 'vicAnorm25_49','vicAnom50_99','vicAnorm100_149','vicAnorm150_199',
				'vicAnorm200_299', 'vicAnorm300_399','vicAnorm400_499','vicAnormPlus500',
				'defNorm0_24','defNorm25_49','defNorm50_99','defNorm100_149','defNorm150_199',
				'defNorm200_299','defNorm300_399','defNorm400_499','defNormPlus500',
				'defAnorm0_24','defAnorm25_49','defAnorm50_99','defAnorm100_149','defAnorm150_199',
				'defAnorm200_299','defAnorm300_399','defAnorm400_499','defAnormPlus500');
		    foreach( $prefs as $pref_name ) {
		        $this->RemovePreference($pref_name);
		}
		$this->SetPreference('email_admin_ping', 'admin@localhost.com');
		$this->SetPreference('email_succes', 'Oui');
		
		
		//on va éliminer les doublons possibles de la table divisions
		$query = "SELECT count(*) AS nb_doublons, iddivision,id FROM ".cms_db_prefix()."module_ping_divisions GROUP BY iddivision HAVING count(*) >1";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$id = $row['id'];
				$iddivision = $row['iddivision'];
				$query1 = "DELETE FROM ".cms_db_prefix()."module_ping_divisions WHERE id = ?";
				$dbresultat = $db->Execute($query1, array($row['id']));

			}
		}
		//on ajoute des contraintes pour qqs tables afin d'éviter des doublons
			$db = $this->GetDb();
			$dict = NewDataDictionary( $db );
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL('divisions_ep',
				    cms_db_prefix().'module_ping_divisions', 'idepreuve,iddivision',$idxoptarray);
			$dict->ExecuteSQLArray($sqlarray);
		
		//on supprime une table inutile
			$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_control_panel");
			$dict->ExecuteSQLArray($sqlarray);
			
			
			$dict = NewDataDictionary( $db );
			$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_poules_rencontres", "renc_id I(11)");
			$dict->ExecuteSQLArray( $sqlarray );
			
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL('renc_id',
						    cms_db_prefix().'module_ping_poules_rencontres', 'renc_id',$idxoptarray);
			$dict->ExecuteSQLArray($sqlarray);
			
			//on fait la requete pour les autres résultats déjà en place
			
			$query = "SELECT lien FROM ".cms_db_prefix()."module_ping_poules_rencontres";
			$dbresult = $db->Execute($query);
			if($dbresult)
			{
				while($row = $dbresult->FetchRow())
				{
					$lien = $row['lien'];
					$renc_prep = explode('&',$lien);
					$renc_id_prep = explode('=',$renc_prep['4']);
					$renc_id = $renc_id_prep['1'];
					$query2 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET renc_id = ? WHERE lien = ?";
					$dbresult2 = $db->Execute($query2, array($renc_id,$lien));
					
				}
			}
			
			$dict = NewDataDictionary( $db );
			$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_equipes", "calendrier I(1) DEFAULT '0'");
			$dict->ExecuteSQLArray( $sqlarray );
			
			
			
		
	}
	case "0.5.4" : 
	{
		//
		//on va éliminer les doublons possibles de la table divisions
		$query = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_spid = '1970-01-01' WHERE maj_spid = '0000-00-00'";
		$dbresult = $db->Execute($query);
		$query1 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET maj_fftt = '1970-01-01' WHERE maj_fftt = '0000-00-00'";
		$dbresult1 = $db->Execute($query1);
	}
	case "0.5.5" :
	case "0.5.6" : 
	case "0.5.7" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "
			pts,
			birthday,
			sexe,
			type,
			certif,
			validation,
			echelon,
			place,
			point,
			cat,
			adresse,
			ville,
			codepostal";

		// create it. 
		$sqlarray = $dict->DropColumnSQL( cms_db_prefix()."module_ping_joueurs",
						   $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		//on ajoute les nouvelles colonnes
		$dict = NewDataDictionary( $db );
		$flds = "
			clast I(5),
			club C(255),
			nclub C(8)";

		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_joueurs",
						   $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		
		
		//on ajoute un champ à la table spid
		//on ajoute les nouvelles colonnes
		$dict = NewDataDictionary( $db );
		$flds = "statut I(1)";

		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_parties_spid",
						   $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on ajoute les nouvelles colonnes
		$dict = NewDataDictionary( $db );
		$flds = "spid_errors I(1)";

		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_recup_parties",
							   $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		
		//On supprime tous les organismes à cause de la réforme territoriale
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_organismes";
		$dbresult = $db->Execute($query);
		
		//on supprime la table ping_comm devenue obsolete
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_comm",
						   $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//On supprime tous les organismes à cause de la réforme territoriale
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_adversaires";
		$dbresult = $db->Execute($query);
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'adversaires',
			    cms_db_prefix().'module_ping_adversaires', 'mois, annee, licence',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		//
		$query = "ALTER TABLE ".cms_db_prefix()."module_ping_div_tours CHANGE `saison` `saison` varchar(10)";
		$dbresult = $db->Execute($query);
		//On supprime des préférences devenues inutiles
		$this->RemovePreference('LastRecupSpid');
		$this->RemovePreference('LastRecupFftt');
		$this->RemovePreference('LastRecupResults');
		$this->RemovePreference('LastRecupRencontres');
		$this->RemovePreference('defaultMonthSitMens');
		$this->RemovePreference('email_admin_ping');
		$this->RemovePreference('email_succes');
		
	}
	case "0.6" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "
			id I(11) AUTO KEY,
			licence I(11),
			idepreuve I(11),
			iddivision I(11),
			idorga I(11),
			tour I(2),
			tableau I(11),
			saison C(10)";

		// create it. 
		$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_participe_tours",
						   $flds);
		$dict->ExecuteSQLArray($sqlarray);
		
		$dict = NewDataDictionary( $db );
		$flds = "saison C(10)";
		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_participe", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$query = "UPDATE ".cms_db_prefix()."module_ping_participe SET saison = '2017-2018'";
		$dbresult = $db->Execute($query);
		
		//on créé un index sur la table de dessus
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL('affectation',
					    cms_db_prefix().'module_ping_participe_tours', 'licence, idepreuve, tour',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		$this->RemovePreference('jour_sit_mens');
		$this->SetPreference('spid_calcul', 0);
		
	}
	case "0.6.1" : 
	{
		//ON crée un nouveau champ numero_equipe d'abord
		$dict = NewDataDictionary( $db );
		$flds = "numero_equipe I(2)";
		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_equipes", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$query = "SELECT id,libequipe FROM ".cms_db_prefix()."module_ping_equipes";
		//on fait la recherche du numéro
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$id = $row['id'];
				$libequipe = $row['libequipe'];
				$out = preg_replace('#[^0-9]#','',$libequipe);
				//on fait l'update ds la base
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_equipes SET numero_equipe = ? WHERE id = ?";
				$dbresult2 = $db->Execute($query2, array($out, $id));
			}
		}
	}
	case "0.6.2" : 
	{
		//on fait un update sur une table à laquelle il manque la saison
		$query = "UPDATE  ".cms_db_prefix()."module_ping_sit_mens SET saison= '2017-2018' WHERE annee = '2017' AND mois > 7";
		//on fait la recherche du numéro
		$dbresult = $db->Execute($query);
		//
		//ON crée un nouveau champ numero_equipe d'abord
		$dict = NewDataDictionary( $db );
		$flds = "idepreuve I(4)";
		// create it. 
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_poules_rencontres", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		
		$query = "SELECT DISTINCT iddiv, idpoule, saison, idepreuve FROM ".cms_db_prefix()."module_ping_equipes";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$idepreuve = $row['idepreuve'];
				$iddiv = $row['iddiv'];
				$idpoule = $row['idpoule'];
				$saison = $row['saison'];
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_poules_rencontres SET idepreuve = ? WHERE iddiv = ? AND idpoule = ? AND saison = ?";
				$dbresult2 = $db->Execute($query2, array($idepreuve, $iddiv, $idpoule,$saison));
			}
		}
	}
	case "0.6.3" :
	case "0.6.4" :
	case "0.6.5" :
	{
		//on cherche à remplacer la valeur fk_id (aujourd'hui le id )ds les tables feuilles_rencontres
		//et rencontres_parties par la valeur renc_id de la FFTT
		$query= "SELECT renc_id, id AS row_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison = '2017-2018'";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$renc_id = $row['renc_id'];
				$row_id = $row['row_id'];
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_feuilles_rencontres SET fk_id = ? WHERE fk_id = ?";
				$dbresult2 = $db->Execute($query2, array($renc_id,$row_id ));
				
				$query3 = "UPDATE ".cms_db_prefix()."module_ping_rencontres_parties SET fk_id = ? WHERE fk_id = ?";
				$dbresult3 = $db->Execute($query3, array($renc_id,$row_id ));
			}
		}
		$this->SetPreference('LastRecupSpid', '');
		$this->SetPreference('LastRecupFftt', '');
	}
	case "0.6.6":
	{
		
		$uid = null;
		if( cmsms()->test_state(CmsApp::STATE_INSTALL) ) {
		  $uid = 1; // hardcode to first user
		} else {
		  $uid = get_userid();
		}
		
		//on ajoute un index sur la table des compet
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL('id_compet',
							    cms_db_prefix().'module_ping_type_competitions', 'idepreuve, idorga',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		$this->SetPreference('LastVerifAdherents', time());
		
		//on ajoute des champs supplémentaires dans certaines tables
		
		//d'abord on enlève tous les enregistrements !!
		$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties";
		$dict->ExecuteSQLArray( $query );
		$dict = NewDataDictionary( $db );
		$flds = "idpartie I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_parties", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on ajoute l'index unicite
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL('unicite',
					    cms_db_prefix().'module_ping_parties', 'idpartie',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//d'abord on enlève tous les enregistrements !!
		$query = "DELETE ".cms_db_prefix()."module_ping_parties_spid WHERE saison LIKE '2018-2019'";
		$dict->ExecuteSQLArray( $query );
		$dict = NewDataDictionary( $db );
		$flds = "idpartie I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_parties_spid", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on nettoie la table recup_parties
		
		$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup_parties";
		$db->Execute($query);
		//on change le type de champ licence en varchar 15
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup_parties",
						     "licence C(15)");
	 	$dict->ExecuteSQLArray( $sqlarray );
		//on ajoute l'index unicite
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL('unicite',
					    cms_db_prefix().'module_ping_recup_parties', 'licence',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//on crée les enregistrements par défaut...
		$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif = '1'";
		$dbresult = $db->Execute($query);
		if($dbresult)
		{
			while($row = $dbresult->FetchRow())
			{
				$licence = $row['licence'];
				$fftt = 0;
				$maj_fftt = time() - (3600*24);
				$spid = 0;
				$spid_total = 0;
				$spid_errors = 0;
				$maj_spid = time() - (3600*24);
				$maj_total = 0;
				
				$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties ( licence, fftt, maj_fftt, spid, spid_total, spid_errors, maj_spid, maj_total) VALUES (?, ?, ?, ?, ?, ? ,?, ? )";
				$db->Execute($query2, array($licence, $fftt, $maj_fftt, $spid, $spid_total, $spid_errors, $maj_spid, $maj_total));
			}
		}
		
		//maintenant on reconstruit

		//on ajoute l'index unicite
		$idxoptarray = array('UNIQUE');
		$sqlarray = $dict->CreateIndexSQL('unicite',
						    cms_db_prefix().'module_ping_parties_spid', 'idpartie',$idxoptarray);
		$dict->ExecuteSQLArray($sqlarray);
		
		//licence pour la table joueurs
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_joueurs",
						     "licence C(11)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//licence et saison pour la table spid
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_parties_spid",
						     "licence C(11), saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//licence et saison et advlic pour la table spid
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_parties",
						     "licence C(11), saison C(10), advlic C(11)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//licence et saison pour la table recup_parties
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_parties",
						     "licence C(11), saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//saison pour la table recup_parties
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_poules_rencontres",
						     "saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//saison pour la table ping_sit_mens
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_sit_mens",
						     "saison C(10), licence C(11)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//licence pour la table ping_adversaires
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_adversaires",
						     "licence C(11)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//saison pour la table ping_div_classement
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_div_classement",
						     "saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//saison pour la table ping_div_classement
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_div_parties",
						     "saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
	
		//licence pour la table ping_participe
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_participe",
						     "licence C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//licence pour la table ping_participe
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_participe_tours",
										     "licence C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//saison pour la table ping_classement
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_classement",
						     "saison C(10)");
	 	$dict->ExecuteSQLArray( $sqlarray );
										
	
		
		//on modifie le type des champs maj_fftt et maj_spid pour les passer en Int (11)
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup_parties",
						     "maj_fftt I(11), maj_spid I(11)");
	 	$dict->ExecuteSQLArray( $sqlarray );
		
		
		//on ajoute d'autres champs dans la table classement des équipes
		$dict = NewDataDictionary( $db );
		$flds = "totvic I(3), totdef I(3), numero C(10), idclub I(10), vic I(3), def I(3), nul I(3), pf I(3), pg I(3), pp I(3)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_classement", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on ajoute le chp clast pour la table joueurs
		
		$dict = NewDataDictionary( $db );
		$flds = "sexe C(1),
		type C(1), 
		certif C(255),
		validation C(100),
		cat C(20),
		clast I(5)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_joueurs", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on supprime des champs devenus inutiles dans la table joueurs
		$flds = "anniversaire, adresse, code_postal, ville, externe, genid,pays";
		$sqlarray = $dict->DropColumnSQL(cms_db_prefix()."module_ping_joueurs",
						      $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on ajoute d'autres champs utiles dans cette table
		
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
			    $fn = cms_join_path(dirname(__FILE__),'templates','orig_sitprov.tpl');
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
			
			//on récupère les préférences du compte !
			$adh = cms_utils::get_module('Adherents');
			$idAppli = $adh->GetPreference('idAppli');
			$mdp = $adh->GetPreference('motdepasse');
			$club_number = $adh->GetPreference('club_number');
		
			$this->SetPreference('idAplli', $idAppli);
			$this->SetPreference('motdepasse', $mdp);
		
			$this->SetPreference('club_number', $club_number);
			
			
	}
	case "0.7" :
	case "0.7.1" :
	{
		//on va aussi faire du ménage ds les préférences obsolètes
		
		//
		
		//licence pour la table ping_participe
		$sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_ping_recup", "datecreated I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropIndexSQL('unicite', cms_db_prefix().'module_ping_equipes');
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->CreateIndexSQL('unicite', cms_db_prefix().'module_ping_equipes', 'saison, phase, idepreuve, numero_equipe');//, array('UNIQUE'));
		$dict->ExecuteSQLArray($sqlarray);
		
		$this->SetPreference('LastRecupRencontres', time());
		$this->SetPreference('LastRecupUsers', time());
		$this->SetPreference('LastRecupClassements', time());
	
		//on ajoute d'autres champs dans la table classement des équipes
		$dict = NewDataDictionary( $db );
		$flds = "eq_id I(11), countdown I(1) DEFAULT 0, horaire C(5) DEFAULT '14:00'";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_poules_rencontres", $flds);
		$dict->ExecuteSQLArray( $sqlarray );		
		
		$flds = "idequipe I(11), maj_class I(11) DEFAULT 0, horaire C(5) DEFAULT '14:00'";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_equipes", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$flds = "detail C(255)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_rencontres_parties", $flds);
		$dict->ExecuteSQLArray( $sqlarray );	
		
		$flds = "pts_spid N(6.3), pts_fftt N(6.3)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_recup_parties", $flds);
		$dict->ExecuteSQLArray( $sqlarray );	
		
		//DESIGN POUR LE COMPTE A REBOURS			
		try {
		    $ping_countdown_type = new CmsLayoutTemplateType();
		    $ping_countdown_type->set_originator($this->GetName());
		    $ping_countdown_type->set_name('Countdown');
		    $ping_countdown_type->set_dflt_flag(TRUE);
		    $ping_countdown_type->set_description('Countdown');
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
		        $tpl->set_name(\CmsLayoutTemplate::generate_unique_name('Countdown'));
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
		
			
	}
	case "0.8" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "num_equipe I(11) DEFAULT 0";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_classement", $flds);
		$dict->ExecuteSQLArray( $sqlarray );	
		
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
		
		//on ajoute qqs preferences
		$this->SetPreference('interval_classement', 604800);
		$this->SetPreference('interval_joueurs', 604800);
		$this->SetPreference('interval_equipes', 604800);
		$this->SetPreference('interval_feuille_parties', 604800);
		//$this->SetPreference('details_rencontre_page','');
		
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
	}
	
	case "0.8.0.1" :
	{
		
		//on créé deux nouveaux champs
		$dict = NewDataDictionary( $db );
		$flds = "equip_id1 I(11), equip_id2 I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_poules_rencontres", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		//On fait la requete pour que les nouveaux champs soient remplis
		//il faut actualiser tous les classements et toutes les rencontres (poules_rencontres)
		$query = "SELECT id, iddiv, idpoule, idepreuve FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = '2020-2021'";
		$dbresult = $db->Execute($query);
		if($dbresult && $dbresult->RecordCount() >0)
		{
			$r_ops = new retrieve_ops;
			while($row = $dbresult->FetchRow())
			{
				$r_ops->retrieve_all_classements($row['id']);
				$r_ops->retrieve_poule_rencontres( $row['id'],$row['iddiv'],$row['idpoule'],$row['idepreuve']);
			}
		}
		
		
	}
	
	case "0.8.0.2" :
	 
	{
		$dict = NewDataDictionary( $db );
		$flds = "actif I(11) DEFAULT 1";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );	
		
		//on supprime la table adversaires aujourd'hui obsolete
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_divisions");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on supprime la table adversaires aujourd'hui obsolete
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_div_tours");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on supprime la table adversaires aujourd'hui obsolete
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_div_classement");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on supprime la table adversaires aujourd'hui obsolete
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_ping_div_parties");
		$dict->ExecuteSQLArray( $sqlarray );
		
		//on ajoute un champ saison à la table compétitions pour pouvoir afficher d'anciennes compets
		$flds = "saison C(11) ";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
	}
	

	case "0.9" :
	{
		$this->SetPreference('max_size', '500000');
		$this->SetPreference('max_width', '800');
		$this->SetPreference('max_height', '800');
		$this->SetPreference('allowed_extensions', 'jpg, gif, jpeg, png');
		//$this->SetPreference('allowed_extensions', 'jpg, gif, jpeg, png');
		
		$flds = "class_mini I(4) DEFAULT 0 ";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_equipes", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
	}

	case "1.0" :
	{
		//on créé une nouvelle table pour les résultats détaillés du week-end (1 seul tour)
		$dict = NewDataDictionary( $db );
		$flds = "id I(11) AUTO KEY,
				licence C(10),
				tour I(2),
				renc_id I(11),
				idepreuve I(4),
				numero_equipe I(2),
				doubles I(1),
				victoires I(1),
				nb_parties I(1),
				details X";
				
		$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_ping_we_results",$flds);
		$dict->ExecuteSQLArray( $sqlarray );
	}
	
	case "1.1.1" :
	{
		$dict = NewDataDictionary( $db );
		$sqlarray = $dict->DropIndexSQL("renc_id", cms_db_prefix()."module_ping_poules_rencontres");
		$dict->ExecuteSQLArray( $sqlarray );
		$idxoptarray = array('UNIQUE');
		$sqlarray2 = $dict->CreateIndexSQL('renc_id_eq_id', cms_db_prefix().'module_ping_poules_rencontres', 'renc_id, eq_id', $idxoptarray);
		$dict->ExecuteSQLArray( $sqlarray2 );
	}
	
	case "1.1.2" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "friendlyname C(255)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$query = "UPDATE  ".cms_db_prefix()."module_ping_type_competitions SET friendlyname = name";
		$dbresult = $db->Execute($query);
				
	}
	case "1.1.3" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "idPere I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_organismes", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$dict = NewDataDictionary( $db );
		$flds = "typepreuve C(1)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
	}
	
	case "1.1.4" : 
	{
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
			uploaded I(1)";

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
		
		$dict = NewDataDictionary( $db );
			
			//on créé un index pour cette table
			$idxoptarray = array('UNIQUE');
			$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'div_tours',
				    cms_db_prefix().'module_ping_div_tours', 'idepreuve, iddivision, tableau',$idxoptarray);
			$dict->ExecuteSQLArray($sqlarray);
		
	}
	
	case "1.1.5" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "suivi I(1) DEFAULT (0)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$this->SetPreference('last_indivs_cla', time());
	}
	case "1.1.6" : 
	{
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
	}
	
	case "1.1.7" :
	{
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
	}
	
	case "1.2" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "date_created ". CMS_ADODB_DT ."";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_div_classement", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$this->SetPreference('details_indivs', 'details_indivs');
	}
	
	case "1.2.1" :
	{
		$dict = NewDataDictionary( $db );
		$flds = "date_created I(11), date_maj I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_type_competitions", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
		
		$this->SetPreference('LastRecupDivisions', time());
		$this->SetPreference('LastRecupTours', time());
		$this->SetPreference('LastRecupClassements', time());
	}
	
	case "1.2.2" :
	{
		$this->SetPreference('LastRecupTeams', time());
		$this->SetPreference('LastRecupDivCla', time());
		$this->SetPreference('teams_interval', 36000);
		$dict = NewDataDictionary( $db );
		$flds = "date_created I(11)";
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_ping_equipes", $flds);
		$dict->ExecuteSQLArray( $sqlarray );
	}
	
	case "1.2.3" :
	{
		$this->RemovePreference('chpt_default');
		$this->RemovePreference('annee_fin');
	}
	 
}


// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>
