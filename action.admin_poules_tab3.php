<?php
#####################################################################
###                  To come                                      ###
#####################################################################
//les compétitions à venir
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$date_courante = date('Y-m-d');
//echo "la date courante : ".$date_courante;
//on teste un affichage par mois
$mois_courant = date('n');
$mois_choisi = '';
$phase_choisie = '';
$phase = (isset($params['phase'])?$params['phase']:$this->GetPreference('phase_en_cours'));
$saison = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));

//le record_id est défini, on peut récupérer toutes les variables nécessaires
if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	//on fait donc la requete pour extraire tout ce dont on a besoin
	$query = "SELECT * FROM ".cms_db_prefix()."module_ping_equipes WHERE id = ? ";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$idepreuve = $row['idepreuve'];
			$iddiv = $row['iddiv'];
			$idpoule = $row['idpoule'];
			$libequipe = $row['libequipe'];
			$libequipe1 = trim($libequipe);
			//var_dump($libequipe1);
			$libequipe2 = '%'.$libequipe1.'%';
			$phase = $row['phase'];
		}
	}
	
}



//echo "la saison est : ".$saison;
//echo "la phase est : ".$phase;
//on crée des liens pour naviguer d'une équipe l'autre
$rowarray3 = array();
$rowclass3 = '';
$query3 = "SELECT id, libequipe, friendlyname FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? AND phase = ? AND idepreuve = ? ORDER BY id ASC";
$dbresultat3 = $db->Execute($query3, array($saison,$phase,$idepreuve));
if($dbresultat3 && $dbresultat3->RecordCount()>0)
{
	while($row3 = $dbresultat3->FetchRow())
	{
		$friendlyname = $row3['friendlyname'];
		if(null !==$friendlyname)
		{
			$libequipe = $friendlyname;
		}
		else
		{
			$libequipe = $row3['libequipe'];
		}
		$onerow3= new StdClass();

		$onerow3->lien_nav= $this->CreateLink($id, 'admin_poules_tab3', $returnid, $contents=$libequipe, array("record_id"=>$row3['id'], "libequipe"=>$libequipe, "idepreuve"=>$idepreuve));
		//$onerow3->libequipe= $row3['libequipe'];
		($rowclass3 == "row1" ? $rowclass3= "row2" : $rowclass3= "row1");
		$onerow3->rowclass3= $rowclass3;
		$rowarray3[]= $onerow3;
	}
	
}
$smarty->assign('items3',$rowarray3);
$smarty->assign('itemcount3', count($rowarray3));
//$libequipe2 = '';
/*
	$libequipe1 = trim($params['libequipe']);
	//var_dump($libequipe1);
	$libequipe2 = '%'.$libequipe1.'%';
*/

$smarty->assign('retour',
	$this->CreateReturnLink($id, $returnid,$contents='Retour aux équipes'));
$smarty->assign('returnlink', $this->CreateLink($id,'defaultadmin',$returnid,$themeObject->DisplayImage('icons/system/back.gif', $this->Lang('back'), '', '', 'systemicon'),array("active_tab"=>"equipes")));
$smarty->assign('all_results', 
		$this->CreateLink($id, 'retrieve_poule_rencontres', $returnid, 'Récupérer tous les résultats', array("record_id"=>$record_id)));
		
//on prépare un lien pour récupérer le classement ou le mette à jour
$smarty->assign('refresh_class',
		$this->CreateLink($id, 'retrieve', $returnid,$contents="Récupérer ou mettre le classement à jour",array("retrieve"=>"classement_equipes","record_id"=>$record_id)));	
//le classement de l'équipe
$query2 = "SELECT cl.clt, cl.joue,cl.equipe,cl.pts,eq.libequipe,eq.friendlyname FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq  WHERE eq.id = cl.idequipe   AND cl.idequipe = ? AND cl.saison = ? ORDER BY cl.id ASC";
$dbresult2= $db->Execute($query2, array($record_id,$saison));

