<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Ping Manage'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('compets');
	}
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
		$saison = $this->GetPreference('saison_en_cours');
		$idepreuve = '';
		if (isset($params['idepreuve']) && $params['idepreuve'] != '')
		{
			$idepreuve = $params['idepreuve'];
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
		$indivs = '';
		if (isset($params['indivs']) && $params['indivs'] !='')
		{
			$indivs = $params['indivs'];
		}
		
		//s'agit-il d'une édition ou d'un ajout ?
		$record_id = '';
		if(isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;//c'est un update
		}
		$tag = ping_admin_ops::tag($record_id,$idepreuve,$indivs,$date_debut,$date_fin);
		
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('compets');
		}		
		
		if($edit == 0)
		{
			$query = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id,saison, idepreuve, date_debut, date_fin, numjourn,tag) VALUES ('',?,?, ?, ?, ?,?)";
			$dbresult = $db->Execute($query, array($saison,$idepreuve,$date_debut, $date_fin, $numjourn,$tag));
			
		}
		else
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_calendrier SET idepreuve = ?, date_debut =?, date_fin = ?, numjourn = ?,tag = ? WHERE id = ?";
			$dbresult = $db->Execute($query, array($idepreuve,$date_debut, $date_fin, $numjourn,$tag,$record_id));
			
		}
		
			if(!$dbresult)
			{
				$designation = $db->ErrorMsg();
				$this->SetMessage("$designation");
				$this->RedirectToAdminTab('calendrier');
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