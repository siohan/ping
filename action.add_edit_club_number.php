<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping use'))
{
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
if(!empty($_POST))
{
	debug_display($_POST, 'Parameters');
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
		if (isset($_POST['fede']) && $_POST['fede'] !='')
		{
			$fede = $_POST['fede'];
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
		if (isset($_POST['ligue']) && $_POST['ligue'] !='')
		{
			$ligue = $_POST['ligue'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['dep']) && $_POST['dep'] !='')
		{
			$dep = $_POST['dep'];
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
		if (isset($_POST['phase_en_cours']) && $_POST['phase_en_cours'] !='')
		{
			$phase_en_cours = $_POST['phase_en_cours'];
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
				$this->SetPreference('fede', $fede);
				$this->SetPreference('zone', $zone);
				$this->SetPreference('ligue', $ligue);
				$this->SetPreference('dep', $dep);
				$this->SetPreference('phase_en_cours', $phase_en_cours);
				$this->SetPreference('saison_en_cours', $saison_en_cours);		
				$this->Redirect($id,'getInitialisation', $returnid, array("step"=>"2"));

			
		}		
}
else
{
	//debug_display($params, 'Parameters');
	
	//
	//
	require_once(dirname(__file__).'/include/prefs.php');
	$orga_ops = new fftt_organismes;
	$liste_fede = $orga_ops->liste_fede();
	$liste_zones = $orga_ops->liste_zones();
	$liste_ligues = $orga_ops->liste_ligues();
	$liste_deps = $orga_ops->liste_deps();
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_club_number.tpl'), null, null, $smarty);
	$tpl->assign('club_number', $this->GetPreference('club_number'));
	$tpl->assign('zone', $this->GetPreference('zone'));
	$tpl->assign('ligue', $this->GetPreference('ligue'));
	$tpl->assign('dep', $this->GetPreference('dep'));
	$tpl->assign('liste_fede', $liste_fede);
	$tpl->assign('liste_zones', $liste_zones);
	$tpl->assign('liste_ligues', $liste_ligues);
	$tpl->assign('liste_deps', $liste_deps);
	$tpl->assign('phase_en_cours', $phase);
	$tpl->assign('saison_en_cours', $saison_en_cours);
	$tpl->display();
}


#
# EOF
#
?>