$rowarray = array();
$rowclass2 = '';
if($dbresult2 && $dbresult2->RecordCount()>0)
{
	while($row2 = $dbresult2->FetchRow())
	{
		$classement = $row2['clt'];
		$joue = $row2['joue'];
		$friendlyname = $row2['friendlyname'];
		if($classement=='0' || $joue =='0' )
		{
			$classement = '-';
		}
		$onerow2= new StdClass();
		//$onerow2->rowclass2= $rowclass2;
		//$poule = $row2['poule'];
		//$onerow2->id= $row2['id'];
		//$onerow2->idpoule = $row2['idpoule'];
		//$onerow2->iddiv = $row2['iddiv'];
		$onerow2->friendlyname= $row2['friendlyname'];
		$onerow2->clt=  $classement;
		$onerow2->equipe= $row2['equipe'];
		$onerow2->joue= $row2['joue'];
		$onerow2->pts= $row2['pts'];
		//$onerow->type_compet = $row['code_compet'];
		($rowclass2 == "row1" ? $rowclass2= "row2" : $rowclass2= "row1");
		$onerow2->rowclass2= $rowclass2;
		$rowarray[]= $onerow2;
	}
}
else
{
	//pas de résultats ?
}
$smarty->assign('libequipe', $friendlyname);
$smarty->assign('itemsfound2', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount2', count($rowarray));
$smarty->assign('items2', $rowarray);		
		
		
		
		
//la requete
//$query = "SELECT tc.coefficient,cal.date_debut, DAY(cal.date_debut) AS jour_compet,cal.date_fin, tc.idepreuve,tc.name, tc.indivs FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc  WHERE tc.idepreuve = cal.idepreuve AND MONTH(cal.date_debut) = ? AND cal.saison = ?";
$query = "SELECT DISTINCT date_event FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE iddiv = ? AND idpoule = ? AND saison = ? ";
/*
if($phase == 1)
{
	$query.=" AND MONTH(date_event) >7";
}
else
{
	$query.=" AND MONTH(date_event) < 7";
}
*/
$query.=" AND (equa LIKE ?  OR equb LIKE ?)";
$query.=" ORDER BY date_event ASC";
//echo $query;
$dbresult = $db->Execute($query, array($iddiv, $idpoule,$saison,$libequipe2,$libequipe2));//,array($mois_choisi,$saison));



$rowarray = array();
$rowclass = '';
$i=0;
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		
		$date_debut = $row['date_event'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->date = $row['date_event'];
		 //on déclare un nouveau tableau
		$rowarray2 = array();
		
			$i++;
			$onerow->valeur = $i;
			//on refait une requete pour extraire les rencontres
			$query2 = "SELECT DISTINCT ren.id AS ren_id, ren.scorea, ren.scoreb, ren.equa, ren.equb,ren.iddiv,eq.idepreuve, ren.idpoule,eq.friendlyname, ren.club,ren.uploaded,eq.libequipe,eq.id,ren.date_event,ren.affiche FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison = eq.saison";
			$query2.= "  AND ren.date_event = ?";
			//$query2.= " AND eq.saison = ?";
			$query2.=" AND eq.id = ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2,array($date_debut,$record_id));
			//if($dbresultat && $dbresultat->RecordCount()>0)
			
			//echo "le nb de lignes est : ".$nblignes;
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				$nblignes = $dbresultat->RecordCount();
				while($row2 = $dbresultat->FetchRow())
				{
					//$valeur = $i;
					$onerow2 = new StdClass();
					$eq_id = $row2['id'];
					$equa = $row2['equa'];
					$equb = $row2['equb'];
					$iddiv = $row2['iddiv'];
					$idpoule = $row2['idpoule'];
					$scorea = $row2['scorea'];
					$scoreb = $row2['scoreb'];
					$club = $row2['club'];
					$date_event = $row2['date_event'];
					$affiche = $row2['affiche'];
					$uploaded = $row2['uploaded'];
					$libequipe = $row2['libequipe'];
					$friendlyname = $row2['friendlyname'];
					$idepreuve = $row2['idepreuve'];
					$onerow2->ren_id = $row2['ren_id'];
					if($affiche ==1 || $club == 1)
					{
						$onerow2->display= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('do_not_display'), '', '', 'systemicon');
						//$onerow2->display= $this->CreateLink($id,)$themeObject->DisplayImage('icons/system/true.gif', $this->Lang('do_not_display'), '', '', 'systemicon');
					}
					else
					{
						$onerow2->display= $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('display_on_frontend'), '', '', 'systemicon');
					}
					
					$pb = 0;
					
					if($scorea ==0 && $scoreb == 0)
					{
						$pb = 1;
					}
					if($uploaded == 0) 
					{

					 	if($pb==1) 
						{
							
							if($date_event <= $date_courante)
							{
							
								$onerow2->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents = 'MAJ', array('idpoule'=>$row2['idpoule'], 'iddiv'=>$row2['iddiv'], 'idepreuve'=>$idepreuve));
							
							}
							
						}
						
						if($date_event <= $date_courante)
						{
						
							$onerow2->retrieve_details = $this->CreateLink($id,'retrieve_details_rencontres2', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('record_id'=>$row2['ren_id'],"eq_id"=>$eq_id));
						}
						
					}
					else
					{
						$onerow2->viewdetails = $this->CreateLink($id, 'details',$returnid,$themeObject->DisplayImage('icons/system/view.gif', $this->Lang('viewdetails'), '', '', 'systemicon'), array('record_id'=>$row2['ren_id'],"eq_id"=>$eq_id));
					}

					if($this->CheckPermission('Ping Delete'))
					{
						$onerow2->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row2['ren_id'], 'type_compet'=>'poules'), $this->Lang('delete_confirm'));
					}
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equa && isset($friendlyname) && $friendlyname !='' )
						{
							$onerow2->equa= $row2['friendlyname'];
						}
						
						else{
							$onerow2->equa= $row2['equa'];
						}
					
					}
					else{
						$onerow2->equa= $row2['equa'];
					}
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equb)
						{
							$onerow2->equb= $row2['friendlyname'];
						}

						else{
							$onerow2->equb= $row2['equb'];
						}
					
					}
					else{
						$onerow2->equb= $row2['equb'];
					}
					$onerow2->scorea = $scorea;
					$onerow2->scoreb = $scoreb;
					$onerow2->club = $row2['club'];
					$onerow->ren_id = $id;
					//$onerow2->valeur = $valeur;
					$rowarray2[] = $onerow2;
					
				}
				
				$smarty->assign('prods_'.$i,$rowarray2);
			//	$smarty->assign('attention_img', '<img src="'. $this->GetModuleURLPath.'/images/warning.gif" alt="'.$this->Lang('new_topic_label').'" title="'.$this->Lang('new_topic_label').'" width="16" height="16" />');
				unset($rowarray2);
			//	unset($valeur);
			}
			
		
		
		$rowarray[]  = $onerow;
		$smarty->assign('items', $rowarray);
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('date_courante', $date_courante);
		
	}
}

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Afficher sur le site"=>"display_on_frontend","Ne plus afficher sur le site"=>"do_not_display","Supprimer"=>"delete_team_results");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));
echo $this->ProcessTemplate('resultats.tpl');
#
#EOF
#
?>







