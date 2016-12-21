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
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
		$saison = $this->GetPreference('saison_en_cours');
		$idepreuve = '';
		if (isset($params['idepreuve']) && $params['idepreuve'] != '')
		{
			$idepreuve = $params['idepreuve'];
			//epreuve individuelle ou par équipes ?
			$query = "SELECT indivs, name FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
			$dbresult = $db->Execute($query, array($idepreuve));
			$row = $dbresult->FetchRow();
			$indivs = $row['indivs'];
			$name = $row['name'];
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
			
			//on insert aussi dans le module Calendrier
			$calendar = retrieve_ops::insert_cgcalendar($name,$tag,$date_debut,$date_fin);
		}
		else
		{
			$query = "UPDATE ".cms_db_prefix()."module_ping_calendrier SET idepreuve = ?, date_debut =?, date_fin = ?, numjourn = ?,tag = ? WHERE id = ?";
			$dbresult = $db->Execute($query, array($idepreuve,$date_debut, $date_fin, $numjourn,$tag,$record_id));
			
		}
		
		//on essaie d'inclure des dates automatiquement
		//d'abord s'assurer que la compétitiion en question dsipose de plusieurs tours
		//si oui on fait la requete
			$query = "SELECT DISTINCT tour FROM ".cms_db_prefix()."module_ping_div_tours WHERE idepreuve = ?";
			$dbresult = $db->Execute($query, array($idepreuve));
			if( $dbresult->RecordCount() >1)
			{
				$query = "UPDATE ".cms_db_prefix()."module_ping_div_tours SET date_debut = ?, date_fin = ? WHERE idepreuve = ? AND tour = ? AND saison = ?";
				$dbresult = $db->Execute($query, array($date_debut, $date_fin, $idepreuve,$numjourn, $saison));

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
			}
			
		

$this->SetMessage('Date enregistrée ! Pensez à récupérer les divisions, poules et tours !');
$this->RedirectToAdminTab('calendrier');

?>