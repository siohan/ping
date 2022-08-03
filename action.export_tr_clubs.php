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

$c_ops = new asso_clubs;			
$p_ops = new asso_pools;	
	$db = cmsms()->GetDb();
	$query = "SELECT renc_id, idpoule, tour, date_event, equa, equb, scorea, scoreb, idepreuve FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE club = 0";
	$dbresult = $db->Execute($query);
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				$idepreuve = $row['idepreuve'];//$name, $description, $active,$home_club)
				
				$id_poule = $row['idpoule'];//->on va chercher le beau libellé ?
				$details = $p_ops->details_pool($id_poule);
				$description = $details['description'];
				$libdivision = '';
				$idepreuve = $row['idepreuve'];
				$pattern_id = 1;
				$active = 1;
				//checking if the team belongs to the default club
				$equa = $row['equa'];	
				$clubA = trim(preg_replace('#[0-9]#', '',$equa));		
				$clubA_exists = $c_ops->club_exists($clubA);
				if(false == $clubA_exists)
				{
					$add_clbA = $c_ops->add_club($clubA, '', 1, 0);
				}	
				
				$equb = $row['equb'];
				$clubB = trim(preg_replace('#[0-9]#', '',$equb));		
				$clubB_exists = $c_ops->club_exists($clubB);
				if(false == $clubB_exists)
				{
					$add_clbB = $c_ops->add_club($clubB, '', 1, 0);
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