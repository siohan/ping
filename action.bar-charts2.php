<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__file__).'/include/prefs.php');
require_once(dirname(__file__).'/function.calculs.php');
$saison = (isset($params['saison']) && $params['saison'] != '') ? $params['saison']: $this->GetPreference('saison_en_cours');
//echo 'la saison est : '.$saison_courante;
$licence = (isset($params['licence']) && $params['licence'] != '') ? $params['licence']: '5310809';//'5310809';
/*
Création d'un lien en frontend
*/
$smarty->assign('liensaison2',
		$this->CreateFrontendLink($id,$returnid,'bar-charts2', $contents = 'Saison 2014-2015', array('saison'=>'2014-2015', 'licence'=>$licence)));
$smarty->assign('liensaison',
		$this->CreateFrontendLink($id,$returnid,'bar-charts2', $contents = 'Saison 2013-2014', array('saison'=>'2013-2014', 'licence'=>$licence)));
$db =& $this->GetDb();
global $themeObject;

//on construit un formulaire pour transiter d'un joueur l'autre
/* on fait un formulaire de filtrage des résultats*/
$smarty->assign('formstart',$this->CreateFormStart($id,'bar-charts2')); 
$playerslist[$this->Lang('allplayers')] = '';
$query = "SELECT * ,licence, CONCAT_WS(' ',nom, prenom) AS player FROM  ".cms_db_prefix()."module_ping_joueurs ORDER BY nom ASC";//"";
$dbresult = $db->Execute($query);
while ($dbresult && $row = $dbresult->FetchRow())
  {
    
    $playerslist[$row['player']] = $row['licence'];
  }

if( isset($params['submitfilter']) )
  {
    	
	if( isset( $params['playerslist']) )
      	{
	$this->SetPreference('playerChoisi', $params['playerslist']);
      	}

}
$curplayer = $this->GetPreference( 'playerChoisi');
				
$smarty->assign('input_player',
		$this->CreateInputDropdown($id,'playerslist',$playerslist,-1,$curplayer));
		
$smarty->assign('submitfilter',
		$this->CreateInputSubmit($id,'submitfilter',$this->Lang('filtres')));
$smarty->assign('formend',$this->CreateFormEnd());


//fin du formulaire de transition entre les joueurs
$smarty->assign('Label_victoires', 'Victoires');
$smarty->assign('Label_defaite', 'Défaites');

/**/
$result = array();
$query2 = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur,p.licence,SUM(p.pointres) as sumpoints,count(p.victoire) - SUM(p.victoire) AS defaites, SUM(p.victoire) AS victoires,count(p.victoire) AS matchs, MONTH(p.date_event) AS mois FROM ".cms_db_prefix()."module_ping_parties_spid AS p, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = p.licence AND p.saison = ? AND p.licence = ? ";//GROUP BY mois ORDER BY YEAR(p.date_event) ASC,mois";
$parms['saison'] = $saison;
//$query = "SELECT SUM(vd) AS victoires, count(vd) AS total, count(vd) - SUM(vd) AS defaites  FROM ".cms_db_prefix()."module_ping_parties WHERE saison = ?";

	if( isset($params['submitfilter'] )){

		if ($curplayer !='')
		{
			$query2 .=" AND j.licence = ?";
			$licence = $curplayer;		
		}
	}
$query2 .=" GROUP BY mois ORDER BY YEAR(p.date_event) ASC,mois";


$dbresult= $db->Execute($query2,array($saison,$licence));
//echo $query2;
//$dbresult = $db->Execute($query, array($saison_courante, $licence));
//$iteration = $db->RecordCount();
$smarty->assign('iteration', $iteration);

$rowclass= 'row1';
$rowarray= array();
$output = array();
$i = 0;
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row= $dbresult->FetchRow())
		{
			$i++;
			$victoires[] = $row['mois'];
			$sumpoints[] = $row['sumpoints'];
			//$temp1[] = "".$row['victoires']."";
			//$temp2[] = "".$row['sumpoints']."";

			
		}
		$output[] = array($victoires,$sumpoints);
		//$output_points[] = $sumpoints;
		//echo "<pre>$output_points</pre>";
		$outputString = json_encode($output);
		//$outputPointsString = json_encode($output_points);
		echo "<pre>$outputPointsString</pre>";
		
	}

//$json = json_encode($results, JSON_PRETTY_PRINT);

/**/
$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
//$datadonnees = array('Victoires'=>'12', 'Total'=>'16');
$smarty->assign('player', $player);
//$smarty->assign('donnees', array('Victoires'=>'12', 'Total'=>'12'));
$smarty->assign('datadonnees', $outputString);
//$smarty->assign('points', $outputPointsString);
//echo $this->ProcessTemplate('pie-charts.tpl');
echo $this->ProcessTemplate('bar-charts2.tpl');


#
# EOF
#
?>