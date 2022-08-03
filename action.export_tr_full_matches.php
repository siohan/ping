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
$db = cmsms()->GetDb();
//$saison = $this->GetPreference('saison_en_cours');
$c_ops = new asso_clubs;			
$t_ops = new asso_teams;
$m_ops = new asso_matches;

//$home_club = $c_ops->home_club();// id of the default club
$saison = '2020-2021';	
$saison2 = '20-21-ph1';
	
	$query = "SELECT renc_id, idpoule, tour, date_event, equa, equb, scorea, scoreb, idepreuve, saison FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ?";
	$dbresult = $db->Execute($query, array($saison));
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$idepreuve = $row['idepreuve'];
				$id_poule = $row['idpoule'];
				$idepreuve = $row['idepreuve'];
				$date = explode('-',$row['date_event']);
				$date_event = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
				$equA = $t_ops->get_team_id($row['equa'], $row['idepreuve'],$saison2);	
				if(false == $equA)
				{
					$equA = 0;
				}
				$equB = $t_ops->get_team_id($row['equb'], $row['idepreuve'],$saison2 );
				if(false == $equB)
				{
					$equB = 0;
				}
				$scorea = $row['scorea'];
				$scoreb = $row['scoreb'];
				if(time() > $date_event)
				{
					$status = 1;
				}
				else
				{
					$status = 0;
				}
				$round = $row['tour'];
				$season = '20-21-ph1';
				$add_matches = $m_ops->add_ping_match($row['renc_id'],$equA, $equB, $date_event, $date_event, $scorea, $scoreb, $id_poule, $status, $round, $season,$idepreuve);
				
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