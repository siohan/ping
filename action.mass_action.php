<?php
//ce fichier fait des actions de masse, il est appelé depuis l'onglet de récupération des infos sur les joueurs
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db = cmsms()->GetDb();
$ping_ops = new ping_admin_ops;
$ren_ops = new rencontres;
if (isset($params['submit_massaction']) && isset($params['actiondemasse']) )
  {
     if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      	{
        	
		switch($params['actiondemasse'])
		{
			case "unable" :
				
				$joueurs = new joueurs;
				foreach( $params['sel'] as $licence )
		  		{
		    			$joueurs->desactivate($licence);
		  		}
				$this->SetMessage('Joueurs désactivés');
				$this->RedirectToAdminTab('joueurs');
				
			break;
			
			case "activate" :
				
				$joueurs = new joueurs;
				foreach( $params['sel'] as $licence )
		  		{
		    			$joueurs->activate($licence);
		  		}
				$this->SetMessage('Joueurs activés');
				$this->RedirectToAdminTab('joueurs');
				
			break;
	
			case "situation" :
			
				$service = new retrieve_ops;
				$message='Retrouvez toutes les infos dans le journal';
				foreach( $params['sel'] as $licence )
		  		{
		
		    			$retrieve = $service->retrieve_sit_mens( $licence );
					sleep(1);
		  		}
				//$message.='</ul>';
				$this->SetMessage("$message");
				$this->RedirectToAdminTab("situation");
			break;
	
			case "delete_team_result" :
			
				foreach( $params['sel'] as $record_id )
		  		{
		
		    			$ping_ops->delete_team_result( $record_id );
		  		}
				//$message.='</ul>';
		
				$this->RedirectToAdminTab("poules");
			break;
	
			case "display_on_frontend" :
		
				foreach( $params['sel'] as $id )
		  		{
		
		    			$ping_ops->display_on_frontend( $id );
		  		}
		
				$this->RedirectToAdminTab("poules");
			break;
	
			case "do_not_display" :
	
				foreach( $params['sel'] as $record_id )
		  		{
		
		    			$ping_ops->do_not_display( $record_id );
		  		}
		
				$this->RedirectToAdminTab("poules");
			break;
			
			case "affiche_ok" :
	
				foreach( $params['sel'] as $id )
		  		{
		
		    			$ren_ops->affiche_ok( $id );
		  		}
		
				$this->RedirectToAdminTab("rencontres");
			break;
	
			case "affiche_ko" :
	
			foreach( $params['sel'] as $record_id )
	  		{
	
	    			$ren_ops->affiche_ko( $record_id );
	  		}
	
			$this->RedirectToAdminTab("rencontres");
			break;
	
			case "fftt" :
			foreach( $params['sel'] as $journalid )
	  		{
	    			$ping_ops->delete_journal( $journalid );
	  		}
			break;
	
			case "spid" :
			//$saison_courante = $this->GetPreference('saison_en_cours');
			$message='Retrouvez toutes les infos dans le journal';
			$service = new retrieve_ops;
			$ping_ops = new ping_admin_ops;
			$i=0;
			if($this->GetPreference('spid_calcul') == 1)
			{
				foreach( $params['sel'] as $licence )
		  		{
		    			$i++;
					$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
					$dbretour = $db->Execute($query, array($licence));
					if ($dbretour && $dbretour->RecordCount() > 0)
					{
					    while ($row= $dbretour->FetchRow())
					      	{
							$player = $row['player'];
							$cat = $row['cat'];
							//return $player;
							
							$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
							$ping_ops->compte_spid($licence);
							$ping_ops->compte_spid_errors($licence);
							
						}

					}
		  		}
			}
			else
			{
				foreach( $params['sel'] as $licence )				
		  		{
					$i++;
					$resultats = $service->retrieve_parties_spid($licence);
					if(($i %2) == 0)
					{
						sleep(1);
					}
				}
			}
			
			
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("recup");
			break;
			
			case "spid_plus" :
			//$saison_courante = $this->GetPreference('saison_en_cours');
			$message='Retrouvez toutes les infos dans le journal';
			$service = new retrieve_ops();
			foreach( $params['sel'] as $record_id )
	  		{
	    			
	
				$query1 = "SELECT licence FROM ".cms_db_prefix()."module_ping_parties_spid WHERE id = ?";
				$dbresult1 = $db->Execute($query1, array($record_id));
				
				if($dbresult1 && $dbresult1->RecordCount()>0)
				{
					while($row = $dbresult1->FetchRow())
					{
						$licence = $row['licence'];
						
						$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player, cat FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
						$dbretour = $db->Execute($query, array($licence));
						if ($dbretour && $dbretour->RecordCount() > 0)
						{
						    while ($row= $dbretour->FetchRow())
						      	{
								$player = $row['player'];
								$cat = $row['cat'];
								//return $player;
								$service = new retrieve_ops();
								$resultats = $service->retrieve_parties_spid2($licence,$player,$cat);
								//var_dump($resultats);
							}

						}
						
					}
				}
				sleep(1);
	
				
	  		}
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("spid");
			break;
			
			case "spid_calcul" :
			
				$spid_ops = new spid_ops;
				foreach( $params['sel'] as $record_id )
		  		{
					$spid_ops->recalcul_spid($record_id);
				}
				//$this->SetMessage("$message");
				$this->RedirectToAdminTab("spid");
			break;
	
			case "fftt_parties" :
			//$saison_courante = $this->GetPreference('saison_en_cours');
			$message='Retrouvez toutes les infos dans le journal';
			foreach( $params['sel'] as $licence )
	  		{
	    			$ping_ops->retrieve_parties_fftt( $licence );
	  		}
			$this->SetMessage("$message");
			$this->RedirectToAdminTab("recuperation");
			break;
	
			
	
			case "supp_spid" : //on supprime les parties spid sélectionnées
			$spid_ops = new spid_ops;
			foreach( $params['sel'] as $record_id)
			{
				$spid_ops->supp_spid( $record_id );
			}
			$message = 'Parties(s) SPID supprimée(s)';
			$this->SetMessage("$message");
			$this->RedirectToAdminTab('spid');
			break;

			//donne le statut Uploadé à une rencontre
			case "is_really_uploaded" :
			{
				foreach( $params['sel'] as $record_id )
	  			{
	  				$ren_ops->is_really_uploaded($record_id);
	  			}
			}
			$this->RedirectToAdminTab('rencontres');
			
			case "change_date_event" :
			{
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id, 'change_date_event', $returnid, array("sels"=>$id_sel));
			}
			
			case "change_horaire" :
			{
				$id_sel = implode("-",$params['sel']);
				$this->Redirect($id, 'change_horaire', $returnid, array("sels"=>$id_sel));
			}
			
			break;
			
			case "delete_teams" :
				$eq_ops = new equipes_ping;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$eq_ops->delete_team($record_id);
	  			}
	  			$this->RedirectToAdminTab('equipes');
			break;
			
			case "activate_epr" :
				$epr_ops = new EpreuvesIndivs;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$epr_ops->active_epreuve($record_id);
	  			}
	  			$this->RedirectToAdminTab('compets');
			
			break;
			
			case "desactivate_epr" :
				$epr_ops = new EpreuvesIndivs;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$epr_ops->desactive_epreuve($record_id);
	  			}
	  			$this->RedirectToAdminTab('compets');
			break;
			
			case "delete_epr" :
				$epr_ops = new EpreuvesIndivs;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$epr_ops->delete_epreuve($record_id);
	  			}
	  			$this->RedirectToAdminTab('compets');
			break;
			
			case "suivi_ok" : 
				$epr_ops = new EpreuvesIndivs;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$epr_ops->suivi_ok($record_id);
	  			}
	  			$this->RedirectToAdminTab('compets');
			break;
			
			case "suivi_ko" : 
				$epr_ops = new EpreuvesIndivs;
				foreach( $params['sel'] as $record_id )
	  			{
	  				$epr_ops->suivi_ko($record_id);
	  			}
	  			$this->RedirectToAdminTab('compets');
			break;
			
	
      		}//fin du switch
  	}
	else
	{
		$this->SetMessage('PB de sélection de masse !!');
		$this->RedirectToAdminTab('recuperation');
	}
}
/**/
#
# EOF
#
?>
