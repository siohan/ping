<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$iddiv = "";
$idpoule = "";
$idepreuve = "";
$message = '';//le message de sortie
$error = 0; //on instancie le compteur d'erreurs
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$designation= '';
$aujourdhui = date('Y-m-d');
/*
if(isset($params['cal']) && $params['cal'] = 'all')
{
	//on récupère le calendrier
}
*/
if(isset($params['record_id']) && $params['record_id'] != '')
{
	$record_id = $params['record_id'];
	$query = "SELECT idepreuve, iddiv, idpoule, libequipe FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?";
	$dbresult = $db->Execute($query, array($record_id));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		$row = $dbresult->FetchRow();
		$idepreuve = $row['idepreuve'];
		$iddiv = $row['iddiv'];
		$idpoule = $row['idpoule'];
		$libequipe = $row['libequipe'];
		$cal =0;
		//on envoie vres le fichier
		$service = new retrieve_ops();
		$retrieve = $service->calendrier($iddiv,$idpoule,$idepreuve,$libequipe);
		
		$this->SetMessage("$designation");
		$this->Redirect($id, 'admin_poules_tab3',$returnid,array("record_id"=>$record_id));
		
	}
}
elseif(isset($params['cal']) && $params['cal'] == 'cal')
{
	$cal = $params['cal'];
	//on récupère tts les iddivisions et idepreuve disponible en bdd.
	$query = "SELECT DISTINCT idepreuve, iddiv, idpoule FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ?";
	$dbresult = $db->Execute($query, array($saison, $phase));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
      		{
			$idepreuve = $row['idepreuve'];
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			$service = new retrieve_ops();
			$retrieve = $service->retrieve_poule_rencontres($iddiv, $idpoule,$cal,$idepreuve);
			
		}
	}
	$this->RedirectToAdminTab('equipes');
}
elseif(isset($params['cal']) && $params['cal'] = 'all')
{
	$cal = $params['cal'];
	$i = 0; //on insère un compteur pour les boucles
	//on récupère tts les iddivisions et idepreuve disponible en bdd.
	$query = "SELECT DISTINCT iddiv, idpoule FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE saison LIKE ? AND scorea = 0 AND scoreb = 0 AND date_event <= NOW()";
//	$query = "SELECT DISTINCT idepreuve, iddiv, idpoule FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ?";
	$dbresult = $db->Execute($query, array($saison));
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while ($dbresult && $row = $dbresult->FetchRow())
      		{
			$i++;
		//	$idepreuve = $row['idepreuve'];
			$idepreuve = 0;
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			$service = new retrieve_ops();
			$retrieve = $service->retrieve_poule_rencontres($iddiv, $idpoule,$cal,$idepreuve);
		//	var_dump($retrieve);
			
		}
	}
	$message = "Récupération des résultats de ".$i." poules";
	$this->SetMessage($message);
	$this->RedirectToAdminTab('equipes');
}
else
{
	if(isset($params['idepreuve']) && $params['idepreuve'] != "")
	{
		$idepreuve = $params['idepreuve'];
	}
	else
	{
		$error++;
	}
	if(isset($params['iddiv']) && $params['iddiv'] != "")
	{
		$iddiv = $params['iddiv'];
	}
	else
	{
		$error++;
	}
	if(isset($params['idpoule']) && $params['idpoule'] != "")
	{
		$idpoule = $params['idpoule'];
	}
	else
	{
		$error++;
	}


	if($error >0)
	{
		$message.="Paramètres manquants";
		$this->Setmessage("$message");
		$this->RedirectToAdminTab('equipes');
	}
	else
	{
		$service = new retrieve_ops();
		$retrieve = $service->retrieve_poule_rencontres($iddiv, $idpoule);
	
		$comptage = $i;
		$status = 'Poules';
		$designation.= "Mise à jour de ".$comptage." rencontres de la poule ".$idpoule;
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_recup (id, datecreated, status, designation, action) VALUES ('', ?, ?, ?, ?)";
		$action = "retrieve_poules_rencontres";
		$dbresult = $db->Execute($query, array($now,$status, $designation,$action));
		if(!$dbresult)
		{
			$designation.= $db->ErrorMsg(); 
		}

			$this->SetMessage("$designation");
			$this->Redirect($id, 'admin_poules_tab3',$returnid,array("record_id"=>$record_id));
	}
}

/*	*/
#
# EOF
#
?>