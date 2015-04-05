<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
global $themeObject;


//$query="SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ?n"
$smarty->assign('id', $this->Lang('id'));
$smarty->assign('username', 'Joueur');
$smarty->assign('points', 'Points');
//$action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

$mois_courant = date('n');

$jour = date('j');
//Faire une préférence pour ne pas afficher le mois pas encore en accès libre ?

	if($jour<=10)
	{
		$mois_courant = $mois_courant-1;
	}
	
	
$annee = date('Y');
$phase_courante = $this->GetPreference('phase');

	
//$mois_pref =$this->SetPreference('defaultMonthSitMens', '6');
$mois_pref = $this->GetPreference('defaultMonthSitMens');
//echo "le mois pref est : ".$mois_pref;
$mois = (!empty($mois_pref)) ? $mois_pref : $mois_courant;
//echo "le mois retenu est : ".$mois;
//le début de saison est le mois N°9
//on peut élaborer un tableau avec l'ordre des mois qu'on souhaite
$tableau = array();
$tableau = array("9"=>"Sept", "10"=>"Oct", "11"=>"Nov", "12"=>"Déc", "1"=>"Jan","2"=>"Fev","3"=>"Mar","4"=>"Avr","5"=>"Mai","6"=>"Juin", "7"=>"Juil");

$query1 = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE actif='1'";
	
	
$query = "SELECT mois, points,clnat, rangreg, rangdep,SUM(progmois) as progmois, CONCAT_WS(' ', nom, prenom) AS joueur";//WHERE (annee = ? AND phase = '1') OR (annee = ? AND phase ='2')";

	
$jour_sit_mens = '10';
$monthslist = array();
$monthsphase1 = array("12", "11","10", "9");

	if($mois_courant >=9)
	{
		for($i=9;$i<=$mois_courant;$i++)
		{
			$monthslist[] = $i;
			
			
		}
	}
	else
	{



		$monthslist[] = 9;
		$monthslist[] = 10;
		$monthslist[] = 11;
		$monthslist[] = 12;
		
		for($i=1;$i<=$mois_courant;$i++)
		{
			$monthslist[] = $i;
			
			
		}
		
		
	}
	
//on fait une boucle pour tous les mois
foreach($monthslist as $entree)
{
	
	$month = $tableau[$entree];
	$query.=" , SUM(IF(mois = '$entree', points, 0))  AS $month"; //$month ";
}
$result= array ();

$query .=" FROM ".cms_db_prefix()."module_ping_sit_mens ";
/*
	if($phase_courante =='1')
	{
		$query.=" WHERE phase = '1' AND annee = '$annee' ";
	}
*/
$query.=" GROUP BY joueur";
//echo $query;

$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->joueur= $row['joueur'];
	$onerow->clnat= $row['clnat'];
	$onerow->rangreg= $row['rangreg'];
	$onerow->rangdep= $row['rangdep'];
	//$onerow->progmois= $row['progmois'];
	$onerow->sept= $row['Sept'];
	$onerow->oct= $row['Oct'];
	$onerow->nov= $row['Nov'];
	$onerow->dec= $row['Déc'];
	$onerow->jan= $row['Jan'];
	$onerow->fev= $row['Fev'];
	$onerow->mar= $row['Mar'];
	$onerow->avr= $row['Avr'];
	$onerow->mai= $row['Mai'];
	$onerow->juin= $row['Juin'];
	$onerow->juil= $row['Juil'];
	
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('monthslist', $monthslist);
$smarty->assign('mois', $tableau);

echo $this->ProcessTemplate('fe_allsitmens.tpl');


#
# EOF
#
?>