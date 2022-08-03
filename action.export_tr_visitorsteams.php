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
$saison = $this->GetPreference('saison_en_cours');
$clb_ops = new asso_clubs;			
$t_ops = new asso_teams;
$p_ops = new asso_pools;
$s_ops = new asso_standings; 

$home_club = $clb_ops->home_club();// id of the default club
	
	$db = cmsms()->GetDb();
	$query = "SELECT renc_id, saison, idpoule, tour, date_event, equa, equb, scorea, scoreb, idepreuve FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE club = 0";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
							
				$id_poule = $row['idpoule'];//->on va chercher le beau libellé ?
				$details = $p_ops->details_pool($id_poule);
				$description = $details['description'];
				$saison = $row['saison'];
				$idepreuve = $row['idepreuve'];
				$pattern_id = 1;
				$active = 1;
				//checking if the team belongs to the default club
				$equa = $row['equa'];	
				$clubA = trim(preg_replace('#[0-9]#', '',$equa));	
				$clubA_id = $clb_ops->get_club_id($clubA);	
				
				
				$equb = $row['equb'];
				$clubB = trim(preg_replace('#[0-9]#', '',$equb));		
				$clubB_id = $clb_ops->get_club_id($clubB);	
				
				
				$team_number = 0;
				$season = '20-21-ph1';
				$teamA_exists = $t_ops->team_exists($equa, $idepreuve,$season);
				if(false == $teamA_exists)
				{
					$add_teamA = $t_ops->add_team($equa, $description, $active,$clubA_id, $idepreuve, $season);
				}
				
				$teamB_exists = $t_ops->team_exists($equb, $idepreuve, $season);
				if(false == $teamB_exists)
				{
					$add_teamB = $t_ops->add_team($equb, $description, $active,$clubB_id, $idepreuve, $season);
					
					if(true == $add_teamB)
					{
					 	$idB = $db->Insert_ID();
					 	$add_to_pool = $p_ops->add_team_to_pool($id_poule, $idB, $team_number, $season, $idepreuve);
					 	$max_number = $s_ops->max_team_number($id_poule);
					 		if(false == $max_number)
					 		{
					 			$max_number = 0;
					 		}
					 		$played = $winned = $draw = $lost = $total_for = $against = $difference = $pts = 0;
					 		$add_standing = $s_ops->add_complete_standing($id_poule, $idB, $max_number, $played, $winned, $draw, $lost, $total_for, $against, $difference, $pts, $season,$idepreuve);
					}
				}
				
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