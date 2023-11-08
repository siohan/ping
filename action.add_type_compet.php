<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping Set Prefs'))
{
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parametres');
$db = cmsms()->GetDb();	
	if(!empty($_POST))  
	{
		if( isset($_POST['cancel']) )
		{
			$this->RedirectToAdminTab('rencontres');
			return;
		}
		debug_display($_POST, 'Parameters');
		if(isset($_POST['idepreuve']) && $_POST['idepreuve'] !='')
		{
			$idepreuve = $_POST['idepreuve'];
		}
		if(isset($_POST['nom']) && $_POST['nom'] !='')
		{
			$nom = $_POST['nom'];
		}
		if(isset($_POST['friendlyname']) && $_POST['friendlyname'] !='')
		{
			$friendlyname = $_POST['friendlyname'];
		}
		else
		{
			$friendlyname = $nom;
		}
		if(isset($_POST['coefficient']) && $_POST['coefficient'] !='')
		{
			$coefficient = $_POST['coefficient'];
		}
		if(isset($_POST['indivs']) && $_POST['indivs'] !='')
		{
			$indivs = $_POST['indivs'];
		}
		if(isset($_POST['saison']) && $_POST['saison'] !='')
		{
			$saison = $_POST['saison'];
		}
		$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET indivs = ?, coefficient = ?, friendlyname = ? WHERE idepreuve = ?";
		$dbresult = $db->Execute($query, array($indivs, $coefficient, $friendlyname, $idepreuve));
		if($dbresult)
		{
			$this->SetMessage('Compétition modifiée');
		}
		else
		{
			$this->SetMessage('Compétition non modifiée !!');
		}
		$this->Redirect($id,"view_indivs_details", $returnid, array("record_id"=>$idepreuve));
    }
    else
    {
		//on va chercher le nom de l'epreuve 
		$error = 0;
		if(isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = (int)$params['record_id'];
		}
		else
		{
			$error++;
		}
		
		if($error < 1)
		{
			
			$epr = new EpreuvesIndivs;
			$det_epr = $epr->details_epreuve($record_id);
			$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_type_compet.tpl', null, null, $smarty));
			$tpl->assign('idepreuve', $record_id);
			$tpl->assign('nom', $det_epr['name']);
			$tpl->assign('friendlyname', $det_epr['friendlyname']);
			$tpl->assign('indivs', $det_epr['indivs']);
			$tpl->assign('saison', $det_epr['saison']);
			$tpl->assign('coefficient', $det_epr['coefficient']);
			$tpl->display();
		}
		else
		{
			echo 'trop d\'erreurs !';
		}
	}


#
# EOF
#
?>
