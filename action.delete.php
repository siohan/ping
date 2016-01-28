<?php
if (!isset($gCms)) exit;

//debug_display($params, 'Parameters');

if (!$this->CheckPermission('Ping Delete'))
	{
	$params = array('message'=>Lang('needpermission'), 'active_tab' => 'users');
	$this->Redirect($id, 'defaultadmin','', $params);
	}
	
$error = 0;
$designation = '';
	$record_id = '';
	if (isset($params['record_id']) && $params['record_id'] != '')
	{
		$record_id = $params['record_id'];
	}
	else
	{
			$error++;
	}
	$type_compet = '';
	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
			 $type_compet = $params['type_compet'];
	}
	else
	{
			$error++;
	}
		
		if ($error==0)
		{
			switch($type_compet)
			{
				case  "spid" :

					$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
					$dbresult = $db->Execute($query, array($record_id));
					
					if(!$dbresult)
					{
						$designation.= $db->ErrorMsg();
						
					}
					else
					{
						$designation.="Résultat supprimé";
						$this->SetMessage("$designation");
						$this->RedirectToAdminTab('spid');
					}			

				break;
				case "fftt" :


					//Now remove the article
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_parties WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Résultat supprimé');
					$this->RedirectToAdminTab('fftt');
				break;
				case "type_compet" :


					//Now remove the article
					// Avant de supprimer l'enregistrement, s'agit-il d'une compet individuelles ?
					// si oui alors on détruit aussi les enregistrements correspondants de la table participe 
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Type de compétition supprimée');
					$this->RedirectToAdminTab('compets');
				break;
				case "teams" : 
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Equipe supprimée');
					$this->RedirectToAdminTab('equipes');
				break;
				
				case "calendrier" : 
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_calendrier WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Date supprimée');
					$this->RedirectToAdminTab('calendrier');
				break;
				
				case "poules" : 
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE id = ?";
					$db->Execute($query, array($record_id));

					$this->SetMessage('Match supprimé');
					$this->RedirectToAdminTab('poules');
				break;
				
				case "sit_mens" :
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_sit_mens WHERE id = ?";
					$db->Execute($query, array($record_id));
					
					$this->SetMessage('situation supprimée');
					$this->RedirectToAdminTab('situation');
				break;
				
				case "division" :
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_divisions WHERE iddivision = ?";
					$db->Execute($query, array($record_id));
					
					//on supprime aussi les autres tours , parties, et classement affiliés
					//on commence par les tours
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_tours WHERE iddivision = ?";
					$db->Execute($query, array($record_id));
					//on continue par les parties
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_parties WHERE iddivision = ?";
					$db->Execute($query, array($record_id));
					//enfin les classements
					$query = "DELETE FROM ".cms_db_prefix()."module_ping_div_classement WHERE iddivision = ?";
					$db->Execute($query, array($record_id));
					
					$this->SetMessage('Division supprimée');
					$this->Redirect('defaultadmin2');
				break;
				case "demo" :
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_joueurs";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_participe";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_equipes";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties_spid";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_parties";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_recup_parties";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_poules_rencontres";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_sit_mens";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_calendrier";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_comm";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_recup";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_adversaires";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_classement";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_divisions";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_classement";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_parties";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_div_tours";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_feuilles_rencontres";
					$db->Execute($query);
					
					$query = "TRUNCATE ".cms_db_prefix()."module_ping_rencontres_parties";
					$db->Execute($query);
					
				break;
				
			}
		}
		
		

?>