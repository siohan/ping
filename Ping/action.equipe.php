<?php
if(!isset($gCms)) exit;
debug_display($params, 'Parameters');
$db =& $this->GetDb();
$saison = $this->GetPreference('saison_en_cours');
$record_id = '';
if(!isset($params['record_id']) || $params['record_id'] =='')
{
	$message = 'Un pb est survenu';
}
else
{
	$record_id = $params['record_id'];
	//le numéro de l'équipe est ok, on continue
	//on va d'abord récupérer le classement de cette équipe
	$query = "SELECT clt, joue,equipe,pts FROM ".cms_db_prefix()."module_ping_classement WHERE idequipe = ? AND saison = ? ORDER BY id ASC";
	$dbresult= $db->Execute($query, array($record_id,$saison));
	
	$rowarray = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$classement = $row['clt'];
			if($classement=='0')
			{
				$classement = '-';
			}
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$poule = $row['poule'];
			$onerow->id= $row['id'];
			$onerow->idpoule = $row['idpoule'];
			$onerow->iddiv = $row['iddiv'];
			//$onerow->equipe= $row['equipe'];
			$onerow->clt=  $classement;
			$onerow->equipe= $row['equipe'];
			$onerow->joue= $row['joue'];
			$onerow->pts= $row['pts'];
			//$onerow->type_compet = $row['code_compet'];
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
	}
}
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);


echo $this->ProcessTemplate('equipe.tpl');
#
#EOF
#
?>