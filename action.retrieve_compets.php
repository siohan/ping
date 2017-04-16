<?php
#################################################################
#    Première étape de récupération des compétitions                 #
#################################################################



if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->RedirectToAdminTab('joueurs');
}
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
$saison = $this->GetPreference('saison_en_cours');
$designation = '';
if(!isset($club_number) && $club_number =='')
{
	$message = "Votre numéro de club n'est pas configuré !!";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('configuration');
}
$now = trim($db->DBTimeStamp(time()), "'");

//première possibilité
//un organisateur a été soumis
$service = new retrieve_ops();

if(isset($params['idorga']) && $params['idorga'] !='')
{
	$idorga = $params['idorga'];
	
	if(isset($params['type']) && $params['type'] !='')
	{
		$type = $params['type'];
		
	}
	else
	{
		$type = 'E';
	}
	$recup = $service->retrieve_compets($idorga,$type);
}
else //deuxième possibilité, rien n'est défini...
{
	//on fait un tableau qui récapitule toutes les possibilités (F, Z etc...)
	//on récupère les préférences...
	$fede = '100001';
	$ligue = $this->GetPreference('ligue');
	$zone = $this->GetPreference('zone');
	$dep = $this->GetPreference('dep');
	$tableau = array($fede,$ligue,$zone,$dep);//fédé, zone, ligue et département
	$tableau_type_epreuves = array('I');//par equipes ou individuelles
	foreach($tableau as $valeur)
	{
		//echo "l'organisateur est : ".$valeur;
		foreach($tableau_type_epreuves as $valeur2)
		{
			//echo "le type de compétition est : ".$valeur2;
			$recup = $service->retrieve_compets($idorga = $valeur,$type = $valeur2);
		}
		//unset($valeur2);
	}
}
if(isset($params['stall']) && $params['stall']== "1")
{
	$stall = $params['stall'];
	
	if(isset($params['step']) && $params['step'] !="")
	{
		$step = $params['step'];
		switch($step)
		{
			
			
			case "2" : 
			$this->SetMessage("$designation");
			$this->Redirect($id, 'getInitialisation', $returnid, array("stall"=>$stall, "step"=>"3"));
			
			case "3" : 
			$this->SetMessage("$designation");
			$this->Redirect($id, 'getInitialisation', $returnid, array("stall"=>$stall, "step"=>"4"));
			
			case "4" : 
			$this->SetMessage("$designation");
			$this->Redirect($id, 'getInitialisation', $returnid, array("stall"=>$stall, "step"=>"5"));
		}
	}
	else
	{
		
		$this->SetMessage("$designation");
		$this->Redirect($id, 'getInitialisation', $returnid, array("stall"=>$stall, "step"=>"2"));
	}
	
	
}
else
{
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('compets');
}
	
	

#
# EOF
#

?>