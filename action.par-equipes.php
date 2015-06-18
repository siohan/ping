<?php
   if (!isset($gCms)) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');
$nom_equipes = $this->GetPreference('nom_equipes');
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
echo 'la saison courantest : '.$saison_courante;
$db =& $this->GetDb();
global $themeObject;
$result= array();
$parms = array();
$rowarray = array();
$parameters = 0;//pour implémenter les parametres // 0 = pas de parametres
//$rowarray1 = array();
$i=0;

	if(isset($params['date_debut']) && $params['date_debut'] !='')
	{
		
		$parameters = 1;
		$date_debut = $params['date_debut'];			
			
		//la requete maintenant : 
		$query1 = "SELECT eq.id AS ind,ren.equa,ren.equb,ren.scorea,ren.scoreb,ren.date_event, eq.friendlyname, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0) AND ren.date_event = ?";//"  AND ren.date_event = ?";
		$parms['date_debut'] = $params['date_debut'];
			
			if(isset($params['type_compet']) && $params['type_compet'])
			{
				$type_compet = $params['type_compet'];
				$query1.=" AND eq.type_compet = ?";
				$parms['type_compet'] = $type_compet;//" AND cal.date_debut = '2014-12-06'";
				$smarty->assign('date_event', $date_debut);				
			}
		//echo $query;	
		$dbresult = $db->Execute($query1,$parms);
			
			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row = $dbresult->FetchRow())
				{
					$onerow = new StdClass();
					$onerow->rowclass = $rowclass;
					$equa = $row['equa'];
					$equb = $row['equb'];
					$scorea = $row['scorea'];
					$scoreb = $row['scoreb'];
					$libequipe = $row['libequipe'];
					$friendlyname = $row['friendlyname'];
					$onerow = new StdClass();
					$onerow->rowclass =$rowclass;
					//$onerow2->id= $row2['id'];
					$onerow->ind= $row['ind'];
					$onerow->date_event= $row['date_event'];
					$onerow->equb = $row['equb'];
					$onerow->equa = $row['equa'];
					$onerow->friendlyname = $row['friendlyname'];
					$onerow->libequipe = $row['libequipe'];
					//echo "equipe B est : ".$equb;

					//$onerow->equipe= $row['equipe'];
					//$onerow2->libelle=  $row2['libelle'] ;
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equa)
						{
							$onerow->equa= $row['friendlyname'];
						}

						else{
							$onerow->equa= $row['equa'];
						}

					}
					else{
						$onerow->equa= $row['equa'];
					}
					$onerow->scorea= $row['scorea'];
					$onerow->scoreb= $row['scoreb'];
					
					if(isset($friendlyname) && $friendlyname !='')
					{
						if ($libequipe == $equb)
						{
							$onerow->equb= $row['friendlyname'];
						}

						else{
							$onerow->equb= $row['equb'];
						}

					}
					else{ 
						$onerow->equb= $row['equb'];
					}
					$onerow->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row['id'], 'template'=>'1'));
					$onerow->class= $this->CreateLink($id, 'equipe', $returnid, 'Classement', array('record_id'=>$row['ind']));
					$rowarray[] = $onerow;
					
				}
				
				
			}
			$smarty->assign('items', $rowarray);
			$smarty->assign('parameters', $parameters);
	}
	else
	{
		
		$parameters = 2;//deuxième cas le type de compétition est seul défini
		$query2 = "SELECT eq.id AS ind,ren.equa,ren.equb,ren.scorea,ren.scoreb,ren.date_event, eq.friendlyname, ren.id, TRIM(eq.libequipe) FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq  WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule AND ren.saison";
		$parms['saison'] = $saison_courante;
		//$query2.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";	
			if(isset($params['type_compet']) && $params['type_compet'])
			{
				$param_type = 1;
				$parameters = 2;
				$query2.=" AND eq.type_compet = ?";
				$parms['type_compet'] = $params['type_compet'];
				
				$query2.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";
				
				$dbresult = $db->Execute($query2,$parms);
				
				if($dbresult && $dbresult->RecordCount()>0)
				{
					while($row = $dbresult->FetchRow())
					{
						
						$i++;
						$date_event2 = $row['date_event'];
						//echo 'la date_event est : '.$date_event2;
						$query2 ="SELECT *,ren.equa,ren.date_event, ren.equb, ren.id AS ind, TRIM(eq.libequipe),eq.friendlyname FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule AND ren.iddiv = eq.iddiv  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0) AND ren.saison = ?";
						$parms['saison'] = $saison_courante;
						$query2.=" AND eq.type_compet = ?";
						$parms['type_compet'] = $params['type_compet'];
						$query2.=" AND ren.date_event = ?";
						$parms['date_event'] = $date_event2;
						$query2.=" AND ren.club = '1'";
						
						$onerow = new StdClass();
						$onerow->rowclass =$rowclass;
						$onerow->date_event = $row['date_event'];
						$onerow->valeur = $i;
						
						//$smarty->assign('date_event', $date_event2);
						$dbresult2 = $db->Execute($query2,$parms);
						$rowarray2 = array();
						if($dbresult2 && $dbresult2->RecordCount()>0)
						{
							while($row2 = $dbresult2->FetchRow())
							{
								/*
								$equa = $row2['equa'];
								$equb = $row2['equb'];
								$scorea = $row2['scorea'];
								$scoreb = $row2['scoreb'];
								$date_event = $row2['date_event'];
								$libequipe = $row2['libequipe'];
								$friendlyname = $row2['friendlyname'];
								*/
								$onerow2 = new StdClass();
								$onerow2->rowclass =$rowclass;
								//$onerow2->id= $row2['id'];
								$onerow2->ind= $row2['ind'];
								$onerow2->date_event= $row2['date_event'];
								$onerow2->equb = $row2['equb'];
								$onerow2->equa = $row2['equa'];
								$onerow2->friendlyname = $row2['friendlyname'];
								$onerow2->libequipe = $row2['libequipe'];
								//echo "equipe B est : ".$equb;

								//$onerow->equipe= $row['equipe'];
								//$onerow2->libelle=  $row2['libelle'] ;

								if(isset($friendlyname) && $friendlyname !='')
								{
									if ($libequipe == $equa)
									{
										$onerow2->equa= $this->CreateLink($id,'equipe',$returnid,$row2['friendlyname'],array("record_id"=>$row['ind']));
										//$onerow2->equa= $row2['friendlyname'];
									}

									else
									{
										//$onerow2->equa= $this->CreateLink($id,'equipe',$returnid,$row2['equb'],array("record_id"=>$row['ind']));
										$onerow2->equa= $row2['equa'];
									}

								}
								else
								{
									//$onerow2->equa= $this->CreateLink($id,'equipe',$returnid,$row2['equb'],array("record_id"=>$row['ind']));
									$onerow2->equa= $row2['equa'];
								}
								
								$onerow2->scorea= $row2['scorea'];
								$onerow2->scoreb= $row2['scoreb'];

								if(isset($friendlyname) && $friendlyname !='')
								{
									if ($libequipe == $equb)
									{
										$onerow2->equb= $this->CreateLink($id,'equipe',$returnid,$row2['friendlyname'],array("record_id"=>$row['ind']));
										//$onerow2->equb= $row2['friendlyname'];
									}

									else
									{
										//$onerow2->equb= $this->CreateLink($id,'equipe',$returnid,$row2['friendlyname'],array("record_id"=>$row['ind']));
										$onerow2->equb= $row2['equb'];
									}

								}
								else{ 
									//$onerow2->equb= $this->CreateLink($id,'equipe',$returnid,$row2['equb'],array("record_id"=>$row['ind']));
									$onerow2->equb= $row2['equb'];
								}
								$onerow2->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row2['ind'], 'template'=>'1'));
								$onerow2->class= $this->CreateLink($id, 'classement_equipes', $returnid, 'Classement', array('record_id'=>$row2['ind']));
								$rowarray2[] = $onerow2;
							}//fin du while
							$smarty->assign('prods_'.$i,$rowarray2);
							unset($rowarray2);

							$rowarray[]  = $onerow;
							$smarty->assign('items', $rowarray);
							$smarty->assign('parameters', $parameters);
							
						}//fin du if dbresult2
						
						
						

					}//fin du premier while


				}
				$smarty->assign('items', $rowarray);
				$smarty->assign('parameters', $parameters);
								
					
											
			}
			else
			{
				$query2 = "SELECT *, ren.id, ren.saison FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_calendrier AS cal  WHERE ren.date_event = cal.date_debut AND cal.date_debut<=NOW() AND ren.saison = ?";//GROUP BY date_debut ORDER BY date_debut DESC";
				$parms['saison'] = $saison_courante;//$query2 = "SELECT ren.date_event FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq  WHERE ren.iddiv = eq.iddiv AND ren.idpoule = eq.idpoule";
				$query2.=" GROUP BY ren.date_event ORDER BY ren.date_event DESC";
				echo $query2;
				$dbresult = $db->Execute($query2,$parms);
				
				
				if($dbresult && $dbresult->RecordCount()>0)
				{
					while($row = $dbresult->FetchRow())
					{
						$i++;
						$date_debut = $row['date_event'];
						//echo "la date début est :".$date_debut;
						$datearr = explode('-', $date_debut);
						$datefr = $datearr[2] . '-' . $datearr[1] . '-' . $datearr[0];
						//$id_imp = $row['id_imp'];
						//echo "le id_imp est :".$id_imp.'<br />';
						$onerow = new StdClass();
						$onerow->rowclass = $rowclass;
						$onerow->date_event = $datefr;
						$onerow->valeur = $i;
						
						$query3 ="SELECT eq.id as eq_id,ren.equa,ren.scorea,ren.date_event, ren.equb,ren.scoreb, ren.id AS ind, TRIM(eq.libequipe) AS equipe,eq.friendlyname FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0) AND ren.saison = ? ";
						$parms['saison'] = $saison_courante;$query3.= " AND ren.date_event = ?";
						//$query3 ="SELECT *,ren.equa, ren.equb, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0) ";
						$parms['date_event'] = $date_debut;//$query2 = "SELECT eq.id AS ind,ren.equa,ren.equb,ren.scorea,ren.scoreb,ren.date_event, eq.friendlyname, ren.id, eq.libequipe FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.idpoule = ren.idpoule  AND ren.saison = eq.saison AND (ren.scorea !=0 AND scoreb !=0) AND eq.id = ?";//"  AND ren.date_event = ?";



						$query3.=" AND ren.club = '1'";
						$dbresultat = $db->Execute($query3,$parms);
						//echo $query3.'<br />';


						$rowarray2 = array();

						if($dbresultat && $dbresultat->RecordCount()>0)
						{

							$rowclass= 'row1';

							while($row2 = $dbresultat->FetchRow())
							{


								$equa = $row2['equa'];
								$equb = $row2['equb'];
								$scorea = $row2['scorea'];
								$scoreb = $row2['scoreb'];
								$eq_id = $row2['eq_id'];
								$libequipe = $row['equipe'];//$libequipe = rtrim($row2['libequipe']," ");
								$friendlyname = $row2['friendlyname'];
								$onerow2 = new StdClass();
								$onerow2->rowclass =$rowclass;
								//$onerow2->id= $row2['id'];
								$onerow2->ind= $row2['ind'];
								//$onerow2->date_event= $row2['date_event'];
								$onerow2->equb = $row2['equb'];
								$onerow2->equa = $row2['equa'];
								$onerow2->friendlyname = $row2['friendlyname'];
								$onerow2->libequipe = $row2['equipe'];
								//echo "equipe B est : ".$equb;

								//$onerow->equipe= $row['equipe'];
								//$onerow2->libelle=  $row2['libelle'] ;

								if(isset($friendlyname) && $friendlyname !='')
								{
									if ($libequipe == $equa)
									{
										$onerow2->equa= $this->CreateLink($id,'equipe',$returnid,$friendlyname, array("record_id"=>"$eq_id"));
									}
									
									else{
										$onerow2->equa= $row2['equa'];
									}
									
								}
								else{
									$onerow2->equa= $row2['equa'];
								}
								$onerow2->scorea= $row2['scorea'];
								$onerow2->scoreb= $row2['scoreb'];

								if(isset($friendlyname) && $friendlyname !='')
								{
									if ($libequipe == $equb)
									{
										$onerow2->equb= $this->CreateLink($id,'equipe',$returnid,$friendlyname, array("record_id"=>$eq_id));
									}
									
									else{
										$onerow2->equb= $row2['equb'];
									}
									

								}
								else{ 
									$onerow2->equb= $row2['equb'];
								}
								$onerow2->details= $this->CreateLink($id, 'retrieve_details_rencontres', $returnid, 'Détails', array('record_id'=>$row2['id'], 'template'=>'1'));
								$onerow2->class= $this->CreateLink($id, 'classement_equipes', $returnid, 'Classement', array('record_id'=>$row2['ind']));
								$rowarray2[] = $onerow2;


							}//fin du deuxième while
							$smarty->assign('prods_'.$i,$rowarray2);
							unset($rowarray2);

							$rowarray[]  = $onerow;
							$smarty->assign('items', $rowarray);
							$smarty->assign('parameters', $parameters);
						}// fin du if $dbresultat			
				
					}
			
			
		
			
				
			

	
	


		//echo $query.'<br />';


		
			
			
			}
		
		}
	}

echo $this->ProcessTemplate('details_rencontre.tpl');

#
?>