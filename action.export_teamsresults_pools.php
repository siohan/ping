<?php
#################################################################################
###                                                                           ###
#################################################################################
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
debug_display($params, 'Parameters');
//$season = $this->GetPreference('saison_en_cours');
$s_ops = new spid_ops;
$std_ops = new asso_standings;
//echo 'cool !';

	
	$db = cmsms()->GetDb();
	$query = "SELECT libequipe, idpoule, libdivision, idepreuve, saison FROM ".cms_db_prefix()."module_ping_equipes";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			//on instancie la classe Asso_clubs
			$clb_ops = new asso_clubs;
			$home_club = $clb_ops->home_club();
			
			$t_ops = new asso_teams;
			$p_ops = new asso_pools;
			if(false == $home_club || true == is_null($home_club))
			{
				$row = $dbresult->FetchRow();
				$home_club = trim(preg_replace('/#[0-9]#/', '',$row['libequipe']));
				//on enregistre le club d'abord
				
				$add_clb = $clb_ops->add_club($home_club, '', 1, 1);
			}
			while($row = $dbresult->FetchRow())
			{
				$libequipe = $row['libequipe'];
				$id_poule = $row['idpoule'];
				$libdivision = $row['libdivision'];
				$idepreuve = $row['idepreuve'];
				$season = $row['saison'];
				$active = 1;
				$pattern_id = 1;
				$id_club = 1;
				//on ajoute les poules
				$add_pools = $p_ops->add_pool_from_ping($id_poule,$libdivision, $libdivision, $active,$idepreuve,$pattern_id, $season);
				//on enregistre les équipes d'abord
				$add_team = $t_ops->add_team($libequipe, $libdivision, $active,$id_club,$idepreuve,$season);
				//on ajoute l'équipe à la poule
				
			}
			
		}
	}
	else
	{
		echo $db->ErrorMsg();
	}


$this->RedirectToAdminTab('spid');

#
# EOF
#
?>