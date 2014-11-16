<?php
if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Ping Manage'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('compets');
	}
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$type_compet = '';
		if (isset($params['type_compet']) && $params['type_compet'] != '')
		{
			$type_compet = $params['type_compet'];
		}
		else
		{
			$error++;
		}
		$date_debut = '';
		if (isset($params['date_debut']) && $params['date_debut'] !='')
		{
			$date_debut = $params['date_debut'];
		}
		else
		{
			$error++;
		}
		$date_fin = '';
		if (isset($params['date_fin']) && $params['date_fin'] !='')
		{
			$date_fin = $params['date_fin'];
		}
		else
		{
			$date_fin = $date_debut;
		}
		$numjourn = '';
		if (isset($params['numjourn']) && $params['numjourn'] !='')
		{
			$numjourn = $params['numjourn'];
		}
		else
		{
			$error++;
		}
		
		
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('compets');
		}		
		
		
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id, type_compet, date_debut, date_fin, numjourn) VALUES ('', ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($type_compet,$date_debut, $date_fin, $numjourn));
		
			if(!$dbresult)
			{
				$designation = $db->ErrorMsg();
				$this->SetMessage("$designation");
				$this->RedirectToAdminTab('compets');
			}
			else
			{
				$now = trim($db->DBTimeStamp(time()), "'");
				$status = 'Ok';
				$designation = "Une nouvelle date du calendrier a été entrée";
				$action = 'do_add_compet';
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
		

$this->SetMessage('Date enregistrée !');
$this->RedirectToAdminTab('compets');

?>