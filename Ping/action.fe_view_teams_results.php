<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');

$numjourn = '';
if(!isset($params['numjourn']) || $params['numjourn'] ==''){
	$numjourn = 1;
}
else
{
	$numjourn = $params['numjourn'];
}

$db =& $this->GetDb();
global $themeObject;

$tableau = array();
$i=0;
$result = array();
$rowarray = array();
$rowarray2 = array();
$query1 = "SELECT date_event FROM ".cms_db_prefix()."module_ping_poules_rencontres GROUP BY date_event";
$dbresultat = $db->Execute($query1);


	if($dbresultat && $dbresultat->RecordCount()>0)
	{
		while($row = $dbresultat->FetchRow())
		{
			
			
			$tableau[$i] = $row['date_event'];
			//on instancie le premier tableau
			//on va boucler à nouveau sur les rencontres selon les différentes dates
			$query2 = "SELECT * FROM ".cms_db_prefix()."module_ping_poules_rencontres WHERE date_event = ? AND affiche ='1'";
			$dbresult = $db->Execute($query2, array($row['date_event']));
			
			if($dbresult && $dbresult->RecordCount()>0)
			{
				//on a des résultats, on traite l'info
				$firstrow= new StdClass();
				$firstrow->rowclass= $rowclass;
				$firstrow->date_event= $row['date_event'];
				$a = 0;
				while($row2 = $dbresult->FetchRow())
				{
					$a++;
					$onerow= new StdClass();
					$onerow->rowclass= $rowclass;
					$tableau[$i]['id'] = $row2['id'];
					$tableau[$i]['equa'] = $row2['equa'];
					$tableau[$i]['scorea'] = $row2['scorea'];
					$tableau[$i]['scoreb'] = $row2['scoreb'];
					$tableau[$i]['equb'] = $row2['equb'];
					
					$onerow->id = $row2['id'];
					$onerow->equa = $row2['equa'];
					$onerow->scorea = $row2['scorea'];
					$onerow->scoreb = $row2['scoreb'];
					$onerow->equb = $row2['equb'];
					//$onerow->id = $row2['id'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray[]= $onerow;
				}
				$rowarray2[]= $firstrow;
				unset($rowarray);
								
			}
			//$smarty->assign('tabs', $tableau);
			$smarty->assign('items', $rowarray);
			$smarty->assign('tabs', $firstrow)
			unset($firstarray);
			
			$i++;
		}
	}
	else
	{
		//pas de résultats ? On fait quoi ?
	}
echo $this->ProcessTemplate('fepoulesRencontres.tpl');
#
# EOF
#
?>