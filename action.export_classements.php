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

$std_ops = new asso_standings;
$t_ops = new asso_teams;
$clb_ops = new asso_clubs;
//echo 'cool !';

	
	$db = cmsms()->GetDb();
	$query = "SELECT saison, idpoule, clt, equipe, joue, pts, totvic, totdef, vic, def, nul, pf, pg, pp, saison  FROM ".cms_db_prefix()."module_ping_classement";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			//get the club_id first
			
			
			
			
			$p_ops = new asso_pools;
			
			while($row = $dbresult->FetchRow())
			{
				$home_club =  trim(preg_replace('#[0-9]#', '',$row['equipe']));
				$cb_id = $clb_ops->get_club_id($home_club);
				if(false == $cb_id)
				{
					
					//on enregistre le club d'abord				
					$add_clb = $clb_ops->add_club($home_club, '', 1, 0);
					if(true == $add_clb)
					{
						$cb_id = $db->insert_Id();
					}
				}	
				$idepreuve = '1073';
				$active = 1;
				$saison = $row['saison'];
				if($saison == '2020-2021')
				{
					$saison = '20-21-ph1';
				}
				$team_id = $t_ops->get_team_id($row['equipe'],$idepreuve,$saison);
				if(false == $team_id)
				{
					$libdivision = 'Championnat de France';
					$home_club = 0;
					$add_team = $t_ops->add_team($row['equipe'], $libdivision, $active,$home_club,$idepreuve,$saison);
					//on ajoute l'équipe à la poule
					if(true == $add_team)
					{
						$team_number = 1;
						$team_id = $db->Insert_id();
					}
				}
				$id_poule = $row['idpoule'];
				$team_number = 1;
				$difference = $row['pg'] - $row['pp'];
				//Adding standings
				$add_standing = $std_ops->add_complete_standing($id_poule, $team_id, $team_number, $row['joue'], $row['vic'], $row['nul'], $row['def'], $row['pg'], $row['pp'], $difference, $row['pts'], $saison, $idepreuve);
				
				
				
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