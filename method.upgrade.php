<?php
#-------------------------------------------------------------------------
# Module: Ping
# Version: 1.5, SjG
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


/**
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Upgrade() method in the module body.
 */

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

		break;
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
		#On crée un nouveau champ dans la table participe
		$dict->NewDataDictionary( $db );
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_ping_participe", "idepreuve C(11)");
		$dict->ExecuteSQLArray( $sqlarray );
	}
}


// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>