<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
if(!empty($_POST))
{
	
    //debug_display($_POST, 'Parameters');
    if (isset($_POST['idepreuve']) && $_POST['idepreuve'] >0)
    {
			$idepreuve = (int) $_POST['idepreuve'];
			$ep_ops = new EpreuvesIndivs;
			$is_f = $ep_ops->is_feminine($idepreuve);
			
	}
	$brul = new brulage_ping;
	$brul->drop_table();
	$brul->create_table($idepreuve);
	if(false == $is_f)
	{
		$brul->insert_all_players($idepreuve);
	}
	else
	{
		$brul->insert_all_f($idepreuve);
	}
	$year = date('Y');
	
		global $themeObject;
		//debug_display($_POST, 'Parameters');
		$aujourdhui = date('d-m-Y');
		
			
		$idepreuve = $_POST['idepreuve'];
		$phase = $this->GetPreference('phase_en_cours');
		
		
		$query = "SELECT renc_id FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison = ?  AND date_event < NOW() AND idepreuve = ? AND club = 1";
		if($phase =="1")
		{
			$current_month = 7;
			$query.= " AND MONTH(date_event) >=? AND YEAR(date_event) = ?";
		}
		else
		{
			//phase2
			$current_month = 12;
			$query.= " AND MONTH(date_event) <=? AND YEAR(date_event) = ?";
		}
			/*
			
			if($phase == '1')
			{ 
				$tour = 8;
				$query.=" AND tour < ?";
			}
			else
			{
				$tour = 7;
				$query.=" AND tour > ?";
			}	
			*/
		//echo $query;
		$dbresult= $db->Execute($query, array($saison, $idepreuve,$current_month, $year));
		if ($dbresult && $dbresult->RecordCount() > 0)
		{
			while ($row= $dbresult->FetchRow())
			{
				$renc_id = $row['renc_id'];	
				$joueur_side = $brul->joueur_en_a($renc_id);
				
				//Plusieurs cas false=la rencontre n'a pas eu lieu, NULL également
				if(!false == $joueur_side)
				{
					if($joueur_side == "A")
					{
						$extract = $brul->has_played ($renc_id, $side="A");
					}
					else
					{
						$extract = $brul->has_played ($renc_id, $side="W");
					}	
				}
				
				
			}
			
		}
		
	$this->Redirect($id, 'defaultadmin', $returnid, array("__activetab"=>"brulage", "idepreuve"=>$idepreuve));
}
else
{
	//debug_display($params, 'Parameters');
	$ping_ops = new ping_admin_ops;
	$liste_epreuves_equipes = $ping_ops->liste_epreuves_equipes();
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_brulage.tpl'), null, null, $smarty);
	$tpl->assign('liste_epreuves_equipes', $liste_epreuves_equipes);
	//$tpl->assign('club_number', $this->GetPreference('club_number'));
	$tpl->display();
}
#
# EOF
#
?>
