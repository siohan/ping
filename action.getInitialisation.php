<?php
if(!isset($gCms)) exit;
if(!$this->CheckPermission('Ping Set Prefs'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
debug_display($params, 'Parameters');
//on récupère les paramètres envoyés pour les tester

$service = new Servicen();
$initialisation = $service->initialisationAPI();
$xml = simplexml_load_string($initialisation, 'SimpleXMLElement', LIBXML_NOCDATA);
//var_dump($xml);

if($xml === FALSE)
{
	$smarty->assign('reussite', FALSE);
	$smarty->assign('lien',
			$this->CreateLink($id,'defaultadmin',$returnid, $contents='Revenir', array("active_tab"=>"compte")));
}
else
{
	$array = json_decode(json_encode((array)$xml), TRUE);
	foreach($xml as $tab)
	{


		$appli = (isset($tab->appli)?"$tab->appli":"");
		if($appli == '1')
		{
			$smarty->assign('reussite', TRUE);
			$smarty->assign('lien',
					$this->CreateLink($id,'defaultadmin',$returnid, $contents='Continuez', array("active_tab"=>"configuration")));
		}
		else
		{
			$smarty->assign('reussite', FALSE);
			$smarty->assign('lien',
					$this->CreateLink($id,'defaultadmin',$returnid, $contents='Revenir', array("active_tab"=>"compte")));
		}

	}
}


echo $this->ProcessTemplate('initialisation.tpl');
#
#EOF
#
?>