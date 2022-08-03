<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping use'))
{
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
if(!empty($_POST))
{
	//debug_display($_POST, 'Parameters');
	if( isset($_POST['cancel']) )
	{
    	$this->RedirectToAdminTab('compte');
    	return;
	}
	$aujourdhui = date('Y-m-d ');
	$error = 0;
	$message = '';
		
		
		if (isset($_POST['club_number']) && $_POST['club_number'] !='')
		{
			$club_number = $_POST['club_number'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['zone']) && $_POST['zone'] !='')
		{
			$zone = $_POST['zone'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['saison_en_cours']) && $_POST['saison_en_cours'] !='')
		{
			$saison_en_cours = $_POST['saison_en_cours'];
		}
		else
		{
			$error++;
		}
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('compte');
		}
		else // pas d'erreurs on continue
		{
			
				$this->SetPreference('club_number', $club_number);
				$this->SetPreference('zone', $zone);
				$this->SetPreference('saison_en_cours', $saison_en_cours);
				$ligue = substr($club_number, 0,2);
				$ligue = '10'.$ligue;
				$departement = substr($club_number, 2, 2);
				$dep = (int) $departement;
				$this->SetPreference('ligue', $ligue);
				$this->SetPreference('dep', $departement);				
				$this->Redirect($id,'getInitialisation', $returnid, array("step"=>"3"));

			
		}		
}
else
{
	//debug_display($params, 'Parameters');
	$orga_ops = new fftt_organismes;
	$liste_zones = array('10001'=>'ZONE 1 (CE-IDF)','10002'=>'ZONE 2 (BR-PDL)', '10003'=>'ZONE 3 (AQ-LI-MP-PC)', '10004'=>'ZONE 4 (AU-CO-CA-LR-PR-RA)', '10005'=>'ZONE 5 (AL-BO-CHA-FC-LO)', '10006'=> 'ZONE 6 (BN-HN-NPC-PI)', '10007'=>'ZONE 7 (DOM-TOM)');//$orga_ops->liste_zones();
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_club_number.tpl'), null, null, $smarty);
	$tpl->assign('club_number', $this->GetPreference('club_number'));
	$tpl->assign('zone', $this->GetPreference('zone'));
	$tpl->assign('liste_zones', $liste_zones);
	$tpl->assign('saison_en_cours', '2021-2022');
	$tpl->display();
}


#
# EOF
#
?>
