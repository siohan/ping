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
$smarty->assign('phase2',
		$this->CreateLink($id,'admin_poules_tab2',$returnid, 'Phase 2', array("phase"=>"2") ));
$smarty->assign('phase1',
		$this->CreateLink($id,'admin_poules_tab2',$returnid, 'Phase 1', array("phase"=>"1") ));
//la requete
$query = "SELECT tc.coefficient,cal.date_debut, DAY(cal.date_debut) AS jour_compet,cal.date_fin, cal.type_compet,tc.name, tc.indivs FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc  WHERE tc.code_compet = cal.type_compet ";

	if($this->GetPreference('phase_en_cours') =='1' )
	{
		if($params['phase'] ==2)
		{
			$query.= " AND MONTH(cal.date_debut) >= 1 AND MONTH(cal.date_debut) <=7"; 
		}
		else
		{
			$query.= " AND MONTH(cal.date_debut) > 7 AND MONTH(cal.date_debut) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
		}
	}
	elseif( $this->GetPreference('phase_en_cours') == '2')
	{
		if($params['phase'] ==1)
		{
			$query.= " AND MONTH(cal.date_debut) > 7 AND MONTH(cal.date_debut) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
		}
		else
		{
			$query.= " AND MONTH(cal.date_debut) >= 1 AND MONTH(cal.date_debut) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
		}
	}

$query.=" ORDER BY cal.date_debut ASC";
$dbresult = $db->Execute($query);



$rowarray = array();
$i=0;
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$indivs = $row['indivs'];
		$date_debut = $row['date_debut'];
		$date_fin = $row['date_fin'];
		$type_compet = $row['type_compet'];
		$jour_compet = $row['jour_compet'];
		$coefficient = $row['coefficient'];
		
		if($jour_compet <= 10)
		{
			$onerow->attention = 1;
		}
		
		$compet = $row['name'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->compet = $compet;
		$onerow->date = $date_debut;
		$onerow->indivs = $row['indivs'];
		 //on déclare un nouveau tableau
		$rowarray2 = array();
		if($indivs == 0)    //on est sur une compétition par équipes
		{
			$i++;
			$onerow->valeur = $i;
			//on refait une requete pour extraire les rencontres
			$query2 = "SELECT DISTINCT ren.id, ren.scorea, ren.scoreb, ren.equa, ren.equb,ren.iddiv, ren.idpoule,eq.friendlyname,ren.id, ren.club,ren.uploaded,eq.libequipe,ren.date_event,ren.affiche FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison = eq.saison AND ren.club = '1' AND ren.date_event = ? AND eq.type_compet = ?";//" AND date_event >=Now()";
			$dbresultat = $db->Execute($query2,array($date_debut, $type_compet));
			$nblignes = $dbresultat->RecordCount();
			//echo "le nb de lignes est : ".$nblignes;
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
					//$valeur = $i;
					$onerow2 = new StdClass();
					$id = $row2['id'];
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
					
					if($affiche ==1)
					{
						$onerow2->display= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('do_not_display'), '', '', 'systemicon');
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
								$onerow2->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents = 'MAJ', array('idpoule'=>$row2['idpoule'], 'iddiv'=>$row2['iddiv'], 'type_compet'=>$row['type_compet']));
							}
						}
						if($date_event <= $date_courante)
						{
							$onerow2->retrieve_details = $this->CreateLink($id,'retrieve_details_rencontres2', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('record_id'=>$row2['id']));
						}
						
					}

					if($this->CheckPermission('Ping Delete'))
					{
						$onerow2->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row2['id'], 'type_compet'=>'poules'), $this->Lang('delete_confirm'));
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
					//$onerow2->valeur = $valeur;
					$rowarray2[] = $onerow2;
					
				}
				
				$smarty->assign('prods_'.$i,$rowarray2);
			//	$smarty->assign('attention_img', '<img src="'. $this->GetModuleURLPath.'/images/warning.gif" alt="'.$this->Lang('new_topic_label').'" title="'.$this->Lang('new_topic_label').'" width="16" height="16" />');
				unset($rowarray2);
			//	unset($valeur);
			}
			
		}
		else
		{
			//on est sur une compet individuelle
			$date_event = $row['date_debut'];
			$name = $row['name'];
			$onerow->download = $this->CreateLink($id,'retrieve_indivs',$returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('type_compet'=>$row['type_compet'],'coefficient'=>'coefficient'));
			//$onerow->compet = $name;
		}
		$rowarray[]  = $onerow;
		$smarty->assign('items', $rowarray);
		$smarty->assign('date_courante', $date_courante);
		
	}
}
else
{
	$smarty->assign('message', 'Pas de résultats');
	echo 'pas de résultats';
}
echo $this->ProcessTemplate('resultats.tpl');
#
#EOF
#
?>







