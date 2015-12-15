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
$phase_en_cours = $this->GetPreference('phase_en_cours');
$saison = $this->GetPreference('saison_en_cours');
if(isset($params['phase_choisie']) && $params['phase_choisie'] !='')
{
	$phase_choisie = $params['phase_choisie'];
}
else
{
	$phase_choisie = $phase_en_cours;
}
$smarty->assign('phase', $phase_choisie);
if(isset($params['mois']) && $params['mois'] !='')
{
	$mois_choisi = $params['mois'];
	//$actif = $mois_choisi;
}
else
{
	$mois_choisi = $mois_courant;
}
if($mois_choisi ==1)
{
	$mois_precedent = 12;
}
else
{
	$mois_precedent = $mois_choisi -1;
}
if($mois_choisi==12)
{
	$mois_suivant = 1;
}
else
{
	$mois_suivant = $mois_choisi + 1;
}
$smarty->assign('Sep',
		$this->CreateLink($id,'defaultadmin', $returnid,'Septembre', array("active_tab"=>"resultats","mois"=>"9","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==9)?'class="pageoptions"':'class="active"')));
$smarty->assign('Oct',
		$this->CreateLink($id,'defaultadmin', $returnid,'Octobre', array("active_tab"=>"resultats","mois"=>"10","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==10)?'class="pageoptions"':'class="active"')));
$smarty->assign('Nov',
		$this->CreateLink($id,'defaultadmin', $returnid,'Novembre', array("active_tab"=>"resultats","mois"=>"11","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==11)?'class="pageoptions"':'class="active"')));
$smarty->assign('Dec',
		$this->CreateLink($id,'defaultadmin', $returnid,'Décembre', array("active_tab"=>"resultats","mois"=>"12","phase_choisie"=>"1"),
		'', false, false, (($mois_choisi==12)?'class="pageoptions"':'class="active"')));
$smarty->assign('Jan',
		$this->CreateLink($id,'defaultadmin', $returnid,'Janvier', array("active_tab"=>"resultats","mois"=>"1","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==1)?'class="pageoptions"':'class="active"')));
$smarty->assign('Fev',
		$this->CreateLink($id,'defaultadmin', $returnid,'Février', array("active_tab"=>"resultats","mois"=>"2","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==2)?'class="pageoptions"':'class="active"')));
$smarty->assign('Mar',
		$this->CreateLink($id,'defaultadmin', $returnid,'Mars', array("active_tab"=>"resultats","mois"=>"3","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==3)?'class="pageoptions"':'class="active"')));
$smarty->assign('Avr',
		$this->CreateLink($id,'defaultadmin', $returnid,'Avril', array("active_tab"=>"resultats","mois"=>"4","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==4)?'class="pageoptions"':'class="active"')));
$smarty->assign('Mai',
		$this->CreateLink($id,'defaultadmin', $returnid,'Mai', array("active_tab"=>"resultats","mois"=>"5","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==5)?'class="pageoptions"':'class="active"')));
$smarty->assign('Juin',
		$this->CreateLink($id,'defaultadmin', $returnid,'Juin', array("active_tab"=>"resultats","mois"=>"6","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==6)?'class="pageoptions"':'class="active"')));
$smarty->assign('Juil',
		$this->CreateLink($id,'defaultadmin', $returnid,'Juillet', array("active_tab"=>"resultats","mois"=>"7","phase_choisie"=>"2"),
		'', false, false, (($mois_choisi==7)?'class="pageoptions"':'class="active"')));

$smarty->assign('mois_precedent',
		$this->CreateLink($id,'defaultadmin',$returnid, '<<', array("active_tab"=>"resultats","phase_choisie"=>"1","mois"=>"12"),
		'', false, false, (($mois_choisi==12)?'class="pageoptions"':'class="active"')));
$smarty->assign('mois_suivant',
		$this->CreateLink($id,'defaultadmin',$returnid, '>>', array("active_tab"=>"resultats","phase_choisie"=>"2","mois"=>"1") ,
		'', false, false, (($mois_choisi==1)?'class="pageoptions"':'class="active"')));

$smarty->assign('all_results', 
		$this->CreateLink($id, 'retrieve_all_poule_rencontres', $returnid, 'Récupérer tous les résultats'));
//la requete
$query = "SELECT tc.coefficient,cal.date_debut, DAY(cal.date_debut) AS jour_compet,cal.date_fin, tc.idepreuve,tc.name, tc.indivs FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc  WHERE tc.idepreuve = cal.idepreuve AND MONTH(cal.date_debut) = ? AND cal.saison = ?";
//$parms['date_debut'] = $mois_courant;

$query.=" ORDER BY cal.date_debut ASC";
$dbresult = $db->Execute($query,array($mois_choisi,$saison));
//echo $query;


$rowarray = array();
$i=0;
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$indivs = $row['indivs'];
		$date_debut = $row['date_debut'];
		$date_fin = $row['date_fin'];
		$idepreuve = $row['idepreuve'];
		$jour_compet = $row['jour_compet'];
		$coefficient = $row['coefficient'];
		$compet = $row['name'];
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->compet = $row['name'];
		//$onerow->iddivision= $row['iddivision'];
		$onerow->date = $row['date_debut'];
		$onerow->indivs = $row['indivs'];
		 //on déclare un nouveau tableau
		$rowarray2 = array();
		if($indivs == 0)    //on est sur une compétition par équipes
		{
			$i++;
			$onerow->valeur = $i;
			//on refait une requete pour extraire les rencontres
			$query2 = "SELECT DISTINCT ren.id AS ren_id, ren.scorea, ren.scoreb, ren.equa, ren.equb,ren.iddiv,eq.idepreuve, ren.idpoule,eq.friendlyname, ren.club,ren.uploaded,eq.libequipe,ren.date_event,ren.affiche FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison = eq.saison  AND ren.date_event = ? AND eq.idepreuve = ?";//" AND ren.club = '1' AND date_event >=Now()";
			//$query2.=" AND eq.id=1";
			$dbresultat = $db->Execute($query2,array($date_debut, $idepreuve));
			$nblignes = $dbresultat->RecordCount();
			//echo "le nb de lignes est : ".$nblignes;
			if($dbresultat && $dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
					//$valeur = $i;
					$onerow2 = new StdClass();
					//$id = $row2['id'];
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
							
								$onerow2->retrieve_poule_rencontres= $this->CreateLink($id, 'retrieve_poule_rencontres', $returnid,$contents = 'MAJ', array('idpoule'=>$row2['idpoule'], 'iddiv'=>$row2['iddiv'], 'idepreuve'=>$row['idepreuve']));
							
							}
							
						}
						
						if($date_event <= $date_courante)
						{
						
							$onerow2->retrieve_details = $this->CreateLink($id,'retrieve_details_rencontres2', $returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('equipe'=>$row2['id']));
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
			
		}
		else
		{
			//on est sur une compet individuelle
			$date_event = $row['date_debut'];
			$name = $row['name'];
			//$onerow->download = $this->CreateLink($id,'retrieve_indivs',$returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('type_compet'=>$row['type_compet'],'coefficient'=>'coefficient'));
			$onerow->download = $this->CreateLink($id,'retrieve_indivs',$returnid,$themeObject->DisplayImage('icons/system/import.gif', $this->Lang('retrieveallpartiesspid'), '', '', 'systemicon'), array('idepreuve'=>$row['idepreuve'],'coefficient'=>'coefficient'));
			//$onerow->compet = $name;//$onerow->compet = $name;
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







