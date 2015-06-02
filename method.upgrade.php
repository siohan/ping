<?php
#-------------------------------------------------------------------------
# Module: Skeleton - a pedantic "starting point" module
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


}


// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>