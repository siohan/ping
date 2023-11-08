<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$idepreuve = $this->GetPreference('chpt_defaut');

$ren_ops = new rencontres;
$last_round = $ren_ops->last_round($idepreuve);
var_dump($last_round);

	global $themeObject;
	$time = time();
	$aujourdhui = date('d-m-Y');
		
	$idepreuve = $this->GetPreference('chpt_defaut');
	$net = (int) $this->GetPreference('nettoyage_journal');
		$time_net = $net*24*3600;
		var_dump($time_net);
	$query = "DELETE FROM ".cms_db_prefix()."module_ping_recup WHERE (datecreated + ?) <= ?";
	$dbresult = $db->Execute($query,array($time_net,$time));
	if($dbresult && $dbresult->RecordCount() > 0)
	{
		return true;
	}
	else
	{	
		return false;
	}
	/*
	$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE tour = ? AND idepreuve= ? AND club = 1";
	$dbresult= $db->Execute($query, array($last_round, $idepreuve));
	if ($dbresult && $dbresult->RecordCount() > 0)
	{
		while ($row= $dbresult->FetchRow())
		{
			$renc_id = $row['renc_id'];	
			$joueur_side = $ren_ops->club_en_A($renc_id);
			
			
			if(!false == $joueur_side)
			{
				if($joueur_side == "A")
				{
					$extract = $ren_ops->we_results($renc_id, $side="A");
				}
				else
				{
					$extract = $ren_ops->we_results($renc_id, $side="W");
				}	
			}
			
			
		}
		
	}
$this->RedirectToAdminTab('brulage');
* */
#
# EOF
#
?>
