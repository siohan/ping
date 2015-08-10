<?php
if(!isset($gCms)) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
$saison = (isset($params['saison']))?$params['saison']:$this->GetPreference('saison_en_cours');
$record_id = '';
if(!isset($params['record_id']) || $params['record_id'] =='')
{
	$message = 'Un pb est survenu';
}


$record_id = $params['record_id'];
//le numéro de l'équipe est ok, on continue
//on va d'abord récupérer le classement de cette équipe
$query = "SELECT cl.clt, cl.joue,cl.equipe,cl.pts,eq.libequipe FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq  WHERE eq.id = cl.idequipe   AND cl.idequipe = ? AND cl.saison = ? ORDER BY cl.id ASC";
$dbresult= $db->Execute($query, array($record_id,$saison));

$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$classement = $row['clt'];
		$joue = $row['joue'];
		$friendlyname = $row['friendlyname'];
		if($classement=='0' || $joue =='0' )
		{
			$classement = '-';
		}
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$poule = $row['poule'];
		$onerow->id= $row['id'];
		$onerow->idpoule = $row['idpoule'];
		$onerow->iddiv = $row['iddiv'];
		$onerow->friendlyname= $row['friendlyname'];
		$onerow->clt=  $classement;
		$onerow->equipe= $row['equipe'];
		$onerow->joue= $row['joue'];
		$onerow->pts= $row['pts'];
		//$onerow->type_compet = $row['code_compet'];
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
}
else
{
	//pas de résultats ?
}
$smarty->assign('libequipe', $friendlyname);
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);



$query2 = "SELECT ren.date_event, ren.idpoule, ren.iddiv,eq.id as id_alias FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren, ".cms_db_prefix()."module_ping_equipes AS eq WHERE ren.idpoule = eq.idpoule AND ren.iddiv = eq.iddiv AND ren.saison = ? AND eq.id = ? GROUP BY ren.date_event ORDER BY ren.date_event ASC ";
$parms['saison'] = $saison;
$parms['id_alias'] = $record_id;

$dbresultat = $db->Execute($query2,$parms);
$rowarray2 = array();
$i = 0;
if($dbresultat && $dbresultat->RecordCount()>0)
{
	
	while($row2 = $dbresultat->FetchRow())
	{
		$i++;
		$date_event = $row2['date_event'];
		$idpoule = $row2['idpoule'];
		$iddiv = $row2['iddiv'];
		$onerow2 = new StdClass();
		$onerow2->rowclass =$rowclass;
		$onerow2->date_event = $row2['date_event'];
		$onerow2->valeur = $i;
		
		
			//on fait la deuxième requete dérivant de la première
			$query3 = "SELECT ren.equa, ren.scorea, ren.equb, ren.scoreb FROM ".cms_db_prefix()."module_ping_poules_rencontres AS ren WHERE ren.date_event = ? AND idpoule = ? AND iddiv = ? ";
			$dbresult3 = $db->Execute($query3, array($date_event, $idpoule, $iddiv));
			$rowarray3 = array();
			
				if($dbresult3 && $dbresult3->RecordCount()>0)
				{
					while($row3 = $dbresult3->FetchRow())
					{
						$onerow3  = new StdClass();
						$onerow3->rowclass = $rowclass;
						$onerow3->equa = $row3['equa'];
						$onerow3->scorea = $row3['scorea'];
						$onerow3->equb = $row3['equb'];
						$onerow3->scoreb = $row3['scoreb'];
						$rowarray3[] = $onerow3;
					}
					$smarty->assign('prods_'.$i,$rowarray3);
					$smarty->assign('itemscount_'.$i, count($rowarray3));
					unset($rowarray3);
					
				}
		$rowarray2[]  = $onerow2;
	}
	
	$smarty->assign('itemcount2', count($rowarray2));
	$smarty->assign('items2', $rowarray2);
}
echo $this->ProcessTemplate('equipe.tpl');
//echo $this->ProcessTemplate('details_rencontre.tpl');
#
#EOF
#
?>