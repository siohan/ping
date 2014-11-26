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
		$name = '';
		if (isset($params['name']) && $params['name'] !='')
		{
			$name = $params['name'];
		}
		else
		{
			$error++;
		}
		$code_compet = '';
		if (isset($params['code_compet']) && $params['code_compet'] != '')
		{
			$code_compet = $params['code_compet'];
		}
		else
		{
			$error++;
		}
		$coefficient = '';
		if (isset($params['coefficient']) && $params['coefficient'] !='')
		{
			$coefficient = $params['coefficient'];
		}
		else
		{
			$error++;
		}
		$indivs = '';
		if (isset($params['indivs']) && $params['indivs'] !='')
		{
			$indivs = $params['indivs'];
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
		$edit = '';
		if(isset($params['edit']) && $params['edit'] =='Oui')
		{
			//on regarde le recor_id qui est en parametre
			if(isset($params['record_id']) && $params['record_id'] != '')
			{
				$record_id= $params['record_id'];
			}
			
			$query = "UPDATE ".cms_db_prefix()."module_ping_type_competitions SET name = ?, code_compet = ?, coefficient = ?, indivs = ? WHERE id = ?";
			$dbresult = $db->Execute($query, array($name, $code_compet, $coefficient, $indivs, $record_id));
			$this->SetMessage("$designation");
			//$this->RedirectToAdminTab('compets');
		}
		else
		{
		
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_type_competitions (id, name, code_compet, coefficient, indivs) VALUES ('', ?, ?, ?, ?)";
		$dbresult = $db->Execute($query, array($name,$code_compet, $coefficient, $indivs));
		
			if(!$dbresult)
			{
				$designation = $db->ErrorMsg();
				$this->SetMessage("$designation");
			//	$this->RedirectToAdminTab('compets');
			}
			else
			{
				$now = trim($db->DBTimeStamp(time()), "'");
				$status = 'Ok';
				$designation = "Une nouvelle compétition a été entrée";
				$action = 'do_add_type_competition';
				ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
			}
		
		}
/*
$this->SetMessage('Compétition enregistrée !');
$this->RedirectToAdminTab('compets');
*/
?>