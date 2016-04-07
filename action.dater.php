<?php

if( !isset($gCms) ) exit;
#################################################################################################
##      Cette page date deux tables calendrier et div_tours                                 #####
##      Le formulaire se retourne sur lui même pour traitement                              #####
#################################################################################################

	if (!$this->CheckPermission('Ping Manage'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('divisions');
    		return;
  	}
$error = 0; //on instancie un compteur d'erreur
//debug_display($params, 'Parameters');
//le formulaire a t-il été soumis ?
if(isset($params['submit']))
{
	//on fait les traitements
	//on vérifie que tt est là
	$db =& $this->GetDb();
	if(isset($params['sel']) && $params['sel'] != '')
	{
		$sel = $params['sel'];
		$tab = explode('-', $sel);
		$a = array();
		foreach($tab as $value)
		{
			array_push($a,$value);
		}
		//var_dump($a);
		$date_debut = '';
		
		if(isset($params['date_debut']) && $params['date_debut'] !='')
		{
			$date_debut = $params['date_debut'];
			if(!isset($params['date_fin'])|| empty($params['date_fin']))
			{
				$date_fin = $date_debut;
			}
			else
			{
				$date_fin = $params['date_fin'];
			}
		}
		else
		{
			$error++;
			
		}
		if(isset($params['numjourn']) && $params['numjourn'] !='')
		{
			$numjourn = $params['numjourn'];
		}
		else
		{
			$error++;
		}
		
		$i = 0;//on instancie un compteur pour rendre compte
		
		if($error == 0)
		{
			foreach($a as $valeur)
			{
				//on va chercher les infos : idepreuve, iddivision etc..
				if(isset($params['methode']) && $params['methode'] == 'tableau')
				{
					$query = "SELECT * FROM ".cms_db_prefix()."module_ping_divisions AS dv, ".cms_db_prefix()."module_ping_div_tours AS tours WHERE tours.tableau = ? ";
				}
				else
				{
					$query = "SELECT * FROM ".cms_db_prefix()."module_ping_divisions AS dv, ".cms_db_prefix()."module_ping_div_tours AS tours WHERE tours.iddivision = ? ";
				}
				$dbresult = $db->Execute($query, array($valeur));

				if($dbresult && $dbresult->RecordCount()>0)
				{
					//
					$row = $dbresult->FetchRow();
					$idepreuve = $row['idepreuve'];
					$iddivsion = $row['iddivision'];
					//$tableau = $row['tableau'];
					$libelle = $row['libelle'];
					$saison = $row['saison'];
					$indivs = $row['indivs'];
					//On crée le tag
					//$service = new ping_admin_ops();
					$tag = ping_admin_ops::create_tag($idepreuve,$indivs,$date_debut, $date_fin );
					//on fait la requete d'insertion
					//on va vérifier si la date est déjà ds le calendrier
					$query1 = "SELECT saison, date_debut, date_fin,idepreuve FROM ".cms_db_prefix()."module_ping_calendrier WHERE saison = ? AND date_debut = ? AND idepreuve = ?";
					$dbresult1 = $db->Execute($query1, array($saison, $date_debut, $idepreuve));
					if($dbresult1->RecordCount()==0)
					{
						$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_calendrier (id, saison, date_debut, date_fin, numjourn,tag, idepreuve ) VALUES ('', ?, ?, ? ,?, ?, ?)";
						$dbresult2 = $db->Execute($query2, array($saison,$date_debut, $date_fin,$numjourn,$tag, $idepreuve));
						// on insert aussi dans CGCalendar ?
						// Chiche !
						$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE idepreuve = ?";
						$dbresult = $db->Execute($query, array($idepreuve));
						$row = $dbresult->FetchRow();
						$name = $row['name'];
						// on récupère id ds différentes tables
						//Tout d'abord celui de la table events
						$query1 = "SELECT id FROM ".cms_db_prefix()."module_cgcalendar_events_seq";
						$dbresult1 = $db->Execute($query1);
						$row = $dbresult1->FetchRow();
						$id_event = $row['id']+1;
						$query_cal = "INSERT INTO demo_module_cgcalendar_events
						           (event_id, event_title, event_details, event_date_start, event_date_end)
						            VALUES (?, ?, ? , ?, ?)";
						$dbresult_cal = $db->Execute($query_cal, array($id_event,$name,$tag,$date_debut,$date_fin));
						//on insère aussi l'événement dans une categorie par défaut la générale donc 1
						$cat = 1;
						$query_cat = "INSERT INTO ".cms_db_prefix()."module_cgcalendar_events_to_categories (category_id, event_id) VALUES (?,?)";
						$dbresult_cat = $db->Execute($query_cat, array($cat,$id_event));
						//on modifie le events_seq
						$query = "UPDATE ".cms_db_prefix()."module_cgcalendar_events_seq SET id = id+1";
						$dbresult = $db->Execute($query);
					}

				}
				if(isset($params['methode']) && $params['methode'] == 'tableau')
				{
					$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours  SET date_debut = ?, date_fin = ? WHERE tableau = ?";
				}
				else
				{
					$query2 = "UPDATE ".cms_db_prefix()."module_ping_div_tours  SET date_debut = ?, date_fin = ? WHERE iddivision = ?";
				}

				$dbresult2 = $db->Execute($query2, array($date_debut,$date_fin,$valeur));


			}
			$this->SetMessage('Datation réalisée');
			$this->Redirect($id,'defaultadmin', $returnid='', array("active_tab"=>"indivs"));
		}
		else
		{
			$this->SetMessage('Date(s) et/ou tour manquant(s)');
			$this->Redirect($id, 'defaultadmin', $returnid='', array("active_tab"=>"divisions"));
		}
		
		
		
		
	}
}
else
{
	if(isset($params['sel']) && $params['sel'] !="")
	{			
		$sel = $params['sel'];
		
		//on construit le formulaire
		$smarty->assign('formstart',
				    $this->CreateFormStart( $id, 'dater', $returnid ) );	
		$smarty->assign('record_id',
				$this->CreateInputHidden($id,'sel',$sel));
		$smarty->assign('methode',
				$this->CreateInputHidden($id,'methode','tableau'));
	
		$smarty->assign('date_debut',
				$this->CreateInputDate($id, 'date_debut'));
		$smarty->assign('date_fin',
				$this->CreateInputDate($id, 'date_fin'));
		$smarty->assign('numjourn',
				$this->CreateInputText($id, 'numjourn'));
	
		$smarty->assign('submit',
				$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
		$smarty->assign('cancel',
				$this->CreateInputSubmit($id,'cancel',
							$this->Lang('cancel')));
		$smarty->assign('back',
				$this->CreateInputSubmit($id,'back',
							$this->Lang('back')));

		$smarty->assign('formend',
				$this->CreateFormEnd());
	
		echo $this->ProcessTemplate('dater.tpl');
	}
}



#
# EOF
#
?>
